<?
	$this->Html->css('bootstrap-multiselect', array('inline' => false));
	$this->Html->script(array(
		'vendor/bootstrap-multiselect',
		'vendor/jquery.serialize-object.min'
	), array('inline' => false));

	$title = __('Custom order');
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
	echo $this->element('AdminUI/form_title', array('title' => __('Custom song order')));

	echo $this->PHForm->create('OrderCustom');
	echo $this->PHForm->input('artist');
	echo $this->PHForm->input('song');

	echo $this->PHForm->input('services', array('options' => $aServices, 'multiple' => true));

	echo $this->PHForm->input('comment');

	echo $this->element('AdminUI/form_save', array('title' => __('Add to cart'), 'icon' => 'fa-shopping-cart'));
	echo $this->PHForm->end();

?>
			<div id="afterAdd" class="portlet-body form tabbable-bordered" style="margin: 20px 0; display: none;">
				<?=__('Your custom order have been added to the %s', $this->Html->link(__('cart'), array('action' => 'cart')))?><br />
			</div>

		</div>
	</div>
</div>
<script type="text/javascript">
	var type;
	function isFormValid() {
		var lValid = true;
		$('input.form-control, select.form-control').each(function(){
			if (!$(this).val()) {
				lValid = false;
				if (!$(this).parent().parent().hasClass('error')) {
					$(this).parent().append('<span class="small help-block error"><?=__('Field is mandatory')?></span>');
					$(this).parent().parent().addClass('error').addClass('has-error');
				}
			}
		});
		return lValid;
	}

	function item_addCart() {
		var cart = getCart();
		if (!cart[type]) {
			cart[type] = [];
		}
		var data = $('#OrderCustomCustomorderForm').serializeObject().data.OrderCustom;
		cart[type].push(data);
		setCart(cart);
	}
	$(function(){
		type = 'custom';

		$('.form-actions .btn.blue').prop('type', 'button');

		$('#OrderCustomServices').multiselect({
			nonSelectedText: '<?=__('Choose services')?>',
			nSelectedText: '<?=__('service(s) choosen')?>',
			numberDisplayed: 0,
			onChange: function(option, checked) {
				var select = $(option).parent().get(0);
				var $parent = $(select).closest('.form-group');
				$parent.removeClass('has-error').removeClass('error');
				$parent.find('.help-block.error').remove();
			}
		});

		$('.form-actions .btn.blue').click(function(){
			if (isFormValid()) {
				item_addCart();
				$('.portlet-body').hide();
				$('#afterAdd').show();
			}
		});

	});
</script>