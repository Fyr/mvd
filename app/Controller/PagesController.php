<?php
App::uses('AppController', 'Controller');
App::uses('Media', 'Media.Model');
App::uses('Page', 'Model');
App::uses('News', 'Model');
App::uses('Product', 'Model');
class PagesController extends AppController {
	public $uses = array('Media.Media', 'Page', 'News', 'Product');

	public function home() {
		$page = $this->Page->findBySlug('home');
		$aSlider = $this->Media->getList(array('object_type' => 'Slider'));

		$conditions = array('published' => 1, 'featured' => 1);
		$order = array('modified' => 'desc');
		$aNews = $this->News->find('all', compact('conditions', 'order'));

		$conditions = array('Product.published' => 1, 'Product.featured' => 1);
		$order = array('Product.modified' => 'desc');
		$aProducts = $this->Product->find('all', compact('conditions', 'order'));

		$this->set(compact('page', 'aSlider', 'aNews', 'aProducts'));
	}

	public function about() {
		$aPages = array();
		foreach(array('museum', 'customers', 'exposition') as $page) {
			$aPages[$page] = $this->Page->findBySlug($page);
		}

		$this->set(compact('aPages'));
	}

	public function view($slug) {
		$this->set('page', $this->Page->findBySlug($slug));
		$this->currMenu = ucfirst($slug);
	}
}
