<?php
App::uses('AppModel', 'Model');
class Payment extends AppModel {

    const OPER_INCOME = 1;
    const OPER_OUTCOME = 2;

    const ST_CREATED = 1;
    const ST_PENDING = 2;
    const ST_FAIL = 3;
    const ST_SUCCESS = 4;

    public function getOperOptions() {
        return array(
            self::OPER_INCOME => __('Balance recharge'),
            self::OPER_OUTCOME => __('Withdraw balance')
        );
    }

    public function getStatusOptions() {
        return array(
            self::ST_CREATED => __('Created'),
            self::ST_PENDING => __('Pending'),
            self::ST_FAIL => __('Failed'),
            self::ST_SUCCESS => __('Success'),
        );
    }

    public function hash($oper) {
        $aData = array(
            Configure::read('robokassa.merchant'),
            $oper['sum'],
            $oper['id'],
            Configure::read('robokassa.password'),
            'Shp_hash='.$oper['hash']
        );
        return md5(implode(':', $aData));
    }

    public function hash2($oper) {
        $aData = array(
            $oper['sum'],
            $oper['id'],
            Configure::read('robokassa.password2'),
            'Shp_hash='.$oper['hash']
        );
        return strtoupper(md5(implode(':', $aData)));
    }

    public function writeLog($actionType, $data = ''){
        $data = (is_array($data)) ? serialize($data) : $data;
        $string = date('d.m.Y H:i:s').' '.$actionType.' '.$data;
        file_put_contents(Configure::read('robokassa.log'), $string."\r\n", FILE_APPEND);
    }
}
