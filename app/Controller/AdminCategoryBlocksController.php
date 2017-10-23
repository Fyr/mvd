<?php
App::uses('AppController', 'Controller');
App::uses('AdminController', 'Controller');
App::uses('AdminContentController', 'Controller');
class AdminCategoryBlocksController extends AdminContentController {
    public $name = 'AdminCategoryBlocks';
    public $uses = array('CategoryBlock');

    protected $parentModel = 'Category';

    public $paginate = array(
        'fields' => array('title_$lang', 'published', 'sorting'),
        'order' => array('sorting' => 'asc'),
        'limit' => 20
    );

}
