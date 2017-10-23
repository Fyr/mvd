<?php
App::uses('AppModel', 'Model');
App::uses('OrderSong', 'Model');
App::uses('OrderPack', 'Model');
App::uses('OrderCustom', 'Model');
App::uses('Song', 'Model');
App::uses('SongPack', 'Model');
App::uses('Service', 'Model');
App::uses('User', 'Model');
class Order extends AppModel {

    public function saveCart($data, $currUser, $cart) {
        $aServices = $this->loadModel('Service')->find('all', array('order' => 'sorting'));
        $aServices = Hash::combine($aServices, '{n}.Service.id', '{n}.Service');

        $songs = Hash::get($data, 'songs');
        $packs = Hash::get($data, 'packs');
        $custom = Hash::get($data, 'customOrders');

        if ($songs || $packs || $custom) {
            try {
                $this->trxBegin();

                $this->save(array('user_id' => $currUser['id']));
                if ($songs) {
                    $data = array();
                    $total_rus = 0;
                    $total_eng = 0;
                    foreach ($songs as $id) {
                        $data[] = array(
                            'order_id' => $this->id,
                            'song_id' => $id,
                            'price_rus' => floatval(Configure::read('Settings.song_price_rus')),
                            'price_eng' => floatval(Configure::read('Settings.song_price_eng'))
                        );
                        $total_rus += floatval(Configure::read('Settings.song_price_rus'));
                        $total_eng += floatval(Configure::read('Settings.song_price_eng'));
                    }
                    $this->loadModel('OrderSong')->saveAll($data);
                }
                if ($packs) {
                    $data = array();
                    foreach ($packs as $id) {
                        $data[] = array(
                            'order_id' => $this->id,
                            'pack_id' => $id,
                            'price_rus' => floatval(Configure::read('Settings.pack_price_rus')),
                            'price_eng' => floatval(Configure::read('Settings.pack_price_eng'))
                        );
                        $total_rus += floatval(Configure::read('Settings.pack_price_rus'));
                        $total_eng += floatval(Configure::read('Settings.pack_price_eng'));
                    }
                    $this->loadModel('OrderPack')->saveAll($data);
                }
                if ($custom) {
                    $this->OrderCustom = $this->loadModel('OrderCustom');
                    foreach ($custom as $id) {
                        $order = $cart['custom'][$id];
                        $order['order_id'] = $this->id;
                        $data = array('OrderCustom' => $order, 'OrderService' => array());
                        foreach ($order['services'] as $_id) {
                            $data['OrderService'][] = array(
                                'service_id' => $_id,
                                'price_rus' => floatval($aServices[$_id]['price_rus']),
                                'price_eng' => floatval($aServices[$_id]['price_eng']),
                            );
                            $total_rus += floatval($aServices[$_id]['price_rus']);
                            $total_eng += floatval($aServices[$_id]['price_eng']);
                        }
                        $this->OrderCustom->clear();
                        $this->OrderCustom->saveAll($data);
                    }
                }

                // Проверить баланс юзера
                // Проверяем тут + транзакция, чтобы
                // 1. не дублировать код на подсчет общей суммы
                // 2. записи создаются и можно читать с них данные (код проще и можно вызвать метод getOrder)
                // 3. при откате транзакции, записей не станет
                // TODO: продумать как обрабатывать USD
                $balance = floatval($currUser['balance']);
                if ($balance < $total_rus) {
                    throw new Exception(__('Not enough money to pay for! Please, recharge your balance by %s', $total_rus - $balance));
                }

                $this->save(compact('total_rus', 'total_eng'));

                $this->loadModel('User')->save(array('id' => $currUser['id'], 'balance' => $balance - $total_rus));

                $xdata = $this->getOrder($this->id);
                $this->loadModel('Payment')->save(array(
                    'user_id' => $currUser['id'],
                    'oper_type' => Payment::OPER_OUTCOME,
                    'status' => Payment::ST_SUCCESS,
                    'sum' => $total_rus,
                    'comment' => __('Order N %s', $this->id),
                    'xdata' => serialize($xdata) // Все данные по заказу
                ));

                $this->trxCommit();
            } catch (Exception $e) {
                $this->trxRollback();
                $this->validationErrors = array(
                    'Order' => array(
                        'error' => $e->getMessage() // вешаем ошибку на несущ-е поле
                    )
                );
                return false;
            }
        }

        return true;
    }

    public function getOrder($ids) {
        $order['Order'] = $this->findAllById($ids);
        if ($order['Order'] && !is_array($ids)) {
            $order['Order'] = $order['Order'][0]['Order'];
        }

        $this->OrderSong = $this->loadModel('OrderSong');
        $order['OrderSongs'] = $this->OrderSong->findAllByOrderId($ids);
        $order['Songs'] = array();
        if ($order['OrderSongs']) {
            $order['OrderSongs'] = (is_array($ids)) ? Hash::combine($order['OrderSongs'], '{n}.OrderSong.id', '{n}', '{n}.OrderSong.order_id') : $order['OrderSongs'];
            $this->Song = $this->loadModel('Song');
            $order['Songs'] = $this->Song->findAllById(Hash::extract($order['OrderSongs'], (is_array($ids)) ? '{n}.{n}.OrderSong.song_id' : '{n}.OrderSong.song_id'));
            $order['Songs'] = Hash::combine($order['Songs'], '{n}.Song.id', '{n}.Song');
        }

        $this->OrderPack = $this->loadModel('OrderPack');
        $order['OrderPacks'] = $this->OrderPack->findAllByOrderId($ids);
        $order['Packs'] = array();
        if ($order['OrderPacks']) {
            $order['OrderPacks'] = (is_array($ids)) ? Hash::combine($order['OrderPacks'], '{n}.OrderPack.id', '{n}', '{n}.OrderPack.order_id') : $order['OrderPacks'];
            $this->SongPack = $this->loadModel('SongPack');
            $order['Packs'] = $this->SongPack->findAllById(Hash::extract($order['OrderPacks'], (is_array($ids)) ? '{n}.{n}.OrderPack.pack_id' : '{n}.OrderPack.pack_id'));
            $order['Packs'] = Hash::combine($order['Packs'], '{n}.SongPack.id', '{n}.SongPack');
        }

        $this->OrderCustom = $this->loadModel('OrderCustom');
        $order['OrderCustoms'] = $this->OrderCustom->findAllByOrderId($ids);
        if ($order['OrderCustoms']) {
            $order['OrderCustoms'] = (is_array($ids)) ? Hash::combine($order['OrderCustoms'], '{n}.OrderCustom.id', '{n}', '{n}.OrderCustom.order_id') : $order['OrderCustoms'];
        }

        return $order;
    }
}
