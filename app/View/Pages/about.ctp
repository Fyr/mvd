<?
    $title = __('About the Museum');
    $filter = array('cat_id' => $aPages[$slug]['Page']['id']);
    $aCategories = array_values($aPages);
    $aSubcategories = array();
?>
<div class="container collections">
    <div class="row">
        <?=$this->element('categories', compact('title', 'filter', 'aCategories', 'aSubcategories'))?>
        <div class="col-md-9 col-sm-8 article">
<?
    $this->ArticleVars->init($aPages[$slug], $url, $title, $teaser, $src, 'noresize');
?>
            <h1><?=$title?></h1>
            <?=$this->ArticleVars->body($aPages[$slug])?>
        </div>
    </div>
</div>