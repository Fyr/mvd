    <div class="row">
        <div class="col-sm-4">
            <div class="name"><?=__('Contact us')?></div>
            <p><?=$this->Settings->read('title')?></p>
            <p><?=nl2br($this->Settings->read('address'))?></p>
            <p><?=nl2br($this->Settings->read('phone_footer'))?></p>
            <p>Skype: <?=Configure::read('Settings.skype')?></p>
            <a href="mailto:<?=Configure::read('Settings.email')?>"><?=Configure::read('Settings.email')?></a>
        </div>
		<div class="col-sm-4">
			<div class="row">
<?
    foreach($aCategories as $cat_id => $category) {
?>
        <div class="col-sm-6">
            <div class="name"><?=$category['Category']['title_'.$lang]?></div>
<?
            foreach($aProducts[$cat_id] as $article) {
                $this->ArticleVars->init($article, $url, $title);
                echo $this->Html->link($title, $url).'<br />';
            }
?>
        </div>
<?
    }
?>
				<div class="col-sm-12 copyright">© 2016 Your Day Karaoke</div>
			</div>
		</div>
        <div class="col-sm-2">
            <div class="name"><?=__('Applications')?></div>
            <div class="link"><a href="<?=Configure::read('Settings.app_apple')?>" target="_blank"><img src="/img/apple.png" class="img-responsive" alt="App Store" width="140" /></a></div>
            <div class="link"><a href="<?=Configure::read('Settings.app_google')?>" target="_blank"><img src="/img/google.png" class="img-responsive" alt="Play Market" width="140" /></a></div>
        </div>
        <div class="col-sm-2 developer">
            <div class="dev"><?=__('Site development')?></div>
            <a href="http://kakadu.bz" title="kakadu.bz" target="_blank"><img alt="kakadu.bz" src="/img/kakadu.png"></a></div>
    </div>
    