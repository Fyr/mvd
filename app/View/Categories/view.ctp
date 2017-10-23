<?
	$article['Category']['body_'.$lang] = $article['Category']['descr_'.$lang];
	$cat_id = $article['Category']['id'];
?>
<div class="otherKaraokeSystems">
	<div class="container">
		<?=$this->element('SiteUI/title', array('title' => $article['Category']['title_'.$lang]))?>
		<div class="text">
			<?=$this->ArticleVars->body($article)?>
		</div>
		<div class="row">
<?
	foreach($aProducts[$cat_id] as $id => $product) {
		$this->ArticleVars->init($product, $url, $title, $teaser, $src, 'noresize');
		$price = (isset($aPrices[$id]) && $aPrices[$id]) ? $this->Price->format($aPrices[$id]) : '';
?>
			<div class="col-sm-<?=ceil(12 / count($aProducts[$cat_id]))?>">
<?
		if ($src) {
?>
				<div class="outerThumb">
					<a href="<?=$url?>"><img class="img-responsive" src="<?=$src?>" alt="<?=$title?>" /></a>
					<i class="vert"></i>
				</div>
<?
		}
?>
				<a href="<?=$url?>" class="link"><?=$title?></a>
<?
		if ($price) {
			echo $this->Html->div('price', 'от '.$price);
		}
?>
			</div>
<?
	}
?>

		</div>
	</div>
</div>
<?
	$class = '';
	foreach($blocks as $block) {
		$class = ($class) ? '' : 'grey';
?>
<div class="<?=$class?> bestMarket">
	<div class="container">
		<h3><?=$block['CategoryBlock']['title_'.$lang]?></h3>
		<?=$this->ArticleVars->body($block)?>
	</div>
</div>
<?
	}
?>
