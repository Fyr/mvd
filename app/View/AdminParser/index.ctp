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
        if ($task['status'] === 'DONE') { // show stats
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <?=$this->element('AdminUI/form_title', compact('title'))?>
            <div class="portlet-body dataTables_wrapper">
                <div class="form">
                    <b>Загрузка успешно завершена!</b><br/>
                    <br/>
                    Загружено: <?=$task['xdata']['products']['total']?> предметов, из них: <br/>
                    <ul>
                        <li><?=$task['xdata']['products']['no_image']?> без фото</li>
                        <li><?=$task['xdata']['products']['image']?> с фото (всего <?=$task['xdata']['images']?> изображений)</li>
                        <li><?=$task['xdata']['products']['image_3d']?> c 3D фото (всего <?=$task['xdata']['images_3d']?> изображений для 3D)</li>
                        <li><?=$task['xdata']['products']['video']?> с видео (всего <?=$task['xdata']['video']?> видео-файлов)</li>
<?
            if ($task['xdata']['products']['error']) {
?>
                        <li><span class="alert-danger"><b><?=$task['xdata']['products']['error']?></b> с ошибкой</span></li>
<?
            }
?>
                    </ul><br/>

                    Отчет по загрузке: <a href="parser_log.txt" target="_blank">скачать</a><br/>
                    <br/>
                    <div class="form-actions">
                        <a class="btn default" href="<?=$this->Html->url(array('action' => 'index'))?>">
                            <i class="fa fa-angle-left"></i>&nbsp;&nbsp;<?=__('Back')?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?
        } else { // show progress
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <?= $this->element('AdminUI/form_title', compact('title')) ?>
            <div class="portlet-body dataTables_wrapper">
                <?= $this->element('progress', compact('task', 'aTaskNames')) ?>
            </div>
        </div>
    </div>
</div>
<?
        }
    } else { // show input form
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
        echo $this->PHForm->input('clear_data', array('type' => 'checkbox', 'checked' => 0, 'autocomplete' => 'off',
            'label' => array('text' => 'Очищать данные перед загрузкой', 'class' => 'col-md-3 control-label'),
        ));
        echo $this->PHForm->input('publish_all', array('type' => 'checkbox', 'checked' => 0, 'autocomplete' => 'off',
            'label' => array('text' => 'Публиковать предметы', 'class' => 'col-md-3 control-label'),
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