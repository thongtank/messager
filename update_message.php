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
        "message_id" => trim($_POST['message_id']),
    );
    $sql = "UPDATE tb_message SET subject = '" . $data['subject'] . "', message='" . $data['message'] . "', student_id = '" . $data['student_id'] . "' WHERE message_id = " . $data['message_id'];
    // echo $sql;exit;
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
        "message_id" => trim($_POST['message_id']),
    );
    $dep_id = ($_POST['department'] != "") ? $_POST['department'] : $_POST['dep_id'];
    $branch_id = ($_POST['branch'] != "") ? $_POST['branch'] : $_POST['branch_id'];
    $grade_id = ($_POST['grade'] != "") ? $_POST['grade'] : $_POST['grade_id'];
    $sql = "UPDATE tb_message SET subject = '" . $data['subject'] . "', message = '" . $data['message'] . "', dep_id = " . $dep_id . ", branch_id = " . $branch_id . ", grade_id = " . $grade_id . ", `group` = " . $data['group'] . " WHERE message_id = " . $data['message_id'] . ";";
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