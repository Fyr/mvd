<?php
App::uses('AppController', 'Controller');
App::uses('AdminController', 'Controller');
App::uses('AdminContentController', 'Controller');
class AdminParamGroupsController extends AdminContentController {
    public $name = 'AdminParamGroups';
    public $uses = array('ParamGroup');

    public $paginate = array(
        'fields' => array('title_$lang', 'featured', 'sorting'),
        'order' => array('sorting' => 'asc'),
        'limit' => 20
    );

    protected $parentModel = 'Category';
}
