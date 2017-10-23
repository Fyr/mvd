<?php
App::uses('AppHelper', 'View/Helper');
App::uses('ArticleVars', 'View/Helper');

class SettingsHelper extends AppHelper {
	public $helpers = array('ArticleVars');

	public function read($option, $lang = '') {
		$lang = ($lang) ? $lang : $this->getLang();
		return Configure::read('Settings.'.$option.'_'.$lang);
	}

	public function getStatus($objectType, $status = null, $lang = '') {
		$lang = ($lang) ? $lang : $this->getLang();

		$aTypes = array(
			'Order' => 'status_orders_'.$lang,
			'OrderSong' => 'status_songs_'.$lang,
			'OrderPack' => 'status_packs_'.$lang,
			'OrderCustom' => 'status_custom_'.$lang
		);
		$option = Configure::read('Settings.'.$aTypes[$objectType]);
		$aStatus = $this->ArticleVars->list2array($option);
		return ($status === null) ? $aStatus : $aStatus[$status];
	}
}
