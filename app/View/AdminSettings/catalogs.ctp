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

	echo $this->PHForm->input('song_price_'.$lang, array(
		'class' => 'form-control input-small',
		'label' => array('class' => 'col-md-3 control-label', 'text' => __('Song price'))
	));
	echo $this->PHForm->input('catalog_features_'.$lang, array(
		'label' => array('class' => 'col-md-3 control-label', 'text' => __('Catalog features'))
	));
	echo $this->PHForm->input('catalog_video_'.$lang, array(
		'label' => array('class' => 'col-md-3 control-label', 'text' => __('Video (HTML-code)'))
	));

	echo $this->element('AdminUI/form_save');
	echo $this->PHForm->end();
?>
		</div>
	</div>
</div>
