<?php
Router::parseExtensions('json', 'xml');

Router::connect('/', array('controller' => 'pages', 'action' => 'home'));

Router::connect('/news', array(
	'controller' => 'news',
	'action' => 'index',
),
	array('named' => array('page' => 1))
);
/*
Router::connect('/news/:slug',
	array(
		'controller' => 'News',
		'action' => 'view',
	),
	array('pass' => array('slug'))
);
*/
Router::connect('/news/page/:page', array(
	'controller' => 'news',
	'action' => 'index',
),
	array('named' => array('page' => '[\d]*'))
);

	CakePlugin::routes();
	require CAKE . 'Config' . DS . 'routes.php';
