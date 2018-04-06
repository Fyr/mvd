<?
    $title = __('Product CSV Parser');
    $breadcrumbs = array(
        __('Background tasks') => 'javascript:;',
        $title => ''
    );
    echo $this->element('AdminUI/breadcrumbs', compact('breadcrumbs'));
    echo $this->element('AdminUI/title', array('title' => __('Background tasks')));
    echo $this->Flash->render();

    $aTaskNames = array(
        'ProductCsvParser_readCsv' => 'Чтение CSV файла...',
        'ProductCsvParser_updateProducts' => 'Сохранение предметов...'
    );
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <?=$this->element('AdminUI/form_title', compact('title'))?>
            <div class="portlet-body dataTables_wrapper">
                <?=$this->element('progress', compact('task', 'aTaskNames'))?>
            </div>
        </div>
    </div>
</div>
