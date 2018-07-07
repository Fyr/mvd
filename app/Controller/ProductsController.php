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

	private function _getFilter() {
		$filter = array();
		if ($cat_id = $this->request->query('cat_id')) {
			$filter['cat_id'] = $cat_id;
		}
		if ($subcat_id = $this->request->query('subcat_id')) {
			$filter['subcat_id'] = $subcat_id;
		}
		if ($q = $this->request->query('q')) {
			$filter['OR'] = array('Product.title LIKE ' => "%$q%", 'Product.teaser LIKE ' => "%$q%");
		}
		return $filter;
	}

	public function index() {
		$filter = $this->_getFilter();
		$this->paginate = array(
			'Product' => array(
				'conditions' => array_merge(array('Product.published' => 1), $filter),
				'order' => array('modified' => 'desc'),
				'limit' => 8
			)
		);
		$this->set('filter', $filter);
		$this->set('aArticles', $this->paginate('Product'));
		$this->set('lDirectSearch', $this->request->query('q') && true);
	}

	public function view($id) {
		$article = $this->Product->findById($id);
		$order = null;
		if (Hash::get($article, 'Media.file') === '3D_image') {
			$order = array('Media.main' => 'DESC', 'Media.orig_fname' => 'ASC');
		}
		$aMedia = $this->Media->getList(array('object_type' => 'Product', 'object_id' => $id, 'main' => 0), $order);
		$this->set(compact('article', 'aMedia'));
	}


}
