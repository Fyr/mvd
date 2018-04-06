<?php
App::uses('Shell', 'Console');
App::uses('AppShell', 'Console/Command');
App::uses('Product', 'Model');
App::uses('Media', 'Media.Model');
App::uses('CsvReader', 'Vendor');
App::uses('Image', 'Media.Vendor');
define('PHOTO_PATH', WWW_ROOT.'photo'.DS);
define('3D_PHOTO_PATH', WWW_ROOT.'photo'.DS);
class ProductCsvParserTask extends AppShell {
    public $uses = array('Product', 'Media.Media', 'Category', 'Subcategory');

    private $_xdata = array('products' => 0, 'images' => 0, '3d' => 0, 'video' => 0);

    public function execute() {
        @unlink('parser.log');
        $this->Task->setProgress($this->id, 0, 3); // 3 subtasks
        $this->Task->setStatus($this->id, Task::RUN);

        $this->_clearMedia(); // subtask 1
        $this->params['csv_file'] = WWW_ROOT.'csv_data2.csv';
        $aData = $this->_readCsv($this->params['csv_file']); // subtask 2

        try {
            $this->Product->getDataSource()->begin();
            $aID = $this->_updateProducts($aData['data']); // subtask 3
            $this->Product->getDataSource()->commit();
        } catch (Exception $e) {
            $this->Product->getDataSource()->rollback();
            @unlink($this->params['csv_file']);
            throw new Exception($e->getMessage());
        }

        @unlink($this->params['csv_file']);
        $this->Task->setData($this->id, 'xdata', $aID);
        $this->Task->setProgress($this->id, 3);
        $this->Task->setStatus($this->id, Task::DONE);
    }

    private function _clearMedia() {
        $total = $this->Media->find('count', array('conditions' => array('object_type' => 'Product')));

        $subtask_id = $this->Task->add(0, 'ProductCsvParser_clearMedia', null, $this->id);
        $this->Task->setData($this->id, 'subtask_id', $subtask_id);
        $this->Task->setProgress($subtask_id, 0, $total);
        $this->Task->setStatus($subtask_id, Task::RUN);
        $this->Task->saveStatus($this->id);
        $progress = $this->Task->getProgressInfo($this->id);

        $this->Product->deleteAll(array('Product.id > 0'));
        $aRows = $this->Media->find('all', array('conditions' => array('object_type' => 'Product')));
        foreach($aRows as $i => $media) {
            $status = $this->Task->getStatus($this->id);
            if ($status == Task::ABORT) {
                $this->Task->setStatus($subtask_id, Task::ABORTED);
                throw new Exception(__('Processing was aborted by user'));
            }

            // main cycle
            $this->Media->delete($media['Media']['id']);

            $this->Task->setProgress($subtask_id, $i + 1);
            $_progress = $this->Task->getProgressInfo($subtask_id);
            $this->Task->setProgress($this->id, $progress['progress'] + $_progress['percent'] * 0.01);
        }

        $this->Task->setStatus($subtask_id, Task::DONE);
        $this->Task->setProgress($this->id, $progress['progress'] + 1);
        $this->Task->saveStatus($this->id);
    }

    private function _convertToCSV($fname) {
        if (!file_exists($fname)) {
            throw new Exception('File does not exist');
        }

        $aRows = file($fname);
        $newFname = ROOT.DS.APP_DIR.DS.'tmp'.DS.'_'.basename($fname);
        for($i = 0; $i < 41; $i++) {
            array_shift($aRows);
        }
        $headers = 'title;author;creation_date;body;id_num;location;img;link_doc;cat_81;cat_87;cat_82;cat_91;cat_88;cat_93;cat_90;cat_92;cat_89;cat_96;cat_95;cat_94';
        file_put_contents($newFname, $headers."\n".implode("", $aRows));

        return $newFname;
    }

    private function _readCsv($file) {
        $subtask_id = $this->Task->add(0, 'ProductCsvParser_readCsv', null, $this->id);
        $this->Task->setData($this->id, 'subtask_id', $subtask_id);
        $this->Task->saveStatus($this->id);
        $progress = $this->Task->getProgressInfo($this->id);

        $this->params['csv_file'] = $this->_convertToCSV($this->params['csv_file']);

        $aData = CsvReader::parse($this->params['csv_file'], array(
            'Task' => $this->Task,
            'task_id' => $this->id,
            'subtask_id' => $subtask_id
        ));

        $this->Task->setProgress($this->id, $progress['progress'] + 1);
        $this->Task->saveStatus($this->id);
        return $aData;
    }

    private function _getCategoryId($aCategories, $row) {
        foreach($aCategories as $cat_id => $cat) {
            $key = 'cat_'.$cat_id;
            if ($row[$key]) {
                return $cat_id;
            }
        }
        return null;
    }

