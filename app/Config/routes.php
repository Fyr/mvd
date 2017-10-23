<?php
	Router::parseExtensions('json', 'xml');

	Router::connect('/', array('controller' => 'Admin', 'action' => 'index'));

	CakePlugin::routes();
	require CAKE . 'Config' . DS . 'routes.php';
