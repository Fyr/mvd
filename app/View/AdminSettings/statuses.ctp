<?
	$title = __('Statuses');
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

	echo $this->PHForm->input('status_orders_'.$lang, array(
		'label' => array('class' => 'col-md-3 control-label', 'text' => __('Orders'))
	));
	echo $this->PHForm->input('status_songs_'.$lang, array(
		'label' => array('class' => 'col-md-3 control-label', 'text' => __('Songs'))
	));
	echo $this->PHForm->input('status_packs_'.$lang, array(
		'label' => array('class' => 'col-md-3 control-label', 'text' => __('Song packs'))
	));
	echo $this->PHForm->input('status_custom_'.$lang, array(
		'label' => array('class' => 'col-md-3 control-label', 'text' => __('Custom song order'))
	));

	echo $this->element('AdminUI/form_save');
	echo $this->PHForm->end();
?>
		</div>
	</div>
</div>
