<?
    $title = __('Upgrade');
    $breadcrumbs = array(
        __('User area') => 'javascript:;',
        $title => ''
    );
    echo $this->element('AdminUI/breadcrumbs', compact('breadcrumbs'));
    echo $this->element('AdminUI/title', compact('title'));
    echo $this->Flash->render();
?>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
<?
    echo __('Upgrade');
?>
            </div>
        </div>
    </div>
