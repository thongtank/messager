<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config/autoload.inc.php';

use classes as cls;
use config as cfg;

$db = new cfg\database;
$tc = new cls\teachers();

$data = $tc->get_teacher_by_username($_POST['teacher_username']);

print json_encode($data);
