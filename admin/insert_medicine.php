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

$sql = "select * from medicine where medicine_id = '" . $_POST['medicine_id'] . "';";
$result = $db->query($sql, $rows, $num_rows);
if ($result === true) {
    if ($num_rows > 0) {
        alert_and_back("เลขทะเบียนยาของท่านซ้ำ กรุณาตรวจสอบข้อมูล");
        exit;
    }
}
$result = null;
$rows = null;
$num_rows = null;
$sql = "";
// print '<pre>' . print_r($_POST, 1) . '</pre>';
/*
Array
(
[medicine_id] => 1A 656 2531
[medicine_name_th] => พารา ไซรัป
[medicine_name_eng] => PARA SYRUP
[medicine_type] => ยาน้ำ
[medicine_use] => ภายใน
[medicine_type_control] => ยาสามัญ
[medicine_status] => คงอยู่
[medicine_detail] => บรรเทาอาการปวด
[medicine_chemical] => PARACETAMOL 120MG
[owner_name] => บริษัทบูรพาโอสถ  จำกัด
[company_name] => บริษัทบูรพาโอสถ  จำกัด
[company_address] => 19/19  ม.9   ซ.ทิมแลนด์  ถ.งามวงศ์วาน
[province] => 3
[amphur] => 58
[district] => 303
[zipcode] => 11000
[tel] => 0 2589 2750-3
)
 */

// สร้างตัวแปรชนิด array เพื่อเก็บค่า $_POST
$data = array();

// เก็บค่า POST ที่ได้ด้วยคำสั่งวนลูป foreach
foreach ($_POST as $k => $v) {
    // $k = เก็บชื่อของ POST
    // $v = เก็บค่าของ POST
    $data[$k] = trim($v);
}

$sql = "INSERT INTO `medicine`(`medicine_id`, `medicine_name_th`, `medicine_name_eng`, `medicine_type`,
    `medicine_type_control`, `medicine_detail`, `medicine_chemical`, `medicine_status`, `medicine_use`,
    `owner_name`, `company_name`, `company_address`, `company_province`, `company_amphur`, `company_district`,
    `company_zipcode`, `tel`, `date_added`)
    VALUES (
        '" . $data['medicine_id'] . "',
        '" . $data['medicine_name_th'] . "',
        '" . $data['medicine_name_eng'] . "',
        '" . $data['medicine_type'] . "',
        '" . $data['medicine_type_control'] . "',
        '" . $data['medicine_detail'] . "',
        '" . $data['medicine_chemical'] . "',
        '" . $data['medicine_status'] . "',
        '" . $data['medicine_use'] . "',
        '" . $data['owner_name'] . "',
        '" . $data['company_name'] . "',
        '" . $data['company_address'] . "',
        '" . $data['province'] . "',
        '" . $data['amphur'] . "',
        '" . $data['district'] . "',
        '" . $data['zipcode'] . "',
        '" . $data['tel'] . "',
        NOW())";
$result = $db->query($sql, $rows, $num_rows);
if ($result) {
    header("Location: insert_success.php");
} else {
    print $result . "<BR>";
    echo "<a href='create-medicine.php'>กลับหน้าเพิ่มข้อมูล</a>";
}
