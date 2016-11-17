<?php
session_start();

$_SESSION["admin"] = "";
$_SESSION["admin_username"] = "";
$_SESSION["typeOfUser"] = "";
// session_unset();
// session_destroy();

header("Location: index.php");