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
$branch_id = (empty($_POST['branch'])) ? $_POST['hidden_branch_id'] : $_POST['branch'];
$grade_id = (empty($_POST['grade'])) ? $_POST['hidden_grade_id'] : $_POST['grade'];

// รับค่า POST ที่ส่งมาเก็บลงในตัวแปร array
$data = array
    (
    "student_id" => trim($_POST['student_id']),
    "student_fname" => trim($_POST['student_fname']),
    "student_lname" => trim($_POST['student_lname']),
    "department" => trim($department_id),
    "branch" => trim($branch_id),
    "grade" => trim($grade_id),
    "group" => trim($_POST['group']),
    "tel" => trim($_POST['tel']),
    "email" => trim($_POST['email']),
);
// เรียกใช้งานคลาส database
use config\database as db;

$db = new db;

$sql = "UPDATE `tb_student` SET `student_id`='" . $data['student_id'] . "',
    `fname`='" . $data['student_fname'] . "',
    `lname`='" . $data['student_lname'] . "',
    `dep_id`='" . $data['department'] . "',
    `branch_id`='" . $data['branch'] . "',
    `grade_id`='" . $data['grade'] . "',
    `group`='" . $data['group'] . "',
    `tel`='" . $data['tel'] . "',
    `email`='" . $data['email'] . "',
    `date_create`=NOW() WHERE student_id='" . $_POST['hidden_id'] . "';";
// print $sql;exit();
$result = $db->query($sql, $rows, $num_rows);
if ($result === true) {
    header("Location: update_success.php");
} else {
    echo $result . "<BR>";
    echo "<a href='main.php'>กลับหน้าเพิ่มข้อมูล</a>";
}
