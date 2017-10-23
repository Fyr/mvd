<?php
App::uses('AppController', 'Controller');
App::uses('Faq', 'Model');
App::uses('Page', 'Model');
App::uses('Contact', 'Model');
App::uses('PHForm', 'Form.View/Helper');
App::uses('CakeEmail', 'Network/Email');
class FaqController extends AppController {
	public $name = 'Faq';

	public $uses = array('Faq', 'Page', 'Contact');
	public $helpers = array('Form.PHForm');

	public function index() {
		$conditions = array('published' => 1);
		$order = 'sorting';
		$this->set('aArticles', $this->Faq->find('all', compact('conditions', 'order')));
		$this->set('faq', $this->Page->findBySlug('faq'));

		if ($this->request->is(array('post', 'put'))) {
			$this->Contact->set($this->request->data('Contact'));
			if ($this->Contact->validates()) { //
				Configure::write('Config.language', 'rus');
				$email = new CakeEmail();
				$email->template('contact_message')->viewVars(compact('aRowset', 'aParams'))
					->emailFormat('html')
					->from('info@'.Configure::read('domain.url'))
					->to(Configure::read('Settings.email'))
					->bcc(Configure::read('Settings.admin_email'))
					->subject(Configure::read('domain.title').': '.__('Message from Support page'))
					->send();
				$this->redirect(array('action' => 'index', '?' => array('success' => 1)));
			}
		}
	}
}
