<?php
App::uses('AppController', 'Controller');
App::uses('AdminController', 'Controller');
App::uses('AdminContentController', 'Controller');
App::uses('Product', 'Model');
App::uses('Category', 'Model');
App::uses('ParamGroup', 'Model');
App::uses('PMFormField', 'Form.Model');
App::uses('PMFormValue', 'Form.Model');
class AdminProductsController extends AdminContentController {
    public $name = 'AdminProducts';
    public $uses = array('Product', 'Category', 'ParamGroup', 'Form.PMFormField', 'Form.PMFormValue');

    public $paginate = array(
        'fields' => array('parent_id', 'title_$lang', 'slug', 'published', 'featured', 'sorting'),
        'order' => array('sorting' => 'desc'),
        'limit' => 20
    );

    public function beforeRender() {
        parent::beforeRender();
        $this->set('aCategoryOptions', $this->Category->getOptions());
    }

    public function index($parent_id = '') {
        if ($parent_id) {
            // Fix for redirecting on parent list
            return $this->redirect(array('action' => 'index'));
        }
        parent::index();
    }

    protected function afterSave($id) {
        $this->PMFormValue->saveValues('ProductParam', $id, $this->request->data('PMFormValue'));
    }

    public function edit($id = 0, $parent_id = '') {
        parent::edit($id, $parent_id);

        $conditions = array('parent_id' => $this->parent_id, 'featured' => 0);
        $order = 'sorting';
        $aParamGroups = $this->ParamGroup->find('all', compact('conditions', 'order'));
        $aParamGroups = Hash::combine($aParamGroups, '{n}.ParamGroup.id', '{n}');
        $this->set('aFormGroups', $aParamGroups);

        $conditions = array('object_type' => 'PMFormField', 'parent_id' => array_keys($aParamGroups));
        $order = 'sorting';
        $aParams = $this->PMFormField->find('all', compact('conditions', 'order'));
        if ($aParams) {
            $ids = Hash::extract($aParams, '{n}.PMFormField.id');
            $aParams = Hash::combine($aParams, '{n}.PMFormField.id', '{n}', '{n}.PMFormField.parent_id');
        }
        $this->set('aForms', $aParams);

        $aValues = array();
        if ($this->request->is(array('put', 'post'))) {
            $aValues = $this->request->data('PMFormValue');
        } elseif ($id) {
            $aValues = $this->PMFormValue->getValues('ProductParam', $id);
        }
        $this->set('aValues', $aValues);
    }

}
