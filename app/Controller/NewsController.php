<?php
App::uses('AppController', 'Controller');
App::uses('News', 'Model');
class NewsController extends AppController {
	public $name = 'News';
	public $uses = array('News');
	// public $helpers = array('Core.PHTime');

	public function index($page = 1) {
		$conditions = array('published' => 1);
		$order = 'modified DESC';
		$limit = 6;
		$this->set('aNews', $this->News->find('all', compact('conditions', 'order', 'limit', 'page')));

		$more = $this->News->find('count', compact('conditions'));
		$more = intval($more) > $page * $limit;
		$this->set(compact('more'));
		if ($this->request->is('ajax')) {
			// $this->layout = 'ajax';
			$this->render('/Elements/news', 'ajax');
		}
	}

	public function view($slug) {
		$article = $this->News->findBySlug($slug);
		$this->set('article', $article);

		$conditions = array('News.published' => 1, 'News.id <> ' => $article['News']['id']);
		$order = 'News.featured DESC, News.modified DESC';
		$limit = 3;
		$this->set('aFeaturedNews', $this->News->find('all', compact('conditions', 'order', 'limit')));
	}
}

