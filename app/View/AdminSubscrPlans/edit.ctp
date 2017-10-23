<?
    $id = $this->request->data($objectType.'.id');
    $title = $this->ObjectType->getTitle('index', $objectType);
    $breadcrumbs = array(
        __('Catalogs') => 'javascript:;',
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
            .$this->PHForm->input('descr_'.$lang,
                array('label' => array('class' => 'col-md-3 control-label', 'text' => __('Description')))
            )
            .$this->PHForm->input('price_'.$lang,
                array(
                    'class' => 'form-control input-small',
                    'label' => array('class' => 'col-md-3 control-label', 'text' => __('Price'))
                )
            )
            .$this->PHForm->input('sorting', array('class' => 'form-control input-small'))
        )
    );

    echo $this->element('AdminUI/tabs', compact('tabs'));
    echo $this->element('AdminUI/form_actions', array('backURL' => array('action' => 'index')));
    echo $this->PHForm->end();
?>
        </div>
    </div>
</div>
