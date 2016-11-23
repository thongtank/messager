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
	"branch_id" => trim($_POST['branch_id']),
	"dep_id" => trim($_POST['dep_id']),
	"branch" => trim($_POST['branch']),
);
// เรียกใช้งานคลาส database
use config\database as db;

$db = new db;

$dep_id = ($_POST['department'] != "") ? $_POST['department'] : $_POST['dep_id'];

$sql = "UPDATE `tb_branch` SET `branch_name`='" . $data['branch'] . "',`dep_id`=" . $dep_id . ",`admin_id`=" . $_SESSION['admin_id'] . ",`date_create`=NOW() WHERE `branch_id` = " . $data['branch_id'] . ";";
$result = $db->query($sql, $rows, $num_rows);
if ($result === true) {
	header("Location: update_success.php");
} else {
	echo $result . "<BR>";
	echo "<a href='main.php'>กลับหน้าเพิ่มข้อมูล</a>";
}
