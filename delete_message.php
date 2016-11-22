<?php
session_start();
if (!isset($_SESSION["teacher"]) || $_SESSION["teacher"] != "logon") {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
}

include './php/config/autoload.inc.php';
use config as cfg;
$db = new cfg\database;
$sql = "DELETE FROM `tb_message` WHERE `message_id` = " . $_GET['id'];
$result = $db->query($sql, $rows, $num_rows);
if ($result) {
    header("Location: delete-success.php");
} else {
    echo $result . "<BR>";
    echo "<a href='main.php'>กลับหน้าหลัก</a>";
}
