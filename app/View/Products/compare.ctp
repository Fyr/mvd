<div class="section">
	<div class="container">
		<h2 class="light"><?=__('Compare selected systems')?></h2>
		<table class="compareTable">
			<tr class="products">
				<td></td>
<?
	$colspan = 1;
	$i = 0;
	$buy = false;
	foreach($aProducts[$cat_id] as $id => $product) {
		if (in_array($id, $selected)) {
			if (isset($aPacks[$id])) {
				foreach($aPacks[$id] as $_id => $pack) {
					if (in_array($_id, $selected_packs[$id])) {
						$colspan++;
						$i++;
						echo $this->element('compare_product', compact('product', 'pack', 'buy', 'i'));
					}
				}
			} else {
				$i++;
				$colspan++;
				echo $this->element('compare_product', compact('product', 'buy', 'i'));
			}
		}
	}
?>

			</tr>
			<tr>
				<th colspan="<?=$colspan?>"><?=__('General information')?></th>
			</tr>
			<tr>
				<td><?=__('Description')?></td>
<?
	foreach($aProducts[$cat_id] as $id => $product) {
		if (in_array($id, $selected)) {
			$this->ArticleVars->init($product, $url, $title, $teaser, $src, 'noresize');
			if (isset($aPacks[$id])) {
				foreach($aPacks[$id] as $_id => $pack) {
					if (in_array($_id, $selected_packs[$id])) {
						echo $this->Html->tag('td', $teaser);
					}
				}
			} else {
				echo $this->Html->tag('td', $teaser);
			}
		}
	}
?>

			</tr>
<?
	$aFeatures = array();
	foreach($aProducts[$cat_id] as $id => &$product) {
		$features = trim($product['Product']['features_'.$lang]);
		$product['Product']['features'] = ($features) ? $this->ArticleVars->list2array($features) : array();
		$aFeatures = array_merge($aFeatures, $product['Product']['features']);
	}
	unset($product);
	if ($aFeatures) {
?>
			<tr>
				<th colspan="<?=$colspan?>"><?=__('System features')?></th>
			</tr>

<?
		$aFeatures = array_unique($aFeatures);
		sort($aFeatures);
		foreach($aFeatures as $feature) {
?>
			<tr>
				<td><?=$feature?></td>
<?
			foreach($aProducts[$cat_id] as $id => $product) {
				if (in_array($id, $selected)) {
					$class = (in_array($feature, $product['Product']['features'])) ? 'icon-check' : 'icon-close';
					if (isset($aPacks[$id])) {
						foreach ($aPacks[$id] as $_id =>$pack) {
							if (in_array($_id, $selected_packs[$id])) {
?>
				<td class="center"><span class="<?= $class ?>"></span></td>
<?
							}
						}
					} else {
?>
				<td class="center"><span class="<?= $class ?>"></span></td>
<?
					}
				}
			}
?>
			</tr>
<?
		}
	}
	$lShowParams = false;
	foreach($aFormGroups as $group_id => $group) {
		if (!$group['ParamGroup']['featured']) {
			$lShowParams = true;
			break;
		}
	}
	if ($lShowParams) {
		foreach($aFormGroups as $group_id => $group) {
			if (!$group['ParamGroup']['featured']) {
?>
			<tr>
				<th colspan="<?= $colspan ?>"><?=$group['ParamGroup']['title_'.$lang]?></th>
			</tr>
<?
				foreach($aForms[$group_id] as $fid => $field) {
?>
			<tr>
				<td><?=$field['PMFormField']['label_'.$lang]?></td>
<?
					foreach($aProducts[$cat_id] as $id => $product) {
						if (in_array($id, $selected)) {
							$value = $aValues[$fid]['ProductParam'][$id];
							if (isset($aPacks[$id])) {
								foreach ($aPacks[$id] as $_id=> $pack) {
									if (in_array($_id, $selected_packs[$id])) {
										echo $this->element('compare_param', compact('field', 'value'));
									}
								}
							} else {
								echo $this->element('compare_param', compact('field', 'value'));
							}
						}
					}
?>
			</tr>
<?
				}
			}
		}
	}
	$lShowPacks = false;
	if ($aPacks) {
		foreach ($aFormGroups as $group_id => $group) {
			if ($group['ParamGroup']['featured']) {
				$lShowPacks = true;
				break;
			}
		}
	}
	if ($lShowPacks) {
		foreach($aFormGroups as $group_id => $group) {
			if ($group['ParamGroup']['featured']) {
?>
			<tr>
				<th><?=$group['ParamGroup']['title_'.$lang]?></th>
<?
				foreach($aProducts[$cat_id] as $id => $product) {
					if (in_array($id, $selected)) {
						if (isset($aPacks[$id])) {
							foreach($aPacks[$id] as $_id => $pack) {
								if (in_array($_id, $selected_packs[$id])) {
?>
				<th class="center">
					<b><?=$product['Product']['title_'.$lang]?></b><br/>
					<?=$pack['ProductPack']['title_'.$lang]?>
				</th>
<?
								}
							}
						} else {
?>
				<th></th>
<?
						}
					}
				}
?>
			</tr>
<?
				foreach($aForms[$group_id] as $fid => $field) {
?>
			<tr>
				<td><?=$field['PMFormField']['label_'.$lang]?></td>
<?
					foreach($aProducts[$cat_id] as $id => $product) {
						if (in_array($id, $selected)) {
							if (isset($aPacks[$id])) {
								foreach ($aPacks[$id] as $_id => $pack) {
									if (in_array($_id, $selected_packs[$id])) {
										$value = $aValues[$fid]['ProductPackParam'][$_id];
										echo $this->element('compare_param', compact('field', 'value'));
									}
								}
							} else {
?>
				<td class="center">-</td>
<?
							}
						}
					}
?>
			</tr>
<?
				}
			}
		}
	}
?>
			<tr class="products">
				<td></td>
<?
	$colspan = 1;
	$buy = true;
	foreach($aProducts[$cat_id] as $id => $product) {
		if (in_array($id, $selected)) {
			if (isset($aPacks[$id])) {
				foreach($aPacks[$id] as $_id => $pack) {
					if (in_array($_id, $selected_packs[$id])) {
						$i++;
						echo $this->element('compare_product', compact('product', 'pack', 'buy', 'i'));
					}
				}
			} else {
				$i++;
				echo $this->element('compare_product', compact('product', 'buy', 'i'));
			}
		}
	}
?>
			</tr>
		</table>

	</div>
</div>
<script type="text/javascript">
$(function(){
	$('.thumb .icon-close').click(function(){
		var id = $(this).closest('td').prop('id');
		var i = 0, count = 0;
		$(this).closest('tr').find('td').each(function(){
			if ($(this).prop('id') == id) {
				i = count;
			}
			count++;
		});

		$('.compareTable tr').each(function(){
			count = 0;
			$(this).find('td,th').each(function(){
				if ($(this).prop('colspan') > 1) {
					$(this).prop('colspan', $(this).prop('colspan') - 1);
				} else {
					if (count == i) {
						$(this).hide();
					}
				}
				count++;
			});
		});
	});
});
</script>