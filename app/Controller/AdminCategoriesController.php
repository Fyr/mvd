<?php
App::uses('AppController', 'Controller');
App::uses('AdminController', 'Controller');
App::uses('AdminContentController', 'Controller');
class AdminCategoriesController extends AdminContentController {
    public $name = 'AdminCategories';
    public $uses = array('Category');

    public $paginate = array(
        'fields' => array('title_$lang', 'slug', 'sorting'),
        'order' => array('sorting' => 'desc'),
        'limit' => 20
    );
}
