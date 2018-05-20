<div class="container article">
<?
	$this->ArticleVars->init($article, $url, $title, $teaser, $src, '1200x');
?>
	<b><?=date('d.m.Y', strtotime($article['News']['modified']))?></b>
	<h1><?=$title?></h1>
	<img src="<?=$src?>" alt="<?=$title?>" style="width: 100%"/>
	<?=$this->ArticleVars->body($article)?>
</div>