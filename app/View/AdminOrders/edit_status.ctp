<style>
    .dataTables_wrapper { margin-bottom: 40px; }
</style>
<?
    // $title = $this->ObjectType->getTitle('edit', $objectType);
    $breadcrumbs = array(
        __('Catalogs') => 'javascript:;',
        $this->ObjectType->getTitle('index', $objectType) => array('action' => 'index'),
        __('Order N %s', $this->request->data('Order.id')) => array('action' => 'edit', $this->request->data('Order.id')),
        __('Edit status') => ''
    );
    echo $this->element('AdminUI/breadcrumbs', compact('breadcrumbs'));

    $title = __('Edit status');
    echo $this->element('AdminUI/title', compact('title'));
    echo $this->Flash->render();
?>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
<?
    echo $this->element('AdminUI/form_title', array('title' => __('Order info')));
    echo $this->PHForm->create('Order');
    echo $this->PHForm->textOnly(__('Order N'), $this->request->data('Order.id'));
    echo $this->PHForm->textOnly(__('Created'), $this->PHTime->niceShort($this->request->data('Order.created')));
    echo $this->PHForm->textOnly(__('Sum'), $this->Price->format($this->request->data('Order.total_'.$lang), $lang));
    echo $this->PHForm->textOnly(__('Status'), $this->Settings->getstatus('Order', $this->request->data('Order.status')));
    echo $this->PHForm->end();
?>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
<?
    $objectType = $this->request->pass[0];
    $aTitle = array(
        'OrderSong' => __('Songs'),
        'OrderPack' => __('Song packs'),
        'OrderCustom' => __('Custom song order')
    );

    echo $this->element('AdminUI/form_title', array('title' => $aTitle[$objectType]));
    echo $this->PHForm->create($objectType);
    if ($objectType == 'OrderSong') {
        echo $this->PHForm->textOnly(__('Song'), $song['Song']['artist'].' - '.$song['Song']['song']);
        echo $this->PHForm->textOnly(__('Format'), $song['Song']['format']);
        echo $this->PHForm->textOnly(__('Back vocals'), ($song['Song']['back_vocals']) ? __('Yes') : __('No'));
        echo $this->PHForm->textOnly(__('Video clip'), ($song['Song']['video_clip']) ? __('Yes') : __('No'));
    } elseif ($objectType == 'OrderPack') {
        echo $this->PHForm->textOnly(__('Title'), $pack['SongPack']['title_'.$lang]);
    } elseif ($objectType == 'OrderCustom') {
        $services = array();
        foreach($this->request->data('OrderService') as $_row) {
            $services[] = $aServices[$_row['service_id']];
        }
        echo $this->PHForm->textOnly(__('Services'), implode('<br />', $services));
    }
    echo $this->PHForm->input('status', array(
        'class' => 'form-control input-medium',
        'options' => $this->Settings->getStatus($objectType, null)
    ));
    echo $this->PHForm->input('url', array(
        'label' => array('class' => 'col-md-3 control-label', 'text' => __('URL'))
    ));
    echo $this->element('AdminUI/form_save');
    echo $this->PHForm->end();
?>
        </div>
    </div>
</div>
