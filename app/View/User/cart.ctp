<style>
    .dataTables_wrapper { margin-bottom: 40px; }
</style>
<?
    $title = __('Cart');
    $breadcrumbs = array(
        __('User area') => 'javascript:;',
        $title => ''
    );
    echo $this->element('AdminUI/breadcrumbs', compact('breadcrumbs'));
    echo $this->element('AdminUI/title', compact('title'));
    echo $this->Flash->render();
?>
<form action="" method="post">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
<?
    if ($songs) {
        echo $this->element('../User/_cart_songs');
    }
    if ($packs) {
        echo $this->element('../User/_cart_packs');
    }
    if ($customOrders) {
        echo $this->element('../User/_cart_customorders');
    }
    if ($songs || $packs || $customOrders) {
?>
                    <div class="portlet-title">
                        <div class="caption font-red">
                            <span class="caption-subject bold uppercase"><?=__('Total')?></span>
                        </div>
                        <div id="total" class="actions" style="font-weight: bold; font-size: 16px; margin-right: 10px;">

                        </div>
                    </div>
                    <div class="portlet-body">
                        <button type="submit" class="btn blue">
                            <i class="fa fa-save"></i>
                            <?=__('Create order')?>
                        </button>
                    </div>

<?
    } else {
        echo __('Your cart is empty');
    }
?>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    var decimals, dec_point, thousands_sep, prefix, postfix;
    function price_format(number) {
        price = (prefix + number_format(number, decimals, dec_point, thousands_sep) + postfix);
        return price.replace(/\$P/ig, '<span class="rubl">₽</span>');
    }

    function updateTotal() {
        var total = 0;
        $('td.checkboxes :checked').each(function(){
            var $tr = $(this).closest('tr');
            total+= parseFloat($('.price', $tr).html());
        });
        $('#total').html(price_format(total));
        $('[type=submit]').prop('disabled', !$('td.checkboxes :checked').length);
    }

    $(function(){
        decimals = '<?=Configure::read('Settings.decimals_'.$lang)?>';
        dec_point = '<?=Configure::read('Settings.float_div_'.$lang)?>';
        thousands_sep = '<?=Configure::read('Settings.int_div_'.$lang)?>';

        prefix = '<?=Configure::read('Settings.price_prefix_'.$lang)?>';
        postfix = '<?=Configure::read('Settings.price_postfix_'.$lang)?>';

        $('.dataTables_wrapper').each(function(){
            $('td.checkboxes input', this).prop('name', 'data[' + $(this).prop('id') + '][]')
        });

        $('#customOrders td.checkboxes input').each(function(i){
            $(this).prop('value', i);
        });

        $('td.checkboxes .checker span').addClass('checked');
        $('td.checkboxes input').prop('checked', true);
        updateTotal();

        $('[type=checkbox]').change(function(){
            updateTotal();
        });
    });
</script>