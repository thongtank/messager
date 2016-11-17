<?php
namespace classes;

use config\database as db;

Class students extends db {

    public function get_student($id) {
        $sql = "SELECT * FROM tb_student WHERE student_id = " . $id . " LIMIT 1;";
        $result = parent::query($sql, $rows, $num_rows);
        if ($result) {
            return $rows[0];
        }
    }
}
