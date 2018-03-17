<?
    $title = $this->ObjectType->getTitle('index', $objectType);
    $breadcrumbs = array(
        __('Collections') => 'javascript:;',
        $title => ''
    );
    echo $this->element('AdminUI/breadcrumbs', compact('breadcrumbs'));
    echo $this->element('AdminUI/title', array('title' => __('Collections')));
    echo $this->Flash->render();

    $columns = $this->PHTableGrid->getDefaultColumns($objectType);
    unset($columns['Product.cat_id']);
    unset($columns['Product.subcat_id']);
    $columns['Product.id_num']['label'] = 'Номер по КП';
    // $columns['Product.featured']['label'] = __('For home page');
    array_unshift($columns, array('key' => 'Product.photo', 'label' => __('Photo'), 'format' => 'string'));

    $rowset = $this->PHTableGrid->getDefaultRowset($objectType);
    $aSubcategories = Hash::combine($aSubcategories, '{n}.Subcategory.id', '{n}.Subcategory.title');
    foreach($rowset as &$row) {
        $row['Product']['photo'] = $this->Html->image($this->Media->imageUrl($row, '100x'));

        if ($title = Hash::get($filter, 'title')) {
            // $row['Product']['title'] = $this->Text->highlight($row['Product']['title'], $title, array('format' => '<span class="label label-info">\1</span>'));
        }

        $row['Product']['title'] = sprintf("<small>%s &gt; %s</small><br />%s<br /><small>",
            $aCategories[$row['Product']['cat_id']],
            $aSubcategories[$row['Product']['subcat_id']],
            $row['Product']['title']
        );
    }

    $row_actions = '../AdminProducts/_row_actions';
?>
<style>
    .table.dataTable > tbody > tr > td:first-child {
        text-align: center;
    }
    .highlight {
        color: #900;
        font-weight: bold;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <?=$this->element('AdminUI/form_title', array('title' => $title))?>
            <div class="portlet-body dataTables_wrapper">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-inline" role="form" method="get">
                                <div class="form-group">
                                    Найти предмет
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control input-xlarge" placeholder="по названию предмета..." name="title" value="<?=$this->request->query('title')?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control input-medium" placeholder="по месту хранения..." name="location" value="<?=$this->request->query('location')?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control input-medium" placeholder="по номеру..." name="id_num" value="<?=$this->request->query('id_num')?>">
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-info">
                                        <i class="fa fa-search"></i> Найти
                                    </button>
                                </div>
                            </form>
                            <hr/>
                            <div class="btn-group">
                                <a class="btn green" href="<?=$this->Html->url(array('action' => 'edit', 0))?>">
                                    <i class="fa fa-plus"></i> <?=$this->ObjectType->getTitle('create', $objectType)?>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
                <?=$this->PHTableGrid->render($objectType, compact('rowset', 'columns', 'row_actions'))?>
            </div>
        </div>
    </div>
</div>
