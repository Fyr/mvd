<div class="slide">
	<div class="is_overlay">
		<video autoplay="autoplay" loop="loop">
			<source src="/img/video.mp4" type="video/mp4">
		</video>
	</div>
	<div class="container">
		<div class="phoneNumber">
			<div class="phone">
				<div><?=__('Free call')?></div>
				<div class="number"><?=nl2br($this->Settings->read('phone_header'))?></div>
			</div>
		</div>
		<div class="text">
			<h2><?=$page['title_'.$lang]?></h2>
			<div class="description"><?=$page['body_'.$lang]?></div>
		</div>
		<i class="vert"></i>
	</div>
	<div class="main-block-bg"></div>
</div>
<?
	foreach($blocks as $id => $block) {
		echo $this->element('Pages/home/'.$id, compact('block'));
	}
?>
<div id="slide-news" class="slide">
	<div class="container">
		<i class="vert"></i>
		<div class="content">
			<h2><?=__('The latest news from the world of karaoke')?></h2>
			<?=$this->element('news')?>
			<div class="link">
				<?=$this->Html->link(__('More news...'), array('controller' => 'news', 'action' => 'index'), array('class' => 'btn btn-success'))?>
			</div>
		</div>
	</div>
	<div class="footer">
		<div class="container">
			<?=$this->element('SiteUI/footer')?>
		</div>
	</div>
</div>
<script>
	$(function(){
		$('.home-elipsys').dotdotdot();
	});
</script>