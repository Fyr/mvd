<?php
App::uses('AppController', 'Controller');
App::uses('AdminController', 'Controller');
App::uses('AdminContentController', 'Controller');
App::uses('Product', 'Model');
App::uses('ParamGroup', 'Model');
App::uses('ProductPack', 'Model');
App::uses('PMFormField', 'Form.Model');
App::uses('PMFormValue', 'Form.Model');
App::uses('Price', 'View/Helper');
class AdminProductPacksController extends AdminContentController {
    public $name = 'AdminProductPacks';
    public $uses = array('ProductPack', 'Product', 'ParamGroup', 'Form.PMFormField', 'Form.PMFormValue');
    public $helpers = array('Price');

    public $paginate = array(
        'fields' => array('title_$lang', 'price_$lang', 'sorting'),
        'order' => array('sorting' => 'asc'),
        'limit' => 20
    );

    protected $parentModel = 'Product';

    protected function afterSave($id) {
        $this->PMFormValue->saveValues('ProductPackParam', $id, $this->request->data('PMFormValue'));
    }

    public function edit($id = 0, $parent_id = '') {
        parent::edit($id, $parent_id);

        // find all groups of params by category of product
        $product = $this->Product->findById($this->parent_id);
        $cat_id = $product['Product']['parent_id'];
        $conditions = array('parent_id' => $cat_id, 'featured' => 1);
        $order = 'sorting';
        $aParamGroups = $this->ParamGroup->find('all', compact('conditions', 'order'));
        $aParamGroups = Hash::combine($aParamGroups, '{n}.ParamGroup.id', '{n}');
        $this->set('aFormGroups', $aParamGroups);

        // find all params by groups
        $conditions = array('object_type' => 'PMFormField', 'parent_id' => array_keys($aParamGroups));
        $order = 'sorting';
        $aParams = $this->PMFormField->find('all', compact('conditions', 'order'));
        if ($aParams) {
            $ids = Hash::extract($aParams, '{n}.PMFormField.id');
            $aParams = Hash::combine($aParams, '{n}.PMFormField.id', '{n}', '{n}.PMFormField.parent_id');
        }
        $this->set('aForms', $aParams);

        // get all values of params
        $aValues = array();
        if ($this->request->is(array('put', 'post'))) {
            $aValues = $this->request->data('PMFormValue');
        } elseif ($id) {
            $aValues = $this->PMFormValue->getValues('ProductPackParam', $id);
        }
        $this->set('aValues', $aValues);
    }
}
