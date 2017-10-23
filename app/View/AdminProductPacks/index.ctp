<?
    $title = $this->ObjectType->getTitle('index', $objectType);
    $editURL = array('controller' => 'AdminProducts', 'action' => 'edit', Hash::get($parentArticle, 'Product.id'));
    $breadcrumbs = array(
        __('eCommerce') => 'javascript:;',
        $this->ObjectType->getTitle('index', 'Product') => array('controller' => 'AdminProducts', 'action' => 'index'),
        Hash::get($parentArticle, 'Product.title_'.$lang) => $editURL,
        $title => ''
    );
    echo $this->element('AdminUI/breadcrumbs', compact('breadcrumbs'));
    echo $this->element('AdminUI/title', compact('title'));
    echo $this->Flash->render();

    $price = 'price_'.$lang;
    $columns = $this->PHTableGrid->getDefaultColumns($objectType);
    $columns[$objectType.'.title_'.$lang]['label'] = __('Title');
    $columns[$objectType.'.price_'.$lang]['label'] = __('Price');

    $rowset = $this->PHTableGrid->getDefaultRowset($objectType);
    foreach($rowset as &$row) {
        $row['ProductPack'][$price] = $this->Price->format($row['ProductPack'][$price]);
    }
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <?=$this->element('AdminUI/form_title', array('title' => Hash::get($parentArticle, 'Product.title')))?>
            <div class="portlet-body dataTables_wrapper">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a class="btn green" href="<?=$this->Html->url(array('action' => 'edit', 0, $parent_id))?>">
                                    <i class="fa fa-plus"></i> <?=$this->ObjectType->getTitle('create', $objectType)?>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>
                </div>
                <?=$this->PHTableGrid->render($objectType, compact('rowset', 'columns'))?>
            </div>
        </div>
    </div>
</div>
