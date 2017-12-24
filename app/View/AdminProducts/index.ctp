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
    unset($columns['Product.id_num']);
    $columns['Product.featured']['label'] = __('For home page');
    array_unshift($columns, array('key' => 'Product.photo', 'label' => __('Photo'), 'format' => 'string'));

    $rowset = $this->PHTableGrid->getDefaultRowset($objectType);
    $aSubcategories = Hash::combine($aSubcategories, '{n}.Subcategory.id', '{n}.Subcategory.title');
    foreach($rowset as &$row) {
        $row['Product']['photo'] = $this->Html->image($this->Media->imageUrl($row, '100x'));
        $row['Product']['title'] = sprintf("<small>%s &gt; %s</small><br />%s<br /><small>%s: #%s</small>",
            $aCategories[$row['Product']['cat_id']],
            $aSubcategories[$row['Product']['subcat_id']],
            $row['Product']['title'],
            __('ID Num'),
            $row['Product']['id_num']
        );
    }

    $row_actions = '../AdminProducts/_row_actions';
?>
<style>
    .table.dataTable > tbody > tr > td:first-child {
        text-align: center;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <?=$this->element('AdminUI/form_title', array('title' => $title))?>
            <div class="portlet-body dataTables_wrapper">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <form class="form-inline" role="form" method="get">
                                <div class="form-group">
                                    <label class="sr-only">Название</label>
                                    <input type="text" class="form-control input-xlarge" placeholder="Введите название предмета..." name="q" value="<?=$this->request->query('q')?>">
                                </div>
                                <div class="btn-group">
                                    <button class="btn blue">
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
                        <div class="col-md-6">
                        </div>
                    </div>
                </div>
                <?=$this->PHTableGrid->render($objectType, compact('rowset', 'columns', 'row_actions'))?>
            </div>
        </div>
    </div>
</div>
