<?
    $row_actions = '../AdminOrders/_edit_row_actions';
    $pagination = false;
    $order = '';

    $columns = array(
        'SongPack.title' => array(
            'key' => 'SongPack.title',
            'label' => __('Title'),
            'format' => 'string'
        ),/*
        'SongPack.filesize' => array(
            'key' => 'SongPack.filesize',
            'label' => __('Filesize'),
            'format' => 'integer'
        ),
        'SongPack.price' => array(
            'key' => 'SongPack.price',
            'label' => __('Price'),
            'format' => 'integer'
        )*/
        'OrderPack.status' => array(
            'key' => 'OrderPack.status',
            'label' => __('Status'),
            'format' => 'string'
        ),
        'OrderPack.url' => array(
            'key' => 'OrderPack.url',
            'label' => __('URL'),
            'format' => 'string'
        ),
    );
    $rowset = array();
    foreach($orderData['OrderPacks'] as $row) {
        $pack_id = $row['OrderPack']['pack_id'];
        $row['SongPack'] = $orderData['Packs'][$pack_id];
        $row['SongPack']['title'] = $row['SongPack']['title_'.$lang];
        $row['OrderPack']['status'] = $this->Settings->getStatus('OrderPack', $row['OrderPack']['status']);
        $row['OrderPack']['url'] = ($row['OrderPack']['url']) ? $this->Html->link(__('Download'), $row['OrderPack']['url'], array('target' => '_blank')) : '';
        /*
        $price = $this->Settings->read('pack_price');
        $row[$objectType]['price'] = $this->Price->format($price, $lang).'<span class="price hidden">'.$price.'</span>';
        $row[$objectType]['filesize'] = $this->PHMedia->MediaPath->filesizeFormat($aMedia[$id]['Media']['orig_fsize'], 1);
        */
        $rowset[] = $row;
    }
?>
            <?=$this->element('AdminUI/form_title', array('title' => __('Song packs')))?>
            <div id="packs" class="portlet-body dataTables_wrapper">
                <?=$this->PHTableGrid->render('SongPack', compact('row_actions', 'rowset', 'columns', 'order', 'pagination'))?>
            </div>
