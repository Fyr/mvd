<div class="container">
    <div class="row mainContent">
        <div class="col-md-6 col-sm-6">
            <div id="owl-carousel" class="mainPageGallery">
<?
    foreach($aSlider as $media) {
?>
                <div class="item" style="background-image: url('<?=$this->Media->imageUrl($media, '600x')?>')"></div>
<?
    }
?>
            </div>
        </div>
        <div class="col-md-5 col-md-offset-1 col-sm-6">
            <h2><?=$page['Page']['title']?></h2>
            <?=$this->ArticleVars->body($page)?>
        </div>
    </div>
    <div class="head">
        <div class="outerIcon">
            <span class="icon-star"></span>
        </div>
        <h2><?=__('Events')?></h2>
    </div>
    <div class="row mainPageEvents">
<?
    foreach($aNews as $article) {
        $this->ArticleVars->init($article, $url, $title, $teaser, $src, '400x');
?>
        <div class="col-sm-4">
			<div class="item">
				<div class="outer">
					<a href="<?=$url?>" class="picture" title="<?=$title?>" style="background-image: url('<?=$src?>')"></a>
					<div class="date"><?=date('d.m.Y', strtotime($article['News']['modified']))?></div>
				</div>
				<a href="<?=$url?>" class="description"><?=$title?></a>
			</div>
        </div>
<?
    }
?>
    </div>
    <div class="head">
        <div class="outerIcon">
            <span class="icon-star"></span>
        </div>
        <h2><?=__('Interesting exhibits')?></h2>
    </div>
    <div class="row mainPageEvents exhibits">
<?
    foreach($aProducts as $article) {
        $this->ArticleVars->init($article, $url, $title, $teaser, $src, '400x');
?>

        <div class="col-sm-4">
			<div class="item">
				<a href="<?=$url?>" class="picture" title="<?=$title?>">
					<img src="<?=$this->Media->imageUrl($article)?>" alt="<?=$title?>" />
				</a>
				<a href="<?=$url?>" class="description"><?=$title?></a>
			</div>
        </div>

<?
    }
?>

    </div>
</div>