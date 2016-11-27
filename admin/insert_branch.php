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
    "branch" => trim($_POST['branch']),
);

// เรียกใช้งานคลาส database
use classes as cls;
use config\database as db;

$db = new db;
$dep = new cls\department();

if (sizeof($dep->get_branch_by_name($data['branch'], $data['department'])) == 0) {
    $sql = "INSERT INTO `tb_branch` (`branch_name`, `dep_id`, `admin_id`, `date_create`) VALUES ('" . $data['branch'] . "', '" . $data['department'] . "', " . $_SESSION['admin_id'] . ", NOW());";

    $result = $db->query($sql, $rows, $num_rows);
    if ($result === true) {
        header("Location: insert_branch_success.php");
    } else {
        echo $result . "<BR>";
        echo "<a href='list-branch.php'>กลับหน้าเพิ่มข้อมูลสาขาวิชา</a>";
    }
} else {
    echo "ชื่อสาขาวิชา " . $data['branch'] . " มีอยู่แล้ว<BR>";
    echo "<a href='list-branch.php'>กลับหน้าเพิ่มข้อมูลสาขาวิชา</a>";
}
