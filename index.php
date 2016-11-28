<?php
session_start();
include "./php/config/autoload.inc.php";

// เรียกใช้งานคลาส database
use classes as cls;
use config\database as db;
$db = new db;
$dep = new cls\department;
$tc = new cls\teachers;
$std = new cls\students;
$pr = new cls\parents;
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>ระบบแจ้งข้อมูลข่าวสารวิทยาลัยเทคนิคอุบลราชธานี</title>
        <link rel="stylesheet" href="js/jquery-ui-1.11.4.custom/jquery-ui.min.css">
        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
        <link rel="stylesheet" href="css/mine.css">
        <style>
        div.menu {
            /* height: 200px; */
            padding-top: 20px;
            padding-bottom: 20px;
        }
        </style>
        <script type="text/javascript">
        function inapprove_popup(message) {
            alert("เหตุผลที่ไม่อนุมัติคือ \"" + message + "\"");
        }
        </script>
    </head>

    <body>
        <?php include "header.php";?>
        <article class="container-fluid">
            <section class="container-fluid">
                <div class="col-md-12 menu text-center">
                    <?php if (!isset($_SESSION['teacher_id'])) {?>
                    <form action="php/login.php" method="POST" class="form-horizontal">
                        <div class="form-group">
                            <h1 class="text-center"><i class="fa fa-user fa-5x"></i></h1>
                            <h1 class="text-center">Teacher Login</h1>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="text" autocomplete="off" pattern="[a-zA-Z0-9_]{2,12}" class="form-control" id="username" name="username" placeholder="Username" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="password" pattern="[a-zA-Z0-9_]{2,12}" class="form-control" id="password" name="password" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-default">เข้าสู่ระบบ</button>
                            </div>
                        </div>
                    </form>
                    <?php } else {
    ?>
                    <div class="col-md-12 menu text-center">
                        <a href="create-message.php" title="ประเมินการรักษา">
                            <i class="fa fa-plus fa-5x text-success"></i>
                            <h1 class="text-success">สร้างข้อความ</h1>
                        </a>
                    </div>
                    <div class="col-md-12" style="padding-top: 10px;">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <h3>จัดการข้อความ</h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-hover">
                                    <tr>
                                        <th>หัวข้อ</th>
                                        <th>ข้อความ</th>
                                        <th>ช่องทางการส่ง</th>
                                        <th>ผู้รับ</th>
                                        <th>วันที่สร้าง</th>
                                        <th>สถานะ</th>
                                        <th colspan="2">จัดการ</th>
                                    </tr>
                                    <?php
$sql = "";
    $sql = "select * from tb_message where `teacher_id` = " . $_SESSION['teacher_id'] . " ";
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
                    $receive_name = $department_name . ' ' . $grade_name . '/' . $v['group'];
                }

                $status = $v['status'];
                if ($v['status'] == 'ส้งแล้ว') {

                } else if ($v['status'] == 'ไม่อนุมัติส่ง') {
                    $status = "<a href='#' onClick='inapprove_popup(\"" . $v['note'] . "\");'>ไม่อนุมัติส่ง</a>";
                }
                $delete_link = "";
                $edit_link = "";
                print "
            <tr>
                <td align=left>" . $v['subject'] . "</td>
                <td align=left>" . $v['message'] . "</td>
                <td align=left>" . $kind_of_send . "</td>
                <td align=left>" . $receive_name . "</td>
                <td align=left>" . $v['date_create'] . "</td>
                <td align=left>" . $status . "</td>";
                if ($status == "รออนุมัติ") {
                    $delete_link = "
                    <a title='ลบข้อความ' href='delete_message.php?id=" . $v['message_id'] . "' onclick='return confirm(\"ยืนยันการลบข้อความ " . $v['subject'] . " ?\");'><i class='fa fa-trash' aria-hidden='true'></i></a>
                ";
                    $edit_link = "
                    <a title='แก้ไขข้อความ' href='edit-message.php?id=" . $v['message_id'] . "'><i class='fa fa-pencil' aria-hidden='true'></i></a>
                ";
                } else {

                }
                print "
                <td align=left>
                    " . $delete_link . "
                </td>
                <td align=left>
                    " . $edit_link . "
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
                    <?php }?>
                </div>
            </section>
        </article>
        <?php include 'footer.php';?>
        <script src="js/jquery-1.11.3.min.js"></script>
        <script src="js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
        <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    </body>

    </html>
