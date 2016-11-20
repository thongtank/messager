<?php
session_start();
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] != "logon") {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}
// เรียกใช้คลาส autoload
include "../php/config/autoload.inc.php";

// เรียกใช้งานคลาส database
use classes as cls;
use config\database as db;

$db = new db;
$pr = new cls\parents();
$std = new cls\students();

if (isset($_POST['txtnote'])) {
    $sql = "UPDATE `tb_message` SET `status` = 'ไม่อนุมัติส่ง', `note` = '" . $_POST['txtnote'] . "', `date_approve` = NOW(), `admin_id` = " . $_SESSION['admin_id'] . " WHERE `tb_message`.`message_id` = " . $_POST['hidden_id'] . ";";
    $result = $db->query($sql, $rows, $num_rows);
    if ($result) {
        header("Location: inapprove_success.php");
    } else {
        print "การไม่อนุมัติล้มเหลว<BR>";
        echo "<a href='list-msg.php'>กลับหน้าเพิ่มข้อมูล</a>";
        print $result;
        exit;
    }
} else {
    $sql = "select * from tb_message where message_id = " . $_GET['id'] . " LIMIT 1;";
    $result = $db->query($sql, $rows, $num_rows);
    if (!$result) {
        print $result;
        exit;
    }
}
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>ไม่อนุมัติการส่งข้อความ</title>
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
                        <h1>เหตุผลที่ไม่อนุมัติ ข้อความเลขที่ <?=$rows[0]['message_id'];?></h1>
                    </hgroup>
                </header>
            </section>
            <section class="content">
                <form action="<?=$_SERVER['PHP_SELF'];?>" method="POST" class="form-horizontal form-register">
                    <div class="form-group">
                        <label for="txtnote" class="control-label col-md-4">เหตุผลที่ไม่อนุมัติคือ *</label>
                        <div class="col-md-8">
                            <textarea name="txtnote" id="txtnote" class="form-control" rows="3" required="required"></textarea>
                            <input type="hidden" name="hidden_id" value="<?php echo $_GET['id']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-success" onclick="return confirm('ยืนยันการไม่อนุมัติส่งข้อความ ?')">ยืนยัน</button>
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
