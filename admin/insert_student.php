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
    "student_id" => trim($_POST['student_id']),
    "student_fname" => trim($_POST['student_fname']),
    "student_lname" => trim($_POST['student_lname']),
    "department" => trim($_POST['department']),
    "branch" => trim($_POST['branch']),
    "grade" => trim($_POST['grade']),
    "group" => trim($_POST['group']),
    "tel" => trim($_POST['tel']),
    "email" => trim($_POST['email']),
);

// เรียกใช้งานคลาส database
use config\database as db;

$db = new db;

$sql = "INSERT INTO `tb_student`(`student_id`, `fname`, `lname`, `dep_id`, `branch_id`, `grade_id`, `group`, `tel`, `email`, `date_create`, `admin_id`)
    VALUES ('" . $data['student_id'] . "','" . $data['student_fname'] . "','" . $data['student_lname'] . "'," . $data['department'] . "," . $data['branch'] . "," . $data['grade'] . "," . $data['group'] . ", '" . $data['tel'] . "','" . $data['email'] . "', NOW(), " . $_SESSION['admin_id'] . ");";
$result = $db->query($sql, $rows, $num_rows);
if ($result === true) {
    header("Location: insert_success.php");
} else {
    echo $result . "<BR>";
    echo "<a href='create-student.php'>กลับหน้าเพิ่มข้อมูล</a>";
}