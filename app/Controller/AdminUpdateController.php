<?php
App::uses('AdminController', 'Controller');
App::uses('Media', 'Media.Model');
App::uses('CsvReader', 'Vendor');
class AdminUpdateController extends AdminController {
    public $name = 'AdminUpdate';
	public $autoRender = false;
    
    public function beforeFilter() {
		if (!$this->isAdmin()) {
			$this->redirect(array('controller' => 'Admin', 'action' => 'index'));
			return;
		}
		parent::beforeFilter();
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

	public function parser() {
		// TODO: 2-progress indicators (CSV/Saving product/UploadMedia)
		// $aData = CsvReader::getHeaders('_csv_data3.csv');
		$this->Category = $this->loadModel('Category');
		$aCategories = $this->Category->find('all', array('order' => array('Category.id' => 'ASC')));
		$aCategories = Hash::combine($aCategories, '{n}.Category.id', '{n}.Category');

		$this->Subcategory = $this->loadModel('Subcategory');
		$aSubcategories = $this->Subcategory->find('all', array('order' => array('Subcategory.sorting' => 'ASC')));
		$aSubcategories = Hash::combine($aSubcategories, '{n}.Subcategory.sorting', '{n}.Subcategory', '{n}.Subcategory.parent_id');

		$this->Media = $this->loadModel('Media.Media');
		$this->Product = $this->loadModel('Product');
		$this->Product->deleteAll(array('Product.id > 0'));
		@$this->Media->deleteAll(array('Media.object_type' => 'Product')); // почему то выдает warning

		$photoPath = WWW_ROOT.'photo'.DS;
		@unlink('parser.log');
		try {
			$this->Product->trxBegin();
			$aData = CsvReader::parse('_csv_data4.csv');
			foreach($aData['data'] as $line => $row) {
				$cat_id = $this->_getCategoryId($aCategories, $row);
				if (!$cat_id) {
					throw new Exception(__('Category not found (Line %)', $line));
				}

				$subcat_i = $row['cat_'.$cat_id];
				if (!(isset($aSubcategories[$cat_id]) && isset($aSubcategories[$cat_id][$subcat_i]))) {
					throw new Exception(__('Subcategory not found (Line %)', $line));
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
					throw new Exception(__("Error! Cannot save item `{$row['id_num']}` (Line %s)", $line));
				}

				if ($row['img'] == 1) {
					$fname = mb_convert_encoding($photoPath.$row['id_num'].'.jpg', 'cp1251', 'utf8');
					if (file_exists($fname)) {
						$media = array(
							'media_type' => 'image',
							'object_type' => 'Product',
							'object_id' => $this->Product->id,
							'orig_fname' => $photoPath.$row['id_num'].'.jpg',
							'real_name' => $fname,
							'file' => 'image',
							'ext' => '.jpg'
						);
						$this->Media->uploadMedia($media);
					} else {
						fdebug("Error! No photo for item `{$row['id_num']}: {$fname}`\r\n", 'parser.log');
					}
				}
			}
			$this->Product->trxCommit();
		} catch (Exception $e) {
			$this->Product->trxRollback();
			echo 'Error! '.$e->getMessage();
		}

	}
}
