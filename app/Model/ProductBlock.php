<?php
App::uses('AppModel', 'Model');
App::uses('Article', 'Article.Model');
class ProductBlock extends Article {
    protected $objectType = 'ProductBlock';

    public $hasOne = array(
        'Media' => array(
            'className' => 'Media.Media',
            'foreignKey' => 'object_id',
            'conditions' => array('Media.media_type' => 'image', 'Media.object_type' => 'ProductBlock', 'Media.main' => 1),
            'dependent' => false
        )
    );
}
