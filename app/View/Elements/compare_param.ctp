<td class="center">
<?
    if ($field['PMFormField']['field_type'] == FieldTypes::TEXTAREA) {
        $value = nl2br($value);
    } elseif ($field['PMFormField']['field_type'] == FieldTypes::CHECKBOX) {
        $class = ($value) ? 'icon-check' : 'icon-close';
        $value = '<span class="'.$class.'"></span>';
    }
    echo $value;
?>
</td>