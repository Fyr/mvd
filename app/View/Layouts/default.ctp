<!DOCTYPE html>
<html lang="en">
<head>
	<?=$this->Html->charset()?>
	<title><?=Configure::read('domain.title')?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

<?
	echo $this->Html->css(array(
		'bootstrap-grid-3.3.1',
		'iconfont',
		'owl-carousel/owl.carousel',
		'owl-carousel/owl.theme',
		'owl-carousel/owl.transitions',
		'stacktable',
		'style',
		'extra'
	));

	echo $this->Html->meta('icon');
	echo $this->fetch('meta');
	echo $this->fetch('css');

	echo $this->Html->script(array(
		'vendor/html5shiv',
		'vendor/respond.min',
		'vendor/jquery.1.11.0.min',
		'vendor/jquery.cookie',
		'vendor/owl.carousel.min',
		'vendor/jquery.dotdotdot.min',
		'vendor/jquery.sticky',
		'vendor/stacktable',
		'custom',
		'lang',
		// '/Core/js/json_handler'
	));
	echo $this->fetch('script');
?>
</head>
<body>
	<div class="header">
		<div class="container top">
			<div class="row">
				<div class="col-lg-3 col-sm-3 logo">
					<a href="/"><?=__('MUSEUM<span>of the Ministry of Internal Affairs</span><span>of the Republic of Belarus</span>')?></a>
				</div>
				<div class="col-md-3 col-sm-5 address">
					<?=Configure::read('Settings.address')?>
					<div><?=Configure::read('Settings.phone')?></div>
				</div>
				<div class="col-md-2 col-sm-4 col-lg-offset-5 col-md-offset-4 languages">
<?
	foreach($aLangs as $_lang => $title) {
		$class = ($lang == $_lang) ? 'active' : '';
?>
					<a href="javascript:;" class="<?=$class?>" onclick="setLang('<?=$_lang?>')"><?=$title?></a>
<?
	}
?>
					<div class="mvd">
						<div class="png2x png2x-mvd"></div>
						<div class="text"><?=Configure::read('Settings.title')?></div>
					</div>
				</div>
			</div>
		</div>
		<div class="topMenu">
			<div class="container">
				<div class="row">
					<div class="col-md-9">
						<?=$this->element('main_menu')?>
					</div>
					<div class="col-md-3 mvd">
						<div class="mobileBtn">
							<span><?=__('Menu')?></span>
							<div></div>
							<div></div>
							<div></div>
						</div>
						<div class="png2x png2x-mvd"></div>
						<div class="text"><?=__('Ministry of Internal Affairs of the Republic of Belarus')?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?=$this->fetch('content')?>
	<div class="footer">
		<div class="container">
			<div class="png2x png2x-footer"></div>
			<div class="row top">
				<div class="col-md-3 col-sm-3 logo">
					<a href="/"><?=__('MUSEUM<span>of the Ministry of Internal Affairs</span><span>of the Republic of Belarus</span>')?></a>
				</div>
				<div class="col-md-2 col-sm-2 col-xs-6 firstColomn">
					<?=$this->element('main_menu', array('class' => 'menu'))?>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 secondColomn">
					<!-- ul class="menu"></ul-->
				</div>
				<div class="col-md-2 col-md-offset-3 col-sm-3 languages">
<?
	foreach($aLangs as $_lang => $title) {
		$class = ($lang == $_lang) ? 'active' : '';
?>
					<a href="javascript:;" class="<?=$class?>" onclick="setLang('<?=$_lang?>')"><?=$title?></a>
<?
	}
?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 address">
					<?=Configure::read('Settings.address')?>
					<div><?=Configure::read('Settings.phone')?></div>
				</div>
			</div>
			<div class="row bottom">
				<div class="col-lg-3 col-md-3 copyright">
					©2017 <?=Configure::read('Settings.title')?>
				</div>
				<div class="col-lg-2 col-md-3 col-lg-offset-2 col-md-offset-1 links">
					<a href="http://mvd.gov.by" target="_blank">mvd.gov.by</a>
				</div>
			</div>
		</div>
	</div>
<?
	// echo $this->element('sql_dump');
?>
</body>
</html>
