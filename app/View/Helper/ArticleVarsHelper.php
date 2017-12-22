<?php
App::uses('AppHelper', 'View/Helper');
App::uses('SiteRouter', 'Lib/Routing');
class ArticleVarsHelper extends AppHelper {
	public $helpers = array('Media');

	public function init($article, &$url, &$title, &$teaser = '', &$src = '', $size = 'noresize', &$featured = false, &$id = '') {
		$objectType = $this->getObjectType($article);
		$id = $article[$objectType]['id'];
		
		$url = SiteRouter::url($article);
		$lang = $this->getLang();

		$_title = ($objectType == 'Product') ? 'title' : 'title_'.$lang;
		$title = $article[$objectType][$_title];

		$_teaser = ($objectType == 'Product') ? 'teaser' : 'teaser_'.$lang;
		$teaser = nl2br($article[$objectType][$_teaser]);

		$src = (isset($article['Media']) && $article['Media'] && isset($article['Media']['id']) && $article['Media']['id']) 
			? $this->Media->imageUrl($article, $size) : '';
		$featured = $article[$objectType]['featured'];
	}

	public function body($article) {
		$objectType = $this->getObjectType($article);
		$_body = ($objectType == 'Product') ? 'body' : 'body_'.$this->getLang();
		return '<article>'.$article[$objectType][$_body].'</article>';
	}

	public function divideColumns($items, $cols) {
		$aCols = array();
		$col = 0;
		$count = 0;
		$total = ceil(count($items) / $cols) ;
		$i = 0;
		foreach($items as $key => $item) {
			$aCols[$col][$key] = $item;
			$count++;
			$i++;
			if ($count >= $total && $i < count($items)) {
				$col++;
				$total = ceil((count($items) - $i) / ($cols - $col));
				$count = 0;
			}
		}
		return $aCols;
	}

	public function list2array($list) {
		$list = str_replace(array('<br />', '<br>'), '', trim($list)); // почему-то иногда при добавлении записи в textarea есть <br>
		return explode("\n", str_replace("\r\n", "\n", trim($list)));
	}

}
