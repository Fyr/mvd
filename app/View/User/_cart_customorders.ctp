<?
    $objectType = 'OrderCustom';
    $checkboxes = true;
    $row_actions = false;
    $pagination = false;
    $order = '';
    $rowset = $songs;

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
        ),
        'OrderCustom.price' => array(
            'key' => 'OrderCustom.price',
            'label' => __('Price'),
            'format' => 'integer'
        ),
    );
    $rowset = array();
    foreach($customOrders as $row) {
        $services = array();
        $price = 0;
        foreach($row['services'] as $id) {
            $services[] = $aServices[$id]['title_'.$lang];
            $price+= $aServices[$id]['price_'.$lang];
        }
        $rowset[] = array('OrderCustom' => array(
            'title' => $row['artist'].'<br />'.$row['song'],
            'services' => implode('<br />', $services),
            'price' => $this->Price->format($price, $lang).'<span class="price hidden">'.$price.'</span>'
        ));
    }
?>

            <?=$this->element('AdminUI/form_title', array('title' => __('Custom song order')))?>
            <div id="customOrders" class="portlet-body dataTables_wrapper">
                <?=$this->PHTableGrid->render($objectType, compact('row_actions', 'checkboxes', 'rowset', 'columns', 'order', 'pagination'))?>
            </div>
