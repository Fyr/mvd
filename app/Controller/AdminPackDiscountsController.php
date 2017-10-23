<?php
App::uses('AppController', 'Controller');
App::uses('AdminController', 'Controller');
App::uses('AdminContentController', 'Controller');
class AdminPackDiscountsController extends AdminContentController {
    public $name = 'AdminPackDiscounts';
    public $uses = array('PackDiscount');

    public $paginate = array(
        'fields' => array('qty', 'discount'),
        'order' => array('qty' => 'asc'),
        'limit' => 20
    );

}
