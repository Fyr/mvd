<?
    $row_actions = '../AdminOrders/_edit_row_actions';
    $pagination = false;
    $order = '';
    $columns = array(
        'Song.title' => array(
            'key' => 'Song.title',
            'label' => __('Song'),
            'format' => 'string'
        ),
        'Song.format' => array(
            'key' => 'Song.format',
            'label' => __('Format'),
            'format' => 'string'
        ),
        'Song.back_vocals' => array(
            'key' => 'Song.back_vocals',
            'label' => __('Back vocals'),
            'format' => 'boolean'
        ),
        'Song.video_clip' => array(
            'key' => 'Song.video_clip',
            'label' => __('Video clip'),
            'format' => 'boolean'
        ),/*
        'Song.price' => array(
            'key' => 'Song.price',
            'label' => __('Price'),
            'format' => 'integer'
        )
*/
        'OrderSong.status' => array(
            'key' => 'OrderSong.status',
            'label' => __('Status'),
            'format' => 'string'
        ),
        'OrderSong.url' => array(
            'key' => 'OrderSong.url',
            'label' => __('URL'),
            'format' => 'string'
        ),
    );
    $rowset = array();
    foreach($orderData['OrderSongs'] as $row) {
        $song_id = $row['OrderSong']['song_id'];
        $row['Song'] = $orderData['Songs'][$song_id];
        $row['Song']['title'] = $row['Song']['artist'].'<br />'.$row['Song']['song'];
        $row['OrderSong']['status'] = $this->Settings->getStatus('OrderSong', $row['OrderSong']['status']);
        $row['OrderSong']['url'] = ($row['OrderSong']['url']) ? $this->Html->link(__('Download'), $row['OrderSong']['url'], array('target' => '_blank')) : '';
        // $price = $this->Settings->read('song_price');
        // $row['Song']['price'] = $this->Price->format($price, $lang).'<span class="price hidden">'.$price.'</span>';
        $rowset[] = $row;
    }

?>

            <?=$this->element('AdminUI/form_title', array('title' => __('Songs')))?>
            <div id="songs" class="portlet-body dataTables_wrapper">
                <?=$this->PHTableGrid->render('Song', compact('row_actions', 'rowset', 'columns', 'order', 'pagination'))?>
            </div>
