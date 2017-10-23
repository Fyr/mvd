<?php
App::uses('AppController', 'Controller');
App::uses('AdminController', 'Controller');
App::uses('AdminContentController', 'Controller');
class AdminNewsController extends AdminContentController {
    public $name = 'AdminNews';
    public $uses = array('News');

    public $paginate = array(
        'conditions' => array(),
        'fields' => array('modified', 'title_$lang', 'slug', 'published', 'featured'),
        'order' => array('sorting' => 'asc'),
        'limit' => 20
    );
}
