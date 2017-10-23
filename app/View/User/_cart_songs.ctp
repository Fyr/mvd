<?
    $checkboxes = true;
    $row_actions = false;
    $pagination = false;
    $order = '';
    $rowset = $songs;

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
        ),
        'Song.price' => array(
            'key' => 'Song.price',
            'label' => __('Price'),
            'format' => 'integer'
        )
    );
    $rowset = array();
    foreach($songs as $row) {
        $row['Song']['title'] = $row['Song']['artist'].'<br />'.$row['Song']['song'];
        $price = $this->Settings->read('song_price');
        $row['Song']['price'] = $this->Price->format($price, $lang).'<span class="price hidden">'.$price.'</span>';
        $rowset[] = $row;
    }
?>

            <?=$this->element('AdminUI/form_title', array('title' => __('Songs')))?>
            <div id="songs" class="portlet-body dataTables_wrapper">
                <?=$this->PHTableGrid->render('Song', compact('row_actions', 'checkboxes', 'rowset', 'columns', 'order', 'pagination'))?>
            </div>
