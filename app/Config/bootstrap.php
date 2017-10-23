<?php
Cache::config('default', array('engine' => 'File'));

CakePlugin::loadAll();
//CakePlugin::load('DebugKit');

Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher'
));

App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
	'engine' => 'File',
	'types' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));
CakeLog::config('error', array(
	'engine' => 'File',
	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));
Configure::write('Exception.renderer', 'AppExceptionRenderer');
// Configure::write('Config.language', 'rus');

/* -= Custom settings =- */
Configure::write('domain', array(
	'url' => $_SERVER['SERVER_NAME'],
	'title' => 'MuseiMVD.dev'
));
Configure::write('media', array(
	'path' => $_SERVER['DOCUMENT_ROOT'].'/files/'
));

function fdebug($data, $logFile = 'tmp.log', $lAppend = true) {
	file_put_contents($logFile, mb_convert_encoding(print_r($data, true), 'cp1251', 'utf8'), ($lAppend) ? FILE_APPEND : null);
}

function assertTrue($msg, $result, $file = '') {
	if ($result) {
		$msg = $msg.' - OK%s';
	} else {
		$result = var_export($result, true);
		$msg = "{$msg} - ERROR!%sResult: `{$result}`%sMust be: `{$sample}`%s";
	}
	if ($file) {
		fdebug(sprintf($msg, "\r\n"), $file);
	} else {
		echo sprintf($msg, '<br />');
	}
}

function assertEqual($msg, $sample, $result, $file = '') {
	if ($sample === $result) {
		$msg = $msg.' - OK%s';
	} else {
		$result = var_export($result, true);
		$sample = var_export($sample, true);
		$msg = "{$msg} - ERROR!%sResult: `{$result}`%sMust be: `{$sample}`%s";
	}

	if ($file) {
		fdebug(str_replace('%s', " \r\n", $msg), $file);
	} else {
		echo sprintf(str_replace('%s', '<br />', $msg));
	}
}