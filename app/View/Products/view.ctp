<?
$this->Html->css('jquery.fancybox', array('inline' => false));
$this->Html->script(array('vendor/jquery.fancybox.pack'), array('inline' => false));

    $title = 'Коллекции';
    $filter = array('cat_id' => $article['Product']['cat_id'], 'subcat_id' => $article['Product']['subcat_id']);
    $this->ArticleVars->init($article, $url, $title, $teaser, $src, 'noresize');

    $aMedia3D = array_filter($aMedia, function($media){ return $media['Media']['file'] === '3D_image'; });
    $aMedia = array_filter($aMedia, function($media){ return $media['Media']['file'] !== '3D_image'; });
?>
<div class="container collections">
    <div class="row">
        <?=$this->element('categories', compact('title', 'filter', 'aCategories', 'aSubcategories'))?>
        <div class="col-md-9 col-sm-8">
            <?=$this->element('search')?>
            <h1><?=$title?></h1>
            <div class="row">
                <div class="col-md-7 exhibit">
<?
    if ($aMedia3D) {
        $i = 1;
?>
                    <div style="position: relative;">
                        <div id="rotate3D_left" class="prevButton"><i class="icon-arrow-left"></i></div>
                        <div id="rotate3D_right" class="nextButton"><i class="icon-arrow-right"></i></div>

                        <img id="img3D_<?=$i?>" class="mainImg img3D" src="<?=$src?>" alt="<?=$title?>" style="z-index: 1"/>
<?
        foreach($aMedia3D as $media) {
            $i++;
            $src = $this->Media->imageUrl($media, 'noresize');
?>
                        <img id="img3D_<?=$i?>" class="mainImg img3D" src="<?=$src?>" alt="<?=$title?>" style="z-index: 0"/>
<?
        }
?>
                    </div>
<?
    } else {
?>
                    <a class="fancybox" href="<?=$src?>" rel="gallery"><img class="mainImg" src="<?=$src?>" alt="<?=$title?>"/></a>
<?
    }
?>
                    <div class="thumbs">
<?
    foreach($aMedia as $media) {

        $src = $this->Media->imageUrl($media, 'noresize');
?>
                            <a class="fancybox" href="<?=$src?>" rel="gallery"><img class="thumb" src="<?=$this->Media->imageUrl($media, '400x')?>" alt="" /></a>
<?
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
var currFrame, timer;
function rotate3D(step) {
    currFrame+= step;
    if (currFrame < 1) {
        currFrame = $('.img3D').length;
    } else if (currFrame > $('.img3D').length) {
        currFrame = 1;
    }
    $('.img3D').css('z-index', 1);
    $('#img3D_' + currFrame).css('z-index', 2);
}

$(function(){
    if ($('.fancybox').length) {
        $('.fancybox').fancybox({
            padding: 5
        });
    }

    var maxH = 0;
    $('.img3D').each(function() {
        maxH = Math.max(maxH, $(this).height());
    });
    $('.exhibit > div:first-child').height(maxH);

    currFrame = 1;
    timer = null;
    if ($('#rotate3D_left').length && $('#rotate3D_right').length) {

        $('#rotate3D_left').hover(
            function(){ timer = setInterval(function(){ rotate3D(-1); }, 100); },
            function(){ clearInterval(timer); }
        );
        $('#rotate3D_right').hover(
            function(){ timer = setInterval(function(){ rotate3D(1); }, 100); },
            function(){ clearInterval(timer); }
        );
    }
});
</script>