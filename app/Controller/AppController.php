<?php
App::uses('Category', 'Model');
App::uses('Product', 'Model');
class AppController extends Controller {
	public $components = array(
		'Auth' => array(
			'authorize'      => array('Controller'),
			'loginAction'    => array('plugin' => '', 'controller' => 'pages', 'action' => 'home', '?' => array('login' => 1)),
			'loginRedirect'  => array('plugin' => '', 'controller' => 'user', 'action' => 'index'),
			'ajaxLogin' => 'Core.ajax_auth_failed',
			'logoutRedirect' => '/',
			'authError'      => 'You must sign in to access that page'
		),
	);

	protected $aCategories, $currUser, $aNavBar, $currMenu, $aBottomLinks, $currLink;

	public function __construct($request = null, $response = null) {
		$this->_beforeInit();
		parent::__construct($request, $response);
		$this->_afterInit();
	}

	protected function _beforeInit() {
		$this->helpers = array_merge(array('ArticleVars', 'Media'), $this->helpers); // 'ArticleVars', 'Media.PHMedia', 'Core.PHTime', 'Media', 'ObjectType'
	}

	protected function _afterInit() {
		// after construct actions here
		$this->_initLang();

		$this->loadModel('Settings');
		$this->Settings->initData();
	}

	public function _initLang() {
		$aLangs = array_keys(Configure::read('Config.langs'));
		$lang = (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], $aLangs)) ? $_COOKIE['lang'] : 'rus';
			/* заказчик не просил автоопределение языка
			preg_match_all('/([a-z]{1,8}(?:-[a-z]{1,8})?)(?:;q=([0-9.]+))?/', strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"]), $matches);
			$langs = array_combine($matches[1], $matches[2]);
			foreach ($langs as $n => $v)
				$langs[$n] = $v ? $v : 1;
			arsort($langs);

			$aSupportLang = array('ru-ru' => 'rus', 'ru' => 'rus');
			foreach($aSupportLang as $code => $_lang) {
				if (isset($langs[$code])) {
					$lang = $_lang;
					break;
				}
			}
			*/
		Configure::write('Config.language', $lang);
	}

	public function loadModel($modelClass = null, $id = null) {
		if ($modelClass === null) {
			$modelClass = $this->modelClass;
		}

		$this->uses = ($this->uses) ? (array)$this->uses : array();
		if (!in_array($modelClass, $this->uses, true)) {
			$this->uses[] = $modelClass;
		}

		list($plugin, $modelClass) = pluginSplit($modelClass, true);

		$this->{$modelClass} = ClassRegistry::init(array(
			'class' => $plugin . $modelClass, 'alias' => $modelClass, 'id' => $id
		));
		if (!$this->{$modelClass}) {
			throw new MissingModelException($modelClass);
		}
		return $this->{$modelClass};
	}


	public function isAuthorized($user) {
		return Hash::get($user, 'active');
	}

	public function redirect404() {
		// return $this->redirect(array('controller' => 'pages', 'action' => 'notExists'), 404);
		throw new NotFoundException();
	}

	private function _getCurrMenu() {
		foreach($this->aNavBar as $curr => $item) {
			if ($this->request->controller == $item['url']['controller'] && $this->request->action == $item['url']['action']) {
				return $curr;
			}
		}
		return '';
	}

	public function beforeFilter() {
		$this->beforeFilterLayout();
	}

	public function beforeFilterLayout() {
		$this->aNavBar = array(
			'Home' => array('title' => __('Home'), 'url' => array('controller' => 'pages', 'action' => 'home')),
			'About' => array('title' => __('About the Museum'), 'url' => array('controller' => 'pages', 'action' => 'about', 'museum')),
			'News' => array('title' => __('Events'), 'url' => array('controller' => 'news', 'action' => 'index')),
			'Products' => array('title' => __('Collections'), 'url' => array('controller' => 'products', 'action' => 'categories')),
			'History' => array('title' => __('History of police'), 'url' => array('controller' => 'pages', 'action' => 'history', 'history-pdf')),
			'Contacts' => array('title' => __('Visitors'), 'url' => array('controller' => 'pages', 'action' => 'view', 'contacts')),
		);
		$this->currMenu = $this->_getCurrMenu();
		// $this->aBottomLinks = $this->aNavBar;
		// $this->currLink = $this->_currMenu;
		if (Configure::read('Config.language') !== 'rus') {
			unset($this->aNavBar['Products']);
		}
		$this->Auth->allow(array('home', 'view', 'index', 'login', 'categories', 'about', 'history'));
		$this->currUser = array();
		$this->cart = array();
		if ($this->Auth->loggedIn()) {
			$this->_refreshUser();
		}
	}

	public function beforeRender() {
		$this->beforeRenderLayout();
	}

	protected function beforeRenderLayout() {
		$this->set('aLangs', Configure::read('Config.langs'));
		$this->set('lang', Configure::read('Config.language'));
		$this->set('currUser', $this->currUser);
		$this->set('aNavBar', $this->aNavBar);
		$this->set('currMenu', $this->currMenu);
		// $this->set('aBottomLinks', $this->aBottomLinks);
		// $this->set('currLink', $this->currLink);
	}

	protected function _refreshUser($lForce = false) {
		if ($lForce) {
			$this->loadModel('User');
			$user = $this->User->findById($this->currUser['id']);
			$this->Auth->login($user['User']);
		}

		$this->loadModel('Product');

		$this->currUser = AuthComponent::user();
	}
}
