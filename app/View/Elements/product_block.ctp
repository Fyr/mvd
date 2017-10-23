<?
    $text = '<td class="text">'.$text.'</td>';
    $img = ($src) ? '<td>'.$this->Html->image($src, array('class' => 'img-responsive', 'alt' => $title)).'</td>': '';
    $html = ($class) ? $text.$img : $img.$text;
?>
<div class="<?=($class) ? 'grey' : ''?> section">
    <div class="container">
        <h2 class="light"><?=$title?></h2>
        <table class="sectionContent">
            <tr>
                <?=$html?>
            </tr>
        </table>
    </div>
</div>