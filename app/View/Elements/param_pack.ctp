<tr>
    <td><?=$field['PMFormField']['label_'.$lang]?></td>
<?
    foreach($values as $value) {
        if ($field['PMFormField']['field_type'] == FieldTypes::TEXTAREA) {
            $value = nl2br($value);
        } elseif ($field['PMFormField']['field_type'] == FieldTypes::CHECKBOX) {
            $value = ($value) ? '<span class="icon-check"></span>' : '<span class="icon-close"></span>';
        }
?>
    <td><?=$value?></td>
<?
    }
?>
</tr>