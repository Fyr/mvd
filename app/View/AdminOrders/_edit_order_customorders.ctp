<?
    $row_actions = '../AdminOrders/_edit_row_actions';
    $pagination = false;
    $order = '';

    $columns = array(
        'OrderCustom.title' => array(
            'key' => 'OrderCustom.title',
            'label' => __('Song'),
            'format' => 'string'
        ),
        'OrderCustom.services' => array(
            'key' => 'OrderCustom.services',
            'label' => __('Services'),
            'format' => 'string'
        ),/*
        'OrderCustom.price' => array(
            'key' => 'OrderCustom.price',
            'label' => __('Price'),
            'format' => 'integer'
        ),*/
        'OrderCustom.status' => array(
            'key' => 'OrderCustom.status',
            'label' => __('Status'),
            'format' => 'string'
        ),
        'OrderCustom.url' => array(
            'key' => 'OrderCustom.url',
            'label' => __('URL'),
            'format' => 'string'
        ),
    );
    $rowset = array();
    foreach($orderData['OrderCustoms'] as $row) {
        $row['OrderCustom']['title'] = $row['OrderCustom']['artist'].'<br />'.$row['OrderCustom']['song'];

        $services = array();
        // $price = 0;
        foreach($row['OrderService'] as $_row) {
            $services[] = $aServices[$_row['service_id']];
            // $price+= $aServices[$id]['price_'.$lang];
        }
        $row['OrderCustom']['services'] = implode('<br />', $services);
        $row['OrderCustom']['status'] = $this->Settings->getStatus('OrderCustom', $row['OrderCustom']['status']);
        $row['OrderCustom']['url'] = ($row['OrderCustom']['url']) ? $this->Html->link(__('Download'), $row['OrderCustom']['url'], array('target' => '_blank')) : '';
            /*
        $rowset[] = array('OrderCustom' => array(
            'title' => $row['artist'].'<br />'.$row['song'],
            'services' => implode('<br />', $services),
            'status' => $row['OrderCustom']['status'],
            'url' => $row['OrderCustom']['url'],
            // 'price' => $this->Price->format($price, $lang).'<span class="price hidden">'.$price.'</span>'
        ));
            */
        $rowset[] = $row;
    }
?>

            <?=$this->element('AdminUI/form_title', array('title' => __('Custom song order')))?>
            <div id="customOrders" class="portlet-body dataTables_wrapper">
                <?=$this->PHTableGrid->render('OrderCustom', compact('row_actions', 'rowset', 'columns', 'order', 'pagination'))?>
            </div>
