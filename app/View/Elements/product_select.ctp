<?
    $this->ArticleVars->init($product, $url, $title, $teaser, $src, 'noresize', $featured, $id);
    $go_title = __('Go to View product page');
?>
<div class="col-sm-<?=$col?>">
    <div class="item <?=($checked) ? 'active' : ''?>">
        <div class="outerCheckbox">
            <input type="checkbox" class="styler" name="data[products][]" value="<?=$id.((isset($pack) && $pack) ? '-'.$pack['ProductPack']['id'] : '')?>" autocomplete="off" <?=$checked?>/>
        </div>
<?
    if ($src) {
?>
            <div class="outerThumb">
                <a href="<?=$url?>" title="<?=$go_title?>"><img src="<?=$src?>" alt="<?=$title?>"/></a>
                <i class="vert"></i>
            </div>
<?
    }
?>
        <div class="title"><a href="<?=$url?>" title="<?=$go_title?>"><?=$title?></a></div>
<?
    if (isset($pack) && $pack) {
        $price = $pack['ProductPack']['price_'.$lang];
?>
            <div class="equipment"><?=$pack['ProductPack']['title_'.$lang]?></div>
<?
        if ($price) {
?>
                <div class="price"><?=$this->Price->format($price)?></div>

<?
        }
    }
?>
    </div>
</div>