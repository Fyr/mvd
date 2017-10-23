<?
    $title = $this->ObjectType->getTitle('index', $objectType);
    $breadcrumbs = array(
        __('User area') => 'javascript:;',
        $title => ''
    );
    echo $this->element('AdminUI/breadcrumbs', compact('breadcrumbs'));
    echo $this->element('AdminUI/title', compact('title'));
    echo $this->Flash->render();

    $checkboxes = true;
    // $columns = $this->PHTableGrid->getDefaultColumns($objectType);
/*
    $columns = $this->PHTableGrid->getDefaultColumns($objectType);
    $columns[$objectType.'.title_'.$lang]['label'] = __('Title');
    $columns[$objectType.'.filesize'] = array(
        'key' => 'SongPack.filesize',
        'label' => __('File size'),
        'format' => 'integer'
    );

    $rowset = $this->PHTableGrid->getDefaultRowset($objectType);
    foreach($rowset as &$row) {
        $id = $row[$objectType]['id'];
        $row[$objectType]['filesize'] = $this->PHMedia->MediaPath->filesizeFormat($aMedia[$id]['Media']['orig_fsize'], 1);
    }
*/
    $row_actions = false;
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <?=$this->element('AdminUI/form_title', array('title' => $title))?>
            <div class="portlet-body dataTables_wrapper">
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="btn-group">
                                <button id="addCart" class="btn green" onclick="item_addCart()" disabled="disabled">
                                    <i class="fa fa-shopping-cart"></i> <?=__('Add to cart')?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-12">
<?
    $options = array(
        'class' => 'form-inline',
        'type' => 'get',
        'url' => array('controller' => 'user', 'action' => 'songs'),
        'inputDefaults' => array(
            'div' => 'form-group',
            'class' => 'form-control',
            'label' => array('class' => 'sr-only'),
            // 'between' => '<div class="col-md-9">',
            // 'after' => '</div>',
        )

    );
    echo $this->Form->create('Song', $options);
    echo $this->Form->input('artist', array('placeholder' => __('Artist')));
    echo $this->Form->input('song', array('placeholder' => __('Song')));

    $aFormatOptions = array_merge(array('' => __('- any format -')), $aFormatOptions);
    $value = $this->request->query('format');
    echo $this->Form->input('format', array('options' => $aFormatOptions, 'value' => $value, 'autocomplete' => 'off'));
    echo $this->Form->input('back_vocals', array('label' => array('class' => '', 'text' => __('Back vocals'))));
    echo $this->Form->input('video_clip', array('label' => array('class' => '', 'text' => __('Video clip'))));
    echo $this->Form->button('<i class="fa fa-search"></i>&nbsp;'.__('Find'), array('class' => 'btn btn-primary'));
    echo $this->Form->end();
?>

                        </div>
                    </div>
                </div>
                <?=$this->PHTableGrid->render($objectType, compact('row_actions', 'checkboxes'))?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var type;
    function item_addCart() {
        $('td.checkboxes :checked').each(function(){
            cartAdd(type, $(this).val());
        });
        window.location.href = (window.location.href + '?items=' + $('td.checkboxes :checked').length);
    }

    function updateCartBtn() {
        $('#addCart').prop('disabled', !$('td.checkboxes [type=checkbox]:checked').length);
    }

    $(function(){
        type = 'songs';
        $('td.checkboxes').each(function(){
            var cart = getCart();
            if (!cart[type]) {
                cart[type] = [];
            }
            if (in_array($('[type=checkbox]', this).val(), cart[type])) {
                $(this).html('<i class="fa fa-shopping-cart"></i>');
            }
        });

        $('td.checkboxes [type=checkbox]').change(function(){
            updateCartBtn();
        });
        $('.dataTable th.checkboxes input[type=checkbox]').change(function() {
            setTimeout(function(){ // должен отработать обработчик grid.js
                var checked = $(this).prop('checked');
                updateCartBtn();
            }, 10);
        });
    });
</script>