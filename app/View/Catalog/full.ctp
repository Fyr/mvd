<?
	$this->Html->css('mediaelementplayer', array('inline' => false));
	$this->Html->script('vendor/mediaelement-and-player.min', array('inline' => false));
?>
<div class="playerKaraoke" style="padding-bottom: 0;">
	<div class="container">
		<div class="title"><?=$page['Page']['title_'.$lang]?></div>
		<div class="smallDesc"><?=__('Order professional recording karaoke songs individually')?></div>
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
		</div>
	</div>
</div>
<div class="darkGrey characteristics">
	<div class="container">
		<div class="row">
<?
	$features = $this->ArticleVars->list2array($this->Settings->read('catalog_features'));
	$cols = ceil(12 / (count($features) + 1));
?>
			<div class="col-sm-<?=$cols?>">
				<div style="padding-bottom: 10px;"><?=__('%s for one song', $this->Price->format($this->Settings->read('song_price', 'rus'), 'rus'))?></div>
				<?=__('%s for one song', $this->Price->format($this->Settings->read('song_price', 'eng'), 'eng'))?>
			</div>
<?
	foreach($features as $title) {
?>
			<div class="col-sm-<?=$cols?>">
				<?=$title?>
			</div>

<?
	}
?>
		</div>
	</div>
</div>
<div class="playerKaraoke" style="padding-bottom: 0;">
	<div class="container">
		<div class="title"><?=__('Examples of songs sound')?></div>
		<div class="smallDesc"><?=__('You can appreciate the sound quality and our soundtracks phones')?></div>
		<div class="row">
			<div class="col-sm-6">
<?
	foreach($aTracks as $media) {
?>
				<div class="songPlayer">
					<div class="songTitle"><?=pathinfo($media['Media']['orig_fname'], PATHINFO_FILENAME)?></div>
					<audio id="player2" src="<?=$media['Media']['url_download']?>" type="audio/<?=str_replace('.', '', $media['Media']['ext'])?>" controls="controls"></audio>
				</div>

<?
	}
?>
			</div>
			<div class="col-sm-6">
				<!-- img src="/img/temp/youtube.jpg" class="img-responsive" alt="" /-->
				<!--iframe width="600" height="350" src="https://www.youtube.com/embed/et281UHNoOU" frameborder="0" allowfullscreen></iframe-->
				<?=$this->Settings->read('catalog_video')?>
			</div>
		</div>
		<div class="row catalogPrice">
			<div class="col-sm-6">
				<?=__('The cost of the full song catalog - %s', $this->Price->format($this->Settings->read('song_price', 'rus'), 'rus'))?><br />
				(<?=__('The same price %s for song', $this->Price->format($this->Settings->read('song_price', 'rus'), 'rus'))?>)
			</div>
			<div class="col-sm-6">
<?
	if ($pdf) {
?>
				<a href="<?=$pdf['Media']['url_download']?>" class="manual">
					<img src="/img/pdf.png" alt="">
					<span><?=$pdf['Media']['orig_fname']?> (<?=$this->PHMedia->MediaPath->filesizeFormat($pdf['Media']['orig_fsize'], 1)?>)</span>
				</a>
<?
	}
?>

			</div>
		</div>
		<div class="requestSong"><a href="javascript: void(0)" class="btn btn-success"><?=__('Order song')?></a></div>
	</div>
</div>
<div class="lineGradient"></div>
<?=$this->element('call_us')?>
<script>
	$(document).ready(function(){
		$('audio').mediaelementplayer({
			audioWidth: 542,
			features: ['playpause','current','duration','progress'],
			success: function(media, node, player) {
				media.addEventListener('play', function(e) {
					$(player.container).addClass('playing');
				});
			}
		});
	});
</script>
