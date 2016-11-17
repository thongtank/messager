<?php
include './config/autoload.inc.php';
use config\database as db;

$db = new db;
$sql = "select * from tb_branch";
$result = $db->query($sql, $rows, $num_rows);
if ($result) {
    print json_encode($rows);
} else {
    print $result;
}

?>