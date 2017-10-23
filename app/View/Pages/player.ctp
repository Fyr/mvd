<div class="playerKaraoke">
    <div class="container">
        <div class="title"><?=$page['Page']['title_'.$lang]?></div>
        <div class="smallDesc"><?=__('One application for all your entertainment')?></div>
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
            <div class="row">
                <div class="col-sm-6 price">
                    <div class="value"><?=$this->Price->format($this->Settings->read('player_price'))?></div>
                    <div class="license"><?=$this->Settings->read('player_licence')?></div>
<?
    if ($doc) {
?>
                    <a href="<?=$doc['Media']['url_download']?>" class="manual">
                        <img src="/img/pdf.png" alt="" />
                        <span><?=$doc['Media']['orig_fname']?> (<?=$this->PHMedia->MediaPath->filesizeFormat($doc['Media']['orig_fsize'], 1)?>)</span>
                    </a>

<?
    }
?>
                </div>
                <div class="col-sm-6 buyButton">
                    <a href="javascript: void(0)" class="btn btn-success"><?=__('Buy player')?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?
    $class = 'grey';
    $mainTitle = __('The advantages of working with a player');
    foreach($blocks as $block) {
        $class = ($class == 'grey') ? '' : 'grey';
        $this->ArticleVars->init($block, $url, $title, $teaser, $src, 'noresize');
        $text = $block['PageBlock']['body_'.$lang];
        if ($block['PageBlock']['slug'] == 'player-features') {
            $features = $this->ArticleVars->list2array($teaser);
            echo $this->element('player_features', compact('class', 'title', 'features'));
        } elseif ($block['PageBlock']['slug'] == 'player-try-and-buy') {
            echo $this->element('player_try', compact('title', 'teaser'));
        } else {
            echo $this->element('page_block', compact('class', 'title', 'src', 'text', 'mainTitle'));
        }
        $mainTitle =  '';
    }

    echo $this->element('call_us');
?>
