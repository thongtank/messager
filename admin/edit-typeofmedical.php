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
use config as cfg;
$db = new cfg\database;
$sql = "select * from typeOfMedical where medical_type_id = '" . trim($_GET['id']) . "' limit 1";
$result = $db->query($sql, $rows, $num_rows);
if (!$result) {
    print $result . "<BR>";
    print "<a href='main.php'>กลับหน้าหลัก</a>";
    exit;
}

// print "<pre>" . print_r($rows, 1) . "</pre>";exit;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>แก้ไขข้อมูลประเภทการรักษา</title>
</head>

<body>
    <div class="se-pre-con"></div>
    <article class="container">
        <?php include "header.php";?>
            <section>
                <header>
                    <hgroup>
                        <h1>แก้ไขข้อมูลประเภทการรักษา</h1>
                        <h5>แบบฟอร์มแก้ไขข้อมูลประเภทการรักษา</h5>
                    </hgroup>
                </header>
            </section>
            <section class="content">
                <form action="update_typeofmedical.php" method="POST" class="form-horizontal form-register">
                    <div class="form-group">
                        <label for="medical_name" class="control-label col-md-4">ชื่อประเภทการรักษา *</label>
                        <div class="col-md-8">
                            <input type="text" value="<?=$rows[0]['medical_name'];?>" class="form-control" id="medical_name" name="medical_name" minlength="2" maxlength="255" required>
                            <input type="hidden" name="hidden_id" value="<?=$rows[0]['medical_type_id'];?>" id="hidden_id">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-success" onclick="return confirm('ยืนยันการแก้ไขข้อมูลประเภทการรักษา ?');">แก้ไข</button>
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
