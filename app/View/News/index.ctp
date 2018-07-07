<div class="container article">
    <h1><?=__('Events')?></h1>
<?
    $aArticleGroups = array_chunk($aArticles, 3);
    foreach($aArticleGroups as $aArticles) {
?>
    <div class="row mainPageEvents" style="margin-bottom: 40px">
<?
        foreach ($aArticles as $article) {
            $this->ArticleVars->init($article, $url, $title, $teaser, $src, '800x');
?>
            <div class="col-sm-4">
                <div class="outer">
                    <a href="<?=$url?>" class="picture" title="<?=$title?>" style="background-image: url('<?=$src?>')"></a>
                    <div class="date"><?=date('d.m.Y', strtotime($article['News']['modified']))?></div>
                </div>
                <a href="<?=$url?>" class="description"><?=$title?></a>
            </div>
<?
        }
?>
    </div>
<?
    }
    echo $this->element('paginate');
?>
</div>