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
$dep = new cls\department;

$sql = "select * from tb_teacher where teacher_id = " . trim($_GET['id']) . " limit 1";
$result = $db->query($sql, $rows, $num_rows);
if (!$result) {
    print $result . "<BR>";
    print "<a href='main.php'>กลับหน้าหลัก</a>";
    exit;
} else {
    $data = array();
    foreach ($rows[0] as $key => $value) {
        $data[$key] = $value;
    }
}
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>แก้ไขข้อมูลนักเรียน</title>
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
                            <h1>แก้ไขข้อมูลนักเรียน</h1>
                            <h5>แบบฟอร์มแก้ไขข้อมูลนักเรียน</h5>
                        </hgroup>
                    </header>
                </section>
                <section class="content">
                    <form action="update_teacher.php" method="POST" class="form-horizontal form-register">
                        <div class="form-group">
                            <label for="teacher_username" class="control-label col-md-4">username *</label>
                            <div class="col-md-8">
                                <input type="text" value="<?=$data['teacher_username'];?>" class="form-control" id="teacher_username" name="teacher_username">
                                <input type="hidden" value="<?=$data['teacher_id'];?>" name="hidden_id" id="hidden_id">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="teacher_password" class="control-label col-md-4">password *</label>
                            <div class="col-md-8">
                                <input type="password" value="" class="form-control" id="teacher_password" name="teacher_password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="teacher_fname" class="control-label col-md-4">ชื่อ *</label>
                            <div class="col-md-8">
                                <input type="text" value="<?=$data['fname'];?>" class="form-control" id="teacher_fname" name="teacher_fname" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="teacher_lname" class="control-label col-md-4">นามสกุล *</label>
                            <div class="col-md-8">
                                <input type="text" value="<?=$data['lname'];?>" class="form-control" id="teacher_lname" name="teacher_lname" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="department" class="control-label col-md-4">แผนกวิชา</label>
                            <div class="col-md-8">
                                <?php $department = $dep->get_department($data['dep_id']);?>
                                    <select name="department" id="department" class="form-control" aria-describedby="department-helpBox">
                                        <option value="">เลือกแผนกวิชา</option>
                                    </select>
                                    <span id="department-helpBox" class="help-block">แผนกวิชาเดิมคือ <?=$department[0]['dep_name'];?></span>
                                    <input type="hidden" name="hidden_department_id" value="<?=$department[0]['dep_id'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tel" class="control-label col-md-4">เบอร์โทรศัพท์ *</label>
                            <div class="col-md-8">
                                <input type="text" pattern="[0-9,]{1,}" value="<?=trim($data['tel']);?>" class="form-control" id="tel" name="tel" required>
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
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success" onclick="return confirm('ยืนยันการบแก้ไขข้อมูลนักเรียน ?')">แก้ไข</button>
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
        <script src="../js/jquery.confirm-master/jquery.confirm.min.js"></script>
    </body>

    </html>
