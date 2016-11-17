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

$province_id = (empty($_POST['province'])) ? $_POST['hidden_province_id'] : $_POST['province'];
$amphur_id = (empty($_POST['amphur'])) ? $_POST['hidden_amphur_id'] : $_POST['amphur'];
$district_id = (empty($_POST['district'])) ? $_POST['hidden_district_id'] : $_POST['district'];

// รับค่า POST ที่ส่งมาเก็บลงในตัวแปร array
$data = array
(
    "hospital_verify_code" => trim($_POST['hospital_verify_code']),
    "hospital_name" => trim($_POST['hospital_name']),
    "hospital_address" => trim($_POST['hospital_address']),
    "province" => trim($province_id),
    "amphur" => trim($amphur_id),
    "district" => trim($district_id),
    "zipcode" => trim($_POST['zipcode']),
    "tel" => trim($_POST['tel']),
    "email" => trim($_POST['email']),
    "lat" => trim($_POST['lat']),
    "lng" => trim($_POST['lng']),
);
// เรียกใช้งานคลาส database
use config\database as db;

$db = new db;

$sql = "UPDATE `hospital` SET `hospital_verify_code`='" . $data['hospital_verify_code'] . "',
    `hospital_name`='" . $data['hospital_name'] . "',
    `hospital_address`='" . $data['hospital_address'] . "',
    `province`='" . $data['province'] . "',
    `amphur`='" . $data['amphur'] . "',`district`='" . $data['district'] . "',
    `zipcode`='" . $data['zipcode'] . "',`lat`='" . $data['lat'] . "',`lng`='" . $data['lng'] . "',
    `tel`='" . $data['tel'] . "',`email`='" . $data['email'] . "' WHERE hospital_id=" . $_POST['hidden_id'];
$result = $db->query($sql, $rows, $num_rows);
if ($result === true) {
    header("Location: update_success.php");
} else {
    echo $result . "<BR>";
    echo "<a href='main.php'>กลับหน้าเพิ่มข้อมูล</a>";
}