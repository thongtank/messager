<?php
ini_set("display_errors", 1);
session_start(); // เริ่มการทำงาน session
include "config/autoload.inc.php"; // เรียกใช้ไฟล์ autoload.inc.php
use config\database as db; // เรียกใช้ namespace

/** @var db เรียกใช้ Database Class โดยเก็บ Object ลงตัวแปร $db */
$db = new db;

/** @var array เก็บ POST ที่ส่งมาส่งตัวแปรชนิด Array */
$data = array(
	"username" => $_POST["username"],
	"password" => $_POST["password"],
);

/** @var string คำสั่ง sql ค้นหา Username And Password ใน Admin Table */
$sql = "select *, count(*) as a from tb_teacher
    where teacher_username = '" . $data["username"] . "' AND teacher_password = PASSWORD('" . $data["password"] . "');";

// Query คำสั่ง
$result = $db->query($sql, $rows, $num_rows);

// ถ้าการ Query สำเร็จไม่พบ Error
// === หมายถีงเปรียบเทียบทั้งชนิดของตัวแปรและค่าตัวแปร
// ตัวอย่าง $result ต้องทีชนิดตัวแปรเป็น Boolean และค่าของมันคือ true เงื่อนไขนี้ถึงจะเป็นจริง
if ($result === true) {
	// ถ้าพบ Username และ Password
	if ($rows[0]["a"] > 0) {
		$teacher_id = $rows[0]["teacher_id"];
		$teacher_username = $rows[0]["teacher_username"];
		$typeOfUser = "teacher";
		$data = $rows[0];
		// session_unset();
		// ทำการลบค่า $result ก่อน Query คำสั่งต่อไป
		$result = NULL;

		// คำสั่ง Update Field last_login ใน Admin Table
		// NOW() คือการดึงค่าเวลา ณ ปัจจุบัน
		$sql = "update tb_teacher set last_login = NOW() where
            teacher_username = '" . $data["username"] . "';";
		$result = $db->query($sql, $rows, $num_rows);
		if ($result === true) {
			$_SESSION["teacher"] = "logon";
			$_SESSION["teacher_username"] = $teacher_username;
			$_SESSION["teacher_id"] = $teacher_id;
			$_SESSION["teacher_typeOfUser"] = $typeOfUser;
			$_SESSION["teacher_detail"] = $data;
			header("location: ../index.php");
		}
	} else {
		$_SESSION["not_found"] = "YES";
		print "";
		header("location: ../login-fail.php");
	}
} else {
	print $result;
}
?>