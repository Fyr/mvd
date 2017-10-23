<?php
App::uses('AppHelper', 'View/Helper');
class PriceHelper extends AppHelper {

	public function format($sum, $lang = '') {
		$lang = ($lang) ? $lang : $this->getLang();
		$sum = number_format(
			$sum,
			Configure::read('Settings.decimals_'.$lang),
			Configure::read('Settings.float_div_'.$lang),
			Configure::read('Settings.int_div_'.$lang)
		);
		$sum = Configure::read('Settings.price_prefix_'.$lang).$sum.Configure::read('Settings.price_postfix_'.$lang);
		return str_replace('$P', $this->symbolP(), $sum);
	}

	public function symbolP() {
		return '<span class="rubl">₽</span>';
	}
}
