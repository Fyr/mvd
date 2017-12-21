<div class="container">
    <div class="row mainContent">
        <div class="col-md-6 col-sm-6">
            <div id="owl-carousel" class="mainPageGallery">
<?
    foreach($aSlider as $media) {
?>
                <div class="item" style="background-image: url('<?=$this->Media->imageUrl($media, 'noresize')?>')"></div>
<?
    }
?>
            </div>
        </div>
        <div class="col-md-5 col-md-offset-1 col-sm-6">
            <h2><?=$page['Page']['title_'.$lang]?></h2>
            <?=$this->ArticleVars->body($page)?>
        </div>
    </div>
    <div class="head">
        <div class="outerIcon">
            <span class="icon-star"></span>
        </div>
        <h2>События и мероприятия</h2>
    </div>
    <div class="row mainPageEvents">
        <div class="col-sm-4">
            <div class="outer">
                <a href="javascript: void(0)" class="picture" style="background-image: url('img/temp/5.jpg')"></a>
                <div class="date">3 марта 2017</div>
            </div>
            <a href="javascript: void(0)" class="description">Музей МВД посетили семьи сотрудников органов внутренних дел, погибших при исполнении служебного долга Музей МВД посетили семьи сотрудников органов внутренних дел, погибших при исполнении служебного долга</a>
        </div>
        <div class="col-sm-4">
            <div class="outer">
                <a href="javascript: void(0)" class="picture" style="background-image: url('img/temp/4.jpg')"></a>
                <div class="date">28 апреля 2017</div>
            </div>
            <a href="javascript: void(0)" class="description">Музей МВД посетил директор Центрального музея Вооруженных Сил Российской Федерации А.К.Никонов Музей МВД посетил директор Центрального музея Вооруженных Сил Российской Федерации А.К.Никонов.</a>
        </div>
        <div class="col-sm-4">
            <div class="outer">
                <a href="javascript: void(0)" class="picture" style="background-image: url('img/temp/3.jpg')"></a>
                <div class="date">20 мая 2017</div>
            </div>
            <a href="javascript: void(0)" class="description">Акция "Ночь музеев - 2017". Совместное мероприятие с</a>
        </div>
    </div>
    <div class="head">
        <div class="outerIcon">
            <span class="icon-star"></span>
        </div>
        <h2>Интересные экспонаты</h2>
    </div>
    <div class="row mainPageEvents exhibits">
        <div class="col-sm-4">
            <a href="javascript: void(0)" class="picture">
                <img src="img/temp/gram1.png" alt="" />
            </a>
            <a href="javascript: void(0)" class="description">Почетная грамота Верховного Совета БССР, которой был награжден Климовской А.А., министр внутренних дел БССР с 1967 по 1978 год.</a>
        </div>
        <div class="col-sm-4">
            <a href="javascript: void(0)" class="picture">
                <img src="img/temp/gram2.png" alt="" />
            </a>
            <a href="javascript: void(0)" class="description">Нагрудный знак «ХV лет РКМ», которым был награжден Горячева П.Я., начальник управления милиции Барановичской области в 1932 году.</a>
        </div>
        <div class="col-sm-4">
            <a href="javascript: void(0)" class="picture">
                <img src="img/temp/3.jpg" alt="" />
            </a>
            <a href="javascript: void(0)" class="description">7,62 мм револьвер системы Нагана образца 1895 года.</a>
        </div>
    </div>
</div>