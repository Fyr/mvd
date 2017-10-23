<div class="container">
	<div class="support">
		<?=$this->element('SiteUI/title', array('title' => $faq['Page']['title_'.$lang]))?>

		<div class="smallDesc"><?=__('Promptly reply to any question')?></div>
		<div class="text"><?=$this->ArticleVars->body($faq)?></div>

		<?=$this->element('SiteUI/title', array('title' => __('Frequently asked questions')))?>

		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

<?
	foreach($aArticles as $i => $article) {
?>
		<div class="panel">
			<a data-toggle="collapse" data-parent="#accordion" href="#answer<?=$i?>" aria-expanded="true"
			   aria-controls="answer1" class="headPanel collapsed">
				<span class="icon icon-arrow-up"></span>
				<?=$article['Faq']['title_'.$lang]?>
			</a>

			<div id="answer<?=$i?>" class="bodyPanel collapse" role="tabpanel">
				<?=$this->ArticleVars->body($article)?>
			</div>
		</div>
<?
	}
?>

		</div>
	</div>
</div>
<a name="contacts"></a>
<div class="grey">
	<div class="container">
		<div class="supportForm">

<?
	if ($lSent = $this->request->query('success')) {
		$msg = '<b>'.__('Thank you for your message!').'</b><br/>'.__('In the near future our experts will answer');
	} else {
		$msg = __('We did not find an answer to your question?').'<br/>'.__('Write to us and we will be happy to answer.');
	}
?>
			<div class="text"><?=$msg?></div>
<?
	$options = array(
		'class' => 'row form',
		'url' => $this->Html->url(array('action' => 'index')).'#contacts',
		'inputDefaults' => array(
			'class' => 'form-control',
			'label' => false,
		)
	);
	echo $this->PHForm->create('Contact', $options);
?>
				<div class="col-sm-5">
<?
	echo $this->PHForm->input('Contact.username', array('placeholder' => __('Name')));
	echo $this->PHForm->input('Contact.phone', array('type' => 'tel', 'placeholder' => __('Phone').' +(NNN) NNN-NN-NN', /*'pattern' => '\(\d\d\d\) ?\d\d\d-\d\d-\d\d'*/ ));
	echo $this->PHForm->input('Contact.email', array('placeholder' => 'E-mail'));
	echo $this->PHForm->input('Contact.subj', array('placeholder' => __('Subject matter')));
?>
				</div>
				<div class="col-sm-7">
<?
	echo $this->PHForm->input('Contact.body', array('type' => 'textarea', 'placeholder' => __('Type your question...')));
?>
					<!--textarea placeholder="Введите Ваш вопрос" class="form-control"></textarea-->
				</div>
				<div class="col-sm-12 submit">
					<button class="btn btn-success"><?=__('Submit')?></button>
				</div>
<?
	echo $this->PHForm->end();
?>

		</div>

	</div>
</div>

<?=$this->element('call_us')?>
<?
	if ($lSent) {
?>
<script>
	$(function () {
		window.scrollBy(0, -80);
	});
</script>
<?
	}
?>