<?php
namespace classes;

use config\database as db;

Class teachers extends db {

    public function get_teacher($id) {
        $sql = "SELECT * FROM tb_teacher WHERE teacher_id = " . $id . " LIMIT 1;";
        $result = parent::query($sql, $rows, $num_rows);
        if ($result) {
            return $rows[0];
        }
    }

    public function get_teacher_by_username($username) {
        $sql = "SELECT * FROM tb_teacher WHERE teacher_username = '" . $username . "' LIMIT 1;";
        $result = parent::query($sql, $rows, $num_rows);
        if ($result) {
            return $rows[0];
        }
    }
}
