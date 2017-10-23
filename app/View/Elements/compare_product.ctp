<?
    $this->ArticleVars->init($product, $url, $title, $teaser, $src, 'noresize', $featured, $id);
?>
<td id="<?=$i?>" class="center">
<?
    if ($src) {
?>
        <div class="thumb">
            <img alt="<?=$title?>" src="<?=$src?>">
            <span class="icon-close"></span>
        </div>
<?
    }
?>
    <div class="name"><?=$title?></div>
<?
    if (isset($pack)) {
?>
        <div class="equipment"><?=$pack['ProductPack']['title_'.$lang]?></div>
<?
    }
    if (isset($pack) && $pack['ProductPack']['price_'.$lang]) {
?>
        <div class="price"><?=$this->Price->format($pack['ProductPack']['price_'.$lang])?></div>
<?
    }
    if ($buy) {
?>
        <a class="btn btn-success" href="<?=$this->Html->url(array('action' => 'order', $id))?>">Купить</a>
<?
    }
?>
</td>