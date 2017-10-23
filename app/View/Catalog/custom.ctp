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
<div class="section">
	<div class="container">
		<div class="title"><?=__('When an individual may need to order songs for karaoke')?></div>
		<ul class="individualList">
			<li>
				<img src="/img/icon1.png" class="img-responsive" alt="" />
				<div class="name"><?=__('New hit')?></div>
			</li>
			<li>
				<img src="/img/icon2.png" class="img-responsive" alt="" />
				<div class="name"><?=__('Out of the %stotal complete', '<br />')?></div>
			</li>
			<li>
				<img src="/img/icon3.png" class="img-responsive" alt="" />
				<div class="name"><?=__('Rare song')?></div>
			</li>
			<li>
				<img src="/img/icon4.png" class="img-responsive" alt="" />
				<div class="name"><?=__('The song of %sown composition', '<br />')?></div>
			</li>
			<li>
				<img src="/img/icon5.png" class="img-responsive" alt="" />
				<div class="name"><?=__('Children song')?></div>
			</li>
			<li>
				<img src="/img/icon6.png" class="img-responsive" alt="" />
				<div class="name"><?=__('Song in a gift')?></div>
			</li>
			<li>
				<img src="/img/icon7.png" class="img-responsive" alt="" />
				<div class="name"><?=__('Old song')?></div>
			</li>
			<li>
				<img src="/img/icon8.png" class="img-responsive" alt="" />
				<div class="name"><?=__('Folk song')?></div>
			</li>
			<li>
				<img src="/img/icon9.png" class="img-responsive" alt="" />
				<div class="name"><?=__('Professional%soundtrack', '<br />')?></div>
			</li>
		</ul>
	</div>
</div>
<div class="section grey">
	<div class="container">
		<div class="title"><?=__('How much is the personal order of karaoke songs')?></div>
		<table class="individualPrice">
			<tr>
				<th></th>
				<th class="price1"><?=__('Price')?>, <span class="rubl">₷</span></th>
				<th style="text-align: center"><?=__('Price')?>, $</th>
			</tr>
<?
	foreach($aServices as $service) {
?>
			<tr>
				<td class="name"><?=$service['Service']['title_'.$lang]?></td>
				<td class="price1"><?=$this->Price->format($service['Service']['price_rus'], 'rus')?></td>
				<td class="price2" style="padding-right: 0px; text-align: center;"><?=$this->Price->format($service['Service']['price_eng'], 'eng')?></td>
			</tr>
<?
	}
?>
	</table>
		<div class="requestSong"><a class="btn btn-success" href="javascript: void(0)"><?=__('Order song')?></a></div>
	</div>
</div>
<?=$this->element('call_us')?>