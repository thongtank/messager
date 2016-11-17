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

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: main.php");
}

use classes as cls;
use config\database as db;

$db = new db;
$pv = new cls\provinces();
$pf = new cls\profiles();

$data = $pf->get_profile(trim($_GET['id']));
$province = $pv->get_province($data['province'])[0];
$amphur = $pv->get_amphur($data['amphur'])[0];
$district = $pv->get_district($data['district'])[0];
// print "<pre>" . print_r($province, 1) . "</pre>";
// exit;
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
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h1 class=""><?=$data['title'] . "" . $data['firstname'] . " " . $data['lastname'] . " <small>( " . $data['age'] . " ปี )</small>";?></h1>
                                </div>
                                <div class="panel-body">
                                    <p class="lead">
                                        <strong>เกิดเมื่อวันที่</strong>
                                        <?=$pf->convert_birthday($data['birthday'], $arr_month);?>
                                    </p>
                                    <p class="lead">
                                        <strong>ที่อยู่</strong>
                                        <?=$data['address'] . " ตำบล" . $district['DISTRICT_NAME'] . " อำเภอ" . $amphur['AMPHUR_NAME'] . " จังหวัด" . $province['PROVINCE_NAME'] . $data['zipcode'];?>
                                    </p>
                                    <p class="lead">
                                        <strong>เบอร์โทรศัพท์ </strong>
                                        <?=$data['tel'];?>
                                    </p>
                                    <p class="lead">
                                        <strong>อีเมล์ </strong>
                                        <?=($data['email'] == "") ? "-" : $data['email'];?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
        </article>
        <script src="../js/jquery-1.11.3.min.js"></script>
        <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../src/province.js"></script>
    </body>

    </html>
