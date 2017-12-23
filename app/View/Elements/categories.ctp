<?
	$aSubcategories = Hash::combine($aSubcategories, '{n}.Subcategory.id', '{n}', '{n}.Subcategory.parent_id');
?>
<div class="col-md-3 col-sm-4">
	<div class="subMenu">
		<div class="title">Коллекции</div>
		<ul>
<?
	foreach($aCategories as $category) {
		$this->ArticleVars->init($category, $url, $title, $teaser, $src, '600x', $cat_id);
?>
			<li><span><a id="cat_<?=$cat_id?>" href="javascript:void(0)"><?=$title?></a></span>
				<ul>
<?
		foreach($aSubcategories[$cat_id] as $subcategory) {
			$this->ArticleVars->init($subcategory, $url, $title, $teaser, $src, '600x', $subcat_id);
?>
				<li class="effective"><a href="<?=$url?>"><?=$title?></a></li>
<?
		}
?>
				</ul>
			</li>
<?
	}
?>

		</ul>
	</div>
</div>
<?
	if (isset($curr_cat_id)) {
?>
<script>
$(function () {
	setTimeout(function(){
		console.log($('.subMenu a#cat_<?=$curr_cat_id?>').get(0));
		$('.subMenu a#cat_<?=$curr_cat_id?>').click();
	}, 0);
});
</script>
<?
	}
?>