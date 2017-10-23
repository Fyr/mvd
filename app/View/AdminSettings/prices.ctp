<?
	$title = __('Prices');
	$breadcrumbs = array(
		__('Settings') => 'javascript:;',
		$title => ''
	);
	echo $this->element('AdminUI/breadcrumbs', compact('breadcrumbs'));
	echo $this->element('AdminUI/title', array('title' => __('Settings')));
	echo $this->Flash->render();
?>

<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">

<?
	echo $this->element('AdminUI/form_title', compact('title'));
	echo $this->PHForm->create('Settings');
	$currency = $lang;
	echo $this->PHForm->input('price_prefix_'.$currency, array(
			'class' => 'form-control input-small',
			'label' => array('text' => __('Price prefix'), 'class' => 'col-md-3 control-label')
		))
		.$this->PHForm->input('price_postfix_'.$currency, array(
			'class' => 'form-control input-small',
			'label' => array('text' => __('Price postfix'), 'class' => 'col-md-3 control-label')
		))
		.$this->PHForm->input('int_div_'.$currency, array(
			'class' => 'form-control input-small',
			'label' => array('text' => __('Thousands separator'), 'class' => 'col-md-3 control-label')
		))
		.$this->PHForm->input('decimals_'.$currency, array(
			'class' => 'form-control input-small',
			'label' => array('text' => __('Decimals'), 'class' => 'col-md-3 control-label')
		))
		.$this->PHForm->input('float_div_'.$currency, array(
			'class' => 'form-control input-small',
			'label' => array('text' => __('Decimal point'), 'class' => 'col-md-3 control-label')
		));

	echo $this->element('AdminUI/form_save');
	echo $this->PHForm->end();
?>
		</div>
	</div>
</div>
