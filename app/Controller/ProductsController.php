<?php
App::uses('AppController', 'Controller');
App::uses('Media', 'Media.Model');
App::uses('Product', 'Model');
App::uses('ProductBlock', 'Model');
App::uses('ParamGroup', 'Model');
App::uses('ProductPack', 'Model');
App::uses('PMFormField', 'Form.Model');
App::uses('PMFormValue', 'Form.Model');
App::uses('FieldTypes', 'Form.Vendor');
App::uses('Page', 'Model');
App::uses('PageBlock', 'Model');
class ProductsController extends AppController {
	public $name = 'Products';
	public $uses = array('Media.Media', 'Product', 'ProductBlock', 'ParamGroup', 'ProductPack', 'Form.PMFormField', 'Form.PMFormValue', 'Page', 'PageBlock');

	public function view($slug) {
		$product = $this->Product->findBySlug($slug);
		$id = $product['Product']['id'];
		$conditions = array('media_type' => 'image', 'object_type' => 'Product', 'object_id' => $id, 'main' => 0);
		$aMedia = $this->Media->find('all', compact('conditions'));

		$conditions = array('parent_id' => $id, 'published' => 1);
		$order = 'sorting';
		$productBlocks = $this->ProductBlock->find('all', compact('conditions', 'order'));
		$this->set(compact('product', 'aMedia', 'productBlocks'));

		$conditions = array('parent_id' => $product['Product']['parent_id']);
		$order = 'sorting';
		$aParamGroups = $this->ParamGroup->find('all', compact('conditions', 'order'));
		$aParamGroups = Hash::combine($aParamGroups, '{n}.ParamGroup.id', '{n}');
		$this->set('aFormGroups', $aParamGroups);

		$conditions = array('object_type' => 'PMFormField', 'parent_id' => array_keys($aParamGroups));
		$order = 'sorting';
		$aParams = $this->PMFormField->find('all', compact('conditions', 'order'));
		if ($aParams) {
			// $ids = Hash::extract($aParams, '{n}.PMFormField.id');
			$aParams = Hash::combine($aParams, '{n}.PMFormField.id', '{n}', '{n}.PMFormField.parent_id');
		}
		$this->set('aForms', $aParams);

		$aValues = $this->PMFormValue->getValues('ProductParam', $id);
		$this->set('aValues', $aValues);

		$conditions = array('parent_id' => $id);
		$order = 'sorting';
		$aPacks = $this->ProductPack->find('all', compact('conditions', 'order'));
		$this->set('aPacks', $aPacks);
		$aPackValues = array();
		foreach($aPacks as $pack) {
			$pack_id = Hash::get($pack, 'ProductPack.id');
			foreach($this->PMFormValue->getValues('ProductPackParam', $pack_id) as $fid => $val) {
				$aPackValues[$fid][$pack_id] = $val;
			}
		}
		$this->set('aPackValues', $aPackValues);

		$page['support'] = $this->Page->findBySlug('support');
		$pageBlocks['support'] = $this->PageBlock->findAllByPublishedAndParentId(1, $page['support']['Page']['id'], null, 'sorting');
		$this->set(compact('page', 'pageBlocks'));

		// в первую очередь выводим особые продукты, затем из той же категории, затем все остальные
		$conditions = array('Product.id <> '.$product['Product']['id']);
		$order = 'Product.featured DESC, Product.parent_id = '.$product['Product']['parent_id'].' DESC';
		$limit = 3;
		$otherProducts = $this->Product->find('all', compact('conditions', 'order', 'limit'));

		$conditions = array('parent_id' => Hash::extract($otherProducts, '{n}.Product.id'));
		$order = 'sorting';
		$otherPacks = $this->ProductPack->find('all', compact('conditions', 'order'));
		$otherPacks = Hash::combine($otherPacks, '{n}.ProductPack.id', '{n}', '{n}.ProductPack.parent_id');
		$this->set(compact('otherProducts', 'otherPacks'));
	}

	public function select($cat_id, $selected = '') {
		$this->set('cat_id', $cat_id);
		$this->set('selected', ($selected) ? explode(',', $selected) : array());
		$conditions = array('parent_id' => Hash::extract($this->aProducts[$cat_id], '{n}.Product.id'));
		$order = 'sorting';
		$aPacks = $this->ProductPack->find('all', compact('conditions', 'order'));
		$aPacks = Hash::combine($aPacks, '{n}.ProductPack.id', '{n}', '{n}.ProductPack.parent_id');
		$this->set('aPacks', $aPacks);
	}

	public function compare($cat_id, $selected = '') {
		$this->set('cat_id', $cat_id);
		$selected_packs = array();
		$selected = ($selected) ? explode(',', $selected) : array();

		foreach($selected as &$sel) {
			if (strpos($sel, '-') !== false) {
				list($prod_id, $pack_id) = explode('-', $sel);
				$selected_packs[$prod_id][] = $pack_id;
				$sel = $prod_id;
			}
		}
		$selected = array_unique($selected);
		$this->set(compact('selected', 'selected_packs'));

		$conditions = array('parent_id' => $cat_id);
		$order = 'sorting';
		$aParamGroups = $this->ParamGroup->find('all', compact('conditions', 'order'));
		$aParamGroups = Hash::combine($aParamGroups, '{n}.ParamGroup.id', '{n}');
		$this->set('aFormGroups', $aParamGroups);

		$conditions = array('object_type' => 'PMFormField', 'parent_id' => array_keys($aParamGroups));
		$order = 'sorting';
		$aParams = $this->PMFormField->find('all', compact('conditions', 'order'));
		if ($aParams) {
			$aParams = Hash::combine($aParams, '{n}.PMFormField.id', '{n}', '{n}.PMFormField.parent_id');
		}
		$this->set('aForms', $aParams);

		$conditions = array('parent_id' => $selected);
		$order = 'sorting';
		$aPacks = $this->ProductPack->find('all', compact('conditions', 'order'));
		$pack_ids = Hash::extract($aPacks, '{n}.ProductPack.id');
		$aPacks = Hash::combine($aPacks, '{n}.ProductPack.id', '{n}', '{n}.ProductPack.parent_id');
		$this->set('aPacks', $aPacks);

		$values = $this->PMFormValue->find('all', array('conditions' => array('OR' => array(
			array('object_type' => 'ProductParam', 'parent_id' => $selected),
			array('object_type' => 'ProductPackParam', 'parent_id' => $pack_ids)
		))));
		$aValues = array();
		foreach($values as $param) {
			$param = $param['PMFormValue'];
			$aValues[$param['field_id']][$param['object_type']][$param['parent_id']] = $param['value'];

		}
		$this->set(compact('aValues'));
	}
}
