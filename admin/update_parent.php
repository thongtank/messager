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
$data = array
    (
    "parent_id" => trim($_POST['parent_id']),
    "parent_fname" => trim($_POST['parent_fname']),
    "parent_lname" => trim($_POST['parent_lname']),
    "tel" => trim($_POST['tel']),
    "email" => trim($_POST['email']),
    "waytoreceive" => trim($_POST['radio_receive']),
);
// เรียกใช้งานคลาส database
use config\database as db;

$db = new db;

$sql = "UPDATE `tb_parent` SET `parent_id`='" . $data['parent_id'] . "',
    `fname`='" . $data['parent_fname'] . "',
    `lname`='" . $data['parent_lname'] . "',
    `tel`='" . $data['tel'] . "',
    `email`='" . $data['email'] . "',
    `waytoreceive`='" . $data['waytoreceive'] . "',
    `date_create`=NOW() WHERE parent_id='" . $_POST['hidden_id'] . "';";
$result = $db->query($sql, $rows, $num_rows);
if ($result === true) {
    header("Location: update_success.php");
} else {
    echo $result . "<BR>";
    echo "<a href='main.php'>กลับหน้าเพิ่มข้อมูล</a>";
}
