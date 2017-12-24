<?php
App::uses('AppController', 'Controller');
App::uses('Media', 'Media.Model');
App::uses('Page', 'Model');
App::uses('News', 'Model');
App::uses('Product', 'Model');
class PagesController extends AppController {
	public $uses = array('Media.Media', 'Page', 'News', 'Product', 'Category', 'Subcategory');
	public $helpers = array('Core.PHTime');

	public function beforeRender() {
		$order = 'Category.sorting';
		$aCategories = $this->Category->find('all', compact('order'));
		$order = 'Subcategory.sorting';
		$aSubcategories = $this->Subcategory->find('all', compact('order'));
		$this->set(compact('aCategories', 'aSubcategories'));

		parent::beforeRender();
	}

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

	public function about($slug = 'museum') {
		$aPages = array();
		foreach(array('museum', 'customers', 'exposition') as $page) {
			$aPages[$page] = $this->Page->findBySlug($page);
		}
		$this->set(compact('aPages', 'slug'));
	}

	public function history($slug = 'history-pdf') {
		$aPages = array();
		foreach(array('history-pdf', 'history') as $page) {
			$aPages[$page] = $this->Page->findBySlug($page);
		}
		$this->set(compact('aPages', 'slug'));
	}

	public function view($slug) {
		$this->set('article', $this->Page->findBySlug($slug));
		$this->currMenu = ucfirst($slug);
	}
}
