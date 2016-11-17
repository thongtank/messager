<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config/autoload.inc.php';

use classes as cls;
use config as cfg;

$db = new cfg\database;
$ht = new cls\hospitals;

$medicines = $ht->get_medicine();

// print "<p>" . $_POST['rt'] . "</p>";
$medicine_option = "";
for ($i = 1; $i <= $_POST['s']; $i++) {
    $medicine_option .= "<select name='medicine_" . $i . "' id='medicine_" . $i . "' class='form-control sub-medicine' style='margin-bottom:5px;'>";
    foreach ($medicines as $key => $value) {
        $name = "";
        if ($value['medicine_name_th'] != "-") {
            $name = $value['medicine_name_th'];
        } else {
            $name = $value['medicine_name_end'];
        }
        $medicine_option .= "<option value='" . $value['medicine_id'] . "'>" . $name . "</option>";
    }
    $medicine_option .= "</select>";
}

echo $medicine_option;