<?
    $id = $this->request->data($objectType.'.id');
    $title = $this->ObjectType->getTitle('index', $objectType);
    $indexURL = array('controller' => 'AdminParamGroups', 'action' => 'index', $parent_id);
    $breadcrumbs = array(
        __('eCommerce') => 'javascript:;',
        $this->ObjectType->getTitle('index', 'Category') => array('controller' => 'AdminCategories', 'action' => 'index'),
        Hash::get($parentArticle, 'Category.title_'.$lang) => array('controller' => 'AdminCategories', 'action' => 'edit', Hash::get($parentArticle, 'Category.id')),
        $this->ObjectType->getTitle('index', 'ParamGroup') => $indexURL,
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
    echo $this->PHForm->create($objectType);
    echo $this->PHForm->input('title_'.$lang,
        array('label' => array('class' => 'col-md-3 control-label', 'text' => __('Title')))
    );
    echo $this->PHForm->input('sorting', array('class' => 'form-control input-small'));
    echo $this->PHForm->input('featured', array('label' => array('class' => 'col-md-3 control-label', 'text' => __('Product packs'))));
    echo $this->element('AdminUI/form_actions', array('backURL' => $indexURL));
    echo $this->PHForm->end();
?>
        </div>
    </div>
</div>
