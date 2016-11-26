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
$pr = new cls\parents();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Admin Management</title>
        <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    </head>

    <body>
        <article class="container-fluid" style="">
            <?php include "header.php";?>
            <section>
                <div class="row">
                    <div class="col-md-12">
                        <form action="" method="GET" class="col-md-5 pull-right">
                            <div class="input-group">
                                <input type="text" class="form-control" name="keyword" placeholder="ค้นหานักเรียน ชื่อ, นามสกุล, รหัสนักเรียน">
                                <span class="input-group-btn"><button class="btn btn-default" type="submit">Go!</button></span>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12" style="padding-top: 10px;">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3>นักเรียน <a href="create-student.php"><i style="color: white;" class="fa fa-plus"></i></a></h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-hover">
                                    <tr>
                                        <th>รหัสประจำตัวนักเรียน</th>
                                        <th>ชื่อ - นามสกุล</th>
                                        <th>ระดับ</th>
                                        <th>แผนกวิชา</th>
                                        <th>สาขาวิชา</th>
                                        <th>กลุ่ม</th>
                                        <th>ผู้ปกครอง</th>
                                        <th colspan="2">จัดการ</th>
                                    </tr>
                                    <?php
$sql = "";
if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
    $keyword = trim($_GET['keyword']);
    $sql .= "select * from tb_student where
        fname like '%" . $keyword . "%' or
        lname like '%" . $keyword . "%' or
        student_id like '%" . $keyword . "%' ";
} else {
    $sql = "select * from tb_student ";
}
$sql .= "order by date_create desc";
$result = $db->query($sql, $rows, $num_rows);
if ($result) {
    // print "<pre>" . print_r($rows, 1) . "</pre>";
    if ($num_rows > 0) {
        foreach ($rows as $k => $v) {
            $department = $dep->get_department($v['dep_id']);
            $department_name = $department[0]['dep_name'];
            $branch = $dep->get_branch($v['branch_id']);
            $branch_name = $branch[0]['branch_name'];
            $grade_name = $dep->get_grade($v['grade_id']);
            $parent = $pr->get_parent($v['parent_id']);
            $parent_name = $parent['fname'] . ' ' . $parent['lname'];
            print "
            <tr>
                <td>" . $v['student_id'] . "</td>
                <td>" . $v['fname'] . " " . $v['lname'] . "</td>
                <td>" . $grade_name . "</td>
                <td>" . $department_name . "</td>
                <td>" . $branch_name . "</td>
                <td>" . $v['group'] . "</td>
                <td>" . $parent_name . "</td>
                <td><a href='delete-student.php?id=" . $v['student_id'] . "' onclick='return confirm(\"ยืนยันการลบข้อมูล ?\");'><i class='fa fa-trash-o'></i></a></td>
                <td><a href='edit-student.php?id=" . $v['student_id'] . "'><i class='fa fa-pencil'></i></a></td>
            </tr>
            ";
        }
    } else {
        print "
            <tr>
                <td colspan=7 align=center>ไม่พบข้อมูล</td>
            </tr>
        ";
    }
}
$result = null;
$rows = null;
$num_rows = null;
?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--
                    <div class="col-md-3 hidden-print hidden-xs hidden-sm affix" style="right: 0;">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">รายการ</h3>
                            </div>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <a href="#hospital"><i class="fa fa-heartbeat"></i> โรงพยาบาล</a>
                                </li>
                                <li class="list-group-item">
                                    <a href="#medicine"><i class="fa fa-medkit"></i> ยา</a>
                                </li>
                                <li class="list-group-item">
                                    <a href="#profile"><i class="fa fa-users"></i> สมาชิก</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    -->
            </section>
        </article>
        <script src="../js/jquery-1.11.3.min.js"></script>
        <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    </body>

    </html>
