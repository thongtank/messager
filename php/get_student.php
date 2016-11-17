<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config/autoload.inc.php';

use classes as cls;
use config as cfg;

$db = new cfg\database;
$std = new cls\students;

$data = $std->get_student($_POST['student_id']);

print json_encode($data);
