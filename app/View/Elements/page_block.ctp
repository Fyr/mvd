<?
    $text = '<td class="text">'.$text.'</td>';
    $img = ($src) ? '<td>'.$this->Html->image($src, array('class' => 'img-responsive', 'alt' => $title)).'</td>': '';
    $html = ($class) ? $img.$text : $text.$img;
?>
<div class="<?=($class) ? 'grey' : ''?> section">
    <div class="container">
<?
    if (isset($mainTitle) && $mainTitle) {
?>
        <div class="title"><?=$mainTitle?></div>
<?
    }
?>
        <h2 class="light"><?=$title?></h2>
        <table class="sectionContent">
            <tr>
                <?=$html?>
            </tr>
        </table>
    </div>
</div>