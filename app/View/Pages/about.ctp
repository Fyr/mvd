<div class="container article">
<?
    foreach($aPages as $page => $article) {
        $this->ArticleVars->init($article, $url, $title, $teaser, $src, 'noresize');
        if ($page == 'museum') {
?>
        <h1><?=$title?></h1>
<?
        } else {
?>
    <div class="head">
        <div class="outerIcon">
            <span class="icon-star"></span>
        </div>
        <h2><?=$title?></h2>
    </div>
<?
        }
        echo $this->ArticleVars->body($article);
    }
?>

</div>