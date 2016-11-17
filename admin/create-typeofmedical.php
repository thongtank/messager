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
    <title>บันทึกข้อมูลประเภทการรักษา</title>
</head>

<body>
    <div class="se-pre-con"></div>
    <article class="container">
        <?php include "header.php";?>
            <section>
                <header>
                    <hgroup>
                        <h1>บันทึกข้อมูลประเภทการรักษา</h1>
                        <h5>แบบฟอร์มบันทึกข้อมูลประเภทการรักษา</h5>
                    </hgroup>
                </header>
            </section>
            <section class="content">
                <form action="insert_typeofmedical.php" method="POST" class="form-horizontal form-register">
                    <div class="form-group">
                        <label for="medical_name" class="control-label col-md-4">ชื่อประเภทการรักษา *</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="medical_name" name="medical_name" minlength="2" maxlength="255" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-success" onclick="return confirm('ยืนยันการบันทึกข้อมูลประเภทการรักษา ?');">บันทึก</button>
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
