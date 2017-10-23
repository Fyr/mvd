<?php
App::uses('AppModel', 'Model');
App::uses('Article', 'Article.Model');
class PageBlock extends Article {
    protected $objectType = 'PageBlock';

    public $hasOne = array(
        'Media' => array(
            'className' => 'Media.Media',
            'foreignKey' => 'object_id',
            'conditions' => array('Media.media_type' => 'image', 'Media.object_type' => 'PageBlock', 'Media.main' => 1),
            'dependent' => false
        )
    );
}
