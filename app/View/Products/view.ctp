<?
	$this->Html->css(array('owl-carousel/owl.carousel', 'owl-carousel/owl.theme'), array('inline' => false));
	$this->Html->script(array('vendor/owl.carousel.min'), array('inline' => false));

	$lShowParams = false;
	foreach($aFormGroups as $group_id => $group) {
		if (!$group['ParamGroup']['featured']) {
			$lShowParams = true;
			break;
		}
	}
	$lShowPacks = false;
	if ($aPacks) {
		foreach ($aFormGroups as $group_id => $group) {
			if ($group['ParamGroup']['featured']) {
				$lShowPacks = true;
				break;
			}
		}
	}

	$spec_features = trim($product['Product']['spec_features_'.$lang]);
	$features = trim($product['Product']['features_'.$lang]);

	$header = ($product['Product']['header_'.$lang]) ? $product['Product']['header_'.$lang] : $product['Category']['title_'.$lang].': '.$product['Product']['title_'.$lang];
?>
<div class="subMenu">
	<div class="container">
		<div class="name"><?=$header?></div>
		<a class="btn btn-success orderBtn" href="javascript: void(0)"><?=__('Order')?></a>
		<ul class="menu">
<?
	if ($features) {
?>
			<li><a href="#features"><?=__('Features')?></a></li>
<?
	}
	if ($lShowParams) {
?>
			<li><a href="#params"><?=__('Technical specifications')?></a></li>
<?
	}
	if ($lShowPacks) {
?>
			<li><a href="#packs"><?=__('Contents of delivery')?></a></li>
<?
	}
?>

		</ul>
	</div>
</div>
<div class="playerKaraoke">
	<div class="container">
		<div class="title"><?=$product['Product']['title_'.$lang]?></div>
		<div class="smallDesc"><?=$product['Product']['teaser_'.$lang]?></div>
		<div class="outerCarousel">
			<div id="owl-carousel" class="owl-carousel">
<?
	foreach($aMedia as $media) {
?>
				<div class="item"><img class="lazyOwl" data-src="<?=$this->Media->imageUrl($media, 'noresize')?>" alt="" /></div>
<?
	}
?>

			</div>
		</div>
	</div>
</div>
<div class="grey buyPlayer">
	<div class="container">
		<div class="text">
			<?=$this->ArticleVars->body($product)?>
			<div class="row">
<?
	foreach($aPacks as $pack) {
?>
				<div class="col-sm-<?=ceil(12 / count($aPacks))?> price">
					<div class="value"><?=$this->Price->format($pack['ProductPack']['price_'.$lang])?></div>
					<div class="license"><?=$pack['ProductPack']['title_'.$lang]?></div>
				</div>
<?
	}
?>
			</div>
		</div>
	</div>
