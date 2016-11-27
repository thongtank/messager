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

include_once './sms.class.php';

include_once './mailer/PHPMailerAutoload.php';
$mail = new PHPMailer;

// เรียกใช้งานคลาส database
use classes as cls;
use config\database as db;

$db = new db;
$pr = new cls\parents();
$std = new cls\students();
$msg = new cls\messages();
$tc = new cls\teachers();
$dep = new cls\department();

$sql = "select * from tb_message where message_id = " . $_GET['id'] . " LIMIT 1;";
$result = $db->query($sql, $rows, $num_rows);
if ($result) {
    $teacher = $tc->get_teacher($rows[0]['teacher_id']);
    $teacher_name = $teacher['fname'] . ' ' . $teacher['lname'];
    // echo $teacher_name;exit;
    if ($rows[0]['kind_of_send'] == 'one') {
        $sql = "SELECT pr.*, pr.email as pr_email, pr.tel as pr_tel, pr.fname as pr_fname, pr.lname as pr_lname, std.*, std.email as std_email, std.tel as std_tel FROM tb_parent as pr JOIN tb_student as std ON pr.parent_id = std.parent_id WHERE std.student_id = '" . $rows[0]['student_id'] . "';";
        $result_2 = $db->query($sql, $rows_2, $num_rows_2);
        if ($result_2) {
            if ($rows_2[0]['waytoreceive'] == 'phone') {
                // ถ้าเลือกรับข้อความทางโทรศัพท์
                $username = '0875435550';
                $password = '489329261624';
                $msisdn = $rows_2[0]['pr_tel']; // เบอร์โทรผู้ปกครอง
                $message = $rows[0]['message'];
                $sender = 'SMS';
                $ScheduledDelivery = date('ymdhi');
                $force = 'standard';

                $result_sms = sms::send_sms($username, $password, $msisdn, $message, $sender, $ScheduledDelivery, $force);
                if ($result_sms) {
                    if ($msg->insert_receive($_GET['id'], $rows_2[0]['parent_id'], 'y')) {
                        $msg->send_success($_GET['id'], 'ส่งแล้ว', '', $db);
                    } else {
                        echo "ไม่สามารถอัพเดทตาราง parent_receive ได้";
                        exit;
                    }
                } else {
                    $msg->send_success($_GET['id'], 'ส่งไม่สำเร็จ', $result_sms, $db);
                    exit;
                }
            } else {
                // $mail->SMTPDebug = 2; // Enable verbose debug output
                $parent_name = $rows_2[0]['pr_fname'] . " " . $rows_2[0]['pr_lname'];
                // $mail->charSet = "UTF-8";
                $mail->isSMTP(); // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
                $mail->SMTPAuth = true; // Enable SMTP authentication
                $mail->Username = 'thongtank@gmail.com'; // SMTP username
                $mail->Password = '489329261624'; // SMTP password
                $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587; // TCP port to connect to

                $mail->setFrom('itutc@ac.th', 'อาจารย์' . $teacher_name);
                $mail->addAddress($rows_2[0]['pr_email'], $parent_name); // Add a recipient
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');

                // $mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name
                $mail->isHTML(true); // Set email format to HTML

                $mail->Subject = $rows[0]['subject'];
                $message = '<h1>เรียนคุณ ' . $parent_name . '</h1>
                    <br>
                    ' . $rows[0]['message'];
                $mail->Body = $message;
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                if (!$mail->send()) {
                    $msg->send_success($_GET['id'], 'ส่งไม่สำเร็จ', 'Mailer Error: ' . $mail->ErrorInfo, $db);
                } else {
                    if ($msg->insert_receive($_GET['id'], $rows_2[0]['parent_id'], 'y')) {
                        $msg->send_success($_GET['id'], 'ส่งแล้ว', '', $db);
                    } else {
                        echo "ไม่สามารถอัพเดทตาราง parent_receive ได้";
                        exit;
                    }
                }
            }
        } else {
            echo "Join Tables ไม่สำเร็จ <BR>" . $result_2;
            exit;
        }
    } else {
        $department = $dep->get_department($rows[0]['dep_id']);
        $department_name = $department[0]['dep_name'];
        $branch = $dep->get_branch($rows[0]['branch_id']);
        $branch_name = $branch[0]['branch_name'];
        $grade_name = $dep->get_grade($rows[0]['grade_id']);
        $group = $rows[0]['group'];
        // เมื่อส่งแบบกลุ่ม
        $sql = "SELECT pr.*, pr.email as pr_email, pr.tel as pr_tel, pr.fname as pr_fname, pr.lname as pr_lname, std.*, std.email as std_email, std.tel as std_tel FROM tb_parent as pr JOIN tb_student as std ON pr.parent_id = std.parent_id WHERE std.dep_id = " . $rows[0]['dep_id'] . " AND std.branch_id = " . $rows[0]['branch_id'] . " and std.grade_id = " . $rows[0]['grade_id'] . " AND std.group = " . $rows[0]['group'] . ";";
        $result_2 = $db->query($sql, $rows_2, $num_rows_2);
        if ($result_2) {
            if ($num_rows_2 > 0) {
                $success = 1;
                $email = 0;
                $sms = 0;
                $msisdn = '';
                foreach ($rows_2 as $key => $value) {
                    if ($value['waytoreceive'] == 'email') {
                        $email = 1;
                        $mail->addAddress($value['pr_email'], $value['pr_fname'] . " " . $value['pr_lname']); // Add a recipient
                    } else {
                        $sms = 1;
                        // ถ้าเลือกรับข้อความทางโทรศัพท์
                        $msisdn .= $value['pr_tel'] . ','; // เบอร์โทรผู้ปกครอง
                    }
                }

                if ($email == 1) {
                    // ============================== ส่งเมล์ ==============================
                    // $mail->SMTPDebug = 2; // Enable verbose debug output
                    $mail->isSMTP(); // Set mailer to use SMTP
                    $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true; // Enable SMTP authentication
                    $mail->Username = 'thongtank@gmail.com'; // SMTP username
                    $mail->Password = '489329261624'; // SMTP password
                    $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 587; // TCP port to connect to

                    $mail->setFrom('itutc@ac.th', 'อาจารย์' . $teacher_name);

                    $mail->isHTML(true); // Set email format to HTML
                    // $mail->CharSet = 'UTF-8';
                    $mail->Subject = $rows[0]['subject'];
                    $mail->Body = 'เรียนผู้ปกครองนักศึกษาระดับ ' . $grade_name . ' แผนกวิชา ' . $department_name . ' สาขาวิชา ' . $branch_name . ' กลุ่ม ' . $group . '<br>
                    <b>' . $rows[0]['message'] . '</b>';
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    if (!$mail->send()) {
                        $msg->send_success($_GET['id'], 'ส่งไม่สำเร็จ', 'Mailer Error: ' . $mail->ErrorInfo, $db);
                    } else {
                        foreach ($rows_2 as $key1 => $value2) {
                            if (!$msg->insert_receive($_GET['id'], $value2['parent_id'], 'y')) {
                                $success = 0;
                                $note = "EMAIL insert_receive Failed";
                            }
                        }
                    }
                }

                if ($sms == 1) {
                    $username = '0875435550';
                    $password = '489329261624';
                    $message = $rows[0]['message'];
                    $sender = 'SMS';
                    $ScheduledDelivery = date('ymdhi');
                    $force = 'standard';

                    $result_sms = sms::send_sms($username, $password, $msisdn, $message, $sender, $ScheduledDelivery, $force);
                    if ($result_sms) {
                        // $success3 = 1;
                        foreach ($rows_2 as $key1 => $value2) {
                            if (!$msg->insert_receive($_GET['id'], $value2['parent_id'], 'y')) {
                                $success = 0;
                                $note = "SMS insert_receive Failed";
                            }
                        }
                    } else {
                        $success = 0;
                        $note = $result_sms;
                    }
                }

                if ($success) {
                    $msg->send_success($_GET['id'], 'ส่งแล้ว', '', $db);
                } else {
                    $msg->send_success($_GET['id'], 'ส่งไม่สำเร็จ', $note, $db);
                }
            } else {
                $msg->send_success($_GET['id'], 'ส่งแล้ว', '', $db);
            }
        } else {
            $note = "ไม่พบข้อมูลผู้ปกครองของนักเรียน";
            $msg->send_success($_GET['id'], 'ส่งไม่สำเร็จ', $note, $db);
        }
    }
} else {
    echo $result . "<BR>";
    exit;
}
