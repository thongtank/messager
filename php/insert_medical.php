<?php
session_start();
if (isset($_SESSION['profile']) && $_SESSION['profile'] == 'logon') {
    include 'config/autoload.inc.php';
} else {
    echo "
    <script type='text/javascript'>
        alert('กรุณาเข้าสู่ระบบก่อนกรอกประวัติการรักษา');
        window.location = 'signin.php';
    </script>
    ";
    exit;
}

use classes as cls;
use config as cfg;

$db = new cfg\database;
$ht = new cls\hospitals;

$ht->medical_detail = $_POST;

if ($ht->set_medical()) {
    header("Location: insert_success.php");
} else {
    header("Location: insert_failed.php");
}
// Array
// (
//     [hospital] => 3
//     [typeofmedical] => 6
//     [organ] => ไส้ติ่ง
//     [date_start] => 2015-11-01
//     [date_end] => 2015-11-05
//     [cost] => 14000
//     [amountofmedicine] => 2
//     [medicine_1] => 1A 656/2531
//     [medicine_2] => A6578T43
// )
