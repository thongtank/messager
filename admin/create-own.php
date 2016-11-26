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

$sql = "select * from tb_parent where parent_id = " . trim($_GET['id']) . " limit 1";
$result = $db->query($sql, $rows, $num_rows);
if (!$result) {
    print $result . "<BR>";
    print "<a href='main.php'>กลับหน้าหลัก</a>";
    exit;
} else {
    /*
    parent_id = 6
    parent_id = asdasd
    student_id = asdasd
    hospital_address = asdasd
    department = 1
    branch = 1
    grade = 1
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
        <title>เพิ่มข้อมูลการปกครอง</title>
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
                        <h1>เพิ่มข้อมูลการปกครอง</h1>
                        <h5>แบบฟอร์มเพิ่มข้อมูลการปกครอง</h5>
                    </hgroup>
                </header>
            </section>
            <section class="content">
                <form action="insert_own.php" method="POST" class="form-horizontal form-register">
                    <div class="form-group">
                        <label for="parent_id" class="control-label col-md-4">รหัสประจำตัวการปกครอง *</label>
                        <div class="col-md-8">
                            <input type="text" value="<?=$data['parent_id'];?>" class="form-control" id="parent_id" name="parent_id" disabled>
                            <input type="hidden" value="<?=$data['parent_id'];?>" name="hidden_id" id="hidden_id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="student_id" class="control-label col-md-4">รหัสนักศึกษา *</label>
                        <div class="col-md-8">
                            <input type="text" pattern="[0-9]{10}" placeholder="รหัสนักศึกษา 10 หลัก" class="form-control" id="student_id" name="student_id" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <label for="" id="student_name"></label>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 text-center">
                            <!-- <button type="submit" class="btn btn-success" id="btnown" onclick="return confirm('ยืนยันการเพิ่มข้อมูลการปกครอง ?')">เพิ่ม</button>
                            <button class="btn btn-danger" type="reset">ยกเลิก</button> -->
                            <button type="submit" class="btn btn-success" id="btnown">เพิ่ม</button>
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
