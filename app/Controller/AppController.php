<?php
App::uses('Category', 'Model');
App::uses('Product', 'Model');
class AppController extends Controller {
	public $components = array(/*'DebugKit.Toolbar',*/
		'Auth' => array(
			'authorize'      => array('Controller'),
			'loginAction'    => array('plugin' => '', 'controller' => 'pages', 'action' => 'home', '?' => array('login' => 1)),
			'loginRedirect'  => array('plugin' => '', 'controller' => 'user', 'action' => 'index'),
			'ajaxLogin' => 'Core.ajax_auth_failed',
			'logoutRedirect' => '/',
			'authError'      => 'You must sign in to access that page'
		),
	);

	protected $aCategories, $currUser, $cart;

	public function __construct($request = null, $response = null) {
		$this->_beforeInit();
		parent::__construct($request, $response);
		$this->_afterInit();
	}

	protected function _beforeInit() {
		$this->helpers = array_merge(array('ArticleVars'), $this->helpers); // 'ArticleVars', 'Media.PHMedia', 'Core.PHTime', 'Media', 'ObjectType'
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

	public function beforeFilter() {
		$this->beforeFilterLayout();
	}

	public function beforeFilterLayout() {
		$this->loadModel('Product');
		$this->loadModel('Category');

		$this->Auth->allow(array('home', 'show', 'view', 'index', 'custom', 'full', 'compare', 'karaoke_systems', 'player', 'tablet', 'select', 'login'));
		$this->currUser = array();
		$this->cart = array();
		if ($this->Auth->loggedIn()) {
			$this->_refreshUser();
		}

		$this->aCategories = $this->Category->find('all', array('order' => 'sorting'));
		$this->aCategories = Hash::combine($this->aCategories, '{n}.Category.id', '{n}');
	}

	public function beforeRender() {
		$this->beforeRenderLayout();
	}

	protected function beforeRenderLayout() {
		$this->set('aCategories', $this->aCategories);
		$this->set('lang', Configure::read('Config.language'));
		$this->set('currUser', $this->currUser);
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
