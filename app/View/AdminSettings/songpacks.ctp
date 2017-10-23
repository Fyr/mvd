<?
	$title = __('Catalogs');
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

	echo $this->PHForm->input('pack_price_'.$lang, array(
		'class' => 'form-control input-small',
		'label' => array('class' => 'col-md-3 control-label', 'text' => __('Song pack price'))
	));
	echo $this->PHForm->input('pack_features_'.$lang, array(
		'label' => array('class' => 'col-md-3 control-label', 'text' => __('Song pack features'))
	));

	echo $this->element('AdminUI/form_save');
	echo $this->PHForm->end();
?>
		</div>
	</div>
</div>
