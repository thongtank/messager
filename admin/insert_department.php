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
    "department" => trim($_POST['department']),
    "tel" => trim($_POST['tel']),
);

// เรียกใช้งานคลาส database
use config\database as db;

$db = new db;

$sql = "INSERT INTO `tb_department` (`dep_id`, `dep_name`, `tel`, `admin_id`, `date_create`) VALUES (NULL, '" . $data['department'] . "', '" . $data['tel'] . "', " . $_SESSION['admin_id'] . ", NOW());";
// print $sql;exit();
$result = $db->query($sql, $rows, $num_rows);
if ($result === true) {
    header("Location: insert_success.php");
} else {
    echo $result . "<BR>";
    echo "<a href='list-department.php'>กลับหน้าเพิ่มข้อมูลแผนกวิชา</a>";
}