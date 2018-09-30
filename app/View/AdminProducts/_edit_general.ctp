<?
	echo $this->element('AdminUI/checkboxes', array('labels' => array('published' => __('Published'), 'featured' => __('For home page'))));
	echo $this->PHForm->input('cat_id', array(
		'options' => $aCategories,
		'value' => $this->request->data('Product.cat_id'),
		'onchange' => 'category_onChange(this)',
		'label' => array('class' => 'col-md-3 control-label', 'text' => __('Collection'))
	));
?>
	<div class="form-group">
		<label class="col-md-3 control-label" for="ProductSubCatId"><?=__('Item type')?></label>
		<div class="col-md-9">
			<select id="ProductSubCatId" class="form-control" name="data[Product][subcat_id]" autocomplete="off">
				<optgroup id="cat-<?=Hash::get($aSubcategories[0], 'Category.id')?>" label="<?=Hash::get($aSubcategories[0], 'Category.title')?>">
<?
	$cat = Hash::get($aSubcategories[0], 'Category.id');
	foreach($aSubcategories as $subcat) {
		if ($cat != $subcat['Category']['id']) {
			$cat = $subcat['Category']['id'];
?>
				</optgroup>
				<optgroup id="cat-<?=$subcat['Category']['id']?>" label="<?=$subcat['Category']['title']?>">
<?
		}
		$selected = ($this->request->data('Product.subcat_id') == $subcat['Subcategory']['id']) ? ' selected="selected"' : '';
?>
					<option value="<?=$subcat['Subcategory']['id']?>"<?=$selected?>><?=$subcat['Subcategory']['title']?></option>
<?
	}
?>
				</optgroup>
			</select>
		</div>
	</div>
<?

	// echo $this->PHForm->input('subcat_id', array('options' => $aSubcategoryOptions, 'label' => array('class' => 'col-md-3 control-label', 'text' => __('Subcategory'))));
	echo $this->PHForm->input('title');
	// echo $this->PHForm->input('slug');
/*
	echo $this->PHForm->input('teaser', array('label' => array('class' => 'col-md-3 control-label', 'text' => 'Предметное имя')));
	echo $this->PHForm->input('author', array('label' => array('class' => 'col-md-3 control-label', 'text' => 'Автор/Коллектив авторов')));
	echo $this->PHForm->input('creation_date', array('label' => array('class' => 'col-md-3 control-label', 'text' => 'Период создания')));
	echo $this->PHForm->input('creation_place', array('label' => array('class' => 'col-md-3 control-label', 'text' => 'Место создания')));
	echo $this->PHForm->input('creation_technology', array('label' => array('class' => 'col-md-3 control-label', 'text' => 'Материал, техника')));
	echo $this->PHForm->input('size', array('label' => array('class' => 'col-md-3 control-label', 'text' => 'Размер')));
	echo $this->PHForm->input('location', array('label' => array('class' => 'col-md-3 control-label', 'text' => 'Место хранения')));
	echo $this->PHForm->input('id_num', array('label' => array('class' => 'col-md-3 control-label', 'text' => 'Номер по КП (НВ)')));
	echo $this->PHForm->input('acceptance_doc', array('label' => array('class' => 'col-md-3 control-label', 'text' => 'Акт приема-передачи')));
	echo $this->PHForm->input('protocol', array('label' => array('class' => 'col-md-3 control-label', 'text' => 'Протокол ФЗК')));
	echo $this->PHForm->input('sorting', array('class' => 'form-control input-small'));
*/
	echo $this->PHForm->input('teaser', array('label' => array('class' => 'col-md-3 control-label', 'text' => __('Subject name'))));
	echo $this->PHForm->input('author', array('label' => array('class' => 'col-md-3 control-label', 'text' => __('Author/Team of authors'))));
	echo $this->PHForm->input('creation_date', array('label' => array('class' => 'col-md-3 control-label', 'text' => __('Creation period'))));
	echo $this->PHForm->input('creation_place', array('label' => array('class' => 'col-md-3 control-label', 'text' => __('Creation place'))));
	echo $this->PHForm->input('creation_technology', array('label' => array('class' => 'col-md-3 control-label', 'text' => __('Creation technology'))));
	echo $this->PHForm->input('size', array('label' => array('class' => 'col-md-3 control-label', 'text' => __('Size'))));
	echo $this->PHForm->input('location', array('label' => array('class' => 'col-md-3 control-label', 'text' => __('Location'))));
	echo $this->PHForm->input('id_num', array('label' => array('class' => 'col-md-3 control-label', 'text' => __('Identification number'))));
	echo $this->PHForm->input('acceptance_doc', array('label' => array('class' => 'col-md-3 control-label', 'text' => __('Acceptance Act'))));
	echo $this->PHForm->input('protocol', array('label' => array('class' => 'col-md-3 control-label', 'text' => __('Protocol'))));
	echo $this->PHForm->input('sorting', array('class' => 'form-control input-small'));

	$subcat_id = $this->request->data('Product.subcat_id');
?>
<script type="text/javascript">
function category_onChange(e, subcat_id) {
	$('#ProductSubCatId optgroup').hide();
	var $optgroup = $('#ProductSubCatId optgroup#cat-' + $(e).val());
	$optgroup.show();
	$('#ProductSubCatId').val((subcat_id) ? subcat_id : $('option:first', $optgroup).attr('value'));
}

$(document).ready(function() {
	category_onChange($('#ProductCatId').get(0), <?=($subcat_id) ? $subcat_id : '0'?>);
});
</script>