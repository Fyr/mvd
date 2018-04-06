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

	public function renameFiles() {
		App::uses('Path', 'Core.Vendor');
		App::uses('Translit', 'Article.Vendor');

		$aFiles = Path::dirContent(PHOTO_PATH);
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

	public function parser() {
		$this->autoRender = true;
		$this->loadModel('Task');

		$task = $this->Task->getActiveTask('ProductCsvParser', 0);
		if ($task) {
			$id = Hash::get($task, 'Task.id');
			$task = $this->Task->getFullData($id);
			if ($task['status'] === 'DONE') {
				$this->Task->close($task['id']);
				$this->redirect(array('action' => 'parser'));
				return;
			}
			if (!isset($task['subtask'])) {
				$task['subtask'] = true;
			}
			$this->set(compact('task'));
		} else {
			$id = $this->Task->add(0, 'ProductCsvParser');
			$this->Task->runBkg($id);
			sleep(1);
			$this->redirect(array('action' => 'parser'));
		}
	}
}
