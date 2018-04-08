<?
    $title = __('Product CSV Parser');
    $breadcrumbs = array(
        __('Background tasks') => 'javascript:;',
        $title => ''
    );
    echo $this->element('AdminUI/breadcrumbs', compact('breadcrumbs'));
    echo $this->element('AdminUI/title', array('title' => __('Background tasks')));
    echo $this->Flash->render();

    if (isset($task)) {
        $aTaskNames = array(
            'ProductCsvParser' => $title,
            'ProductCsvParser_clearMedia' => 'Очистка предыдущих данных...',
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
<?
    } else {
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
<?
        echo $this->element('AdminUI/form_title', compact('title'));
        echo $this->PHForm->create('parserForm', array(
            'method' => 'POST',
            'enctype' => 'multipart/form-data'
        ));
        echo $this->PHForm->input('clear_data', array('type' => 'checkbox', 'checked' => 1, 'autocomplete' => 'off',
            'label' => array('text' => 'Очищать данные перед загрузкой', 'class' => 'col-md-3 control-label'),
        ));
        echo $this->PHForm->input('csv_file', array(
            'type' => 'file',
            'label' => array('text' => 'Загрузить файл', 'class' => 'col-md-3 control-label'),
            'help-block' => 'Выберите файл CSV-формата (разделители запятые)'
        ));
?>
        <div class="form-actions">
            <?=$this->element('AdminUI/form_apply', array('title' => 'Начать загрузку'))?>
        </div>
<?
        echo $this->PHForm->end();
?>
        </div>
    </div>
</div>
<?
    }
?>