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
$sql = "select * from medicine where medicine_id = '" . trim($_GET['id']) . "' limit 1";
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
    // exit;
    /*
Array
(
[medicine_id] => 2A 148/2546
[medicine_name_th] => ขี้ผึ้งแก้ปวดบวม
[medicine_name_eng] => -
[medicine_type] => ยาขี้ผึ้งหรือครีม
[medicine_type_control] => ยาสามัญ
[medicine_detail] => บรรเทาอาการปวดบวมอักเสบเนื่องจากแมลงกัดต่อย หรือปวดเมื่อยกล้ามเนื้อ
[medicine_chemical] => MENTHOL  10.00 G
METHYL SALICYLATE   50.00 G
EUCALYPTUS OIL  3.00 G
[medicine_status] => คงอยู่
[medicine_use] => ภายนอก
[owner_name] => บริษัทมิลลิเมด  จำกัด
[company_name] => บริษัท มิลลิเมด  จำกัด
[company_address] => 193  ม.1   ซ.-  ถ.สุขสวัสดิ์
[company_province] => 2
[company_amphur] => 56
[company_district] => 296
[company_zipcode] => 10290
[tel] => 0 2461 1027
[date_added] => 2015-10-28 20:27:28
)
 */
}
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>แก้ไขข้อมูลยา</title>
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
                            <h1>แก้ไขข้อมูลยา</h1>
                            <h5>แบบฟอร์มเพิ่มข่อมูลยา</h5>
                        </hgroup>
                    </header>
                </section>
                <section class="content">
                    <form action="update_medicine.php" method="POST" class="form-horizontal form-register">
                        <div class="form-group">
                            <label for="medicine_id" class="control-label col-md-4">เลขทะเบียนยา *</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" value="<?=$data['medicine_id'];?>" id="medicine_id" name="medicine_id" pattern="[a-zA-Z0-9_/+- ]{1,30}" required>
                                <input type="hidden" name="hidden_id" id="hidden_id" value="<?=$data['medicine_id'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="medicine_name_th" class="control-label col-md-4">ชื่อตัวยา (ไทย) *</label>
                            <div class="col-md-8">
                                <input type="text" value="<?=$data['medicine_name_th'];?>" class="form-control" id="medicine_name_th" name="medicine_name_th" aria-describedby="medicine_name_th-helpBox" required>
                                <span id="medicine_name_th-helpBox" class="help-block">กรณีไม่มีชื่อให้กรอกเครื่องหมายลบ "-"</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="medicine_name_eng" class="control-label col-md-4">ชื่อตัวยา (อังกฤษ) *</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" value="<?=$data['medicine_name_eng'];?>" id="medicine_name_eng" name="medicine_name_eng" aria-describedby="medicine_name_eng-helpBox" pattern="[a-zA-Z_/+- ]{1,255}" required>
                                <span id="medicine_name_eng-helpBox" class="help-block">กรณีไม่มีชื่อให้กรอกเครื่องหมายลบ "-"</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label col-md-4">รูปแบบของตัวยา</label>
                            <div class="col-md-8">
                                <?php
$checked_medicine_type[1] = "";
$checked_medicine_type[2] = "";
$checked_medicine_type[3] = "";
if ($data['medicine_type'] == "ยาน้ำ") {
    $checked_medicine_type[1] = "checked";
} elseif ($data['medicine_type'] == "ยาเม็ด") {
    $checked_medicine_type[2] = "checked";
} else {
    $checked_medicine_type[3] = "checked";
}
?>
                                    <label class="radio-inline">
                                        <input type="radio" name="medicine_type" id="medicine_type" value="ยาน้ำ" <?=$checked_medicine_type[1];?>> ยาน้ำ
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="medicine_type" id="medicine_type" value="ยาเม็ด" <?=$checked_medicine_type[2];?>> ยาเม็ด
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="medicine_type" id="medicine_type" value="ยาขี้ผึ้งหรือครีม" <?=$checked_medicine_type[3];?>> ยาขี้ผึ้งหรือครีม
                                    </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label col-md-4">การใช้ยา</label>
                            <div class="col-md-8">
                                <?php
$checked_medicine_use[1] = "";
$checked_medicine_use[2] = "";
if ($data['medicine_use'] == "ภายนอก") {
    $checked_medicine_use[1] = "checked";
} else {
    $checked_medicine_use[2] = "checked";
}
?>
                                    <label class="radio-inline">
                                        <input type="radio" name="medicine_use" id="medicine_use" value="ภายนอก" <?=$checked_medicine_use[1];?>> ภายนอก
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="medicine_use" id="medicine_use" value="ภายใน" <?=$checked_medicine_use[2];?>> ภายใน
                                    </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label col-md-4">ชนิดของยาควบคุมตามกฎหมาย</label>
                            <div class="col-md-8">
                                <?php
