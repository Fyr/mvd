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
			<li><span><a href="javascript:void(0)"><?=$title?></a></span>
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