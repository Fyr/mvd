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
/*
    public function index($parent_id = '') {
        if ($parent_id) {
            // Fix for redirecting on parent list
            return $this->redirect(array('action' => 'index'));
        }
        parent::index();
    }

    public function edit($id = 0, $cat_id = 0, $subcat_id = 0) {
        parent::edit($id, 0);
    }
*/
}
