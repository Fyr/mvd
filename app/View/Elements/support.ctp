<div class="section serviceMaintenance <?=isset($class) ? $class: ''?>">
    <div class="container">
        <h2 class="light"><?=$title?></h2>
        <div class="row">
<?
    foreach($blocks as $block) {
        $this->ArticleVars->init($block, $url, $title, $teaser, $src, 'noresize');
?>
        <div class="col-sm-<?=ceil(12 / count($blocks))?>">
<?
        if ($src) {
?>
            <img src="<?=$src?>" alt="<?=$title?>" />
<?
        }
?>


            <div class="title"><?=$title?></div>
            <div class="description"><?=$this->ArticleVars->body($block)?></div>
        </div>

<?
    }
?>
        </div>
    </div>
</div>