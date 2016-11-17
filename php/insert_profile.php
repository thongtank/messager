<?php
include 'config/autoload.inc.php';

use classes as cls;
use config as cfg;
$db = new cfg\database;
$pf = new cls\profiles;

/*
username = panchai
password = 489329
title = นาย
firstname = พันชัย
lastname = ประสมเพชร
birthday = 1988-12-21
tel = 0875435550
email = thongtank@hotmail.com
address = 213 หมู่ 12
province = 23
amphur = 325
district = 2947
zipcode = 34140
lat =
lng =
privacy = 1
 */
$data = array();
foreach ($_POST as $k => $v) {
    $data[$k] = $v;
}

$latlng = explode(",", $data['latlng']);
$data['lat'] = trim($latlng[0]);
$data['lng'] = trim($latlng[1]);
$pf->pf = $data;

$result = $pf->set();
if ($result) {
    header("Location: insert_success.php");
} else {
    header("Location: insert_failed.php");
}