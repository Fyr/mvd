<?
    $title = $this->ObjectType->getTitle('index', $objectType);
    $breadcrumbs = array(
        __('Catalogs') => 'javascript:;',
        $title => ''
    );
    echo $this->element('AdminUI/breadcrumbs', compact('breadcrumbs'));
    echo $this->element('AdminUI/title', compact('title'));
    echo $this->Flash->render();

    $columns = $this->PHTableGrid->getDefaultColumns($objectType);
    $columns = array(
        'Order.id' => array(
            'key' => 'Order.id',
            'label' => __('Order N'),
            'format' => 'integer'
        ),
        'Order.user_id' => array(
            'key' => 'Order.user_id',
            'label' => __('User'),
            'format' => 'string'
        ),
        'Order.created' => $columns['Order.created'],
        'Order.order_body' => array(
            'key' => 'Order.order_body',
            'label' => __('Ordered'),
            'format' => 'string'
        ),
        'Order.total_'.$lang => array(
            'key' => 'Order.total_'.$lang,
            'label' => __('Sum'),
            'format' => 'integer'
        ),
        'Order.status' => $columns['Order.status'],
    );

    $rowset = $this->PHTableGrid->getDefaultRowset($objectType);
    foreach($rowset as &$row) {
        $row['Order']['order_body'] = $this->element('../User/_orders_body', compact('row', 'orders', 'lang'));
        $row['Order']['status'] = $this->Settings->getStatus('Order', $row['Order']['status']);
        $row['Order']['total_'.$lang] = $this->Price->format($row['Order']['total_'.$lang], $lang);
        $user_id = $row['Order']['user_id'];
        $row['Order']['user_id'] = $this->Html->link($users[$user_id]['username'], 'mailto:'.$users[$user_id]['email']);
    }
    $row_actions = '../AdminOrders/_index_row_actions';
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <?=$this->element('AdminUI/form_title', array('title' => $title))?>
            <div class="portlet-body dataTables_wrapper">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-12">
<?
    $options = array(
        'class' => 'form-inline',
        'type' => 'get',
        'url' => array('controller' => 'AdminOrders', 'action' => 'index'),
        'inputDefaults' => array(
            'div' => 'form-group',
            'class' => 'form-control',
            'label' => array('class' => 'sr-only'),
            // 'between' => '<div class="col-md-9">',
            // 'after' => '</div>',
        )

    );
    echo $this->Form->create('Order', $options);
    echo $this->Form->input('id', array('type' => 'text', 'placeholder' => __('Order N')));

    $aOptions = Hash::merge(array('' => __('- any user -')), $aUserOptions);
    $value = $this->request->query('user_id');
    echo $this->Form->input('user_id', array('options' => $aOptions, 'value' => $value, 'autocomplete' => 'off'));

    $aOptions = Hash::merge(array('' => __('- any status -')), $this->Settings->getStatus('Order'));
    $value = $this->request->query('status');
    echo $this->Form->input('status', array('options' => $aOptions, 'value' => $value, 'autocomplete' => 'off'));

    echo $this->Form->button('<i class="fa fa-search"></i>&nbsp;'.__('Find'), array('class' => 'btn btn-primary'));
    echo $this->Form->end();
?>
                        </div>
                    </div>
                </div>
                <?=$this->PHTableGrid->render($objectType, compact('row_actions', 'rowset', 'columns'))?>
            </div>
        </div>
    </div>
</div>