<?php
App::uses('AppController', 'Controller');
App::uses('Page', 'Model');
App::uses('News', 'Model');
App::uses('Product', 'Model');
/*
App::uses('PageBlock', 'Model');


App::uses('Category', 'Model');
*/
App::uses('Media', 'Media.Model');

class PagesController extends AppController {
	public $uses = array('Media.Media', 'Page', 'News', 'Product');
	// public $helpers = array('Media.PHMedia');

	public function home() {
		$page = $this->Page->findBySlug('home');
		$aSlider = $this->Media->getList(array('object_type' => 'Slider'));

		$conditions = array('published' => 1, 'featured' => 1);
		$order = array('modified' => 'desc');
		$aNews = $this->News->find('all', compact('conditions', 'order'));

		$conditions = array('Product.published' => 1, 'Product.featured' => 1);
		$order = array('Product.modified' => 'desc');
		$aProducts = $this->Product->find('all', compact('conditions', 'order'));
		fdebug($aProducts);

		$this->set(compact('page', 'aSlider', 'aNews', 'aProducts'));

		/*
		$this->layout = 'home';
		$page = $this->Page->findBySlug('home');
		$blocks = $this->PageBlock->findAllByParentIdAndPublished($page['Page']['id'], 1, null, 'PageBlock.sorting');
		$blocks = Hash::combine($blocks, '{n}.PageBlock.slug', '{n}.PageBlock');
		$this->set('page', $page['Page']);
		$this->set('blocks', $blocks);

		$aNews = $this->News->findAllByPublished(1, null, 'News.modified DESC', 3);
		$aCategories = $this->Category->findAllByPublished(1, null, 'Category.sorting');
		$aProducts = $this->Product->findAllByPublished(1, null, 'Product.sorting');
		$this->set(compact('aNews', 'aProducts', 'aCategories'));
		*/
	}

	public function karaoke_systems() {
		$page = $this->Page->findBySlug('karaoke-systems');
		$this->set('page', $page);

		$this->ProductPack = $this->loadModel('ProductPack');
		foreach($this->aCategories as $cat_id => $category) {
			$ids = Hash::extract($this->aProducts[$cat_id], '{n}.Product.id');
			$conditions = array('parent_id' => $ids);
			$order = 'price_'.$this->getLang();
			$packs = $this->ProductPack->find('first', compact('conditions', 'order'));
			$aPrices[$cat_id] = ($packs) ? floatval($packs['ProductPack']['price_'.$this->getLang()]) : 0;
		}
		$this->set('aPrices', $aPrices);
	}

	public function player() {
		$page = $this->Page->findBySlug('player');
		$blocks = $this->PageBlock->findAllByParentIdAndPublished($page['Page']['id'], 1, null, 'PageBlock.sorting');

		$conditions = array('media_type' => 'image', 'object_type' => 'Page', 'object_id' => $page['Page']['id']);
		$aMedia = $this->Media->find('all', compact('conditions'));

		$conditions = array('media_type' => 'raw_file', 'object_type' => 'Page', 'object_id' => $page['Page']['id']);
		$doc = $this->Media->find('first', compact('conditions'));
		$this->set(compact('page', 'blocks', 'aMedia', 'doc'));
	}

	public function tablet() {
		$page = $this->Page->findBySlug('tablet');
		$blocks = $this->PageBlock->findAllByParentIdAndPublished($page['Page']['id'], 1, null, 'PageBlock.sorting');

		$conditions = array('media_type' => 'image', 'object_type' => 'Page', 'object_id' => $page['Page']['id']);
		$aMedia = $this->Media->find('all', compact('conditions'));

		$conditions = array('media_type' => 'raw_file', 'object_type' => 'Page', 'object_id' => $page['Page']['id']);
		$doc = $this->Media->find('first', compact('conditions'));
		$this->set(compact('page', 'blocks', 'aMedia', 'doc'));
	}
}
