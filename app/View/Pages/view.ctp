<div class="container article">
<?
        $this->ArticleVars->init($page, $url, $title, $teaser, $src, 'noresize');
?>
        <h1><?=$title?></h1>
        <?=$this->ArticleVars->body($page)?>
</div>