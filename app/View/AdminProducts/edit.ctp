<?
    $id = $this->request->data($objectType.'.id');
    $title = $this->ObjectType->getTitle('index', $objectType);
    $breadcrumbs = array(
        __('Dashboard') => array('controller' => 'Admin', 'action' => 'index'),
        $title => array('action' => 'index'),
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

    $tabs = array(
        __('General') => $this->Html->div('form-body',
            $this->element('AdminUI/checkboxes')
            .$this->PHForm->input('title_'.$lang,
                array('label' => array('class' => 'col-md-3 control-label', 'text' => __('Title')))
            )
            .$this->PHForm->input('header_'.$lang,
                array('label' => array('class' => 'col-md-3 control-label', 'text' => __('Header')))
            )
            .$this->PHForm->input('slug')
            .$this->PHForm->input('parent_id', array('options' => $aCategoryOptions, 'label' => array('class' => 'col-md-3 control-label', 'text' => __('Category'))))
            .$this->PHForm->input('teaser_'.$lang,
                array('label' => array('class' => 'col-md-3 control-label', 'text' => __('Teaser')))
            )
            .$this->PHForm->input('sorting', array('class' => 'form-control input-small'))
        ),
        __('Text') => $this->element('Article.edit_body', array('field' => 'body_'.$lang)),
        __('Features') => $this->PHForm->input('spec_features_'.$lang,
                array('label' => array('class' => 'col-md-3 control-label', 'text' => __('Spec.features list')))
            )
            .$this->PHForm->input('features_'.$lang,
                array('label' => array('class' => 'col-md-3 control-label', 'text' => __('Features list'))))

    );

    foreach($aFormGroups as $_id => $group) {
        $title = $group['ParamGroup']['title_'.$lang];
        if ($form = Hash::get($aForms, $_id)) {
            $tabs[$title] = $this->PHForm->renderForm($form, $aValues);
        }
    }
    if ($id) {
        $tabs[__('Media')] = $this->element('Media.edit', array('object_type' => $objectType, 'object_id' => $id));
    }

    echo $this->element('AdminUI/tabs', compact('tabs'));
    echo $this->element('AdminUI/form_actions', array('backURL' => array('action' => 'index')));
    echo $this->PHForm->end();
?>
        </div>
    </div>
</div>
