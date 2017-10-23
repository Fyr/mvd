<div class="section downloadMobiles">
    <div class="container">
        <h2 class="light"><?=$title?></h2>
        <div class="leftText"><?=$text?></div>
        <h4><?=__('You can download mobile for %s tablets application here', '<br />')?></h4>
        <div class="stores">
            <a href="<?=Configure::read('Settings.app_apple')?>" target="_blank"><img src="/img/apple1.png" alt="App Store" /></a>
            <a href="<?=Configure::read('Settings.app_google')?>" target="_blank"><img src="/img/google1.png" alt="Play Market" /></a>
        </div>
    </div>
</div>