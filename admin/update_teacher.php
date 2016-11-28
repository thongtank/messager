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

$department_id = (empty($_POST['department'])) ? $_POST['hidden_department_id'] : $_POST['department'];

// รับค่า POST ที่ส่งมาเก็บลงในตัวแปร array
$data = array
    (
    "teacher_username" => trim($_POST['teacher_username']),
    // "teacher_password" => trim($_POST['teacher_password']),
    "teacher_fname" => trim($_POST['teacher_fname']),
    "teacher_lname" => trim($_POST['teacher_lname']),
    "department" => trim($department_id),
    "tel" => trim($_POST['tel']),
    "email" => trim($_POST['email']),
);
// เรียกใช้งานคลาส database
use config\database as db;

$db = new db;

// $sql = "UPDATE `tb_teacher` SET `teacher_username`='" . $data['teacher_username'] . "',
//     `teacher_password`=PASSWORD('" . $data['teacher_password'] . "'),
//     `fname`='" . $data['teacher_fname'] . "',
//     `lname`='" . $data['teacher_lname'] . "',
//     `dep_id`='" . $data['department'] . "',
//     `tel`='" . $data['tel'] . "',
//     `email`='" . $data['email'] . "',
//     `date_create`=NOW() WHERE teacher_id='" . $_POST['hidden_id'] . "';";

$sql = "UPDATE `tb_teacher` SET `teacher_username`='" . $data['teacher_username'] . "',
    `fname`='" . $data['teacher_fname'] . "',
    `lname`='" . $data['teacher_lname'] . "',
    `dep_id`='" . $data['department'] . "',
    `tel`='" . $data['tel'] . "',
    `email`='" . $data['email'] . "',
    `date_create`=NOW() WHERE teacher_id='" . $_POST['hidden_id'] . "';";
$result = $db->query($sql, $rows, $num_rows);
if ($result === true) {
    header("Location: update_teacher_success.php");
} else {
    echo $result . "<BR>";
    echo "<a href='main.php'>กลับหน้าเพิ่มข้อมูล</a>";
}
