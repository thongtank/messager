<?php
namespace classes;
use config\database as db;

class messages extends db {
    public function send_success($message_id = 0, $msg = '', $note = '', $db) {
        $sql = "UPDATE `tb_message` SET `status` = '" . $msg . "', `note` = '" . $note . "', date_approve = NOW(), `admin_id` = " . $_SESSION['admin_id'] . " WHERE `tb_message`.`message_id` = " . $message_id . ";";
        $result = $this->query($sql, $rows, $num_rows);
        if ($result === true) {
            header("Location: send_success.php");
        } else {
            echo $result . "<BR>";
            echo "<a href='list-msg.php'>กลับหน้าจัดการข้อความ</a>";
        }
    }

    public function insert_receive($message_id = 0, $parent_id = '', $status = '') {
        $sql = "INSERT INTO `tb_parent_receive` (`message_id`, `parent_id`, `status`, `date_receive`) VALUES ($message_id, '" . $parent_id . "', '" . $status . "', NOW());";
        $result = $this->query($sql, $rows, $num_rows);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function get_message_by_id($id = 0) {
        $sql = "SELECT * FROM tb_message WHERE message_id = " . $id . " LIMIT 1;";
        // echo $sql;
        $result = $this->query($sql, $rows, $num_rows);
        if ($result) {
            return $rows[0];
        } else {
            return false;
        }
    }
}