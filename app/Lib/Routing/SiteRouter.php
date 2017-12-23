<?
App::uses('Router', 'Cake/Routing');
class SiteRouter extends Router {

	static public function getObjectType($article) {
		list($objectType) = array_keys($article);
		return $objectType;
	}
	
	static public function url($article) {
		$objectType = self::getObjectType($article);
		if ($objectType == 'Product') {
			$url = array(
				'controller' => 'products',
				'action' => 'view',
				$article['Product']['id']
				// $article['Product']['slug']
			);
		} elseif ($objectType == 'News') {
			$url = array(
				'controller' => 'news',
				'action' => 'view',
				$article['News']['id']
			);
		} elseif ($objectType == 'Category') {
			$url = array(
				'controller' => 'products',
				'action' => 'index',
				'?' => array('Product.cat_id' => $article['Category']['id'])
			);
		} elseif ($objectType == 'Subcategory') {
			$url = array(
				'controller' => 'products',
				'action' => 'index',
				'?' => array('Product.cat_id' => $article['Subcategory']['parent_id'], 'Product.subcat_id' => $article['Subcategory']['id'])
			);
		} else {
			$url = array(
				'controller' => 'articles',
				'action' => 'view',
				'objectType' => $objectType,
				'slug' => $article[$objectType]['id']
			);
		}
		return parent::url($url);
	}
	
}