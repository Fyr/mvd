<div class="playerKaraoke karaokeTablet">
    <div class="container">
        <div class="title"><?=$page['Page']['title_'.$lang]?></div>
        <div class="smallDesc"><?=__('The application for remote control of your karaoke system')?></div>
        <div class="outerCarousel">
            <div id="owl-carousel" class="owl-carousel">
<?
    foreach($aMedia as $media) {
?>
                <div class="item"><img class="lazyOwl" data-src="<?=$this->Media->imageUrl($media, 'noresize')?>" alt="" /></div>
<?
    }
?>
            </div>
        </div>
    </div>
</div>
<div class="grey buyPlayer">
    <div class="container">
        <div class="text">
            <?=$this->ArticleVars->body($page)?>
            <div class="stores">
                <a href="<?=Configure::read('Settings.app_apple')?>" target="_blank"><img src="/img/apple1.png" alt="App Store" /></a>
                <a href="<?=Configure::read('Settings.app_google')?>" target="_blank"><img src="/img/google1.png" alt="Play Market" /></a>
            </div>
        </div>
    </div>
</div>
<div class="darkGrey characteristics">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <?=__('Installation on the operating system Android and iOS')?>
            </div>
            <div class="col-sm-4">
                <?=__('Access to the full functionality of karaoke player')?>
            </div>
            <div class="col-sm-4">
                <?=__('Easy and quick installation on the tablet')?>
            </div>
        </div>
    </div>
</div>

<?
    $class = 'grey';
    foreach($blocks as $block) {
        $class = ($class == 'grey') ? '' : 'grey';
        $this->ArticleVars->init($block, $url, $title, $teaser, $src, 'noresize');
        $text = $block['PageBlock']['body_'.$lang];
        if ($block['PageBlock']['slug'] == 'tablet-modes') {
            echo $this->element('tablet_modes', compact('title', 'text', 'src'));
        } elseif ($block['PageBlock']['slug'] == 'tablet-download-app') {
            echo $this->element('tablet_download_app', compact('title', 'text'));
        } else {
            echo $this->element('product_block', compact('class', 'title', 'src', 'text', 'mainTitle'));
        }
    }

    echo $this->element('call_us');
?>

<!--div class="section">
    <div class="container">
        <div class="title">Преимущества работы с приложением</div>
        <h2 class="light">Работа в двух режимах: администратора и пользователя</h2>
        <div class="textAllWidth">Приложение Your Tablet работает в двух режимах доступа к караоке системе: режим администратора и режим пользователя. Режим доступа пользователя подходит для посетителей заведения. Он позволяет просмотреть каталог песен и добавить песни в плей-лист. При этом можно не волноваться о настройках системы – они будут защищены паролем администратора. Режим доступа администратора разработан специально для администратора, звукорежиссера или для личного использования дома. В данном режиме открыт доступ к управлению всеми функциями караоке системы.</div>
        <img src="img/karaoke21.png" class="img-responsive" alt="" />
    </div>
</div>
<div class="section grey">
    <div class="container">
        <h2 class="light">Подключение неограниченного количества планшетов</h2>
        <table class="sectionContent">
            <tr>
                <td class="text">Ваше заведение пользуется популярностью и количество его посетителей растет с каждым днем? Приложение  Your Tablet поможет Вам с легкостью обслуживать неограниченное число гостей. С его помощью все ваши клиенты смогут выбирать, искать и заказывать караоке песни без участия звукорежиссера. Для этого посетителю достаточно скачать приложение Your Tablet на планшет, подключиться по сети Wi-Fi и узнать пароль доступа у администратора. И все! Вам останется лишь управлять заказами клиентов, как бы много их ни было.</td>
                <td valign="bottom"><img src="img/karaoke22.png" class="img-responsive" alt="" /></td>
            </tr>
        </table>
    </div>
</div>
<div class="section">
    <div class="container">
        <h2 class="light">Доступ ко всем функциям караоке плеера</h2>
        <table class="sectionContent">
            <tr>
                <td><img src="img/karaoke5.png" class="img-responsive" alt="" /></td>
                <td class="text">Установив приложение Your Tablet, Вы получаете доступ ко всем функциям караоке плеера. Это значит, что Вы сможете пользоваться полным функционалом плеера удаленно. Вам не составит труда сменить тональность, скорость композиции, загрузить или создать плей-лист, воспроизвести музыку в паузах, запустить видеоматериалы, помочь посетителю быстро найти интересующую песню и многое другое. При этом Вы больше не будете неотрывно связаны со своим рабочим местом.</td>
            </tr>
        </table>
    </div>
</div>
<div class="section downloadMobiles">
    <div class="container">
        <h2 class="light">Простое управление караоке системой дома</h2>
        <div class="leftText">Приложение Your Tablet незаменимо в управлении караоке системой дома. Вам больше не придется подходить к системе каждый раз, когда захотите ее включить или выключить, сменить песню, изменить настройки или совершить другие действия. Теперь это можно сделать удаленно при помощи приложения. Начать пользоваться приложением дома легко: откройте караоке плеер и установите в настройках пароль для полного доступа. Запустите Your Tablet на вашем планшете – приложение автоматически найдет доступные подключения Wi-Fi. После этого введите свой пароль полного доступа, в появившемся окне, и наслаждайтесь удобством удаленного управления караоке системой.</div>
        <h4>Скачать мобильное приложение для планшетов<br />Вы можете здесь</h4>
        <div class="stores">
            <a href="javascript: void(0)"><img alt="Google Play" src="img/google.png"></a>
            <a href="javascript: void(0)"><img alt="App Store" src="img/apple.png"></a>
        </div>
    </div>
</div-->