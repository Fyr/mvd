<div class="container">
<?
	$this->ArticleVars->init($article, $url, $title, $teaser, $src, 'noresize');
	echo $this->element('SiteUI/title', compact('title'));
?>
	<div class="article">
<?
	if ($src) {
?>
		<img class="pull-left" src="<?=$src?>" alt="<?=$title?>" style="width: 50%" />
<?
	}
?>
		<div class="date"><span><?=date('d.m.Y', strtotime($article['News']['modified']))?></span> <?=$article['News']['author']?></div>
		<?=$this->ArticleVars->body($article)?>
	</div>
	<div class="oneTitle">Другие караоке новости:</div>
	<div class="row news">
<?
	foreach($aFeaturedNews as $article) {
		$this->ArticleVars->init($article, $url, $title, $teaser, $src, '400x');
?>
		<div class="col-sm-4">
<?
		if ($src) {
?>
			<a href="<?=$url?>" class="thumb" style="background-image: url('<?=$src?>')"></a>
<?
		}
?>
			<a href="<?=$url?>" class="title"><?=$title?></a>

			<div class="description"><?=$teaser?></div>
		</div>
<?
	}
?>
	</div>
</div>