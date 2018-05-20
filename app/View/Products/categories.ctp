<div class="container categories">
    <?=$this->element('search')?>
    <h1><?=__('Choose category')?></h1>
    <ul class="list">
<?
    foreach ($aCategories as $article) {
        $this->ArticleVars->init($article, $url, $title, $teaser, $src, '600x');
?>
        <li><a href="<?=$url?>" style="background-image: url('<?=$src?>')"><span><?=$title?></span></a></li>
<?
    }
?>
    </ul>
</div>