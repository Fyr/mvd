<!DOCTYPE html>
<html lang="en" class="fsvs">
<head>
	<?=$this->Html->charset()?>
	<title><?=Configure::read('domain.title')?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1.0, minimum-scale=1.0">
<?
	echo $this->Html->css(array(
		'bootstrap.min',
		'jquery.formstyler',
		'style.css',
		'extra'
	));

	echo $this->Html->meta('icon');
	echo $this->fetch('meta');
	echo $this->fetch('css');

	echo $this->Html->script(array(
		'vendor/jquery.1.11.0.min',
		'vendor/bootstrap.min',
		'vendor/bundle',
		'vendor/tagcloud.jquery',
		'vendor/jquery.dotdotdot',
		'vendor/jquery.cookie',
		'tagcloud',
		'rego_custom',
		'lang',
		'vendor/jquery.formstyler.min',
		'/Core/js/json_handler'
	));
?>
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
<?=$this->element('SiteUI/navbar')?>
<div id="fsvs-body">
	<?=$this->fetch('content')?>
</div>
<a class="scroller" href="#slide-1"></a>
<?
	echo $this->element('SiteUI/login');
	echo $this->element('SiteUI/thanks');
?>
</body>
</html>