$checked_medicine_type_control[1] = "";
$checked_medicine_type_control[2] = "";
if ($data['medicine_type_control'] == "ยาสามัญ") {
    $checked_medicine_type_control[1] = "checked";
} else {
    $checked_medicine_type_control[2] = "checked";
}
?>
                                    <label class="radio-inline">
                                        <input type="radio" name="medicine_type_control" id="medicine_type_control" value="ยาสามัญ" <?=$checked_medicine_type_control[1];?>> ยาสามัญ
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="medicine_type_control" id="medicine_type_control" value="ยาอันตราย" <?=$checked_medicine_type_control[2];?>> ยาอันตราย
                                    </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label col-md-4">สถานะการผลิต</label>
                            <div class="col-md-8">
                                <?php
$checked_medicine_status[1] = "";
$checked_medicine_status[2] = "";
if ($data['medicine_status'] == "คงอยู่") {
    $checked_medicine_status[1] = "checked";
} else {
    $checked_medicine_status[2] = "checked";
}
?>
                                    <label class="radio-inline">
                                        <input type="radio" name="medicine_status" id="medicine_status" value="คงอยู่" <?=$checked_medicine_status[1];?>> คงอยู่
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="medicine_status" id="medicine_status" value="ยกเลิก" <?=$checked_medicine_status[2];?>> ยกเลิก
                                    </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="medicine_detail" class="control-label col-md-4">รายละเอียดตัวยา *</label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="medicine_detail" id="medicine_detail" cols="30" rows="5" aria-describedby="medicine_detail-helpBox" required>
                                    <?=$data['medicine_detail'];?>
                                </textarea>
                                <span id="medicine_detail-helpBox" class="help-block">รายละเอียดของตัวยาอย่างละเอียด เช่น บรรเทาอาการ, แพ้อะไรห้ามรับประทาน เป็นต้น</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="medicine_chemical" class="control-label col-md-4">สารประกอบตัวยา *</label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="medicine_chemical" id="medicine_chemical" cols="30" rows="5" aria-describedby="medicine_chemical-helpBox" reqiured>
                                    <?=$data['medicine_chemical'];?>
                                </textarea>
                                <span id="medicine_chemical-helpBox" class="help-block">รายละเอียดสารประกอบตัวยาอย่างละเอียด (ถ้ามี)</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="owner_name" class="control-label col-md-4">ชื่อผู้รับอนุญาต *</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="owner_name" name="owner_name" value="<?=$data['owner_name'];?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="company_name" class="control-label col-md-4">ชื่อสถานที่ *</label>
                            <div class="col-md-8">
                                <input type="text" value="<?=$data['company_name'];?>" class="form-control" id="company_name" name="company_name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="company_address" class="control-label col-md-4">ที่ตั้ง *</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="company_address" name="company_address" aria-describedby="company_address-helpBox" required value="<?=$data['company_address'];?>">
                                <span id="company_address-helpBox" class="help-block">เลขที่, หมู่, ถนน, ซอย ฯลฯ</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="province" class="control-label col-md-4">จังหวัด</label>
                            <div class="col-md-8">
                                <select name="province" id="province" class="form-control" aria-describedby="province-helpBox">
                                    <option value="">เลือกจังหวัด</option>
                                </select>
                                <?php
$pv = new cls\provinces;
$province = $pv->get_province($data['company_province']);
/*
Array
(
[0] => Array
(
[PROVINCE_ID] => 1
[PROVINCE_CODE] => 10
[PROVINCE_NAME] => กรุงเทพมหานคร
[GEO_ID] => 2
)

)
 */
?>
                                    <span id="province-helpBox" class="help-block">จังหวัดเดิมคือ <?=$province[0]['PROVINCE_NAME'];?></span>
                                    <input type="hidden" name="hidden_province_id" value="<?=$province[0]['PROVINCE_ID'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="amphur" class="control-label col-md-4">อำเภอ</label>
                            <div class="col-md-8">
                                <?php
$pv = new cls\provinces;
$amphur = $pv->get_amphur($data['company_amphur']);
?>
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
                                <?php
$pv = new cls\provinces;
$district = $pv->get_district($data['company_district']);
?>
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
                                <input type="text" pattern="[0-9]{5}" minlength="5" maxlength="5" size="5" name="zipcode" id="zipcode" class="form-control" value="<?=$data['company_zipcode'];?>" required>
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
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success" onclick="return confirm('ยืนยันการแก้ไขข้อมูลยา ?');">แก้ไข</button>
                                <button class="btn btn-danger" type="reset">ยกเลิก</button>
                            </div>
                        </div>
                    </form>
                </section>
        </article>
        <script src="../js/jquery-1.11.3.min.js"></script>
        <script src="../js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
        <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../src/province.js"></script>
        <script src="../js/jquery.confirm-master/jquery.confirm.min.js"></script>
    </body>

    </html>
