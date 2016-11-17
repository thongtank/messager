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
$pf = new cls\profiles();
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
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    <h3>สมาชิก</h3>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <tr>
                                            <th>ชื่อ</th>
                                            <th>เพศ</th>
                                            <th>ว/ด/ป เกิด</th>
                                            <th>อายุ</th>
                                            <th>ที่อยู่</th>
                                            <th>เบอร์โทรศัพท์</th>
                                            <th colspan="2">จัดการ</th>
                                        </tr>
                                        <?php
$sql = "";
if (isset($_GET['keyword'])) {
    $keyword = trim($_GET['keyword']);
    $sql .= "select * from profile where
        firstname like '%" . $keyword . "%' or
        lastname like '%" . $keyword . "%' or
        title like '%" . $keyword . "%' ";
} else {
    $sql = "select * from profile ";
}
$sql .= "order by date_added desc";
$result = $db->query($sql, $rows, $num_rows);
if ($result) {
    // print "<pre>" . print_r($rows, 1) . "</pre>";
    foreach ($rows as $k => $v) {
        $gender = "หญิง";
        if ($v['gender'] == "M") {
            $gender = "ชาย";
        }

        $province = $pv->get_province($v['province']);
        $provine_name = $province[0]['PROVINCE_NAME'];
        $amphur = $pv->get_amphur($v['amphur']);
        $amphur_name = $amphur[0]['AMPHUR_NAME'];
        $district = $pv->get_district($v['district']);
        $district_name = $district[0]['DISTRICT_NAME'];

        /* วันเกิด */
        $birthday = $pf->convert_birthday($v['birthday'], $arr_month);

        print "
        <tr>
            <td>" . $v['title'] . $v['firstname'] . " " . $v['lastname'] . "</td>
            <td>" . $gender . "</td>
            <td>" . $birthday . "</td>
            <td>" . $v['age'] . "</td>
            <td>"
        . $v['address'] . " <BR>อำเภอ" . $amphur_name . " <BR>ตำบล" . $district_name . " <BR>จังหวัด" . $provine_name . $v['zipcode'] . "
            </td>
            <td>" . str_replace(",", "<BR>", $v['tel']) . "</td>
            <td><a href='view-profile.php?id=" . urlencode($v['profile_id']) . "'><i class='fa fa-list'></i></a></td>
            <td><a href='delete-profile.php?id=" . urlencode($v['profile_id']) . "' onclick='return confirm(\"ยืนยันการลบข้อมูล ?\");'><i class='fa fa-trash-o'></i></a></td>
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
