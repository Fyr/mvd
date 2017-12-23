<div class="container categories">
    <div class="outerSearch">
        <input type="text" placeholder="поиск по сайту" />
        <button class="icon-search"></button>
    </div>
    <h1>Выберите категорию</h1>
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