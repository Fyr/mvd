<div class="container">
    <div class="row mainContent">
        <div class="col-md-6 col-sm-6">
            <div id="owl-carousel" class="mainPageGallery">
<?
    foreach($aSlider as $media) {
?>
                <div class="item" style="background-image: url('<?=$this->Media->imageUrl($media, 'noresize')?>')"></div>
<?
    }
?>
            </div>
        </div>
        <div class="col-md-5 col-md-offset-1 col-sm-6">
            <h2><?=$page['Page']['title_'.$lang]?></h2>
            <?=$this->ArticleVars->body($page)?>
        </div>
    </div>
    <div class="head">
        <div class="outerIcon">
            <span class="icon-star"></span>
        </div>
        <h2>События и мероприятия</h2>
    </div>
    <div class="row mainPageEvents">
<?
    foreach($aNews as $article) {
        $this->ArticleVars->init($article, $url, $title, $teaser, $src, 'noresize');
?>
        <div class="col-sm-4">
            <div class="outer">
                <a href="<?=$url?>" class="picture" title="<?=$title?>" style="background-image: url('<?=$this->Media->imageUrl($article)?>')"></a>
                <div class="date">3 марта 2017</div>
            </div>
            <a href="<?=$url?>" class="description"><?=$title?></a>
        </div>
<?
    }
?>
    </div>
    <div class="head">
        <div class="outerIcon">
            <span class="icon-star"></span>
        </div>
        <h2>Интересные экспонаты</h2>
    </div>
    <div class="row mainPageEvents exhibits">
<?
    foreach($aProducts as $article) {
        $this->ArticleVars->init($article, $url, $title, $teaser, $src, 'noresize');
?>

        <div class="col-sm-4">
            <a href="<?=$url?>" class="picture" title="<?=$title?>">
                <img src="<?=$this->Media->imageUrl($article)?>" alt="<?=$title?>" />
            </a>
            <a href="<?=$url?>" class="description"><?=$title?></a>
        </div>

<?
    }
?>

    </div>
</div>