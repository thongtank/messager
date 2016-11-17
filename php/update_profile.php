<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config/autoload.inc.php';

use classes as cls;
use config as cfg;
$db = new cfg\database;
$pf = new cls\profiles;

/*
Array
(
[title] => นาย
[firstname] => กรุณ
[lastname] => รูปหล่อ
[birthday] => 1988-12-21
[tel] =>                                     0875435550,045261624
[email] =>
[address] => 439 ถ.สรรพสิทธิ์
[province] =>
[hidden_province_id] => 23
[amphur] =>
[hidden_amphur_id] => 312
[district] =>
[hidden_district_id] => 2788
[zipcode] => 34000
[latlng] => 1
)
 */
$data = array();
foreach ($_POST as $k => $v) {
    $data[$k] = trim($v);
}

$latlng = explode(",", $data['latlng']);
$data['lat'] = trim($latlng[0]);
if (count($latlng) > 1) {
    $data['lng'] = trim($latlng[1]);
} else {
    $data['lng'] = "";
}

$pf->pf = $data;

$result = $pf->update();
if ($result) {
    $data = $pf->get_profile($_SESSION['profile_detail']['profile_id']);
    foreach ($data as $key => $value) {
        $_SESSION['profile_detail'][$key] = $value;
    }
    // print "<pre>" . print_r($_SESSION, 1) . "</pre>";
    // exit;
    header("Location: update_success.php");
} else {
    header("Location: update_failed.php");
}