<?php
App::uses('AppModel', 'Model');
App::uses('Category', 'Model');
App::uses('Media', 'Media.Model');
class Product extends AppModel {

    public $belongsTo = array(
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'parent_id',
            'dependent' => false
        )
    );

    public $hasOne = array(
        'Media' => array(
            'className' => 'Media.Media',
            'foreignKey' => 'object_id',
            'conditions' => array('Media.media_type' => 'image', 'Media.object_type' => 'Product', 'Media.main' => 1),
            'dependent' => false
        )
    );

}
