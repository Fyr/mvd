<?php
App::uses('AppController', 'Controller');
class RobokassaController extends AppController {
	public $name = 'Robokassa';
	public $components = array('Flash');
	public $uses = array('Payment', 'User');

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow(array('result', 'success', 'fail'));
		$this->autoRender = false;
	}

	private function _writeLog($action, $data = '') {
		$this->Payment->writeLog($action, $data);
	}

	public function result() {
		$this->_writeLog('RESPONSE RESULT', $this->request->data);

		$id = intval($this->request->data('InvId'));
		$hash = $this->request->data('Shp_hash');
		$sum = $this->request->data('OutSum');
		$crc = strtoupper($this->request->data('SignatureValue'));

		$oper = $this->Payment->findByIdAndHash($id, $hash);
		if (!($oper && Hash::get($oper, 'Payment.status') == Payment::ST_CREATED)) {
			// не обрабатываем др.статусы т.к. почему-то result может придти несколько раз
			return;
		}

		try {
			// Проверяем подпись (CRC)
			$_crc = $this->Payment->hash2(compact('sum', 'id', 'hash'));
			if ($crc !== $_crc) {
				throw new Exception(__('Incorrect CRC'));
			}

			// Проверяем сумму
			if (floatval($sum) != floatval(Hash::get($oper, 'Payment.sum'))) {
				throw new Exception(__('Incorrect sum'));
			}

			$status = Payment::ST_SUCCESS;
			$xdata = serialize(array('response' => $this->request->data));
			$this->Payment->save(compact('id', 'status', 'xdata'));

			$user = $this->User->findById($oper['Payment']['user_id']);
			$this->User->save(array('id' => $user['User']['id'], 'balance' => floatval($user['User']['balance']) + floatval($sum)));
		} catch (Exception $e) {
			$status = Payment::ST_FAIL;
			$comment = $e->getMessage();
			$xdata = serialize(array('response' => $this->request->data, 'operation' => $oper));
			$this->Payment->save(compact('id', 'status', 'comment', 'xdata'));
		}
	}

	public function success() {
		$this->_writeLog('RESPONSE SUCCESS', $this->request->data);
		$this->Flash->success(__('Thank you for your payment'));
		$this->redirect(array('controller' => 'user', 'action' => 'recharge'));
	}

	public function fail() {
		$this->_writeLog('RESPONSE FAIL', $this->request->data);
		$id = $this->request->data('InvId');
		$hash = $this->request->data('Shp_hash');
		$oper = $this->Payment->findByIdAndHash($id, $hash);
		if ($oper || $oper['Payment']['status'] == Payment::ST_CREATED) {
			$comment = __('Aborted by user');
			$status = Payment::ST_FAIL;
			$xdata = serialize(array('response' => $this->request->data));
			$this->Payment->save(compact('id', 'status', 'comment', 'xdata'));
		}

		$this->Flash->error(__('Sorry, your payment have not been completed'));
		$this->redirect(array('controller' => 'user', 'action' => 'recharge'));
	}
}
