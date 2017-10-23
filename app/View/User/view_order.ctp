<style>
    .dataTables_wrapper { margin-bottom: 40px; }
</style>
<?
    $title = __('View order');
    $breadcrumbs = array(
        __('User area') => 'javascript:;',
        __('My orders') => array('action' => 'orders'),
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
?>
            <div class="portlet-body">
                <table class="dataTable">
                    <tbody>
                    <tr>
                        <td width="1%" nowrap="nowrap"><?=__('Order N')?></td>
                        <td><?=$orderData['Order']['id']?></td>
                    </tr>
                    <tr>
                        <td><?=__('Created')?></td>
                        <td><?=$this->PHTime->niceShort($orderData['Order']['created'])?></td>
                    </tr>
                    <tr>
                        <td><?=__('Sum')?></td>
                        <td><?=$this->Price->format($orderData['Order']['total_rus'])?></td>
                    </tr>
                    <tr>
                        <td><?=__('Status')?></td>
                        <td><?=$this->Settings->getStatus('Order', $orderData['Order']['status'])?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
<?
    if ($orderData['OrderSongs']) {
        echo $this->element('../User/_view_order_songs');
    }
    if ($orderData['OrderPacks']) {
        echo $this->element('../User/_view_order_packs');
    }
    if ($orderData['OrderCustoms']) {
        echo $this->element('../User/_view_order_customorders');
    }
?>
            </div>
        </div>
    </div>
