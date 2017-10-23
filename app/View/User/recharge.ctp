<?
	$title = __('Recharge balance');
	$breadcrumbs = array(
		__('User area') => 'javascript:;',
		$title => ''
	);
	echo $this->element('AdminUI/breadcrumbs', compact('breadcrumbs'));
	echo $this->element('AdminUI/title', compact('title'));
	echo $this->Flash->render();

	echo $this->element('/UserUI/state');
?>

<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
<?
	echo $this->element('AdminUI/form_title', array('title' => __('Recharge balance')));
	echo $this->PHForm->create('Payment');
	echo $this->PHForm->textOnly('', '<img src="/img/logo-robokassa.png" alt="Robokassa" />');
	echo $this->PHForm->input('sum', array(
		'class' => 'form-control input-small',
		'required' => true,
		'label' => array('class' => 'col-md-3 control-label', 'text' => __('Sum, %s', ($lang == 'eng') ? '$' : $this->Price->symbolP()))
	));

	echo $this->element('AdminUI/form_save', array('title' => __('Make payment'), 'icon' => 'fa-chevron-right'));
	echo $this->PHForm->end();
?>
		</div>
	</div>
</div>
