<?php
App::uses('AppController', 'Controller');
App::uses('AdminController', 'Controller');
App::uses('AdminContentController', 'Controller');
App::uses('Product', 'Model');
App::uses('Category', 'Model');
App::uses('Subcategory', 'Model');
App::uses('Media', 'View/Helper');
class AdminProductsController extends AdminContentController {
    public $name = 'AdminProducts';
    public $uses = array('Product', 'Category', 'Subcategory');
    public $helpers = array('Media');

    public $paginate = array(
        'conditions' => array(),
        'fields' => array('created', 'cat_id', 'subcat_id', 'title', 'published', 'featured', 'sorting', 'id_num'),
        'recursive' => 2,
        'order' => array('sorting' => 'desc'),
        'limit' => 20
    );

    public function beforeRender() {
        parent::beforeRender();
        $this->set('aCategories', $this->Category->find('list', array(
            'conditions' => array('parent_id' => '0'),
            'order' => 'Category.title'
        )));
        $this->set('aSubcategories', $this->Subcategory->find('all', array(
            'conditions' => array('Subcategory.parent_id <> ' => '0'),
            'fields' => array('id', 'parent_id', 'title', 'Category.id', 'Category.title'),
            'order' => 'Subcategory.title'
        )));
    }

    public function index($parent_id = '') {
        if ($q = $this->request->query('q')) {
            $this->paginate['conditions']['Product.title LIKE '] = "$q%";
        }
        parent::index($parent_id);
    }
}
