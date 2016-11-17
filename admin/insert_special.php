<?php
session_start();
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != "logon") {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}
include '../php/config/autoload.inc.php';

use config\database as db;

$db = new db;

/*
Array
(
[hospital] => 1
[medical_1] => 2
[min-price-1] => 10000
[max-price-1] => 12000
[medical_2] =>
[min-price-2] =>
[max-price-2] =>
[medical_3] =>
[min-price-3] =>
[max-price-3] =>
[medical_4] =>
[min-price-4] =>
[max-price-4] =>
[medical_5] =>
[min-price-5] =>
[max-price-5] =>
)
 */

$hospital = trim($_POST["hospital"]);
$medical_array = array();
// วนลูปเพื่อจัดเก็บความชำนาญการพิเศษกรณีมีมากกว่า 1 ความสามารถพิเศษ แต่ไม่เกิน 5 ความสามารถ
for ($i = 1; $i <= 5; $i++) {
    if (!empty($_POST['medical_' . $i])) {
        $medical_type_id = $_POST['medical_' . $i];
        if (in_array($medical_type_id, $medical_array)) {
            continue;
        } else {
            array_push($medical_array, $medical_type_id);
        }
        /*
        $min_price = trim($_POST['min-price-' . $i]);
        $max_price = trim($_POST['max-price-' . $i]);
        $sql = "INSERT INTO `special_medical`(`medical_type_id`, `hospital_id`, `min_price`, `max_price`, `date_added`)
        VALUES (" . $medical_type_id . "," . $hospital . "," . $min_price . "," . $max_price . ",NOW())";
         */
        $sql = "INSERT INTO `special_medical`(`medical_type_id`, `hospital_id`, `date_added`)
        VALUES (" . $medical_type_id . "," . $hospital . ", NOW())";
        $result = $db->query($sql, $rows, $num_rows);
        if ($result === true) {
            // print $i;
        } else {
            print $result . "<BR>";
            echo "<a href='create-specialmedical.php'>กลับหน้าเพิ่มข้อมูล</a>";
            break;
        }
    }
    if ($i == 5) {
        header("Location: insert_success.php");
    }
}
