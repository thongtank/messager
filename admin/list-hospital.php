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
                                    <input type="text" class="form-control" name="keyword" placeholder="ค้นหาใบอนุญาต, ชื่อ, ที่อยู่">
                                    <span class="input-group-btn"><button class="btn btn-default" type="submit">Go!</button></span>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12" style="padding-top: 10px;">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3>โรงพยาบาล <a href="create-hospital.php"><i style="color: white;" class="fa fa-plus"></i></a></h3>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-hover">
                                        <tr>
                                            <th>ใบอนุญาติ</th>
                                            <th>ชื่อ</th>
                                            <th>ที่ตั้ง</th>
                                            <th>เบอร์โทรศัพท์</th>
                                            <th colspan="2">จัดการ</th>
                                        </tr>
                                        <?php
if (isset($_GET['keyword'])) {
    $keyword = trim($_GET['keyword']);
    $sql = "select * from hospital where
        hospital_id like '%" . $keyword . "%' or
        hospital_name like '%" . $keyword . "%' or
        hospital_address like '%" . $keyword . "%' ";
} else {
    $sql = "select * from hospital ";
}
$sql .= " ORDER BY date_added Desc;";
$result = $db->query($sql, $rows, $num_rows);
if ($result) {
    if ($num_rows == 0) {
        exit;
    }
    foreach ($rows as $k => $v) {
        $province = $pv->get_province($v['province']);
        $province_name = $province[0]['PROVINCE_NAME'];
        $amphur = $pv->get_amphur($v['amphur']);
        $amphur_name = $amphur[0]['AMPHUR_NAME'];
        $district = $pv->get_district($v['district']);
        $district_name = $district[0]['DISTRICT_NAME'];
        print "
        <tr>
            <td>" . $v['hospital_verify_code'] . "</td>
            <td>" . $v['hospital_name'] . "</td>
            <td>
                " . $v['hospital_address'] . " อำเภอ" . $amphur_name . " ตำบล" . $district_name . " จังหวัด" . $province_name . $v['zipcode'] . "
            </td>
            <td>" . $v['tel'] . "</td>
            <td><a href='delete-hospital.php?id=" . $v['hospital_id'] . "' onclick='return confirm(\"ยืนยันก่ารลบข้อมูล ?\");'><i class='fa fa-trash-o'></i></a></td>
            <td><a href='edit-hospital.php?id=" . $v['hospital_id'] . "'><i class='fa fa-pencil'></i></a></td>
        </tr>
        ";
    }
}
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
