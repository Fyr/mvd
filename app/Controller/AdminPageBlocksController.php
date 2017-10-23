<?php
App::uses('AppController', 'Controller');
App::uses('AdminController', 'Controller');
App::uses('AdminContentController', 'Controller');
class AdminPageBlocksController extends AdminContentController {
    public $name = 'AdminPageBlocks';
    public $uses = array('PageBlock');

    protected $parentModel = 'Page';

    public $paginate = array(
        'fields' => array('title_$lang', 'slug', 'published', 'sorting'),
        'order' => array('sorting' => 'asc'),
        'limit' => 20
    );

}
