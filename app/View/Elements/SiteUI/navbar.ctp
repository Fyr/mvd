<nav class="navbar">
	<div class="container">
		<div class="navbar-header">
			<a class="navbar-brand" href="/">
				<img src="/img/logo.png" alt="Brand" />
			</a>
			<button aria-controls="navbar" aria-expanded="true" data-target="#navbar" data-toggle="collapse" class="navbar-toggle" type="button">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
<?
	if ($currUser) {
		echo $this->Html->link(__('User area'), array('controller' => 'user', 'action' => 'index'), array('class' => 'loginBtn'));
	} else {
?>
		<a href="javascript:;" class="loginBtn" data-toggle="modal" data-target="#myLogin"><?=__('User area')?></a>
<?
	}
?>
		<div class="dropdown language">
			<button class="btn" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><?=($lang == 'rus') ? 'RU' : 'EN'?>
				<span class="icon-arrow-down"></span>
			</button>
			<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				<li><a href="javascript:;" onclick="setLang('rus')">RU</a></li>
				<li><a href="javascript:;" onclick="setLang('eng')">EN</a></li>
			</ul>
		</div>
		<div class="navbar-collapse collapse" id="#navbar">
			<ul class="nav navbar-nav">
				<li class="dropdown active">
					<a aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" href="<?=$this->Html->url(array('controller' => 'pages', 'action' => 'karaoke_systems'))?>">
						<?=__('Karaoke systems')?> <span class="icon-arrow-down"></span>
					</a>
					<ul class="dropdown-menu">
<?
	// echo $this->Html->tag('li', $this->Html->link(__('About karaoke systems'), array('controller' => 'pages', 'action' => 'karaoke_systems')));
	foreach($aCategories as $cat_id => $category) {
		$this->ArticleVars->init($category, $url, $title);
		echo $this->Html->tag('li', $this->Html->link($title, $url));
	}
	echo $this->Html->tag('li', $this->Html->link(__('Compare systems'), array('controller' => 'categories', 'action' => 'compare')));
?>
					</ul>
				</li>
				<li class="dropdown">
					<a aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" href="javascript:;"> <?=__('Catalogs')?> <span class="icon-arrow-down"></span></a>
					<ul class="dropdown-menu">
						<li><?=$this->Html->link(__('Full catalog'), array('controller' => 'catalog', 'action' => 'full'))?></li>
						<li><?=$this->Html->link(__('Song packs'), array('controller' => 'catalog', 'action' => 'index'))?></li>
						<li><?=$this->Html->link(__('Custom order'), array('controller' => 'catalog', 'action' => 'custom'))?></li>
					</ul>
				</li>
				<li class="dropdown">
					<a aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" class="dropdown-toggle" href="javascript:;"> <?=__('Applications')?> <span class="icon-arrow-down"></span></a>
					<ul class="dropdown-menu">
						<li><?=$this->Html->link('YOUR DAY Tablet', array('controller' => 'pages', 'action' => 'tablet'))?></li>
						<li><?=$this->Html->link('YOUR DAY Player', array('controller' => 'pages', 'action' => 'player'))?></li>
					</ul>
				</li>
				<li><?=$this->Html->link(__('Support'), array('controller' => 'faq', 'action' => 'index'))?></li>
			</ul>
		</div>

	</div>
</nav>

