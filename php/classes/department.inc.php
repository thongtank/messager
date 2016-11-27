<?php
namespace classes;
use config\database as db;

class department extends db {

    public function get_branch_by_name($branch_name = '', $dep_id = 0) {
        $sql = "SELECT * FROM `tb_branch` WHERE `branch_name` = '" . $branch_name . "' and `dep_id` = " . $dep_id . ";";
        // echo $sql;exit;
        $result = $this->query($sql, $rows, $num_rows);
        if ($result) {
            return $rows;
        }
    }

    public function get_all_province() {
        $sql = "SELECT * FROM `province` WHERE 1;";
        $result = $this->query($sql, $rows, $num_rows);
        if ($result) {
            return $rows;
        } else {
            echo "GET ALl Province error: " . $this->mysqli->error;
            return false;
        }
    }

    public function get_all_amphur() {
        $sql = "SELECT * FROM `amphur` WHERE 1;";
        $result = $this->query($sql, $rows, $num_rows);
        if ($result) {
            return $rows;
        } else {
            echo "GET ALl Amphur error: " . $this->mysqli->error;
            return false;
        }
    }

    public function get_department_by_name($name = '') {
        $sql = "select * from tb_department where dep_name = '" . $name . "';";
        $result = parent::query($sql, $rows, $num_rows);
        if ($result) {
            return $rows;
        } else {
            echo $result;
        }
    }
    public function get_department($id) {
        $sql = "select * from tb_department where dep_id = " . $id . ";";
        $result = parent::query($sql, $rows, $num_rows);
        if ($result) {
            return $rows;
        } else {
            echo $result;
        }
    }

    public function get_branch($id) {
        $sql = "select * from tb_branch where branch_id = " . $id . ";";
        $result = parent::query($sql, $rows, $num_rows);
        if ($result) {
            return $rows;
        } else {
            echo $result;
        }
    }

    public function get_grade($id) {
        $rows = 0;
        switch ($id) {
        case 1:
            $rows = "ปวช. 1";
            break;
        case 2:
            $rows = "ปวช. 2";
            break;
        case 3:
            $rows = "ปวช. 3";
            break;
        case 4:
            $rows = "ปวส. 1";
            break;
        case 5:
            $rows = "ปวส. 1 (ม.6)";
            break;
        case 6:
            $rows = "ปวส. 2";
            break;
        case 7:
            $rows = "ปวส. 2 (ม.6)";
            break;

        default:
            $rows = "ไม่พบระดับชั้นดังกล่าว";
            break;
        }
        return $rows;
    }
}