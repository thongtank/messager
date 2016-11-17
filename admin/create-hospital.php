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
    <title>บันทึกข้อมูลโรงพยาบาล</title>
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
                    <h1>บันทึกข้อมูลโรงพยาบาล</h1>
                    <h5>แบบฟอร์มบันทึกข้อมูลโรงพยาบาล</h5>
                </hgroup>
            </header>
        </section>
        <section class="content">
            <form action="insert_hospital.php" method="POST" class="form-horizontal form-register">
                <div class="form-group">
                    <label for="hospital_verify_code" class="control-label col-md-4">ใบอนุญาตเลขที่ *</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="hospital_verify_code" name="hospital_verify_code" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="hospital_name" class="control-label col-md-4">ชื่อโรงพยาบาล *</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="hospital_name" name="hospital_name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="hospital_address" class="control-label col-md-4">ที่ตั้ง *</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="hospital_address" name="hospital_address" required="" aria-describedby="hospital_address-helpBox">
                        <span id="hospital_address-helpBox" class="help-block">บ้านเลขที่ / หมู่ ถนน ซอย ฯลฯ</span>
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
                    <label for="tel" class="control-label col-md-4">เบอร์โทรศัพท์ *</label>
                    <div class="col-md-8">
                        <textarea class="form-control" name="tel" id="tel" cols="30" rows="5" aria-describedby="tel-helpBlock" required></textarea>
                        <span id="tel-helpBlock" class="help-block">กรณีมีมากกว่า 1 หมายเลขให้ขั้นด้วยเครื่องหมาย ","<br>เช่น 090-111-0xxx,090-222-0xxx เป็นต้น</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="control-label col-md-4">อีเมล์</label>
                    <div class="col-md-8">
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="lat" class="control-label col-md-4">Latitude, Longitude</label>
                    <div class="col-md-8">
                        <input type="text" pattern="[0-9.,]+" name="latlng" id="latlng" class="form-control" aria-describedby="latlng-helpBlock">
                        <span class="help-block" id="latlng-helpBlock">เช่น 15.2407686,104.839887</span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-success" onclick="return confirm('ยืนยันการบันทึกข้อมูลโรงพยาบาล ?')">บันทึก</button>
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
