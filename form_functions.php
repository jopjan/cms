<?php
function check_required_fields($required_array) {
    $field_errors = array();
    foreach($required_array as $fieldname){
        if(!isset($_POST[$fieldname]) || (empty($_POST[$fieldname]) && $_POST[$fieldname] !=0)){
            $field_errors[] = $fieldname;
        }
    }
    return $field_errors;
}

function check_max_fields_lengths($field_length_array) {
    $field_errors = array();
    foreach($fields_with_array as $fieldname => $maxlength) {
            if(strlen(trim(mysql_prep($_POST[$fieldname]))) > $maxlength) {
                $field_errors[] = $fieldname;
            }
        }
        
        return $field_errors;
}

function display_errors($error_array){
            echo "<p class=\"errors\">";
            echo "Please review the following fields: <br />";
            foreach($errors as $error){
                echo " - " . $error . "<br />";
            }
            echo "</p>";
}
?>
