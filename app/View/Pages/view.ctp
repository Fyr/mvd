<div class="container article">
<?
    $this->ArticleVars->init($article, $url, $title, $teaser, $src, 'noresize');
?>
    <h1><?=$title?></h1>
    <?=$this->ArticleVars->body($article)?>
</div>