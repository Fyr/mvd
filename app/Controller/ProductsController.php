<?php
App::uses('AppController', 'Controller');
App::uses('Media', 'Media.Model');
App::uses('Product', 'Model');
App::uses('Category', 'Model');
App::uses('Subcategory', 'Model');
class ProductsController extends AppController {
	public $name = 'Products';
	public $uses = array('Media.Media', 'Product', 'Category', 'Subcategory');

	public function beforeRender() {
		parent::beforeRender();

		$order = 'Category.sorting';
		$aCategories = $this->Category->find('all', compact('order'));
		$order = 'Subcategory.sorting';
		$aSubcategories = $this->Subcategory->find('all', compact('order'));
		$this->set(compact('aCategories', 'aSubcategories'));
	}

	public function categories() {
	}

	public function index() {
		$this->paginate = array(
			'Product' => array(
				'conditions' => array('Product.published' => 1),
				'order' => array('modified' => 'desc'),
				'limit' => 9
			)
		);
		$this->set('aArticles', $this->paginate('Product'));
	}

	public function view($id) {
		$article = $this->Product->findById($id);
		$this->set(compact('article'));
	}


}
