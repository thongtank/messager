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
$data = array(
    "teacher_username" => trim($_POST['teacher_username']),
    "teacher_password" => trim($_POST['teacher_password']),
    "teacher_fname" => trim($_POST['teacher_fname']),
    "teacher_lname" => trim($_POST['teacher_lname']),
    "department" => trim($_POST['department']),
    "tel" => trim($_POST['tel']),
    "email" => trim($_POST['email']),
);
// เรียกใช้งานคลาส database
use config\database as db;

$db = new db;

$sql = "INSERT INTO `tb_teacher`(`teacher_username`, `teacher_password`, `fname`, `lname`, `tel`, `email`, `dep_id`, `admin_id`, `date_create`)
    VALUES ('" . $data['teacher_username'] . "',PASSWORD('" . $data['teacher_password'] . "'),'" . $data['teacher_fname'] . "','" . $data['teacher_lname'] . "','" . $data['tel'] . "','" . $data['email'] . "', " . $data['department'] . ", " . $_SESSION['admin_id'] . ", NOW());";
$result = $db->query($sql, $rows, $num_rows);
if ($result === true) {
    header("Location: insert_teacher_success.php");
} else {
    echo $result . "<BR>";
    echo "<a href='create-teacher.php'>กลับหน้าเพิ่มข้อมูล</a>";
}