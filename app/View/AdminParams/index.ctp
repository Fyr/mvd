<?
	$title = $this->ObjectType->getTitle('index', $objectType);
	$indexURL = array('controller' => 'AdminParamGroups', 'action' => 'index', Hash::get($category, 'Category.id'));
	$editURL = array('controller' => 'AdminParamGroups', 'action' => 'edit', Hash::get($parentArticle, 'ParamGroup.id'));
	$breadcrumbs = array(
		__('eCommerce') => 'javascript:;',
		$this->ObjectType->getTitle('index', 'Category') => array('controller' => 'AdminCategories', 'action' => 'index'),
		Hash::get($category, 'Category.title_'.$lang) => array('controller' => 'AdminCategories', 'action' => 'edit', Hash::get($category, 'Category.id')),
		$this->ObjectType->getTitle('index', 'ParamGroup') => $indexURL,
		Hash::get($parentArticle, 'ParamGroup.title_'.$lang) => $editURL,
		$title => ''
	);
	echo $this->element('AdminUI/breadcrumbs', compact('breadcrumbs'));
	echo $this->element('AdminUI/title', compact('title'));
	echo $this->Flash->render();

	$columns = $this->PHTableGrid->getDefaultColumns($objectType);
	$columns[$objectType.'.label_'.$lang]['label'] = __('Title');
	$columns[$objectType.'.field_type']['format'] = 'string';
	$rowset = $this->PHTableGrid->getDefaultRowset($objectType);
	foreach($rowset as &$row) {
		$row['PMFormField']['field_type'] = $aFieldTypes[$row['PMFormField']['field_type']];
	}
?>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<?=$this->element('AdminUI/form_title', array('title' => $title))?>
			<div class="portlet-body dataTables_wrapper">
				<div class="table-toolbar">
					<div class="row">
						<div class="col-md-6">
							<div class="btn-group">
								<a class="btn green" href="<?=$this->Html->url(array('action' => 'edit', 0, $parent_id))?>">
									<i class="fa fa-plus"></i> <?=$this->ObjectType->getTitle('create', $objectType)?>
								</a>
							</div>
						</div>
						<div class="col-md-6">

						</div>
					</div>
				</div>
				<?=$this->PHTableGrid->render($objectType, compact('rowset', 'columns'))?>
			</div>
		</div>
	</div>
</div>
