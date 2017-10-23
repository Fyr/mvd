<?
    $objectType = 'SongPack';
    $checkboxes = true;
    $row_actions = false;
    $pagination = false;
    $order = '';
    $rowset = $songs;

    $columns = array(
        'SongPack.title' => array(
            'key' => 'SongPack.title',
            'label' => __('Title'),
            'format' => 'string'
        ),
        'SongPack.filesize' => array(
            'key' => 'SongPack.filesize',
            'label' => __('Filesize'),
            'format' => 'integer'
        ),
        'SongPack.price' => array(
            'key' => 'SongPack.price',
            'label' => __('Price'),
            'format' => 'integer'
        )
    );
    $rowset = array();
    foreach($packs as $row) {
        $id = $row['SongPack']['id'];
        $row[$objectType]['title'] = $row[$objectType]['title_'.$lang];
        $price = $this->Settings->read('pack_price');
        $row[$objectType]['price'] = $this->Price->format($price, $lang).'<span class="price hidden">'.$price.'</span>';
        $row[$objectType]['filesize'] = $this->PHMedia->MediaPath->filesizeFormat($aMedia[$id]['Media']['orig_fsize'], 1);
        $rowset[] = $row;
    }
?>
            <?=$this->element('AdminUI/form_title', array('title' => __('Song packs')))?>
            <div id="packs" class="portlet-body dataTables_wrapper">
                <?=$this->PHTableGrid->render($objectType, compact('row_actions', 'checkboxes', 'rowset', 'columns', 'order', 'pagination'))?>
            </div>