</div>
<?
	if ($spec_features) {

?>
<div class="darkGrey characteristics">
	<div class="container">
		<div class="row">
<?
	$aCols = $this->ArticleVars->divideColumns($this->ArticleVars->list2array($spec_features), 3);
	foreach($aCols as $col) {
?>
			<div class="col-sm-4">
				<ul>

<?
		foreach($col as $title) {
?>
					<li><?=$title?></li>
<?
		}
?>
				</ul>
			</div>
<?
	}
?>
		</div>
	</div>
</div>
<?
	}

	$class = 'grey';
	foreach($productBlocks as $i => $article) {
		$this->ArticleVars->init($article, $url, $title, $teaser, $src, 'noresize');
		$class = ($class == 'grey') ? '' : 'grey';
		$text = $this->ArticleVars->body($article);
		echo $this->element('product_block', compact('title', 'src', 'text', 'class'));
	}

	if ($features) {
		$class = ($class == 'grey') ? '' : 'grey';
?>
<a name="features"></a>
<div class="section allOpportunities <?=$class?>">
	<div class="container">
		<?=$this->element('SiteUI/title', array('class' => 'light', 'title' => __('All system features')))?>
		<div class="row">

<?
	$aCols = $this->ArticleVars->divideColumns($this->ArticleVars->list2array($features), 3);
	foreach($aCols as $col) {
?>
			<div class="col-sm-4">
				<ul>

<?
		foreach($col as $title) {
?>
					<li><?=$title?></li>
<?
		}
?>
				</ul>
			</div>

<?
	}
?>
		</div>
	</div>
</div>
<?
	}

	if ($lShowParams) {
?>

<a name="params"></a>
<?
		foreach($aFormGroups as $group_id => $group) {
			$class = ($class == 'grey') ? '' : 'grey';
			if (!$group['ParamGroup']['featured']) {
?>
<div class="section allOpportunities <?=$class?>">
	<div class="container">

		<?=$this->element('SiteUI/title', array('class' => 'light', 'title' => $group['ParamGroup']['title_'.$lang]))?>
		<div class="row">
<?
				$aItems = array();
				foreach($aForms[$group_id] as $fid => $field) {
					$value = Hash::get($aValues, $fid);
					$aItems[] = $this->element('param', compact('field', 'value'));
				}
				foreach($this->ArticleVars->divideColumns($aItems, 3) as $items) {
?>
			<div class="col-sm-4">
				<?=implode('', $items)?>
			</div>
<?
				}
?>
		</div>
<?
			}
?>
	</div>
</div>
<?
		}
	}
	if ($lShowPacks) {
		$class = ($class == 'grey') ? '' : 'grey';
?>
<a name="packs"></a>
<div class="section allOpportunities <?=$class?>">
	<div class="container">
		<?=$this->element('SiteUI/title', array('class' => 'light', 'title' => __('Contents of delivery')))?>
<?
			foreach($aFormGroups as $group_id => $group) {
				if ($group['ParamGroup']['featured']) {
?>
		<table class="deliveryContent">
			<tr>
				<th><?=$group['ParamGroup']['title_'.$lang]?></th>
<?
					foreach($aPacks as $pack) {
?>
				<th><?=$pack['ProductPack']['title_'.$lang]?></th>
<?
					}
?>
			</tr>
<?
					foreach($aForms[$group_id] as $fid => $field) {
						$values = $aPackValues[$fid];
						echo $this->element('param_pack', compact('field', 'values'));
					}
?>
		</table>
<?
				}
			}
?>
	</div>
</div>
<?
	}
	$class = ($class == 'grey') ? '' : 'grey';
?>
<div class="section otherKaraokeSystems <?=$class?>">
	<div class="container">
		<?=$this->element('SiteUI/title', array('class' => 'light', 'title' => 'Другие караоке системы'))?>
		<div class="row">
<?
	foreach($otherProducts as $article) {
		$this->ArticleVars->init($article, $url, $title, $teaser, $src, 'noresize', $featured, $id);
		$price = 0;
		if (isset($otherPacks[$id])) {
			list($pack) = array_values($otherPacks[$id]);
			$price = $pack['ProductPack']['price_'.$lang];
		}
?>
			<div class="col-sm-4">
<?
		if ($src) {
?>
				<div class="outerThumb">
					<a href="<?=$url?>"><img src="<?=$src?>" alt="" class="img-responsive" /></a>
					<i class="vert"></i>
				</div>
<?
		}
?>


				<a href="<?=$url?>" class="link"><?=$title?></a>
<?
		if ($price) {
?>
				<div class="price">от <?=$this->Price->format($price)?></div>
<?
		}
?>
			</div>

<?
	}
?>
		</div>
<?
	$title = __('Compare %s with other systems', $product['Product']['title_'.$lang]);
	$url = array('action' => 'select', $product['Category']['id'], $product['Product']['id']);
	echo $this->Html->link($title, $url, array('class' => 'btn btn-success'));
?>
	</div>
</div>

<?
	$class = ($class == 'grey') ? '' : 'grey';
	echo $this->element('support', array('title' => $page['support']['Page']['title_'.$lang], 'blocks' => $pageBlocks['support'], 'class' => 'grey'));

	echo $this->element('call_us');
?>
