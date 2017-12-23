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
		$order = 'Category.sorting';
		$aCategories = $this->Category->find('all', compact('order'));
		$order = 'Subcategory.sorting';
		$aSubcategories = $this->Subcategory->find('all', compact('order'));
		$this->set(compact('aCategories', 'aSubcategories'));

		$this->currMenu = 'Products';
		parent::beforeRender();
	}

	public function categories() {
	}

	public function index() {
		$filter = array();
		if ($cat_id = $this->request->query('cat_id')) {
			$filter['cat_id'] = $cat_id;
			$this->set('curr_cat_id', $cat_id);
		}
		$this->paginate = array(
			'Product' => array(
				'conditions' => array_merge(array('Product.published' => 1), $filter),
				'order' => array('modified' => 'desc'),
				'limit' => 9
			)
		);
		$this->set('filter', $filter);
		$this->set('aArticles', $this->paginate('Product'));

	}

	public function view($id) {
		$article = $this->Product->findById($id);
		$aMedia = $this->Media->getList(array('object_type' => 'Product', 'object_id' => $id));
		$curr_cat_id = $article['Product']['cat_id'];
		$this->set(compact('article', 'curr_cat_id', 'aMedia'));
	}


}
