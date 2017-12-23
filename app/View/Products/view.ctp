<div class="container collections">
    <div class="row">
        <?=$this->element('categories')?>
        <div class="col-md-9 col-sm-8">

<?
    $this->ArticleVars->init($article, $url, $title, $teaser, $src, 'noresize');
?>
            <h1><?=$title?></h1>
            <div class="row">
                <div class="col-md-7 exhibit">
                    <img class="mainImg" src="<?=$src?>" alt="<?=$title?>" />
                    <div class="thumbs">
<?
    foreach($aMedia as $media) {
?>
                        <img class="thumb" src="<?=$this->Media->imageUrl($media, 'norisize')?>" alt="" />
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
                            <td width="40%">Категория</td>
                            <td width="60%"><?=$article['ProductCategory']['title']?></td>
                        </tr>
                        <tr>
                            <td width="40%">Подкатегория</td>
                            <td width="60%"><?=$article['ProductSubcategory']['title']?></td>
                        </tr>
                        <tr>
                            <td>Инв.номер</td>
                            <td><?=$article['Product']['id_num']?></td>
                        </tr>
                        <tr>
                            <td>Место хранения</td>
                            <td><?// $article['Product']['location']?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>