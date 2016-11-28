<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config/autoload.inc.php';

use classes as cls;
use config as cfg;

$db = new cfg\database;
$pr = new cls\parents;

$data = $pr->get_parent($_POST['parent_id']);

print json_encode($data);
