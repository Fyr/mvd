<ul class="<?=(isset($class)) ? $class : 'mainMenu'?>">
<?
    foreach($aNavBar as $curr => $item) {
        $active = ($curr == $currMenu) ? 'class="active"' : '';
?>
    <li <?=$active?>><?=$this->Html->link($item['title'], $item['url'])?></li>
<?
    }
?>
</ul>