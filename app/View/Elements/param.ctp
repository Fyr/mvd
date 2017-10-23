<div class="technicalItem">
    <div class="name"><?=$field['PMFormField']['label_'.$lang]?></div>
<?
    if ($field['PMFormField']['field_type'] == FieldTypes::TEXTAREA) {
        $value = nl2br($value);
    } elseif ($field['PMFormField']['field_type'] == FieldTypes::CHECKBOX) {
        $value = ($value) ? 'есть' : '-';
    }
    echo $value;
?>
</div>