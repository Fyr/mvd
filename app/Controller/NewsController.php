<?php
App::uses('AppController', 'Controller');
App::uses('SiteRouter', 'Lib/Routing');
App::uses('News', 'Model');
class NewsController extends AppController {
	public $uses = array('News');
	public $helpers = array('Core.PHTime');

	public function index($page = 1) {
		$this->paginate = array(
			'News' => array(
				'conditions' => array('published' => 1),
				'order' => array('modified' => 'desc'),
				'limit' => 9
			)
		);
		$this->set('aArticles', $this->paginate('News'));
	}

	public function view($id) {
		$article = $this->News->findById($id);
		$this->set('article', $article);
	}
}

