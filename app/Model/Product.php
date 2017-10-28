<?php
App::uses('AppModel', 'Model');
App::uses('Category', 'Model');
App::uses('Media', 'Media.Model');
class Product extends AppModel {

    public $belongsTo = array(
        'ProductCategory' => array(
            'className' => 'Category',
            'foreignKey' => 'cat_id',
            'dependent' => false
        ),
        'ProductSubcategory' => array(
            'className' => 'Subcategory',
            'foreignKey' => 'subcat_id',
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
