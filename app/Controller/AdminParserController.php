<?php
App::uses('AdminController', 'Controller');
App::uses('Media', 'Media.Model');
App::uses('CsvReader', 'Vendor');
class AdminParserController extends AdminController {
    public $name = 'AdminParser';

    public function beforeFilter() {
		if (!$this->isAdmin()) {
			$this->redirect(array('controller' => 'Admin', 'action' => 'index'));
			return;
		}
		parent::beforeFilter();
	}

	public function renameFiles() {
		$this->autoRender = false;
		App::uses('Path', 'Core.Vendor');
		App::uses('Translit', 'Article.Vendor');

		$aFiles = Path::dirContent(Configure::read('ProductCSVParser.photo_path'));
		$count = 0;
		foreach($aFiles['files'] as $file) {
			if (file_exists($aFiles['path'].$file)) {
				$new_fname = str_replace('-jpg', '.jpg', Translit::convert(mb_convert_encoding($file, 'utf8', 'cp1251'), true));
				if (rename($aFiles['path'].$file, $aFiles['path'].$new_fname)) {
					$count++;
				} else {
					echo "Error renaming `{$file}` to `{$new_fname}`<br/>";
				}
			}
		}
		echo "Renamed {$count} file(s)";
	}

	public function rename3DFolders() {
		$this->autoRender = false;
		App::uses('Path', 'Core.Vendor');
		App::uses('Translit', 'Article.Vendor');

		$aFiles = Path::dirContent(Configure::read('ProductCSVParser.photo_path_3d'));
		$count = 0;
		foreach($aFiles['folders'] as $folder) {
			if (file_exists($aFiles['path'].$folder)) {
				$new_name = Translit::convert(mb_convert_encoding($folder, 'utf8', 'cp1251'), true);
				if (rename($aFiles['path'].$folder, $aFiles['path'].$new_name)) {
					$count++;
				} else {
					echo "Error renaming `{$folder}` to `{$new_name}`<br/>";
				}
			}
		}
		echo "Renamed {$count} folder(s)";
	}

	private function _convertToCSV($fname) {
		// need to move file to our tmp folder
		$aRows = file($fname);
		$newFname = ROOT.DS.APP_DIR.DS.'tmp'.DS.'_'.basename($fname);
		for($i = 0; $i < 41; $i++) {
			array_shift($aRows);
		}
		$headers = 'title;author;creation_date;body;id_num;location;img;cat_81;cat_87;cat_82;cat_91;cat_88;cat_93;cat_90;cat_92;cat_89;cat_96;cat_95;cat_94';
		file_put_contents($newFname, $headers."\n".implode("", $aRows));

		return $newFname;
	}

	public function index() {
		$this->loadModel('Task');

		$task = $this->Task->getActiveTask('ProductCsvParser');
		if ($task) {
			$id = Hash::get($task, 'Task.id');
			$task = $this->Task->getFullData($id);
			if ($task['status'] === 'ERROR') {
				$this->Task->close($task['id']);
				$this->Flash->error($task['xdata']);
				$this->redirect(array('action' => 'index'));
				return;
			} elseif ($task['status'] === 'ABORTED') {
				$this->Task->close($task['id']);
				$this->Flash->success(__('Processing was aborted by user'));
				$this->redirect(array('action' => 'index'));
				return;
			} elseif ($task['status'] === 'DONE') {
				$this->Task->close($task['id']);
			}

			if (!isset($task['subtask'])) {
				$task['subtask'] = true;
			}
			$this->set(compact('task'));
		} elseif ($this->request->is(array('put', 'post'))) {
			$file = Hash::get($this->request->data, 'parserForm.csv_file');

			// check submitted file
			if (!$file || !$file['tmp_name']) {
				$this->Flash->error(__('You must choose CSV file for parsing'));
				$this->redirect(array('action' => 'index'));
				return;
			}

			$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
			if (!($ext == 'csv' && $file['type'] == 'application/vnd.ms-excel')) {
				$this->Flash->error(__('Incorrect CSV-format for `%s`', $file['name']));
				$this->redirect(array('action' => 'index'));
				return;
			}

			$params = array(
				'clear_data' => $this->request->data('parserForm.clear_data'),
				'publish_all' => $this->request->data('parserForm.publish_all'),
				'csv_file' => $this->_convertToCSV($file['tmp_name']),
			);

			$user_id = AuthComponent::user('id');
			$id = $this->Task->add($user_id, 'ProductCsvParser', $params);
			$this->Task->runBkg($id);
			sleep(1);
			$this->redirect(array('action' => 'index'));
		}
	}
}
