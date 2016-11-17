<?php
session_start();
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != "logon") {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}
include '../php/config/autoload.inc.php';

use config\database as db;

// ดึงข้อมูลโรงพยาบาล
$sql = "select hospital_id, hospital_name from hospital;";
$db = new db;
$result = $db->query($sql, $rows, $num_rows);
if ($result === true) {
    $hospital = $rows;
    $result = null;
    $rows = null;
    $num_rows = null;
}

// ดึงข้อมูลประเภทการรักษาชำนาญการพิเศษ
$sql = "select medical_type_id, medical_name from typeOfMedical;";
$db = new db;
$result = $db->query($sql, $rows, $num_rows);
if ($result === true) {
    $medical_type = $rows;
    $option = "";
    foreach ($medical_type as $key => $value) {
        $option .= "<option value='" . $value['medical_type_id'] . "'>" . $value['medical_name'] . "</option>";
    }
    $result = null;
    $rows = null;
    $num_rows = null;
}

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>บันทึกข้อมูลความชำนาญพิเศษของโรงพยาบาล</title>
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
                            <h1>บันทึกข้อมูลความชำนาญการพิเศษ</h1>
                            <h5>แบบฟอร์มเพิ่มข่อมูลความชำนาญการพิเศษ</h5>
                        </hgroup>
                    </header>
                </section>
                <section class="content">
                    <form action="insert_special.php" method="POST" class="form-horizontal form-register">
                        <div class="form-group">
                            <label for="medicine_id" class="control-label col-md-4">โรงพยาบาล *</label>
                            <div class="col-md-8">
                                <select name="hospital" id="hospital" class="col-md-8 form-control" required="required">
                                    <option value="">เลือกโรงพยาบาล</option>
                                    <?php
foreach ($hospital as $key => $value) {
    print "<option value='" . $value['hospital_id'] . "'>" . $value['hospital_name'] . "</option>";
}
?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="medicine_id" class="control-label col-md-4">ความชำนาญพิเศษ 1 *</label>
                            <div class="col-md-8">
                                <select name="medical_1" id="medical_1" class="col-md-8 form-control" required>
                                    <option value="">เลือกความชำนาญพิเศษ</option>
                                    <?=$option;?>
                                </select>
                            </div>
                        </div>
                        <!--
                        <div class="form-group">
                            <label for="medicine_id" class="control-label col-md-4">ประมาณค่ารักษา</label>
                            <div class="col-md-8">
                                <div class="col-md-5">
                                    <input type="number" name="min-price-1" id="min-price-1" class="form-control">
                                </div>
                                <div class="col-md-2 text-center">
                                    <label for="" class="control-label">-</label>
                                </div>
                                <div class="col-md-5">
                                    <input type="number" name="max-price-1" id="max-price-1" class="form-control">
                                </div>
                            </div>
                        </div>
                        -->
                        <hr/>
                        <div class="form-group">
                            <label for="medicine_id" class="control-label col-md-4">ความชำนาญพิเศษ 2 (ถ้ามี)</label>
                            <div class="col-md-8">
                                <select name="medical_2" id="medical_2" class="col-md-8 form-control">
                                    <option value="">เลือกความชำนาญพิเศษ</option>
                                    <?=$option;?>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <label for="medicine_id" class="control-label col-md-4">ประมาณค่ารักษา</label>
                            <div class="col-md-8">
                                <div class="col-md-5">
                                    <input type="number" name="min-price-2" id="min-price-2" class="form-control">
                                </div>
                                <div class="col-md-2 text-center">
                                    <label for="" class="control-label">-</label>
                                </div>
                                <div class="col-md-5">
                                    <input type="number" name="max-price-2" id="max-price-2" class="form-control">
                                </div>
                            </div>
                        </div> -->
                        <!-- <hr> -->
                        <div class="form-group">
                            <label for="medicine_id" class="control-label col-md-4">ความชำนาญพิเศษ 3 (ถ้ามี)</label>
                            <div class="col-md-8">
                                <select name="medical_3" id="medical_3" class="col-md-8 form-control">
                                    <option value="">เลือกความชำนาญพิเศษ</option>
                                    <?=$option;?>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <label for="medicine_id" class="control-label col-md-4">ประมาณค่ารักษา</label>
                            <div class="col-md-8">
                                <div class="col-md-5">
                                    <input type="number" name="min-price-3" id="min-price-3" class="form-control">
                                </div>
                                <div class="col-md-2 text-center">
                                    <label for="" class="control-label">-</label>
                                </div>
                                <div class="col-md-5">
                                    <input type="number" name="max-price-3" id="max-price-3" class="form-control">
                                </div>
                            </div>
                        </div> -->
                        <!-- <hr> -->
                        <div class="form-group">
                            <label for="medicine_id" class="control-label col-md-4">ความชำนาญพิเศษ 4 (ถ้ามี)</label>
                            <div class="col-md-8">
                                <select name="medical_4" id="medical_4" class="col-md-8 form-control">
                                    <option value="">เลือกความชำนาญพิเศษ</option>
                                    <?=$option;?>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <label for="medicine_id" class="control-label col-md-4">ประมาณค่ารักษา</label>
                            <div class="col-md-8">
                                <div class="col-md-5">
                                    <input type="number" name="min-price-4" id="min-price-4" class="form-control">
                                </div>
                                <div class="col-md-2 text-center">
                                    <label for="" class="control-label">-</label>
                                </div>
                                <div class="col-md-5">
                                    <input type="number" name="max-price-4" id="max-price-4" class="form-control">
                                </div>
                            </div>
                        </div> -->
                        <!-- <hr> -->
                        <div class="form-group">
                            <label for="medicine_id" class="control-label col-md-4">ความชำนาญพิเศษ 5 (ถ้ามี)</label>
                            <div class="col-md-8">
                                <select name="medical_5" id="medical_5" class="col-md-8 form-control">
                                    <option value="">เลือกความชำนาญพิเศษ</option>
                                    <?=$option;?>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <label for="medicine_id" class="control-label col-md-4">ประมาณค่ารักษา</label>
                            <div class="col-md-8">
                                <div class="col-md-5">
                                    <input type="number" name="min-price-5" id="min-price-5" class="form-control">
                                </div>
                                <div class="col-md-2 text-center">
                                    <label for="" class="control-label">-</label>
                                </div>
                                <div class="col-md-5">
                                    <input type="number" name="max-price-5" id="max-price-5" class="form-control">
                                </div>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success" onclick="return confirm('ยืนยันการบันทึกข้อมูลความชำนาญการพิเศษ ?');">บันทึก</button>
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
