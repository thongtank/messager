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
    "parent_id" => trim($_POST['hidden_id']),
    "student_id" => trim($_POST['student_id']),
);

// เรียกใช้งานคลาส database
use config\database as db;

$db = new db;

$sql = "UPDATE `tb_student` SET `parent_id` = '" . $data['parent_id'] . "'
            WHERE `tb_student`.`student_id` = '" . $data['student_id'] . "';";
$result = $db->query($sql, $rows, $num_rows);
if ($result === true) {
    header("Location: insert_success.php");
} else {
    echo $result . "<BR>";
    echo "<a href='create-student.php'>กลับหน้าเพิ่มข้อมูล</a>";
}