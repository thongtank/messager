<?php
session_start();
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != "logon") {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}
// เรียกใช้คลาส autoload
include "../php/config/autoload.inc.php";

// สร้างตัวแปรชนิด array เพื่อเก็บค่า $_POST
$data = array();

// เก็บค่า POST ที่ได้ด้วยคำสั่งวนลูป foreach
foreach ($_POST as $k => $v) {
    // $k = เก็บชื่อของ POST
    // $v = เก็บค่าของ POST
    $data[$k] = trim($v);
}

// เรียกใช้งานคลาส database
use config\database as db;

$db = new db;

$province_id = (empty($_POST['province'])) ? $_POST['hidden_province_id'] : $_POST['province'];
$amphur_id = (empty($_POST['amphur'])) ? $_POST['hidden_amphur_id'] : $_POST['amphur'];
$district_id = (empty($_POST['district'])) ? $_POST['hidden_district_id'] : $_POST['district'];

$sql = "UPDATE `medicine` SET
    `medicine_id`='" . $data['medicine_id'] . "',
    `medicine_name_th`='" . $data['medicine_name_th'] . "',
    `medicine_name_eng`='" . $data['medicine_name_eng'] . "',
    `medicine_type`='" . $data['medicine_type'] . "',
    `medicine_type_control`='" . $data['medicine_type_control'] . "',
    `medicine_detail`='" . $data['medicine_detail'] . "',
    `medicine_chemical`='" . $data['medicine_chemical'] . "',
    `medicine_status`='" . $data['medicine_status'] . "',
    `medicine_use`='" . $data['medicine_use'] . "',
    `owner_name`='" . $data['owner_name'] . "',
    `company_name`='" . $data['company_name'] . "',
    `company_address`='" . $data['company_address'] . "',
    `company_province`=" . $province_id . ",
    `company_amphur`=" . $amphur_id . ",
    `company_district`=" . $district_id . ",
    `company_zipcode`=" . $data['zipcode'] . ",
    `tel`='" . $data['tel'] . "',
    `date_added`=NOW() WHERE medicine_id = '" . $data['hidden_id'] . "';";

// echo $sql;exit;

$result = $db->query($sql, $rows, $num_rows);
if ($result === true) {
    header("Location: update_success.php");
} else {
    echo $result . "<BR>";
    echo "<a href='main.php'>กลับหน้าเพิ่มข้อมูล</a>";
}