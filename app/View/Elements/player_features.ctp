<div class="otherCapabilities <?=$class?>">
    <div class="container">
        <h2 class="light"><?=$title?></h2>
        <ul>
<?
    foreach($features as $title) {
?>
            <li>
                <span class="circleCheck"><span class="icon-check"></span></span>
                <div><?=$title?></div>
            </li>

<?
    }
?>

        </ul>
    </div>
</div>