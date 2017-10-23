<?
    $id = $this->request->data($objectType.'.id');
    $title = $this->ObjectType->getTitle('index', $objectType);
    /*
    $indexURL = array('controller' => 'AdminParams', 'action' => 'index', $parent_id);
    $groupsURL = array('controller' => 'AdminParamGroups', 'action' => 'index', Hash::get($category, 'Category.id'));
    $editURL = array('controller' => 'AdminParamGroups', 'action' => 'edit', Hash::get($parentArticle, 'ParamGroup.id'));
    $breadcrumbs = array(
        __('eCommerce') => 'javascript:;',
        $this->ObjectType->getTitle('index', 'Category') => array('controller' => 'AdminCategories', 'action' => 'index'),
        Hash::get($category, 'Category.title') => 'javascript:;',
        $this->ObjectType->getTitle('index', 'ParamGroup') => $groupsURL,
        Hash::get($parentArticle, 'ParamGroup.title') => $editURL,
        $title => $indexURL,
        __('Edit') => ''
    );
    */
    $indexURL = array('controller' => 'AdminParamGroups', 'action' => 'index', Hash::get($category, 'Category.id'));
    $editURL = array('controller' => 'AdminParamGroups', 'action' => 'edit', Hash::get($parentArticle, 'ParamGroup.id'));
    $breadcrumbs = array(
        __('eCommerce') => 'javascript:;',
        $this->ObjectType->getTitle('index', 'Category') => array('controller' => 'AdminCategories', 'action' => 'index'),
        Hash::get($category, 'Category.title_'.$lang) => array('controller' => 'AdminCategories', 'action' => 'edit', Hash::get($category, 'Category.id')),
        $this->ObjectType->getTitle('index', 'ParamGroup') => $indexURL,
        Hash::get($parentArticle, 'ParamGroup.title_'.$lang) => $editURL,
        $title => array('controller' => 'AdminParams', 'action' => 'index', $parent_id),
        __('Edit') => ''
    );
    echo $this->element('AdminUI/breadcrumbs', compact('breadcrumbs'));
    echo $this->element('AdminUI/title', compact('title'));
    echo $this->Flash->render();
?>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">

<?
    echo $this->element('AdminUI/form_title', array('title' => $this->ObjectType->getTitle($id ? 'edit' : 'create', $objectType)));
    echo $this->PHForm->create('PMFormField');

    echo $this->PHForm->input('label_'.$lang,
        array('label' => array('class' => 'col-md-3 control-label', 'text' => __('Label')))
    );
    echo $this->PHForm->input('field_type', array('options' => $aFieldTypes, 'label' => array('class' => 'col-md-3 control-label', 'text' => __('Field type'))));
    echo $this->PHForm->input('sorting', array('class' => 'form-control input-small'));

    echo $this->element('AdminUI/form_actions');
    echo $this->PHForm->end();
?>
        </div>
    </div>
</div>
