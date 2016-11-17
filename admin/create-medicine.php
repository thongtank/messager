<?php
session_start();
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != "logon") {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>บันทึกข้อมูลยา</title>
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
                        <h1>บันทึกข้อมูลยา</h1>
                        <h5>แบบฟอร์มเพิ่มข่อมูลยา</h5>
                    </hgroup>
                </header>
            </section>
            <section class="content">
                <form action="insert_medicine.php" method="POST" class="form-horizontal form-register">
                    <div class="form-group">
                        <label for="medicine_id" class="control-label col-md-4">เลขทะเบียนยา *</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="medicine_id" name="medicine_id" pattern="[a-zA-Z0-9_/+- ]{1,30}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="medicine_name_th" class="control-label col-md-4">ชื่อตัวยา (ไทย) *</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="medicine_name_th" name="medicine_name_th" aria-describedby="medicine_name_th-helpBox" required>
                            <span id="medicine_name_th-helpBox" class="help-block">กรณีไม่มีชื่อให้กรอกเครื่องหมายลบ "-"</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="medicine_name_eng" class="control-label col-md-4">ชื่อตัวยา (อังกฤษ) *</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="medicine_name_eng" name="medicine_name_eng" aria-describedby="medicine_name_eng-helpBox" pattern="[a-zA-Z_/+- ]{1,255}" required>
                            <span id="medicine_name_eng-helpBox" class="help-block">กรณีไม่มีชื่อให้กรอกเครื่องหมายลบ "-"</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-md-4">รูปแบบของตัวยา</label>
                        <div class="col-md-8">
                            <label class="radio-inline">
                                <input type="radio" name="medicine_type" id="medicine_type" value="ยาน้ำ" checked="checked"> ยาน้ำ
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="medicine_type" id="medicine_type" value="ยาเม็ด"> ยาเม็ด
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="medicine_type" id="medicine_type" value="ยาขี้ผึ้งหรือครีม"> ยาขี้ผึ้งหรือครีม
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-md-4">การใช้ยา</label>
                        <div class="col-md-8">
                            <label class="radio-inline">
                                <input type="radio" name="medicine_use" id="medicine_use" value="ภายนอก" checked="checked"> ภายนอก
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="medicine_use" id="medicine_use" value="ภายใน"> ภายใน
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-md-4">ชนิดของยาควบคุมตามกฎหมาย</label>
                        <div class="col-md-8">
                            <label class="radio-inline">
                                <input type="radio" name="medicine_type_control" id="medicine_type_control" value="ยาสามัญ" checked="checked"> ยาสามัญ
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="medicine_type_control" id="medicine_type_control" value="ยาอันตราย"> ยาอันตราย
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-md-4">สถานะการผลิต</label>
                        <div class="col-md-8">
                            <label class="radio-inline">
                                <input type="radio" name="medicine_status" id="medicine_status" value="คงอยู่" checked="checked"> คงอยู่
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="medicine_status" id="medicine_status" value="ยกเลิก"> ยกเลิก
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="medicine_detail" class="control-label col-md-4">รายละเอียดตัวยา *</label>
                        <div class="col-md-8">
                            <textarea class="form-control" name="medicine_detail" id="medicine_detail" cols="30" rows="5" aria-describedby="medicine_detail-helpBox" required></textarea>
                            <span id="medicine_detail-helpBox" class="help-block">รายละเอียดของตัวยาอย่างละเอียด เช่น บรรเทาอาการ, แพ้อะไรห้ามรับประทาน เป็นต้น</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="medicine_chemical" class="control-label col-md-4">สารประกอบตัวยา *</label>
                        <div class="col-md-8">
                            <textarea class="form-control" name="medicine_chemical" id="medicine_chemical" cols="30" rows="5" aria-describedby="medicine_chemical-helpBox" reqiured></textarea>
                            <span id="medicine_chemical-helpBox" class="help-block">รายละเอียดสารประกอบตัวยาอย่างละเอียด (ถ้ามี)</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="owner_name" class="control-label col-md-4">ชื่อผู้รับอนุญาต *</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="owner_name" name="owner_name" required>
                            <span id="" class="help-block">กรณีไม่มีชื่อให้กรอกเครื่องหมายลบ "-"</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="company_name" class="control-label col-md-4">ชื่อสถานที่ *</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="company_name" name="company_name" required>
                            <span id="" class="help-block">กรณีไม่มีชื่อให้กรอกเครื่องหมายลบ "-"</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="company_address" class="control-label col-md-4">ที่ตั้ง *</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="company_address" name="company_address" aria-describedby="company_address-helpBox" required>
                            <span id="company_address-helpBox" class="help-block">เลขที่, หมู่, ถนน, ซอย ฯลฯ</span>
                            <span id="" class="help-block">กรณีไม่มีชื่อให้กรอกเครื่องหมายลบ "-"</span>
                        </div>
                    </div>
                    <div class="form-group">
                    <label for="province" class="control-label col-md-4">จังหวัด *</label>
                    <div class="col-md-8">
                        <select name="province" id="province" class="form-control" required>
                            <option value="">เลือกจังหวัด</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="amphur" class="control-label col-md-4">อำเภอ *</label>
                    <div class="col-md-8">
                        <select name="amphur" id="amphur" class="form-control" required>
                            <option value="">เลือกอำเภอ</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="district" class="control-label col-md-4">ตำบล *</label>
                    <div class="col-md-8">
                        <select name="district" id="district" class="form-control" required>
                            <option value="">เลือกตำบล</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="zipcode" class="control-label col-md-4">รหัสไปรษณีย์ *</label>
                    <div class="col-md-8">
                        <input type="text" pattern="[0-9]{5}" minlength="5" maxlength="5" size="5" name="zipcode" id="zipcode" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tel" class="control-label col-md-4">เบอร์โทรศัพท์</label>
                    <div class="col-md-8">
                        <textarea class="form-control" name="tel" id="tel" cols="30" rows="5" aria-describedby="tel-helpBlock"></textarea>
                        <span id="tel-helpBlock" class="help-block">กรณีมีมากกว่า 1 หมายเลขให้ขั้นด้วยเครื่องหมาย ","<br>เช่น 090-111-0xxx,090-222-0xxx เป็นต้น</span>
                    </div>
                </div>
                    <div class="form-group">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-success" onclick="return confirm('ยืนยันการบันทึกข้อมูลยา ?');">บันทึก</button>
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
