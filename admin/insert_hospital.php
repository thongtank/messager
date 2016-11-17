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

// รับค่า POST ที่ส่งมาเก็บลงในตัวแปร array
$latlng = explode(",", $_POST['latlng']);
$data = array
    (
    "hospital_verify_code" => trim($_POST['hospital_verify_code']),
    "hospital_name" => trim($_POST['hospital_name']),
    "hospital_address" => trim($_POST['hospital_address']),
    "province" => trim($_POST['province']),
    "amphur" => trim($_POST['amphur']),
    "district" => trim($_POST['district']),
    "zipcode" => trim($_POST['zipcode']),
    "tel" => trim($_POST['tel']),
    "email" => trim($_POST['email']),
    "lat" => trim($latlng[0]),
    "lng" => trim($latlng[1]),
);

// เรียกใช้งานคลาส database
use config\database as db;

$db = new db;

$sql = "INSERT INTO `hospital`(`hospital_verify_code`, `hospital_name`, `hospital_address`, `province`, `amphur`, `district`, `zipcode`, `lat`, `lng`, `tel`, `email`, `date_added`)
    VALUES ('" . $data['hospital_verify_code'] . "','" . $data['hospital_name'] . "','" . $data['hospital_address'] . "'," . $data['province'] . "," . $data['amphur'] . "," . $data['district'] . "," . $data['zipcode'] . ",
        '" . $data['lat'] . "','" . $data['lng'] . "','" . $data['tel'] . "','" . $data['email'] . "',NOW());";
$result = $db->query($sql, $rows, $num_rows);
if ($result === true) {
    header("Location: insert_success.php");
} else {
    echo $result . "<BR>";
    echo "<a href='create-hospital.php'>กลับหน้าเพิ่มข้อมูล</a>";
}