<?php
session_start();
if (!isset($_SESSION["teacher"]) || $_SESSION["teacher"] != "logon") {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}
// เรียกใช้คลาส autoload
include "./php/config/autoload.inc.php";

// เรียกใช้งานคลาส database
use config\database as db;

$db = new db;

if ($_POST['kind_of_send'] == 'one') {
    /**
    Array
    (
    [kind_of_send] => one
    [subject] => UTC BOT
    [message] => message utc bot
    [student_id] => 5211300204
    )
     */
    $data = array
        (
        "kind_of_send" => trim($_POST['kind_of_send']),
        "subject" => trim($_POST['subject']),
        "message" => trim($_POST['message']),
        "student_id" => trim($_POST['student_id']),
    );
    $sql = "INSERT INTO `tb_message` (`message_id`, `subject`, `message`, `date_create`, `kind_of_send`, `student_id`, `teacher_id`, `status`) VALUES (NULL, '" . $data['subject'] . "', '" . $data['message'] . "', NOW(), '" . $data['kind_of_send'] . "', '" . $data['student_id'] . "', " . $_SESSION['teacher_id'] . ", 'รออนุมัติ');";
} else {
    /**
     * Array
    (
    [kind_of_send] => group
    [subject] => UTC BOT
    [message] => Message BOT
    [department] => 1
    [branch] => 1
    [grade] => 6
    [group] => 1
    )
     */
    $data = array
        (
        "kind_of_send" => trim($_POST['kind_of_send']),
        "subject" => trim($_POST['subject']),
        "message" => trim($_POST['message']),
        "department" => trim($_POST['department']),
        "branch" => trim($_POST['branch']),
        "grade" => trim($_POST['grade']),
        "group" => trim($_POST['group']),
    );
    $sql = "INSERT INTO `tb_message` (`message_id`, `subject`, `message`, `date_create`, `kind_of_send`, `dep_id`, `branch_id`, `grade_id`, `group`, `teacher_id`, `status`) VALUES (NULL, '" . $data['subject'] . "', '" . $data['message'] . "', NOW(), '" . $data['kind_of_send'] . "', '" . $data['department'] . "', '" . $data['branch'] . "', '" . $data['grade'] . "', " . $data['group'] . ", " . $_SESSION['teacher_id'] . ", 'รออนุมัติ');";
    // echo $sql;
    // exit;
}

$result = $db->query($sql, $rows, $num_rows);
if ($result === true) {
    header("Location: insert_message_success.php");
} else {
    echo $result . "<BR>";
    echo "<a href='create-message.php'>กลับหน้าเพิ่มข้อความ</a>";
}