<div id="slide-tagcloud" class="slide">
    <div class="container">
        <h2><?=$blocks['tagcloud']['title_'.$lang]?></h2>
        <div id="tagcloud">
            <ul>
<?
    $block['teaser'] = $this->ArticleVars->list2Array($block['teaser_'.$lang]);
    foreach($block['teaser'] as $title) {
?>
                <li><a href="javascript:;"><?=$title?></a></li>
<?
    }
?>
            </ul>
        </div>
    </div>
</div>