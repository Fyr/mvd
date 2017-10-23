<div id="slide-remotecontrol" class="slide">
    <div class="container">
        <div class="content">
            <div class="left">
                <h2><?=nl2br($block['teaser_'.$lang])?></h2>
                <div><?=$block['body_'.$lang]?></div>
            </div>
            <div class="right">
                <a href="<?=Configure::read('Settings.app_apple')?>" target="_blank"><img src="/img/apple.png" alt="" /></a>
                <a href="<?=Configure::read('Settings.app_google')?>" target="_blank"><img src="/img/google.png" alt="" /></a>
            </div>
        </div>
    </div>
</div>