    private function _getMediaName($id_num) {
        $fname = mb_convert_encoding($id_num, 'cp1251', 'utf8').'.jpg';
        if (file_exists(PHOTO_PATH.$fname)) {
            return $fname;
        }
        // possible KP 00NN.jpg
        list($KP, $num) = explode(' ', $id_num);
        $num = intval($num);
        $_fname = mb_convert_encoding($KP.' '.$num, 'cp1251', 'utf8').'.jpg';
        if (file_exists(PHOTO_PATH.$_fname)) {
            return $_fname;
        }
        $fname = mb_convert_encoding($fname, 'utf8', 'cp1251');
        $_fname = mb_convert_encoding($_fname, 'utf8', 'cp1251');
        fdebug("Error! No photo for item `{$id_num}`: `{$fname}`, `{$_fname}`\r\n", 'parser.log');
        return '';
    }

    private function _checkMediaSize($fname) {
        $img = new Image();
        if (!$img->load(PHOTO_PATH.$fname)) {
            $fname = mb_convert_encoding($fname, 'utf8', 'cp1251');
            fdebug("Error! Could not load media as image: `{$fname}`\r\n", 'parser.log');
            return false;
        }
        if (max($img->getSizeX() / $img->getSizeY(), $img->getSizeY() / $img->getSizeX()) > 3) {
            $fname = mb_convert_encoding($fname, 'utf8', 'cp1251');
            fdebug("Error! Incorrect image size: `{$fname}`\r\n", 'parser.log');
            return false;
        }
        return true;
    }

    private function _get3DMediaFolder($id_num) {
        $fdir = mb_convert_encoding($id_num, 'cp1251', 'utf8').DS;
        if (file_exists($fdir)) {

        }
    }

    private function _updateProducts($aRows) {
        $subtask_id = $this->Task->add(0, 'ProductCsvParser_updateProducts', null, $this->id);
        $this->Task->setData($this->id, 'subtask_id', $subtask_id);
        $this->Task->setProgress($subtask_id, 0, count($aRows));
        $this->Task->setStatus($subtask_id, Task::RUN);
        $this->Task->saveStatus($this->id);
        $progress = $this->Task->getProgressInfo($this->id);

        $aCategories = $this->Category->find('all', array('order' => array('Category.id' => 'ASC')));
        $aCategories = Hash::combine($aCategories, '{n}.Category.id', '{n}.Category');

        $aSubcategories = $this->Subcategory->find('all', array('order' => array('Subcategory.sorting' => 'ASC')));
        $aSubcategories = Hash::combine($aSubcategories, '{n}.Subcategory.sorting', '{n}.Subcategory', '{n}.Subcategory.parent_id');

        $photoPath = WWW_ROOT.'photo'.DS;
        $aID = array();
        try {
            $this->Product->trxBegin();
            foreach($aRows as $line => $row) {
                $status = $this->Task->getStatus($this->id);
                if ($status == Task::ABORT) {
                    $this->Task->setStatus($subtask_id, Task::ABORTED);
                    throw new Exception(__('Processing was aborted by user'));
                }

                $cat_id = $this->_getCategoryId($aCategories, $row);
                if (!$cat_id) {
                    throw new Exception('Category not found (Line %)');
                }

                $subcat_i = $row['cat_'.$cat_id];
                if (!(isset($aSubcategories[$cat_id]) && isset($aSubcategories[$cat_id][$subcat_i]))) {
                    throw new Exception('Subcategory not found (Line %)');
                }
                $subcat = $aSubcategories[$cat_id][$subcat_i];
                $row['title'] = trim($row['title']);

                $data = array(
                    'title' => (mb_strlen($row['title']) > 40) ? mb_substr($row['title'], 0, 40).'...' : $row['title'],
                    'teaser' => $row['title'],
                    'body' => trim($row['body']),
                    'id_num' => trim($row['id_num']),
                    'location' => trim($row['location']),
                    'cat_id' => $cat_id,
                    'subcat_id' => $subcat['id'],
                    'published' => true
                );
                $this->Product->clear();
                if (!$this->Product->save($data)) {
                    throw new Exception("Error! Cannot save item `{$row['id_num']}` (Line %s)");
                }
                $this->_xdata['products']++;

                if ($row['img'] == 1) {
                    if ($fname = $this->_getMediaName($row['id_num'])) {
                        if ($this->_checkMediaSize($fname)) {
                            $media = array(
                                'media_type' => 'image',
                                'object_type' => 'Product',
                                'object_id' => $this->Product->id,
                                'orig_fname' => $fname . '.jpg',
                                'real_name' => PHOTO_PATH . $fname,
                                'file' => 'image',
                                'ext' => '.jpg'
                            );
                            $this->Media->uploadMedia($media);
                            $this->_xdata['images']++;
                        }
                    }
                } elseif ($row['img'] == 3) {

                }

                $this->Task->setProgress($subtask_id, $line + 1);
                $_progress = $this->Task->getProgressInfo($subtask_id);
                $this->Task->setProgress($this->id, $progress['progress'] + $_progress['percent'] * 0.01);
            }
            $this->Product->trxCommit();
        } catch (Exception $e) {
            $this->Product->trxRollback();
            throw new Exception(__($e->getMessage(), $line + 3));
        }

        $this->Task->setStatus($subtask_id, Task::DONE);
        $this->Task->setProgress($this->id, $progress['progress'] + 1);
        $this->Task->saveStatus($this->id);
        return $aID;
    }
}
