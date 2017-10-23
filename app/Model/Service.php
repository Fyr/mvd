<?php
App::uses('AppModel', 'Model');
class Service extends AppModel {

    public function getOptions($lAll = false) {
        $fields = array('id', 'title_'.$this->getLang());
        if (!$lAll) {
            $conditions = array('published' => 1);
        }
        $order = array('sorting');
        return $this->find('list', compact('fields', 'conditions', 'order'));
    }
}
