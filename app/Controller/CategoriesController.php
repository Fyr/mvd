<?php
App::uses('AppController', 'Controller');
App::uses('Category', 'Model');
App::uses('ProductPack', 'Model');
App::uses('Page', 'Model');
App::uses('PageBlock', 'Model');
class CategoriesController extends AppController {
	public $name = 'Categories';
	public $uses = array('ProductPack', 'Category', 'CategoryBlock');

	public function compare() {
	}

	public function view($slug) {
		$article = $this->Category->findBySlug($slug);
		$cat_id = $article['Category']['id'];
		$blocks = $this->CategoryBlock->findAllByParentId($cat_id, null, 'sorting');
		$this->set(compact('article', 'blocks'));

		$this->ProductPack = $this->loadModel('ProductPack');


		$ids = array_keys($this->aProducts[$cat_id]);
		$conditions = array('parent_id' => $ids);
		$order = 'price_'.$this->getLang();
		$group = 'parent_id';
		$packs = $this->ProductPack->find('all', compact('conditions', 'order', 'group'));
		foreach($packs as $pack) {
			$aPrices[$pack['ProductPack']['parent_id']] = floatval($pack['ProductPack']['price_'.$this->getLang()]);
		}
		$this->set('aPrices', $aPrices);
	}
}
