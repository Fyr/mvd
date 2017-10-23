<style>
    .dataTables_wrapper { margin-bottom: 40px; }
</style>
<?
    $title = $this->ObjectType->getTitle('edit', $objectType);
    $breadcrumbs = array(
        __('Catalogs') => 'javascript:;',
        $this->ObjectType->getTitle('index', $objectType) => array('action' => 'index'),
        $title => ''
    );
    echo $this->element('AdminUI/breadcrumbs', compact('breadcrumbs'));

    $title = __('View order');
    echo $this->element('AdminUI/title', compact('title'));
    echo $this->Flash->render();
?>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
<?
    echo $this->element('AdminUI/form_title', array('title' => __('Order info')));
    echo $this->PHForm->create($objectType);
    echo $this->PHForm->textOnly(__('Order N'), $this->request->data('Order.id'));
    echo $this->PHForm->textOnly(__('Created'), $this->PHTime->niceShort($this->request->data('Order.created')));
    echo $this->PHForm->textOnly(__('Sum'), $this->Price->format($this->request->data('Order.total_'.$lang), $lang));
    echo $this->PHForm->input('status', array(
        'class' => 'form-control input-medium',
        'options' => $this->Settings->getstatus('Order', null)
    ));
    echo $this->element('AdminUI/form_save');
    echo $this->PHForm->end();
?>

        </div>
    </div>
</div>


    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
<?
    if ($orderData['OrderSongs']) {
        echo $this->element('../AdminOrders/_edit_order_songs');
    }
    if ($orderData['OrderPacks']) {
        echo $this->element('../AdminOrders/_edit_order_packs');
    }
    if ($orderData['OrderCustoms']) {
        echo $this->element('../AdminOrders/_edit_order_customorders');
    }
?>
            </div>
        </div>
    </div>
