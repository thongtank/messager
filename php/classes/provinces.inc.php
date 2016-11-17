<?php
namespace classes;
use config\database as db;

class provinces extends db {

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
    public function get_province($id) {
        $sql = "select * from province where PROVINCE_ID = " . $id . ";";
        $result = parent::query($sql, $rows, $num_rows);
        if ($result) {
            return $rows;
        } else {
            echo $result;
        }
    }

    public function get_amphur($id) {
        $sql = "select * from amphur where AMPHUR_ID = " . $id . ";";
        $result = parent::query($sql, $rows, $num_rows);
        if ($result) {
            return $rows;
        } else {
            echo $result;
        }
    }

    public function get_district($id) {
        $sql = "select * from district where DISTRICT_ID = " . $id . ";";
        $result = parent::query($sql, $rows, $num_rows);
        if ($result) {
            return $rows;
        } else {
            echo $result;
        }
    }
}