<?php
App::uses('AppController', 'Controller');
App::uses('AdminController', 'Controller');
App::uses('AdminContentController', 'Controller');
class AdminProductBlocksController extends AdminContentController {
    public $name = 'AdminProductBlocks';
    public $uses = array('ProductBlock');

    protected $parentModel = 'Product';

    public $paginate = array(
        'fields' => array('title_$lang', 'published', 'sorting'),
        'order' => array('sorting' => 'asc'),
        'limit' => 20
    );

}
