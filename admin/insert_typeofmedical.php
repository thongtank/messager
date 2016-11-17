<?php
session_start();
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != "logon") {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}

include "../php/config/autoload.inc.php";

use config\database;

$db = new database;

$data = Array(
    "medical_name" => trim($_POST["medical_name"]),
);

$sql = "select medical_name from typeOfMedical WHERE medical_name = '" . $data['medical_name'] . "';";
if ($result = $db->query($sql, $rows, $num_rows)) {

    if ($num_rows > 0) {
        alert_and_back("ข้อมูลการรักษานี้มีอยู่แล้ว กรุณาตรวจสอบ . .​ .");
        exit();
    }
    $result = null;
    $rows = null;
    $num_rows = null;
}
$sql = "INSERT INTO `typeOfMedical`(`medical_name`, `date_added`, `added_from`)
    VALUES ('" . $data['medical_name'] . "',NOW(), '" . $_SESSION["typeOfUser"] . "')";

$result = $db->query($sql, $rows, $num_rows);
if ($result) {
    header("Location: insert_success.php");
} else {
    echo $result . "<BR>";
    echo "<a href='create-typeofmedical.php'>กลับหน้าเพิ่มข้อมูล</a>";
}
