<?php
session_start();
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != "logon") {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}

if (!isset($_GET['id']) or empty($_GET['id'])) {
    header("Location: main.php");
} else {
    include '../php/config/autoload.inc.php';
}
use classes as cls;
use config as cfg;
$db = new cfg\database;
$pv = new cls\provinces;

$sql = "select * from hospital where hospital_id = " . trim($_GET['id']) . " limit 1";
$result = $db->query($sql, $rows, $num_rows);
if (!$result) {
    print $result . "<BR>";
    print "<a href='main.php'>กลับหน้าหลัก</a>";
    exit;
} else {
    /*
    hospital_id = 6
    hospital_verify_code = asdasd
    hospital_name = asdasd
    hospital_address = asdasd
    province = 1
    amphur = 1
    district = 1
    zipcode = 10100
    lat =
    lng =
    tel =
    email =
    date_added = 0000-00-00 00:00:00
     */
    $data = array();
    foreach ($rows[0] as $key => $value) {
        $data[$key] = $value;
    }
    // print "<pre>" . print_r($data, 1) . "</pre>";
}
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>แก้ไขข้อมูลโรงพยาบาล</title>
        <link rel="stylesheet" href="../js/jquery-ui-1.11.4.custom/jquery-ui.min.css">
        <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/mine.css">
    </head>

    <body>
        <div class="se-pre-con"></div>
        <article class="container">
            <?php include "header.php";?>
                <section>
                    <header>
                        <hgroup>
                            <h1>แก้ไขข้อมูลโรงพยาบาล</h1>
                            <h5>แบบฟอร์มแก้ไขข้อมูลโรงพยาบาล</h5>
                        </hgroup>
                    </header>
                </section>
                <section class="content">
                    <form action="update_hospital.php" method="POST" class="form-horizontal form-register">
                        <div class="form-group">
                            <label for="hospital_verify_code" class="control-label col-md-4">ใบอนุญาตเลขที่ *</label>
                            <div class="col-md-8">
                                <input type="text" value="<?=$data['hospital_verify_code'];?>" class="form-control" id="hospital_verify_code" name="hospital_verify_code">
                                <input type="hidden" value="<?=$data['hospital_id'];?>" name="hidden_id" id="hidden_id">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="hospital_name" class="control-label col-md-4">ชื่อโรงพยาบาล *</label>
                            <div class="col-md-8">
                                <input type="text" value="<?=$data['hospital_name'];?>" class="form-control" id="hospital_name" name="hospital_name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="hospital_address" class="control-label col-md-4">ที่ตั้ง *</label>
                            <div class="col-md-8">
                                <input type="text" value="<?=$data['hospital_address'];?>" class="form-control" id="hospital_address" name="hospital_address" required="" aria-describedby="hospital_address-helpBox">
                                <span id="hospital_address-helpBox" class="help-block">บ้านเลขที่ / หมู่ ถนน ซอย ฯลฯ</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="province" class="control-label col-md-4">จังหวัด</label>
                            <div class="col-md-8">
                                <?php $province = $pv->get_province($data['province']);?>
                                    <select name="province" id="province" class="form-control" aria-describedby="province-helpBox">
                                        <option value="">เลือกจังหวัด</option>
                                    </select>
                                    <span id="province-helpBox" class="help-block">จังหวัดเดิมคือ <?=$province[0]['PROVINCE_NAME'];?></span>
                                    <input type="hidden" name="hidden_province_id" value="<?=$province[0]['PROVINCE_ID'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="amphur" class="control-label col-md-4">อำเภอ</label>
                            <div class="col-md-8">
                                <?php $amphur = $pv->get_amphur($data['amphur']);?>
                                    <select name="amphur" id="amphur" class="form-control" aria-describedby="amphur-helpBox">
                                        <option value="">เลือกอำเภอ</option>
                                    </select>
                                    <span id="amphur-helpBox" class="help-block">อำเภอเดิมคือ <?=$amphur[0]['AMPHUR_NAME'];?></span>
                                    <input type="hidden" name="hidden_amphur_id" value="<?=$amphur[0]['AMPHUR_ID'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="district" class="control-label col-md-4">ตำบล</label>
                            <div class="col-md-8">
                                <?php $district = $pv->get_district($data['district']);?>
                                <select name="district" id="district" class="form-control" aria-describedby="district-helpBox">
                                    <option value="">เลือกตำบล</option>
                                </select>
                                <span id="district-helpBox" class="help-block">ตำบลเดิมคือ <?=$district[0]['DISTRICT_NAME'];?></span>
                                <input type="hidden" name="hidden_district_id" value="<?=$district[0]['DISTRICT_ID'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="zipcode" class="control-label col-md-4">รหัสไปรษณีย์ *</label>
                            <div class="col-md-8">
                                <input type="text" value="<?=$data['zipcode'];?>" pattern="[0-9]{5}" minlength="5" maxlength="5" size="5" name="zipcode" id="zipcode" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tel" class="control-label col-md-4">เบอร์โทรศัพท์ *</label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="tel" id="tel" cols="30" rows="5" aria-describedby="tel-helpBlock" required>
                                    <?=trim($data['tel']);?>
                                </textarea>
                                <span id="tel-helpBlock" class="help-block">กรณีมีมากกว่า 1 หมายเลขให้ขั้นด้วยเครื่องหมาย ","<br>เช่น 090-111-0xxx,090-222-0xxx เป็นต้น</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label col-md-4">อีเมล์</label>
                            <div class="col-md-8">
                                <input type="email" value="<?=$data['email'];?>" class="form-control" id="email" name="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lat" class="control-label col-md-4">Latitude</label>
                            <div class="col-md-8">
                                <input type="text" pattern="[0-9.]+" value="<?=$data['lat'];?>" name="lat" id="lat" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lng" class="control-label col-md-4">Longitude</label>
                            <div class="col-md-8">
                                <input type="text" pattern="[0-9.]+" name="lng" id="lng" value="<?=$data['lng'];?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success" onclick="return confirm('ยืนยันการบแก้ไขข้อมูลโรงพยาบาล ?')">แก้ไข</button>
                                <button class="btn btn-danger" type="reset">ยกเลิก</button>
                            </div>
                        </div>
                    </form>
                </section>
        </article>
        <script src="../js/jquery-1.11.3.min.js"></script>
        <script src="../js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
        <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../src/hospital.js"></script>
        <script src="../src/province.js"></script>
        <script src="../js/jquery.confirm-master/jquery.confirm.min.js"></script>
    </body>

    </html>
