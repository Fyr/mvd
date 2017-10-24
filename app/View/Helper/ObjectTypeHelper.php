<?php
App::uses('AppHelper', 'View/Helper');
class ObjectTypeHelper extends AppHelper {
    public $helpers = array('Html');
    
    private function _getTitles() {
        $aTitles = array(
            'index' => array(
                'Article' => __('Articles'),
                'Page' => __('Static pages'),
                'News' => __('News'),
                'Category' => __('Categories'),
                'Subcategory' => __('Subcategories'),
                'Product' => __('Products'),
                'User' => __('User profiles'),
            ),
            'create' => array(
                'Article' => __('Create article'),
                'Page' => __('Create static page'),
                'News' => __('Create news article'),
                'Category' => __('Create category'),
                'Subcategory' => __('Create subcategory'),
                'Product' => __('Create product'),
                'User' => __('Create user'),
            ),
            'edit' => array(
                'Article' => __('Edit article'),
                'Page' => __('Edit static page'),
                'News' => __('Edit news article'),
                'Category' => __('Edit category'),
                'Subcategory' => __('Edit subcategory'),
                'Product' => __('Edit product'),
                'User' => __('Edit user'),
            ),
            'view' => array(
            	'Article' => __('View article'),
            	'News' => __('View news article'),
            	'Product' => __('View product'),
            )
        );
        return $aTitles;
    }
    
    public function getTitle($action, $objectType) {
        $aTitles = $this->_getTitles();
        return (isset($aTitles[$action][$objectType])) ? $aTitles[$action][$objectType] : $aTitles[$action]['Article'];
    }
    
    public function getBaseURL($objectType, $objectID = '') {
        return $this->Html->url(array('action' => 'index', $objectType, $objectID));
    }
}