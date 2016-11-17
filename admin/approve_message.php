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

$sql = "select * from tb_message where message_id = " . $_GET['id'] . " LIMIT 1;";
$result = $db->query($sql, $rows, $num_rows);
if ($result) {
    if ($rows[0]['kind_of_send'] == 'one') {
        $sql = "SELECT pr.*, pr.email as pr_email, pr.tel as pr_tel, std.*, std.email as std_email, std.tel as std_tel FROM tb_parent as pr JOIN tb_student as std ON pr.parent_id = std.parent_id WHERE std.student_id = '" . $rows[0]['student_id'] . "';";
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
                    send_success('ส่งแล้ว', '', $db);
                } else {
                    // print $result_sms;
                    send_success('ส่งไม่สำเร็จ', $result_sms, $db);
                    exit;
                }
            } else {

                // $mail->SMTPDebug = 2; // Enable verbose debug output

                $mail->isSMTP(); // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
                $mail->SMTPAuth = true; // Enable SMTP authentication
                $mail->Username = 'thongtank@gmail.com'; // SMTP username
                $mail->Password = '489329261624'; // SMTP password
                $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587; // TCP port to connect to

                $mail->setFrom('itutc@ac.th', 'IT UTC');
                $mail->addAddress($rows_2[0]['pr_email'], 'WTF'); // Add a recipient
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');

                // $mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name
                $mail->isHTML(true); // Set email format to HTML

                $mail->Subject = $rows[0]['subject'];
                $mail->Body = '<h1>' . $rows[0]['message'] . '</h1>';
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                if (!$mail->send()) {
                    // echo 'Message could not be sent.';
                    // echo 'Mailer Error: ' . $mail->ErrorInfo;
                    send_success('ส่งไม่สำเร็จ', 'Mailer Error: ' . $mail->ErrorInfo, $db);
                } else {
                    // echo 'Message has been sent';
                    send_success('ส่งแล้ว', '', $db);
                }
            }
        }
    } else {

    }
} else {
    echo $result . "<BR>";
    exit;
}

function send_success($msg = '', $note = '', $db) {
    $sql = "UPDATE `tb_message` SET `status` = '" . $msg . "', `note` = '" . $note . "', date_approve = 'NOW()' WHERE `tb_message`.`message_id` = " . $_GET['id'] . ";";
    $result = $db->query($sql, $rows, $num_rows);
    if ($result === true) {
        header("Location: send_success.php");
    } else {
        echo $result . "<BR>";
        echo "<a href='list-msg.php'>กลับหน้าเพิ่มข้อมูล</a>";
    }
}
