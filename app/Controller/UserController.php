<?php
App::uses('AppController', 'Controller');
App::uses('SiteRouter', 'Lib/Routing');
App::uses('Media', 'Media.Model');
App::uses('User', 'Model');
App::uses('Song', 'Model');
App::uses('SongPack', 'Model');
App::uses('Service', 'Model');
App::uses('Order', 'Model');
App::uses('Payment', 'Model');
class UserController extends AppController {
	public $name = 'User';
	public $layout = 'user';
	public $components = array('RequestHandler', 'Flash', 'Table.PCTableGrid');
	public $uses = array('User', 'Media.Media', 'SongPack', 'Song', 'Service', 'Order', 'Payment');
	public $helpers = array('Form.PHForm', 'Table.PHTableGrid', 'Media.PHMedia', 'Core.PHTime');

	public $paginate = array();

	public function login() {
		$tries = (isset($_COOKIE['login'])) ? intval($_COOKIE['login']) - 1 : 2;
		$this->_response = array('status' => 'OK', 'errMsg' => __('Invalid key.<br />You have left %s attempt(s)', $tries), 'tries' => $tries);
		if ($tries < 0) {
			$this->_response = array('status' => 'OK', 'errMsg' => __('You have no attempts left'), 'tries' => -1);
		} elseif ($this->request->is('post')) {
			$user = $this->User->findByKeyAndActive($this->request->data('key'), 1);
			if ($user) {
				$this->Auth->login($user['User']);
				$this->_response = array('status' => 'OK', 'url' => Router::url($this->Auth->loginRedirect));
			}
		}
		$this->set('_response', $this->_response);
		$this->set('_serialize', '_response');
	}

	public function logout() {
		return $this->redirect($this->Auth->logout());
	}

	public function index() {
		$this->redirect(array('action' => 'profile'));
	}

	public function profile() {
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data('User.id', $this->currUser['id']);
			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('Record has been successfully saved'));
				$this->_refreshUser(true);
				return $this->redirect(array('action' => 'profile'));
			}
		} else {
			$this->request->data('User', $this->currUser);
		}
	}

	protected function _index($model) {
		foreach($this->paginate['fields'] as &$field) {
			$field = str_replace('$lang', Configure::read('Config.language'), $field);
		}
		$this->set('objectType', $model);
		return $this->PCTableGrid->paginate($model);
	}

	public function songpacks() {
		if ($items = $this->request->query('items')) {
			$this->Flash->success(__('%s item(s) have been added to cart', $items));
			$this->redirect(array('action' => 'songpacks'));
			return;
		}

		$this->paginate = array(
			'fields' => array('title_$lang'),
			'order' => array('sorting' => 'desc'),
			'conditions' => array('published' => 1),
			'limit' => 20
		);
		$rowset = $this->_index('SongPack');
		$ids = Hash::extract($rowset, '{n}.SongPack.id');

		$conditions = array('media_type' => 'raw_file', 'object_type' => 'SongPack', 'object_id' => $ids);
		$aMedia = $this->Media->find('all', compact('conditions'));
		$aMedia = Hash::combine($aMedia, '{n}.Media.object_id', '{n}');

		$aStatus = $this->SongPack->getStatus($ids);
		$this->set(compact('rowset', 'aMedia', 'aStatus'));
	}

	public function songs() {
		if ($items = $this->request->query('items')) {
			$this->Flash->success(__('%s item(s) have been added to cart', $items));
			$this->redirect(array('action' => 'songs'));
			return;
		}

		$this->paginate = array(
			'fields' => array('artist', 'song', 'format', 'back_vocals', 'video_clip'),
			'order' => array('artist'),
			'conditions' => array('published' => 1),
			'limit' => 20
		);

		if ($artist = $this->request->query('artist')) {
			$this->paginate['conditions']['artist'] = $artist;
		}
		if ($song = $this->request->query('song')) {
			$this->paginate['conditions']['song'] = $song;
		}
		if ($format = $this->request->query('format')) {
			$this->paginate['conditions']['format'] = $format;
		}
		if ($back_vocals = $this->request->query('back_vocals')) {
			$this->paginate['conditions']['back_vocals'] = $back_vocals;
		}
		if ($video_clip = $this->request->query('video_clip')) {
			$this->paginate['conditions']['video_clip'] = $video_clip;
		}

		$this->_index('Song');

		$this->set('aFormatOptions', $this->Song->getFormatOptions());
	}

	public function customorder() {
		$this->set('aServices', $this->Service->getOptions());
	}

	public function cart() {
		$aServices = $this->Service->find('all', array('order' => 'sorting'));
		$aServices = Hash::combine($aServices, '{n}.Service.id', '{n}.Service');

		if ($this->request->is(array('put', 'post'))) {
			if ($this->Order->saveCart($this->request->data, $this->currUser, $this->cart)) {
				setcookie('cart', '', null, '/');
				$this->_refreshUser(true);
				$this->Flash->success(__('Thank you! Your order has been accepted'));
				$this->redirect(array('action' => 'viewOrder', $this->Order->id));
				return;
			} else {
				$this->Flash->error($this->Order->validationErrors['Order']['error']);
			}
		}
		$songs = (isset($this->cart['songs'])) ? $this->Song->findAllById($this->cart['songs']) : array();
		$packs = (isset($this->cart['packs'])) ? $this->SongPack->findAllById($this->cart['packs']) : array();
		if ($packs) {
			$ids = Hash::extract($packs, '{n}.SongPack.id');
			$conditions = array('media_type' => 'raw_file', 'object_type' => 'SongPack', 'object_id' => $ids);
			$aMedia = $this->Media->find('all', compact('conditions'));
			$aMedia = Hash::combine($aMedia, '{n}.Media.object_id', '{n}');
		} else {
			$aMedia = array();
		}

		$customOrders = (isset($this->cart['custom'])) ? $this->cart['custom'] : array();
		$this->set(compact('songs', 'packs', 'customOrders', 'aMedia', 'aServices'));
	}

	public function orders() {
		$this->paginate = array(
			'fields' => array('id', 'created', 'total_$lang', 'status'),
			'conditions' => array('user_id' => $this->currUser['id']),
			'order' => array('created' => 'DESC')
		);
		$rowset = $this->_index('Order');
		$ids = Hash::extract($rowset, '{n}.Order.id');

		$orders = $this->Order->getOrder($ids);
		$this->set('orders', $orders);
	}

	public function viewOrder($id) {
		$order = $this->Order->getOrder($id);
		$this->set('orderData', $order);

		$aServices = $this->Service->getOptions(true);
		$this->set('aServices', $aServices);
	}

	public function upgrade() {
	}

	public function recharge() {
		if ($this->request->is(array('put', 'post'))) {
			$hash = md5($this->currUser['id'].time().Configure::read('Security.salt'));
			$data = array(
				'user_id' => $this->currUser['id'],
				'oper_type' => Payment::OPER_INCOME,
				'status' => Payment::ST_CREATED,
				'hash' => $hash,
				'sum' => $this->request->data('Payment.sum')
			);
			$this->Payment->save($data);
			$this->redirect(array('action' => 'payment', $this->Payment->id));
			return;
		}

		$this->_refreshUser(true);
	}

	public function payment($id) {
		$this->layout = false;

		$oper = $this->Payment->findById($id);
		if (!$oper) {
			$this->Flash->success(__('Incorrect payment data'));
			$this->redirect(array('action' => 'recharge'));
			return;
		}
		$crc = $this->Payment->hash($oper['Payment']);
		$this->set(compact('oper', 'crc'));
	}

}
