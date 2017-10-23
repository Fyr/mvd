<div id="slide-karaoke" class="slide">
    <div class="container">
        <i class="vert"></i>
        <div class="content">
            <h2><?=$block['title_'.$lang]?></h2>
            <div class="row">
<?
    $i = -1;
    foreach($aCategories as $cat_id => $category) {
        $i++;
?>
                    <div class="col-sm-6">
                        <div class="title"><?=$category['Category']['title_'.$lang]?></div>
<?
        foreach($aProducts[$cat_id] as $id => $product) {
            $this->ArticleVars->init($product, $url, $title, $teaser, $src, 'noresize');
?>
                            <div class="item<?=($i) ? $i : ''?>">
<?
            if ($src) {
?>
                                    <div class="outerThumb">
                                        <a href="<?=$url?>"><img src="<?=$src?>" alt="<?=$title?>" class="thumb img-responsive" /></a>
                                    </div>

<?
            }
?>
                                <div class="description">
                                    <?=$this->Html->link($title, $url)?>
                                    <div class="text"><?=$teaser?></div>
                                </div>
                            </div>

<?
        }
?>
                    </div>
<?
    }
?>
            </div>
        </div>
    </div>
</div>