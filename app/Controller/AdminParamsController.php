<?php
App::uses('AppController', 'Controller');
App::uses('AdminController', 'Controller');
App::uses('AdminContentController', 'Controller');
App::uses('FieldTypes', 'Form.Vendor');
class AdminParamsController extends AdminContentController {
    public $name = 'AdminParams';
    public $uses = array('Form.PMFormField', 'Category');

    protected $parentModel = 'ParamGroup';

    public $paginate = array(
        'fields' => array('label_$lang', 'field_type', 'sorting'),
        'order' => array('published' => 'desc'),
        'limit' => 20
    );

    public function beforeRender() {
        parent::beforeRender();
        // $this->set('objectType', 'Param');
        $this->set('aFieldTypes', FieldTypes::getTypes());
        $category = $this->Category->findById($this->parentArticle['ParamGroup']['parent_id']);
        $this->set('category', $category);
    }
}
