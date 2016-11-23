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
    "dep_id" => trim($_POST['dep_id']),
    "department" => trim($_POST['department']),
    "tel" => trim($_POST['tel']),
);
// เรียกใช้งานคลาส database
use config\database as db;

$db = new db;

$sql = "UPDATE `tb_department` SET `dep_name`='" . $data['department'] . "', `admin_id`=" . $_SESSION['admin_id'] . ", `tel`='" . $data['tel'] . "', `date_create`=NOW() WHERE `dep_id` = " . $data['dep_id'] . ";";
$result = $db->query($sql, $rows, $num_rows);
if ($result === true) {
    header("Location: update_dep_success.php");
} else {
    echo $result . "<BR>";
    echo "<a href='main.php'>กลับหน้าหลัก</a>";
}
