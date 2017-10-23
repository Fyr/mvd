<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
<?
	echo $this->element('AdminUI/form_title', array('title' => __('Current state')));
?>
			<div class="portlet-body">
				<div class="clearfix">
					<ul class="media-list">
						<li class="media">
<?
	$product = $currUser['product'];
	if ($product) {
?>
							<a class="pull-left" href="<?=SiteRouter::url($product)?>">
								<img class="media-object" src="<?=$this->Media->imageUrl($product, 'noresize')?>" alt="<?=$product['Product']['title_'.$lang]?>" />
							</a>
<?
	}
?>
							<div class="media-body">
								<table class="dataTable">
									<tbody>
									<tr>
										<td width="1%"><?=__('Balance')?></td>
										<td><?=$this->Price->format($currUser['balance'], 'rus')?></td>
									</tr>
									<tr>
										<td nowrap="nowrap"><?=__('Licence key')?></td>
										<td><?=$currUser['key']?></td>
									</tr>
<?
	if ($product) {
		$title = ($product['Product']['header_'.$lang]) ? $product['Product']['header_'.$lang] :  $product['Product']['title_'.$lang];
?>
									<tr>
										<td nowrap="nowrap"><?=__('Current system')?></td>
										<td><?=$title?></td>
									</tr>
<?
	}
	$subscription = $currUser['subscription'];
	if ($subscription) {
		$features = array('');
		if (trim($subscription['SubscrPlan']['descr_'.$lang])) {
			$features = $this->ArticleVars->list2array($subscription['SubscrPlan']['descr_'.$lang]);
		}
?>
									<tr>
										<td nowrap="nowrap"><?=__('Subscription plan')?></td>
										<td><?=$subscription['SubscrPlan']['title_'.$lang]?> (<?=$features[0]?>)</td>
									</tr>
<?
	}
?>

									</tbody>
								</table>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>