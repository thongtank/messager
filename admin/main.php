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
        <article class="container-fluid">
            <?php include "header.php";?>
            <section>
                <div class="col-md-12">
                    <div class="col-md-12">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3>ข้อมูลนักเรียน <a href="create-student.php"><i style="color: white;" class="fa fa-plus"></i></a></h3>
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
$sql = "select * from tb_student limit 10;";
$result = $db->query($sql, $rows, $num_rows);
if ($result) {
    if ($rows > 0) {
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
    }
}
$result = null;
$rows = null;
$num_rows = null;
?>
                                </table>
                            </div>
                            <div class="panel-footer text-right">
                                <a href="list-student.php">รายชื่อนักเรียนทั้งหมด</a>
                            </div>
                        </div>
                        <!-- รายชื่อครู -->
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3>ข้อมูลอาจารย์ <a href="create-teacher.php"><i style="color: white;" class="fa fa-plus"></i></a></h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-hover">
                                    <tr>
                                        <th>ชื่อ - นามสกุล</th>
                                        <th>แผนกวิชา</th>
                                        <th>Tel.</th>
                                        <th>Email</th>
                                        <th colspan="2">จัดการ</th>
                                    </tr>
                                    <?php
$sql = "select * from tb_teacher limit 10;";
$result = $db->query($sql, $rows, $num_rows);
if ($result) {
    if ($rows > 0) {
        foreach ($rows as $k => $v) {
            $department = $dep->get_department($v['dep_id']);
            $department_name = $department[0]['dep_name'];
            print "
            <tr>
                <td>" . $v['fname'] . " " . $v['lname'] . "</td>
                <td>" . $department_name . "</td>
                <td>" . $v['tel'] . "</td>
                <td>" . $v['email'] . "</td>
                <td><a href='delete-teacher.php?id=" . $v['teacher_id'] . "' onclick='return confirm(\"ยืนยันการลบข้อมูล ?\");'><i class='fa fa-trash-o'></i></a></td>
                <td><a href='edit-teacher.php?id=" . $v['teacher_id'] . "'><i class='fa fa-pencil'></i></a></td>
            </tr>
            ";
        }
    }
}
$result = null;
$rows = null;
$num_rows = null;
?>
                                </table>
                            </div>
                            <div class="panel-footer text-right">
                                <a href="list-teacher.php">รายชื่ออาจารย์ทั้งหมด</a>
                            </div>
                        </div>
                        <!-- รายชื่อผู้ปกครอง -->
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3>ข้อมูลผู้ปกครอง <a href="create-parent.php"><i style="color: white;" class="fa fa-plus"></i></a></h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-hover">
                                    <tr>
                                        <th>รหัสประจำตัวประชาชน</th>
                                        <th>ชื่อ - นามสกุล</th>
                                        <th>ช่องทางการรับข้อมูล</th>
                                        <th>Tel.</th>
                                        <th>Email</th>
                                        <th colspan="3">จัดการ</th>
                                    </tr>
                                    <?php
$sql = "select * from tb_parent limit 10;";
$result = $db->query($sql, $rows, $num_rows);
if ($result) {
    if ($rows > 0) {
        foreach ($rows as $k => $v) {
            print "
            <tr>
                <td>" . $v['parent_id'] . "</td>
                <td>" . $v['fname'] . " " . $v['lname'] . "</td>
                <td>" . $v['waytoreceive'] . "</td>
                <td>" . $v['tel'] . "</td>
                <td>" . $v['email'] . "</td>
                <td>
                    <a href='create-own.php?id=" . $v['parent_id'] . "'><i class='fa fa-group'></i></a>
                </td>
                <td>
                    <a href='edit-parent.php?id=" . $v['parent_id'] . "'><i class='fa fa-pencil'></i></a>
                </td>
                <td>
                    <a href='delete-parent.php?id=" . $v['parent_id'] . "' onclick='return confirm(\"ยืนยันการลบข้อมูล ?\");'><i class='fa fa-trash-o'></i></a>
                </td>
            </tr>
            ";
        }
    }
}
$result = null;
$rows = null;
$num_rows = null;
?>
                                </table>
                            </div>
                            <div class="panel-footer text-right">
                                <a href="list-parent.php">รายชื่อผู้ปกครองทั้งหมด</a>
                            </div>
                        </div>
                    </div>
            </section>
        </article>
        <script src="../js/jquery-1.11.3.min.js"></script>
        <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    </body>

    </html>
