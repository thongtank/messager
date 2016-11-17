<?php
namespace classes;

use config\database as db;

Class parents extends db {

    public function get_parent($id) {
        $sql = "SELECT * FROM tb_parent WHERE parent_id = '" . $id . "' LIMIT 1;";
        $result = parent::query($sql, $rows, $num_rows);
        if ($result) {
            return $rows[0];
        }
    }
}
