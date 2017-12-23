<div class="container collections">
    <div class="row">
        <?=$this->element('categories')?>
        <div class="col-md-9 col-sm-8">
            <div class="outerSearch">
                <input type="text" placeholder="поиск по сайту" />
                <button class="icon-search"></button>
            </div>
            <h1>Страница списка предметов категории</h1>
            <ul class="collectionList mainPageEvents exhibits">
<?
    foreach ($aArticles as $article) {
        $this->ArticleVars->init($article, $url, $title, $teaser, $src, '600x');
?>
                <li>
                    <a href="<?=$url?>" class="picture"><img src="<?=$src?>" alt="<?=$title?>" /></a>
                    <a href="<?=$url?>" class="description"><?=$title?></a>
                </li>
<?
    }
?>

            </ul>
            <?=$this->element('paginate');?>
        </div>
    </div>
</div>