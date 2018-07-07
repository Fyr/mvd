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
        $src = $this->Media->imageUrl($row, '100x');
        $row['Product']['photo'] = ($src) ? $this->Html->image($src) : '';
        /*
        if ($title = Hash::get($filter, 'title')) {
            $row['Product']['title'] = $this->Text->highlight($row['Product']['title'], $title, array('format' => '<span class="label label-info">\1</span>'));
        }
        */
        $row['Product']['title'] = sprintf("<small>%s &gt; %s</small><br />%s<br /><small>",
            $aCategories[$row['Product']['cat_id']],
            $aSubcategories[$row['Product']['subcat_id']],
            $row['Product']['title']
        );
    }

    $row_actions = '../AdminProducts/_row_actions';
    $limitOptions = array(10 => '10', 20 => '20', 50 => '50');
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
                            <form class="form-inline" action="" role="form" method="get">
                                <div class="form-group">
                                    <?=__('Search item')?>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control input-xlarge" placeholder="<?=__('by item name...')?>" name="title" value="<?=Hash::get($filter, 'title')?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control input-medium" placeholder="<?=__('by item location...')?>" name="location" value="<?=Hash::get($filter, 'location')?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control input-medium" placeholder="<?=__('by number...')?>" name="id_num" value="<?=Hash::get($filter, 'id_num')?>">
                                </div>
                                <div class="btn-group">
                                    <button class="btn btn-info">
                                        <i class="fa fa-search"></i> <?=__('Find')?>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="btn-group">
                                <a class="btn green" href="<?=$this->Html->url(array('action' => 'edit', 0))?>">
                                    <i class="fa fa-plus"></i> <?=$this->ObjectType->getTitle('create', $objectType)?>
                                </a>
                            </div>
                            <form action="" class="form-inline pull-right" role="form" method="get">
                                <div class="form-group">
                                    <?=__('Show by')?>
                                </div>
                                <div class="form-group">
<?
    echo $this->PHForm->input('limit', array('class' => 'form-control', 'options' => $limitOptions, 'label' => false,
        'value' => Hash::get($filter, 'limit'), 'autocomplete' => 'off'
    ));
?>
                                </div>
                                <div class="form-group">
                                    <?=__('records')?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?=$this->PHTableGrid->render($objectType, compact('rowset', 'columns', 'row_actions'))?>
            </div>
        </div>
    </div>
</div>
<script>
$(function(){
    $('#limit').change(function(){
        var url = window.location.href;
        if (url.indexOf('limit:') > 0) {
            url = url.replace(/limit\:\d+/, 'limit:' + $(this).val());
        } else {
            if (url.indexOf('index') == -1) {
                url+= '/index';
            }
            url+= '/limit:' + $(this).val();
        }
        window.location.href = url;
    });
});
</script>