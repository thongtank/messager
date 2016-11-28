<?php
session_start();
if (!isset($_SESSION["teacher"]) || $_SESSION["teacher"] != "logon") {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}
include 'php/config/autoload.inc.php';

use config as cfg;

$db = new cfg\database;
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>สร้างข้อความ</title>
        <link rel="stylesheet" href="js/jquery-ui-1.11.4.custom/jquery-ui.min.css">
        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/mine.css">
    </head>

    <body>
        <?php include 'header.php';?>
        <article class="container">
            <section class="header">
                <header>
                    <hgroup>
                        <h1>แบบสร้างข้อความสำหรับครู</h1>
                    </hgroup>
                </header>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-success" id="show-std">ส่งแบบเดี่ยว</button>
                        <button type="button" class="btn btn-danger" id="show-grp">ส่งแบบกลุ่ม</button>
                    </div>
                </div>
                <div class="row" id="student_form">
                    <form action="insert_message.php" method="POST" role="form">
                        <input type="hidden" name="kind_of_send" value="one" id="kind_of_send">
                        <legend>สร้างข้อความส่งรายบุคคล</legend>
                        <div class="form-group">
                            <label for="subject">หัวข้อ</label>
                            <input type="text" autocomplete="off" class="form-control" id="subject" name="subject" placeholder="กรุณากรอกหัวข้อของข้อความ" required="required">
                        </div>
                        <div class="form-group">
                            <label for="message">เนื้อหา</label>
                            <textarea name="message" id="message" class="form-control" rows="3" required="required"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="student_id">รหัสนักเรียน</label>
                            <input type="text" autocomplete="off" pattern="[0-9]{10}" class="form-control" id="student_id" name="student_id" required>
                        </div>
                        <div class="form-group text-center">
                            <label for="" class="" id="student_name"></label>
                        </div>
                        <button type="submit" class="btn btn-primary">สร้างข้อความ</button>
                    </form>
                </div>
                <div class="row" id="group_form">
                    <form action="insert_message.php" method="POST" role="form">
                        <input type="hidden" name="kind_of_send" value="group" id="kind_of_send">
                        <legend>สร้างข้อความส่งรายกลุ่ม</legend>
                        <div class="form-group">
                            <label for="subject">หัวข้อ</label>
                            <input type="text" autocomplete="off" class="form-control" id="subject" name="subject" placeholder="กรุณากรอกหัวข้อของข้อความ" required="required">
                        </div>
                        <div class="form-group">
                            <label for="message">เนื้อหา</label>
                            <textarea name="message" id="message" class="form-control" rows="3" required="required"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="department" class="control-label col-md-4">แผนกวิชา *</label>
                            <div class="col-md-8">
                                <select name="department" id="department" class="form-control" required="required">
                                    <option value="">เลือกแผนกวิชา</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="branch" class="control-label col-md-4">สาขาวิชา *</label>
                            <div class="col-md-8">
                                <select name="branch" id="branch" class="form-control" required="required">
                                    <option value="">เลือกสาขาวิชา</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="grade" class="control-label col-md-4">ระดับชั้น *</label>
                            <div class="col-md-8">
                                <select name="grade" id="grade" class="form-control" required="required">
                                    <option value="">เลือกระดับชั้น</option>
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
                        <button type="submit" class="btn btn-primary">สร้างข้อความ</button>
                    </form>
                </div>
            </section>
        </article>
        <?php include 'footer.php';?>
    </body>
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="src/message.js"></script>
    <script src="src/department.js"></script>
    <script src="src/student.js"></script>

    </html>
