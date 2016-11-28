<?php
include './config/autoload.inc.php';
use classes as cls;
use config\database as db;

$db = new db;
$dep = new cls\department;

$result = $dep->get_branch_by_name(trim($_POST['name']), $_POST['dep_id']);

if (sizeof($result) > 0) {
    // print json_encode($result);
    print 1;
} else {
    print 0;
}

?>