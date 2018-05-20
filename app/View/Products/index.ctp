<?
    $pageTitle = '';
    if ($lDirectSearch) {
        $pageTitle = __('Search results');
    } else {
        $pageTitle = __('Collections');
        if (isset($filter['cat_id'])) {
            $_categories = Hash::combine($aCategories, '{n}.Category.id', '{n}.Category');
            $pageTitle = Hash::get($_categories[$filter['cat_id']], 'title');
        }
        if (isset($filter['subcat_id'])) {
            $_subcategories = Hash::combine($aSubcategories, '{n}.Subcategory.id', '{n}.Subcategory');
            $pageTitle = Hash::get($_subcategories[$filter['subcat_id']], 'title');
        }
    }
    $title = __('Collections');
?>
<div class="container collections">
    <div class="row">
        <?=$this->element('categories', compact('title', 'filter', 'aCategories', 'aSubcategories'))?>
        <div class="col-md-9 col-sm-8">
            <?=$this->element('search')?>
            <h1><?=$pageTitle?></h1>
            <ul class="collectionList mainPageEvents exhibits">
<?
    foreach ($aArticles as $article) {
        $this->ArticleVars->init($article, $url, $title, $teaser, $src, '400x');
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