<?php
namespace classes;

use config\database as db;

Class profiles extends db {

    public $pf = array();

    public function get_profile($id) {
        $sql = "SELECT * FROM profile WHERE profile_id = " . $id . " LIMIT 1;";
        $result = parent::query($sql, $rows, $num_rows);
        if ($result) {
            return $rows[0];
        }
    }

    public function get_age() {
        return date_diff(date_create($this->pf['birthday']), date_create(date("Y-m-d")))->format("%y");
    }

    public function convert_birthday($bd = "", $arr_month = array()) {
        $bd = explode("-", $bd); // yyyy-mm-dd
        $month = $arr_month[number_format($bd[1])];
        $year = $bd[0] + 543;
        $birthday = $bd[2] . " " . $month . " " . $year;
        return $birthday;
    }

    public function update() {

        /*
        Array
        (
        [title] => นาย
        [firstname] => กรุณ
        [lastname] => รูปหล่อ
        [birthday] => 1988-12-21
        [tel] =>                                     0875435550,045261624
        [email] => thongtank@hotmail.com
        [address] => 439 ถ.สรรพสิทธิ์
        [province] =>
        [hidden_province_id] => 23
        [amphur] =>
        [hidden_amphur_id] => 312
        [district] =>
        [hidden_district_id] => 2788
        [zipcode] => 34000
        [latlng] => 1
        [lat] => 1
        )
         */
        $sql = "UPDATE `profile` SET `firstname`=?,`lastname`=?,`age`=?,`title`=?,`gender`=?,`birthday`=?,`tel`=?,`email`=?,`address`=?,`province`=?,`amphur`=?,`district`=?,`zipcode`=?,`lat`=?,`lng`=?,`date_added`=NOW(), `last_login`=NOW() WHERE profile_id=" . $_SESSION['profile_detail']['profile_id'];
        if ($this->connection()) {
            $stmt = $this->mysqli->prepare($sql);
            if ($stmt) {
                $profile = array();
                $stmt->bind_param('ssissssssiiiiss', $profile['firstname'], $profile['lastname'], $age, $profile['title'], $profile['gender'], $profile['birthday'], $profile['tel'], $profile['email'], $profile['address'], $province, $amphur, $district, $profile['zipcode'], $profile['lat'], $profile['lng']);
                $profile['firstname'] = $this->pf['firstname'];
                $profile['lastname'] = $this->pf['lastname'];
                $age = $this->get_age();
                $profile['title'] = $this->pf['title'];
                $profile['gender'] = ($this->pf['title'] == "นาง" || $this->pf['title'] == "นางสาว") ? "F" : "M";
                $profile['birthday'] = $this->pf['birthday'];
                $profile['tel'] = $this->pf['tel'];
                $profile['email'] = $this->pf['email'];
                $profile['address'] = $this->pf['address'];
                $province = (empty($this->pf['province'])) ? $this->pf['hidden_province_id'] : $this->pf['province'];
                $amphur = (empty($this->pf['amphur'])) ? $this->pf['hidden_amphur_id'] : $this->pf['amphur'];
                $district = (empty($this->pf['district'])) ? $this->pf['hidden_district_id'] : $this->pf['district'];
                $profile['zipcode'] = $this->pf['zipcode'];
                $profile['lat'] = $this->pf['lat'];
                $profile['lng'] = $this->pf['lng'];

                $stmt->execute();
                if ($stmt->affected_rows) {
                    $this->close_connection();
                    $stmt->close();
                    return true;
                } else {
                    print $stmt->error;
                    $this->close_connection();
                    $stmt->close();
                    return false;
                }
            } else {
                echo $this->mysqli->error;
            }
        }
    }

    public function set() {
        /*
        Array
        (
        [username] => panchai
        [password] => 489329
        [title] => นาย
        [firstname] => พันชัย
        [lastname] => ประสมเพชร
        [birthday] => 1988-12-21
        [tel] => 0875435550
        [email] => thongtank@hotmail.com
        [address] => 213 หมู่ 12
        [province] => 23
        [amphur] => 325
        [district] => 2947
        [zipcode] => 34140
        [lat] =>
        [lng] =>

        )
         */

        $age = $this->get_age();
        $gender = "M";
        if ($this->pf['title'] == 'นางสาว' || $this->pf['title'] == 'นาง') {
            $gender = "F";
        }
        $sql = "INSERT INTO `profile`(`profile_username`, `profile_pwd`, `firstname`, `lastname`, `age`, `title`, `gender`, `birthday`, `tel`, `email`, `address`, `province`, `amphur`, `district`, `zipcode`, `lat`, `lng`, `date_added`)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())";
        if (parent::connection()) {
            if ($stmt = $this->mysqli->prepare($sql)) {
                $stmt->bind_param(
                    'ssssissssssiiiiss',
                    $this->pf['username'],
                    $this->pf['password'],
                    $this->pf['firstname'],
                    $this->pf['lastname'],
                    $age,
                    $this->pf['title'], $gender,
                    $this->pf['birthday'],
                    $this->pf['tel'],
                    $this->pf['email'],
                    $this->pf['address'],
                    $this->pf['province'],
                    $this->pf['amphur'],
                    $this->pf['district'],
                    $this->pf['zipcode'],
                    $this->pf['lat'],
                    $this->pf['lng']
                );
                $stmt->execute();
                if ($stmt->affected_rows) {
                    $stmt->close();
                    parent::close_connection();
                    return true;
                } else {
                    echo $stmt->error;
                    return false;
                }
            } else {
                echo $this->mysqli->error;
            }

        }

    }
}
