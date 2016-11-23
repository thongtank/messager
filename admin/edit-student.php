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

$sql = "select * from tb_student where student_id = " . trim($_GET['id']) . " limit 1";
$result = $db->query($sql, $rows, $num_rows);
if (!$result) {
	print $result . "<BR>";
	print "<a href='main.php'>กลับหน้าหลัก</a>";
	exit;
} else {
	/*
		    student_id = 6
		    student_id = asdasd
		    student_fname = asdasd
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
                    <form action="update_student.php" method="POST" class="form-horizontal form-register">
                        <div class="form-group">
                            <label for="student_id" class="control-label col-md-4">รหัสประจำตัวนักเรียน *</label>
                            <div class="col-md-8">
                                <input type="text" value="<?=$data['student_id'];?>" class="form-control" id="student_id" name="student_id">
                                <input type="hidden" value="<?=$data['student_id'];?>" name="hidden_id" id="hidden_id">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="student_fname" class="control-label col-md-4">ชื่อ *</label>
                            <div class="col-md-8">
                                <input type="text" value="<?=$data['fname'];?>" class="form-control" id="student_fname" name="student_fname" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="student_lname" class="control-label col-md-4">นามสกุล *</label>
                            <div class="col-md-8">
                                <input type="text" value="<?=$data['lname'];?>" class="form-control" id="student_lname" name="student_lname" required>
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
                            <label for="branch" class="control-label col-md-4">สาขาวิชา</label>
                            <div class="col-md-8">
                                <?php $branch = $dep->get_branch($data['branch_id']);?>
                                    <select name="branch" id="branch" class="form-control" aria-describedby="branch-helpBox">
                                        <option value="">เลือกสาขาวิชา</option>
                                    </select>
                                    <span id="branch-helpBox" class="help-block">สาขาวิชาเดิมคือ <?=$branch[0]['branch_name'];?></span>
                                    <input type="hidden" name="hidden_branch_id" value="<?=$branch[0]['branch_id'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="grade" class="control-label col-md-4">ระดับชั้น</label>
                            <div class="col-md-8">
                                <?php $grade = $dep->get_grade($data['grade_id']);?>
                                <select name="grade" id="grade" class="form-control" aria-describedby="grade-helpBox">
                                    <option value="0">เลือกระดับชั้น</option>
                                    <option value="1">ปวช. 1</option>
                                    <option value="2">ปวช. 2</option>
                                    <option value="3">ปวช. 3</option>
                                    <option value="4">ปวส. 1</option>
                                    <option value="5">ปวส. 1 (ม.6)</option>
                                    <option value="6">ปวส. 2</option>
                                    <option value="7">ปวส. 2 (ม.6)</option>
                                </select>
                                <span id="grade-helpBox" class="help-block">ระดับชั้นเดิมคือ <?=$grade;?></span>
                                <input type="hidden" name="hidden_grade_id" value="<?=$data['grade_id'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="group" class="control-label col-md-4">กลุ่ม *</label>
                            <div class="col-md-8">
                                <input type="number" value="<?=$data['group'];?>" name="group" id="group" class="form-control" required>
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
        <script src="../src/department.js"></script>
        <script src="../js/jquery.confirm-master/jquery.confirm.min.js"></script>
    </body>

    </html>
