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
        <title>บันทึกข้อมูลผู้ปกครอง</title>
        <link rel="stylesheet" href="../js/jquery-ui-1.11.4.custom/jquery-ui.min.css">
        <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/mine.css">
    </head>

    <body>
        <article class="container">
            <?php include "header.php";?>
            <section>
                <header>
                    <hgroup>
                        <h1>บันทึกข้อมูลผู้ปกครอง</h1>
                        <h5>แบบฟอร์มบันทึกข้อมูลผู้ปกครอง</h5>
                    </hgroup>
                </header>
            </section>
            <section class="content">
                <form action="insert_parent.php" method="POST" class="form-horizontal form-register">
                    <div class="form-group">
                        <label for="parent_id" class="control-label col-md-4">รหัสประชาชนผู้ปกครอง *</label>
                        <div class="col-md-8">
                            <input type="text" autocomplete="off" pattern="[0-9]{13}" class="form-control" id="parent_id" name="parent_id" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" id="parent_already" class="control-label col-md-12 text-danger"></label>
                    </div>
                    <div class="form-group">
                        <label for="parent_fname" class="control-label col-md-4">ชื่อ *</label>
                        <div class="col-md-8">
                            <input type="text" autocomplete="off" class="form-control" id="parent_fname" name="parent_fname" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="parent_lname" class="control-label col-md-4">นามสกุล *</label>
                        <div class="col-md-8">
                            <input type="text" autocomplete="off" class="form-control" id="parent_lname" name="parent_lname" required>
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
                            <input type="email" class="form-control" id="email" autocomplete="off" name="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label col-md-4">ช่องทางการรับข้อความ</label>
                        <div class="col-md-8">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="radio_receive" value="phone" checked=""> ข้อความ
                                </label>
                                &nbsp;&nbsp;&nbsp;
                                <label>
                                    <input type="radio" name="radio_receive" value="email"> อีเมล์
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 text-center">
                            <!-- <button type="submit" class="btn btn-success" onclick="return confirm('ยืนยันการบันทึกข้อมูลผู้ปกครอง ?')">บันทึก</button>
                            <button class="btn btn-danger" type="reset">ยกเลิก</button> -->
                            <button type="submit" class="btn btn-success">บันทึก</button>
                            <button class="btn btn-danger" type="reset">ยกเลิก</button>
                        </div>
                    </div>
                </form>
            </section>
        </article>
        <script src="../js/jquery-1.11.3.min.js"></script>
        <script src="../js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
        <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../src/parent.js"></script>
        <script src="../js/jquery.confirm-master/jquery.confirm.min.js"></script>
    </body>

    </html>
