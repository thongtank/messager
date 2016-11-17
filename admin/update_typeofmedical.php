<?php
session_start();
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != "logon") {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}

include "../php/config/autoload.inc.php";

use config\database;

$db = new database;

$data = Array(
    "medical_name" => trim($_POST["medical_name"]),
    "medical_type_id" => trim($_POST['hidden_id']),
);
$sql = "UPDATE `typeOfMedical` SET `medical_name`='" . $data['medical_name'] . "',`date_added`=NOW(),`added_from`='" . $_SESSION['typeOfUser'] . "' WHERE medical_type_id = " . $data['medical_type_id'];
// print $sql;exit();
$result = $db->query($sql, $rows, $num_rows);
if ($result) {
    header("Location: update_success.php");
} else {
    echo $result . "<BR>";
    echo "<a href='create-typeofmedical.php'>กลับหน้าเพิ่มข้อมูล</a>";
}

?>