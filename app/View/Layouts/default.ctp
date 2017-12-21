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
		// 'lang',
		// '/Core/js/json_handler'
	));
	echo $this->fetch('script');
?>
</head>
<body>
	<div class="header">
		<div class="container top">
			<div class="row">
				<div class="col-lg-2 col-sm-3 logo">
					<a href="#">МУЗЕЙ МВД <span>Республики Беларусь</span></a>
				</div>
				<div class="col-md-3 col-sm-5 address">
					Минск, ул. Городской Вал, 7
					<div>+375 17 218-55-38</div>
				</div>
				<div class="col-md-2 col-sm-4 col-lg-offset-5 col-md-offset-4 languages">
					<!--a href="#">en</a>
					<a href="#" class="active">ru</a>
					<a href="#">by</a-->
					<div class="mvd">
						<div class="png2x png2x-mvd"></div>
						<div class="text">Министерство внутренних дел Республики Беларусь</div>
					</div>
				</div>
			</div>
		</div>
		<div class="topMenu">
			<div class="container">
				<div class="row">
					<div class="col-md-9">
						<ul class="mainMenu">
							<li class="active"><a href="javascript: void(0)">Главная</a></li>
							<li><a href="javascript: void(0)">О музее</a></li>
							<li><a href="javascript: void(0)">События</a></li>
							<li><a href="javascript: void(0)">Коллекции</a></li>
							<li><a href="javascript: void(0)">История милиции</a></li>
							<li><a href="javascript: void(0)">Посетителям</a></li>
						</ul>
					</div>
					<div class="col-md-3 mvd">
						<div class="mobileBtn">
							<span>Меню</span>
							<div></div>
							<div></div>
							<div></div>
						</div>
						<div class="png2x png2x-mvd"></div>
						<div class="text">Министерство внутренних дел Республики Беларусь</div>
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
				<div class="col-md-2 col-sm-3 logo">
					<a href="#">МУЗЕЙ МВД <span>Республики Беларусь</span></a>
				</div>
				<div class="col-md-2  col-md-offset-1 col-sm-2 col-xs-6 firstColomn">
					<ul class="menu">
						<li class="active"><a href="javascript: void(0)">Главная</a></li>
						<li><a href="javascript: void(0)">О музее</a></li>
						<li><a href="javascript: void(0)">События</a></li>
						<li><a href="javascript: void(0)">Коллекции</a></li>
						<li><a href="javascript: void(0)">История милиции</a></li>
						<li><a href="javascript: void(0)">Посетителям</a></li>
					</ul>
				</div>
				<div class="col-md-2 col-sm-3 col-xs-6 secondColomn">
					<ul class="menu">
						<li class="active"><a href="javascript: void(0)">Главная</a></li>
						<li><a href="javascript: void(0)">О музее</a></li>
						<li><a href="javascript: void(0)">События</a></li>
						<li><a href="javascript: void(0)">Коллекции</a></li>
						<li><a href="javascript: void(0)">История милиции</a></li>
						<li><a href="javascript: void(0)">Посетителям</a></li>
					</ul>
				</div>
				<div class="col-md-2 col-md-offset-3 col-sm-3 languages">
					<!-- a href="#">en</a>
					<a href="#" class="active">ru</a>
					<a href="#">by</a-->
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 address">
					Минск, ул. Городской Вал, 7
					<div>+375 17 218-55-38</div>
				</div>
			</div>
			<div class="row bottom">
				<div class="col-lg-3 col-md-3 copyright">
					©2017 Музей Министерства внутренних дел Республики Беларусь
				</div>
				<div class="col-lg-2 col-md-3 col-lg-offset-2 col-md-offset-1 links">
					<a href="#">mvd.gov.by</a>
				</div>
			</div>
		</div>
	</div>
<?
	// echo $this->element('sql_dump');
?>
</body>
</html>
