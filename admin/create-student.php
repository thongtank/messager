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
        <title>บันทึกข้อมูลนักเรียน</title>
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
                        <h1>บันทึกข้อมูลนักเรียน</h1>
                        <h5>แบบฟอร์มบันทึกข้อมูลนักเรียน</h5>
                    </hgroup>
                </header>
            </section>
            <section class="content">
                <form action="insert_student.php" method="POST" class="form-horizontal form-register">
                    <div class="form-group">
                        <label for="student_id" class="control-label col-md-4">รหัสประจำตัวนักเรียน *</label>
                        <div class="col-md-8">
                            <input type="text" pattern="[0-9]{10}" class="form-control" id="student_id" name="student_id" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="student_fname" class="control-label col-md-4">ชื่อ *</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="student_fname" name="student_fname" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="student_lname" class="control-label col-md-4">นามสกุล *</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="student_lname" name="student_lname" required>
                        </div>
                    </div>
                    <!-- เลือกแผนก -->
                    <div class="form-group">
                        <label for="department" class="control-label col-md-4">แผนกวิชา *</label>
                        <div class="col-md-8">
                            <select name="department" id="department" class="form-control" required>
                                <option value="">เลือกแผนกวิชา</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="branch" class="control-label col-md-4">สาขาวิชา *</label>
                        <div class="col-md-8">
                            <select name="branch" id="branch" class="form-control" required>
                                <option value="">เลือกสาขาวิชา</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="grade" class="control-label col-md-4">ระดับชั้น *</label>
                        <div class="col-md-8">
                            <select name="grade" id="grade" class="form-control" required>
                                <option value="0">เลือกระดับชั้น</option>
                                <option value="1">ปวช. 1</option>
                                <option value="2">ปวช. 2</option>
                                <option value="3">ปวช. 3</option>
                                <option value="4">ปวส. 1</option>
                                <option value="5">ปวส. 1 (ม.6)</option>
                                <option value="6">ปวส. 2</option>
                                <option value="7">ปวส. 2 (ม.6)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="group" class="control-label col-md-4">กลุ่ม *</label>
                        <div class="col-md-8">
                            <input type="number" name="group" id="group" class="form-control" required>
                        </div>
                    </div>
                    <!-- จบเลือกแผนก -->
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
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-success" onclick="return confirm('ยืนยันการบันทึกข้อมูลนักเรียน ?')">บันทึก</button>
                            <button class="btn btn-danger" type="reset">ยกเลิก</button>
                        </div>
                    </div>
                </form>
            </section>
        </article>
        <script src="../js/jquery-1.11.3.min.js"></script>
        <script src="../js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
        <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../src/student.js"></script>
        <script src="../src/department.js"></script>
        <script src="../js/jquery.confirm-master/jquery.confirm.min.js"></script>
    </body>

    </html>
