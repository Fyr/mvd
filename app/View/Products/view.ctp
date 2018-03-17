<?
$this->Html->css('jquery.fancybox', array('inline' => false));
$this->Html->script(array('vendor/jquery.fancybox.pack'), array('inline' => false));

    $title = 'Коллекции';
    $filter = array('cat_id' => $article['Product']['cat_id'], 'subcat_id' => $article['Product']['subcat_id']);
    $this->ArticleVars->init($article, $url, $title, $teaser, $src, '800x');
?>
<div class="container collections">
    <div class="row">
        <?=$this->element('categories', compact('title', 'filter', 'aCategories', 'aSubcategories'))?>
        <div class="col-md-9 col-sm-8">
            <?=$this->element('search')?>
            <h1><?=$title?></h1>
            <div class="row">
                <div class="col-md-7 exhibit">
                    <a class="fancybox" href="<?=$src?>" rel="gallery"><img class="mainImg" src="<?=$src?>" alt="<?=$title?>" /></a>
                    <div class="thumbs">
<?
    foreach($aMedia as $media) {
        if (!$media['Media']['main']) {
            $src = $this->Media->imageUrl($media, '800x');
?>
                        <a class="fancybox" href="<?=$src?>" rel="gallery"><img class="thumb" src="<?=$this->Media->imageUrl($media, '400x')?>" alt="" /></a>
<?
        }
    }
?>

                    </div>
                    <div class="title">Описание</div>
                    <div class="description"><?=$this->ArticleVars->body($article)?></div>
                </div>
                <div class="col-md-5">
                    <table class="features">
                        <tbody>
                        <tr>
                            <td width="40%">Коллекция</td>
                            <td width="60%"><?=$article['ProductCategory']['title']?></td>
                        </tr>
                        <tr>
                            <td width="40%">Вид предмета</td>
                            <td width="60%"><?=$article['ProductSubcategory']['title']?></td>
                        </tr>
                        <tr>
                            <td width="40%">Предметное имя</td>
                            <td width="60%"><?=$article['Product']['teaser']?></td>
                        </tr>
                        <tr>
                            <td width="40%">Автор/Коллектив авторов</td>
                            <td width="60%"><?=$article['Product']['author']?></td>
                        </tr>
                        <tr>
                            <td width="40%">Период создания</td>
                            <td width="60%"><?=$article['Product']['creation_date']?></td>
                        </tr>
                        <tr>
                            <td width="40%">Место создания</td>
                            <td width="60%"><?=$article['Product']['creation_place']?></td>
                        </tr>
                        <tr>
                            <td width="40%">Материал, техника</td>
                            <td width="60%"><?=$article['Product']['creation_technology']?></td>
                        </tr>
                        <tr>
                            <td width="40%">Размер</td>
                            <td width="60%"><?=$article['Product']['size']?></td>
                        </tr>
                        <tr>
                            <td width="40%">Номер по КП (НВ)</td>
                            <td width="60%"><?=$article['Product']['id_num']?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(function(){
    if ($('.fancybox').length) {
        $('.fancybox').fancybox({
            padding: 5
        });
    }
});
</script>