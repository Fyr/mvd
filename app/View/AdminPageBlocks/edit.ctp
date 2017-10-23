<?
    $id = $this->request->data($objectType.'.id');
    $title = $this->ObjectType->getTitle('index', $objectType);
    $indexURL = array('controller' => 'AdminPageBlocks', 'action' => 'index', $parent_id);
    $breadcrumbs = array(
        __('Static content') => 'javascript:;',
        $this->ObjectType->getTitle('index', 'Page') => array('controller' => 'AdminPages', 'action' => 'index'),
        Hash::get($parentArticle, 'Page.title_'.$lang) => array('controller' => 'AdminPages', 'action' => 'edit', Hash::get($parentArticle, 'Page.id')),
        $this->ObjectType->getTitle('index', 'PageBlock') => $indexURL,
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
            $this->element('AdminUI/checkboxes', array('checkboxes' => array('published')))
            .$this->PHForm->input('title_'.$lang,
                array('label' => array('class' => 'col-md-3 control-label', 'text' => __('Title')))
            )
            .$this->PHForm->input('slug')
            .$this->PHForm->input('teaser_'.$lang,
                array('label' => array('class' => 'col-md-3 control-label', 'text' => __('Teaser')))
            )
            .$this->PHForm->input('sorting', array('class' => 'form-control input-small'))
        ),
        __('Text') => $this->element('Article.edit_body', array('field' => 'body_'.$lang)),
    );

    if ($id) {
        $tabs[__('Media')] = $this->element('Media.edit', array('object_type' => $objectType, 'object_id' => $id));
    }

    echo $this->element('AdminUI/tabs', compact('tabs'));
    echo $this->element('AdminUI/form_actions', array('backURL' => $indexURL));
    echo $this->PHForm->end();
?>
        </div>
    </div>
</div>
