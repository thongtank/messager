<?php
session_start();
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != "logon") {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
} else {
    include '../php/config/autoload.inc.php';
}
use classes as cls;
use config\database as db;

$db = new db;
$dep = new cls\department();

$sql = "select * from tb_department where dep_id = " . trim($_GET['id']) . " limit 1";
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
        <title>Admin Management</title>
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
                        <h1>แก้ไขข้อมูลแผนกวิชา</h1>
                        <h5>แบบฟอร์มแก้ไขข้อมูลแผนกวิชา</h5>
                    </hgroup>
                </header>
            </section>
            <section class="content">
                <form action="update_department.php" method="POST" class="col-md-12">
                    <input type="hidden" name="dep_id" id="dep_id" value="<?=$data['dep_id'];?>">
                    <div class="form-group">
                        <label for="department">แผนกวิชา</label>
                        <input type="text" name="department" id="department" class="form-control" placeholder="เพิ่มแผนกวิชา" required="required" value="<?=$data['dep_name'];?>">
                    </div>
                    <div class="form-group">
                        <label for="tel">Tel.</label>
                        <input type="text" name="tel" id="tel" class="form-control" placeholder="กรอกเบอร์โทรศัพท์" pattern="[0-9]{0,10}" required="required" value="<?=$data['tel'];?>">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="แก้ไขแผนก" class="btn btn-default pull-right" name="btnsubmit" id="btnsubmit">
                    </div>
                </form>
            </section>
        </article>
        <script src="../js/jquery-1.11.3.min.js"></script>
        <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../src/department.js" type="text/javascript" charset="utf-8"></script>
    </body>

    </html>
