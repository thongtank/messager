<?php
session_start();
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != "logon") {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
} else {
    include '../php/config/autoload.inc.php';
}
use classes as cls;
use config\database as db;

$db = new db;
$pv = new cls\provinces();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Admin Management</title>
        <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    </head>

    <body>
        <article class="container-fluid" style="">
            <?php include "header.php";?>
                <section>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" method="GET" class="col-md-5 pull-right">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="keyword" placeholder="ค้นหาความชำญการ">
                                    <span class="input-group-btn"><button class="btn btn-default" type="submit">Go!</button></span>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12" style="padding-top: 10px;">
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <h3>ประเภทการรักษา <a href="create-typeofmedical.php"><i style="" class="fa fa-plus"></i></a></h3>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <tr>
                                            <th>ความชำนาญการ</th>
                                            <th>สร้างโดย</th>
                                            <th colspan="2">จัดการ</th>
                                        </tr>
                                        <?php
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $sql = "SELECT * from typeOfmedical where medical_name LIKE '%" . $keyword . "%' ";
} else {
    $sql = "select * from typeOfmedical ";
}
$sql .= " order by date_added desc;";
$result = $db->query($sql, $rows, $num_rows);
if ($result) {
    // print "<pre>" . print_r($rows, 1) . "</pre>";
    if ($num_rows == 0) {
        exit;
    }
    foreach ($rows as $k => $v) {
        print "
        <tr>
            <td>" . $v['medical_name'] . "</td>
            <td>" . $v['added_from'] . "</td>
            <td><a href='delete-typeofmedical.php?id=" . urlencode($v['medical_type_id']) . "' onclick='return confirm(\"ยืนยันการลบข้อมูล ?\");'><i class='fa fa-trash-o'></i></a></td>
            <td><a href='edit-typeofmedical.php?id=" . urlencode($v['medical_type_id']) . "'><i class='fa fa-pencil'></i></a></td>
        </tr>
        ";
    }
}
$result = null;
$rows = null;
$num_rows = null;
?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--
                    <div class="col-md-3 hidden-print hidden-xs hidden-sm affix" style="right: 0;">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">รายการ</h3>
                            </div>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <a href="#hospital"><i class="fa fa-heartbeat"></i> โรงพยาบาล</a>
                                </li>
                                <li class="list-group-item">
                                    <a href="#medicine"><i class="fa fa-medkit"></i> ยา</a>
                                </li>
                                <li class="list-group-item">
                                    <a href="#profile"><i class="fa fa-users"></i> สมาชิก</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    -->
                </section>
        </article>
        <script src="../js/jquery-1.11.3.min.js"></script>
        <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../src/province.js"></script>
    </body>

    </html>
