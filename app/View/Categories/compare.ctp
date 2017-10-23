<style>
.link.light {
	text-decoration: none;
	border-bottom: 1px solid #ddd;
}
.container > a.link.light {
	display: block;
	text-decoration: none;
	margin: 20px 0 50px 0;
	border-bottom: 0px solid #fff;
}
.container > a.link.light:hover {
	color: #333;
	cursor: text;
}
</style>
<div class="otherKaraokeSystems">
	<div class="container">
		<?=$this->Html->link(__('Compare karaoke systems'), 'javascript:', array('class' => 'link light'))?>
		<?//$this->element('SiteUI/title', array('title' => 'Сравнение караоке систем', 'class' => 'light'))?>
		<div class="row">
<?
	foreach($aCategories as $category) {
		$this->ArticleVars->init($category, $url, $title, $teaser, $src, 'noresize', $featured, $id);
		$url = array('controller' => 'products', 'action' => 'select', $id);
?>
			<div class="col-sm-<?=floor(12 / count($aCategories))?>">
<?
		if ($src) {
?>
				<div class="thumbHeight">
					<a href="<?=$this->Html->url($url)?>"><img class="img-responsive" src="<?=$src?>" alt="" /></a></div>
<?
		}
		echo $this->Html->link(__('Compare %s', $title), $url, array('class' => 'link light'));
?>
			</div>

<?
	}
?>
		</div>
	</div>
</div>
