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
		$this->loadModel('Settings');
		$this->Settings->initData();

		$this->_initLang();
	}

	public function _initLang() {
		$lang = 'eng';
		if (isset($_COOKIE['lang'])) {
			$lang = ($_COOKIE['lang'] == 'eng') ? 'eng' : 'rus';
		} else {
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
		}
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
			'Home' => array('title' => 'Главная', 'url' => array('controller' => 'pages', 'action' => 'home')),
			'About' => array('title' => 'О музее', 'url' => array('controller' => 'pages', 'action' => 'about')),
			'News' => array('title' => 'События', 'url' => array('controller' => 'news', 'action' => 'index')),
			'Products' => array('title' => 'Коллеции', 'url' => array('controller' => 'products', 'action' => 'categories')),
			'History' => array('title' => 'История милиции', 'url' => array('controller' => 'pages', 'action' => 'view', 'history')),
			'Contacts' => array('title' => 'Посетителям', 'url' => array('controller' => 'pages', 'action' => 'view', 'contacts')),
		);
		$this->currMenu = $this->_getCurrMenu();
		// $this->aBottomLinks = $this->aNavBar;
		// $this->currLink = $this->_currMenu;

		$this->Auth->allow(array('home', 'about', 'view', 'index', 'login', 'categories'));
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
		$this->set('lang', Configure::read('Config.language'));
		$this->set('currUser', $this->currUser);
		$this->set('aNavBar', $this->aNavBar);
		$this->set('currMenu', $this->currMenu);
		// $this->set('aBottomLinks', $this->aBottomLinks);
		// $this->set('currLink', $this->currLink);
	}

	protected function getLang() {
		return Configure::read('Config.language');
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
