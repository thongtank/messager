<?php
session_start(); // เริ่มการทำงาน session
include "../php/config/autoload.inc.php"; // เรียกใช้ไฟล์ autoload.inc.php
use config\database as db; // เรียกใช้ namespace

/** @var db เรียกใช้ Database Class โดยเก็บ Object ลงตัวแปร $db */
$db = new db;

/** @var array เก็บ POST ที่ส่งมาส่งตัวแปรชนิด Array */
$data = array(
    "username" => $_POST["username"],
    "password" => $_POST["password"],
);

/** @var string คำสั่ง sql ค้นหา Username And Password ใน Admin Table */
$sql = "select *, count(*) as a from tb_admin
    where admin_username = '" . $data["username"] . "' AND admin_password = PASSWORD('" . $data["password"] . "');";

// Query คำสั่ง
$result = $db->query($sql, $rows, $num_rows);

// ถ้าการ Query สำเร็จไม่พบ Error
// === หมายถีงเปรียบเทียบทั้งชนิดของตัวแปรและค่าตัวแปร
// ตัวอย่าง $result ต้องทีชนิดตัวแปรเป็น Boolean และค่าของมันคือ true เงื่อนไขนี้ถึงจะเป็นจริง
if ($result === true) {
    // ถ้าพบ Username และ Password
    if ($rows[0]["a"] > 0) {
        $admin_username = $rows[0]["admin_username"];
        $admin_id = $rows[0]["admin_id"];
        $typeOfUser = "admin";
        // session_unset();
        // ทำการลบค่า $result ก่อน Query คำสั่งต่อไป
        $result = NULL;

        // คำสั่ง Update Field last_login ใน Admin Table
        // NOW() คือการดึงค่าเวลา ณ ปัจจุบัน
        $sql = "update tb_admin set last_login = NOW(), ip_last_login = '" . $_SERVER['SERVER_ADDR'] . "' where admin_username = '" . $data["username"] . "' and admin_password = PASSWORD('" . $data["password"] . "');";
        $result = $db->query($sql, $rows, $num_rows);
        if ($result === true) {
            $_SESSION["admin"] = "logon";
            $_SESSION["admin_username"] = $admin_username;
            $_SESSION["admin_id"] = $admin_id;
            $_SESSION["typeOfUser"] = $typeOfUser;
            header("location: ../admin/main.php");
        }
    } else {
        $_SESSION["not_found"] = "YES";
        header("location: ../admin/index.php");
    }
} else {
    print $result;
}
