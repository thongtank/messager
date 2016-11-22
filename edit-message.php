<?php
session_start();
if (!isset($_SESSION["teacher"]) || $_SESSION["teacher"] != "logon") {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}
include 'php/config/autoload.inc.php';

use classes as cls;
use config as cfg;

$db = new cfg\database;
$ht = new cls\hospitals;
$msg = new cls\messages;
$dep = new cls\department;

$data = $msg->get_message_by_id($_GET['id']);
$department = $dep->get_department($data['dep_id']);
$department_name = $department[0]['dep_name'];
$branch = $dep->get_branch($data['branch_id']);
$branch_name = $branch[0]['branch_name'];
$grade_name = $dep->get_grade($data['grade_id']);
/*
Array
(
[message_id] => 10
[subject] => UTC BOT asdfsdfds
[message] => sfasdfsafasdf
[date_create] => 2016-11-23 00:11:08
[kind_of_send] => one
[student_id] => 5211300204
[dep_id] =>
[branch_id] =>
[grade_id] =>
[group] =>
[teacher_id] => 5
[admin_id] =>
[status] => รออนุมัติ
[note] =>
[date_approve] =>
)
 */
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>แก้ไขข้อความ</title>
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
                        <h1>แบบแก้ไขข้อความสำหรับครู</h1>
                    </hgroup>
                </header>
            </section>
            <section class="content">
                <?php if ($data['kind_of_send'] == 'one') {?>
                <div class="row" id="student_form">
                    <form action="update_message.php" method="POST" role="form">
                        <input type="hidden" name="message_id" value="<?=$data['message_id'];?>" id="message_id">
                        <input type="hidden" name="kind_of_send" value="<?=$data['kind_of_send'];?>" id="kind_of_send">
                        <legend>แก้ไขข้อความส่งรายบุคคล</legend>
                        <div class="form-group">
                            <label for="subject">หัวข้อ</label>
                            <input type="text" class="form-control" id="subject" name="subject" placeholder="กรุณากรอกหัวข้อของข้อความ" required="required" value="<?=trim($data['subject']);?>">
                        </div>
                        <div class="form-group">
                            <label for="message">หัวข้อ</label>
                            <textarea name="message" id="message" class="form-control" rows="3" required="required"><?=trim($data['message']);?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="student_id">รหัสนักเรียน</label>
                            <input type="text" pattern="[0-9]{10}" class="form-control" id="student_id" name="student_id" required value="<?=trim($data['student_id']);?>">
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-12 text-center" id="student_name"></label>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <?php } else if ($data['kind_of_send'] == 'group') {?>
                <div class="row" id="group_form">
                    <form action="update_message.php" method="POST" role="form">
                        <input type="hidden" name="message_id" value="<?=$data['message_id'];?>" id="message_id">
                        <input type="hidden" name="kind_of_send" value="<?=$data['kind_of_send'];?>" id="kind_of_send">
                        <legend>แก้ไขข้อความส่งรายกลุ่ม</legend>
                        <div class="form-group">
                            <label for="subject">หัวข้อ</label>
                            <input type="text" class="form-control" id="subject" name="subject" placeholder="กรุณากรอกหัวข้อของข้อความ" required="required" value="<?=trim($data['subject']);?>">
                        </div>
                        <div class="form-group">
                            <label for="message">หัวข้อ</label>
                            <textarea name="message" id="message" class="form-control" rows="3" required="required"><?=trim($data['message']);?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="department" class="control-label col-md-4">แผนกวิชา *</label>
                            <div class="col-md-8">
                                <select name="department" id="department" class="form-control">
                                    <option value="">เลือกแผนกวิชา</option>
                                </select>
                            </div>
                            <div class="col-md-8 col-md-offset-4">
                                <label class="control-label">แผนกเดิมคือ <?=$department_name;?></label>
                                <input type="hidden" name="dep_id" value="<?=$data['dep_id'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="branch" class="control-label col-md-4">สาขาวิชา *</label>
                            <div class="col-md-8">
                                <select name="branch" id="branch" class="form-control">
                                    <option value="">เลือกสาขาวิชา</option>
                                </select>
                            </div>
                            <div class="col-md-8 col-md-offset-4">
                                <label class="control-label">สาขาเดิมคือ <?=$branch_name;?></label>
                                <input type="hidden" name="branch_id" value="<?=$data['branch_id'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="grade" class="control-label col-md-4">ระดับชั้น *</label>
                            <div class="col-md-8">
                                <select name="grade" id="grade" class="form-control">
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
                            <div class="col-md-8 col-md-offset-4">
                                <label class="control-label">ระดับชั้นเดิมคือ <?=$grade_name;?></label>
                                <input type="hidden" name="grade_id" value="<?=$data['grade_id'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="group" class="control-label col-md-4">กลุ่ม *</label>
                            <div class="col-md-8">
                                <input type="number" name="group" id="group" class="form-control" required value="<?=$data['group'];?>">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <?php }?>
            </section>
        </article>
        <?php include 'footer.php';?>
    </body>
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- <script src="src/message.js"></script> -->
    <script src="src/department.js"></script>
    <script src="src/student.js"></script>

    </html>
