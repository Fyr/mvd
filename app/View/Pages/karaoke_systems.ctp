<div class="otherKaraokeSystems">
    <div class="container">
        <?//$this->element('SiteUI/title', array('title' => 'Что такое Your Day караоке системы  и зачем они нужны?'))?>
        <h3><?=$page['Page']['title_'.$lang]?></h3>
        <div class="bigIntro">
            <?=$this->ArticleVars->body($page)?>
        </div>
    </div>
</div>

<div class="grey otherKaraokeSystems">
    <div class="container">
        <div class="row">
<?
    foreach($aCategories as $cat_id => $article) {
        $this->ArticleVars->init($article, $url, $title, $teaser, $src, 'noresize');
        $price = ($aPrices[$cat_id]) ? 'от '.$this->Price->format($aPrices[$cat_id]) : '&nbsp;';
?>
            <div class="col-sm-<?=ceil(12 / count($aCategories))?>">
<?
        if ($src) {
?>
                <div class="thumbHeight">
                    <a href="<?=$url?>"><img class="img-responsive" src="<?=$src?>" alt="<?=$title?>" /></a>
                </div>
<?
        }
?>
                <a href="<?=$url?>" class="link"><?=$title?></a>
                <div class="price"><?=$price?></div>
                <div class="description">
                    <div class="head"><?=$article['Category']['header_'.$lang]?></div>
                    <?=$this->ArticleVars->body($article)?>
                </div>
            </div>

<?
    }
?>
            <!--div class="col-sm-6">
                <div class="thumbHeight"><a href="javascript:void(0)"><img src="img/virual_systems.png" alt="" class="img-responsive" /></a></div>
                <a href="javascript:void(0)" class="link">Vitrtual системы</a>
                <div class="price">от 35 000</div>
                <div class="description">
                    <div class="head">Виртуальные системы Your Day Virtual</div>
                    <p>Виртуальные караоке системы – это караоке для использования на компьютере. Система представлена портативным жестким диском USB 3.0, на котором находится комплект специального ПО, с необходимым функционалом и возможностями, база караоке песен и другой медиаконтент. </p>
                    <p>Программное обеспечение устанавливается на любой удобный для Вас компьютер. В комплект караоке систем Virtual Plus включена профессиональная звуковая карта, которая делает виртуальную систему полноценной системой караоке. В любой комплект Virtual системы входит современный караоке плеер YOUR DAY с широким функционалом и пакетом услуг.</p>
                </div>
            </div-->
        </div>
    </div>
</div>