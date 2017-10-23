<?
	$this->Html->css('jquery.formstyler', array('inline' => false));
	$this->Html->script('vendor/jquery.formstyler.min', array('inline' => false));
	$category = $aCategories[$cat_id];
?>
<style>
#selected { font-weight: 300; }
.virtualSystems.realSystems .item {
	margin-left: 0px;
	margin-right: 0px;
}
.virtualSystems .item .title {
	font-size: 34px;
}
.virtualSystems .item .title a {
	border-bottom: 1px solid #ddd;
	text-decoration: none;
}
</style>
<div class="container">
	<?=$this->element('SiteUI/title', array('title' => __('Compare %s', $category['Category']['title_'.$lang])))?>
	<div class="compareSelected">
		<span id="selected"></span>
		<?=$this->Html->link(__('Compare'), array('action' => 'compare', $cat_id, '~ids'), array('class' => 'btn btn-success disabled', 'onclick' => 'return go()'))?>
	</div>
	<div class="row virtualSystems realSystems">
<?
	$count = 0;
	foreach($aProducts[$cat_id] as $product) {
		$id = $product['Product']['id'];
		if (isset($aPacks[$id])) {
			foreach($aPacks[$id] as $pack) {
				$count++;
			}
		} else {
			$count++;
		}
	}
	$col = ($count > 4) ? 3 : ceil(12 / $count);
	foreach($aProducts[$cat_id] as $product) {
		$id = $product['Product']['id'];
		$checked = (in_array($id, $selected)) ? 'checked="checked"' : '';
		$pack = (isset($aPacks[$id])) ? $aPacks[$id] : array();
		if (isset($aPacks[$id])) {
			foreach($aPacks[$id] as $pack) {
				echo $this->element('product_select', compact('col', 'product', 'pack', 'checked'));
			}
		} else {
			echo $this->element('product_select', compact('col', 'product', 'checked'));
		}
	}
?>
	</div>

</div>

<script type="text/javascript">
var aSelected = null;
function updateSelected() {
	var count = $(':checked').length;
	$('#selected').html(count < 5 ? aSelected[count] : aSelected[5].replace(/\%s/, count));
	var $a = $('.compareSelected a.btn');
	$a.removeClass('disabled');
	if (!count) {
		$a.addClass('disabled');
	}
}
function go() {
	var $a = $('.compareSelected a.btn');
	var ids = [];
	$(':checked').each(function(){
		ids.push($(this).val());
	});

	if (ids.length) {
		$a.prop('href', $a.prop('href').replace(/~ids/, ids.join()));
	}
	return ids.length > 0;
}
<?
	$aSelected = array(
		__('Select systems to compare'),
		__('1 system selected'),
		__('2 systems selected'),
		__('3 systems selected'),
		__('4 systems selected'),
		__('\%s systems selected'),
	);
?>
$(document).ready(function(){
	/*
	aSelected = [
		'Select the system to compare',
		'Выбрана 1 система',
		'Выбрано 2 системы',
		'Выбрано 3 системы',
		'Выбрано 4 системы',
		'Выбрано %s систем'
	];
	*/
	aSelected = <?=json_encode($aSelected)?>;
	$('input.styler').styler();

	updateSelected();

	$('.virtualSystems .item').click(function(e){
		e.stopPropagation();
		$(this).toggleClass('active');
		var checked = $(this).find('input:checkbox').prop('checked');
		$(this).find('.styler').prop('checked', !checked).trigger('refresh');
		updateSelected();
	});

	$('[type=checkbox]').change(function(e){
		var checked = $(this).prop('checked');
		$(this).prop('checked', !checked);
	});

});
</script>
