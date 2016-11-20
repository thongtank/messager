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
$std = new cls\students();
$dep = new cls\department();
$tc = new cls\teachers();
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
                    <!-- <div class="col-md-12">
                        <form action="" method="GET" class="col-md-5 pull-right">
                            <div class="input-group">
                                <input type="text" class="form-control" name="keyword" placeholder="ค้นหาข้อความ ชื่อ, นามสกุล, รหัสข้อความ">
                                <span class="input-group-btn"><button class="btn btn-default" type="submit">Go!</button></span>
                            </div>
                        </form>
                    </div> -->
                    <div class="col-md-12" style="padding-top: 10px;">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <h3>จัดการข้อความ</h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-hover">
                                    <tr>
                                        <th>ข้อความ</th>
                                        <th>ผู้สร้าง</th>
                                        <th>ช่องทางการส่ง</th>
                                        <th>ผู้รับ</th>
                                        <th>วันที่สร้าง</th>
                                        <th>สถานะ</th>
                                        <th colspan="2">จัดการ</th>
                                    </tr>
                                    <?php
$sql = "";
$sql = "select * from tb_message ";
$sql .= "order by date_create desc";
$result = $db->query($sql, $rows, $num_rows);
if ($result) {
    if ($num_rows > 0) {
        foreach ($rows as $k => $v) {
            $department = $dep->get_department($v['dep_id']);
            $department_name = $department[0]['dep_name'];
            $branch = $dep->get_branch($v['branch_id']);
            $branch_name = $branch[0]['branch_name'];
            $grade_name = $dep->get_grade($v['grade_id']);
            $teacher = $tc->get_teacher($v['teacher_id']);
            $teacher_name = $teacher['fname'] . ' ' . $teacher['lname'];
            if ($v['kind_of_send'] == 'one') {
                $kind_of_send = 'รายบุคคล';
                $student = $std->get_student($v['student_id']);
                $parent = $pr->get_parent($student['parent_id']);
                $receive_name = $parent['fname'] . ' ' . $parent['lname'];
            } else {
                $kind_of_send = 'กลุ่ม';
            }
            if ($v['status'] == 'ส้งแล้ส') {

            }
            print "
            <tr>
                <td>" . $v['message'] . "</td>
                <td>" . $teacher_name . "</td>
                <td>" . $kind_of_send . "</td>
                <td>" . $receive_name . "</td>
                <td>" . $v['date_create'] . "</td>
                <td>" . $v['status'] . "</td>
                <td>
                    <a title='อนุมัติส่งข้อความ' href='approve_message.php?id=" . $v['message_id'] . "' onclick='return confirm(\"ยืนยันการอนุมัติส่งข้อความ ?\");'><i class='fa fa-thumbs-o-up' aria-hidden='true'></i></a>
                </td>
                <td>
                    <a title='ไม่อนุมัติส่งข้อความ' href='inapprove_message.php?id=" . $v['message_id'] . "'><i class='fa fa-thumbs-o-down' aria-hidden='true'></i></a>
                </td>
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
            </section>
        </article>
        <script src="../js/jquery-1.11.3.min.js"></script>
        <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    </body>
    </html>