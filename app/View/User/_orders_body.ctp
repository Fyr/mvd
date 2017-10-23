<?
    $id = $row['Order']['id'];
    if ($orders['OrderSongs'] && isset($orders['OrderSongs'][$id])) {
?>
<b><?=__('Songs')?></b><br />
<?
        foreach($orders['OrderSongs'][$id] as $_order) {
            $_id = $_order['OrderSong']['song_id'];
            $_song = $orders['Songs'][$_id];
            echo $_song['artist'].' - '.$_song['song'].'<br />';
        }
        echo '<br />';
    }
    if ($orders['OrderPacks'] && isset($orders['OrderPacks'][$id])) {
?>
<b><?=__('Song packs')?></b><br />
<?
        foreach($orders['OrderPacks'][$id] as $_order) {
            $_id = $_order['OrderPack']['pack_id'];
            $_pack = $orders['Packs'][$_id];
            echo $_pack['title_'.$lang].'<br />';
        }
        echo '<br />';
    }
    if ($orders['OrderCustoms'] && isset($orders['OrderCustoms'][$id])) {
?>
<b><?=__('Custom song order')?></b><br />
<?
        foreach($orders['OrderCustoms'][$id] as $_order) {
            $_custom = $_order['OrderCustom'];
            echo $_custom['artist'].' - '.$_custom['song'].'<br />';
        }
        echo '<br />';
    }
?>