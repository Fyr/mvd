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
    public $uses = array('Product', 'Category', 'Subcategory', 'Settings');
    public $helpers = array('Text', 'Media');

    public $paginate = array(
        'conditions' => array(),
        'fields' => array('created', 'cat_id', 'subcat_id', 'title', 'location', 'id_num', 'sorting'),
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
        $filter = array();
        $settings = $this->Settings->getData();
        if ($this->request->query) {
            $filter = $this->request->query;
        } elseif ($settings['Settings']['filter']) {
            $filter = unserialize($settings['Settings']['filter']);
        }

        if ($filter) {
            $this->Settings->save(array('id' => 1, 'filter' => serialize($filter)));
            foreach($filter as $key => $value) {
                $value = trim($value);
                if ($value) {
                    $this->paginate['conditions']["Product.{$key} LIKE "] = "%{$value}%";
                }
            }
        }

        if (Hash::get($this->request->params, 'named.sort')) {
            $this->Settings->save(array('id' => 1, 'sorting' => serialize(array(
                'sort' => Hash::get($this->request->params, 'named.sort'),
                'direction' => Hash::get($this->request->params, 'named.direction')
            ))));
        } else {
            if ($settings['Settings']['sorting']) {
                $sorting = unserialize($settings['Settings']['sorting']);
                foreach($sorting as $key => $value) {
                    $this->request->params['named'][$key] = $value;
                }
            }
        }
        if ($limit = Hash::get($this->request->params, 'named.limit')) {
            $this->paginate['limit'] = $limit;
        }
        $filter['limit'] = $this->paginate['limit'];
        $this->set(compact('filter'));
        parent::index($parent_id);
    }
}
