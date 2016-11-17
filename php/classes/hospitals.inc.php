<?php
namespace classes;
error_reporting(E_ALL);
ini_set("display_errors", 1);

// session_start();

use config\database as db;

class hospitals extends db {

    public $medical_detail;
    public $paging_sql;

    public function get() {
        $sql = 'SELECT * FROM `hospital` WHERE 1; ';
        $result = $this->query($sql, $rows, $num_rows);
        if ($result === true) {
            return $rows;
        } else {
            print $result;
        }
    }

    public function get_hospital_detail_by_id($id) {
        $sql = 'SELECT * FROM `hospital` WHERE hospital_id = ' . $id . ';';
        $result = $this->query($sql, $rows, $num_rows);
        if ($result === true) {
            $id = $rows[0];
            return $id;
        } else {
            print $result;
        }
    }

    public function get_typeofmedical() {
        $sql = "SELECT * FROM `typeofmedical` WHERE 1";
        $result = $this->query($sql, $rows, $num_rows);
        if ($result === true) {
            return $rows;
        } else {
            print $result;
        }
    }

    public function get_medicine() {
        $sql = "select * from medicine where 1;";
        $result = $this->query($sql, $rows, $num_rows);
        if ($result === true) {
            return $rows;
        } else {
            print $result;
        }
    }

    public function set_medical() {
        if (parent::connection()) {
            /*
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            Array
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            (
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            [hospital] => 6
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            [typeofmedical] => 9999
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            [organ] => ไส้ติ่งขาด
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            [date_start] => 2015-11-05
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            [date_end] => 2015-11-06
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            [cost] => 18900
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            [amountofmedicine] => 2
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            [medicine_1] => 1A 656/2531
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            [medicine_2] => A656T43
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            )
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             */
            $sql = "INSERT INTO `medical`(`medical_id`, `organ`, `cost`, `date_start`, `date_end`, `rating`, `hospital_id`, `profile_id`, `medical_type_id`, `date_added`, `comment`)
                VALUES (NULL,?,?,?,?,?,?,?,?,NOW(),?)";
            if ($stmt = $this->mysqli->prepare($sql)) {
                $stmt->bind_param('sisssisis',
                    $this->medical_detail['organ'],
                    $this->medical_detail['cost'],
                    $this->medical_detail['date_start'],
                    $this->medical_detail['date_end'],
                    $this->medical_detail['rating'],
                    $this->medical_detail['hospital'],
                    $_SESSION['profile_detail']['profile_username'],
                    $this->medical_detail['typeofmedical'],
                    $this->medical_detail['comment']
                );
                $stmt->execute();
                if ($stmt->affected_rows) {
                    $insert_id = $stmt->insert_id;
                    $stmt->close();
                    if (!$this->set_medicine_order($insert_id)) {
                        return false;
                    }
                    if (!$this->set_rating()) {
                        return false;
                    }
                    parent::close_connection();
                    return true;
                } else {
                    print "Create medical error: " . $stmt->error;
                }
            } else {
                print "Prepare medical error: " . $this->mysqli->error;
            }
        }
    }

    public function get_medical($profile_id) {
        $sql = "SELECT * FROM medical WHERE `profile_id` = '" . $profile_id . "' ORDER BY date_added DESC;";

        $result = $this->query($sql, $rows, $num_rows);
        if ($result) {
            return $rows;
        } else {
            print "Get Medical Error: " . $result;
            return false;
        }
    }

    public function get_medical_by_sql($sql) {
        // $sql = "SELECT * FROM medical WHERE medical_id = '" . $id . "' ORDER BY date_added DESC;";
        $result = $this->query($sql, $rows, $num_rows);
        if ($result) {
            return $rows;
        } else {
            print "Get Medical Error: " . $result;
            return false;
        }
    }

    public function get_medical_by_id($id) {
        $sql = "SELECT * FROM typeofmedical WHERE medical_type_id = '" . $id . "' LIMIT 1";
        $result = $this->query($sql, $rows, $num_rows);
        if ($result) {
            return $rows[0];
        } else {
            print "Get Medical Error: " . $result;
            return false;
        }
    }

    public function set_medicine_order($insert_id = "") {
        $sql = "INSERT INTO `medicine_order`(`medicine_order_id`, `medicine_id`, `medical_id`, `date_added`)
                        VALUES (NULL,?,?,NOW())";
        if ($stmt = $this->mysqli->prepare($sql)) {
            $stmt->bind_param('ss', $medicine_id, $medical_id);
            $arr_medicine_id = array();
            for ($i = 1; $i <= $this->medical_detail['amountofmedicine']; $i++) {
                $medicine_id = $this->medical_detail['medicine_' . $i];
                $medical_id = $insert_id;
                if (!in_array($medicine_id, $arr_medicine_id)) {
                    $stmt->execute();
                }

                if (!$stmt->affected_rows) {
                    print "Create medicine order error: " . $stmt->error;
                    break;
                    return false;
                } else {
                    array_push($arr_medicine_id, $medicine_id);
                }
            }
            $stmt->close();
            return true;
        } else {
            print "Prepare medicine order  error: " . $this->mysqli->error;
            return false;
        }
    }

    public function set_rating() {
        $sql = "INSERT INTO `rating`(`rating_id`, `hospital_id`, `profile_id`, `rate`, `date_added`)
            VALUES (NULL,?,?,?,NOW())";
        if ($stmt = $this->mysqli->prepare($sql)) {
            $stmt->bind_param('iss', $hospital_id, $profile_id, $rate);
            $hospital_id = $this->medical_detail['hospital'];
            $profile_id = $_SESSION['profile_detail']['profile_username'];
            $rate = $this->medical_detail['rating'];

            $stmt->execute();
            if ($stmt->affected_rows) {
                $stmt->close();
                return true;
            } else {
                print "Create rating error: " . $stmt->error;
                return false;
            }
        } else {
            print "Prepare rating error: " . $this->mysqli->error;
            return false;
        }
    }

    public function get_rating_by_hospital_id($hospital_id) {
        $sql = "SELECT AVG(rate) as rate FROM rating WHERE hospital_id=" . $hospital_id;
        $result = $this->query($sql, $rows, $num_rows);
        if ($result) {

            $rate = array('score' => $rows[0]['rate']);

            if ($rows[0]['rate'] > 4) {
                $rate['word'] = "ดีมาก";
            } elseif ($rows[0]['rate'] > 3) {
                $rate['word'] = "ดี";
            } elseif ($rows[0]['rate'] > 2) {
                $rate['word'] = "ปานกลาง";
            } elseif ($rows[0]['rate'] > 1) {
                $rate['word'] = "พอใช้";
            } else {
                $rate['word'] = "ปรับปรุง";
            }

            return $rate;
        }
    }

    public function research($data = array()) {
        $i = 1;
        foreach ($data as $key => $value) {
            if ($key != "do" and $key != "page") {
                if ($value != "") {
                    $i = 0;
                }
            }

        }
        $field = "";
        if ($data['province'] != '') {
            $field .= " INNER JOIN hospital ON medical.hospital_id = hospital.hospital_id ";
        }
        // echo $field;
        $field .= " WHERE ";
        if ($i == 1) {
            $field .= $i;
        } else {
            $field .= "( ";
            if (!empty($data['organ'])) {
                $og = explode(",", $data['organ']);
                $i = 0;
                foreach ($og as $k_og => $v_og) {
                    $field .= "`organ` LIKE '%" . trim($v_og) . "%' ";
                    $i++;
                    if ($i != count($og)) {
                        $field .= " OR ";
                    }
                }
            } else {
                $field .= "`organ` LIKE '%%' ";
            }
            $field .= ") ";
            if (!empty($data['cost'])) {
                $cost_sql = "AND cost = " . $data['cost'] . " ";

                $find = "<";
                $pos = strpos($data['cost'], $find);
                if (gettype($pos) == "integer") {
                    $cost_sql = "AND cost " . $data['cost'] . " ";
                }
                $find = ">";
                $pos = strpos($data['cost'], $find);
                if (gettype($pos) == "integer") {
                    $cost_sql = "AND cost " . $data['cost'] . " ";
                }
                $find = "-";
                $pos = strpos($data['cost'], $find);
                if (gettype($pos) == "integer") {
                    $ex = explode("-", $data['cost']);
                    $cost_sql = "AND cost BETWEEN " . $ex[0] . " AND " . $ex[1] . " ";
                }

                $field .= $cost_sql;
            }
            $field .= (!empty($data['medical_type_id'])) ? "AND `medical_type_id` = " . $data['medical_type_id'] . " " : "";
            $field .= (!empty($data['hospital_id'])) ? "AND medical.`hospital_id` = " . $data['hospital_id'] . " " : "";
            $field .= (!empty($data['rating'])) ? "AND `rating` = " . $data['rating'] . " " : "";

            $field .= (!empty($data['province'])) ? "AND hospital.`province` = " . $data['province'] . " " : "";
            $field .= (!empty($data['amphur'])) ? "AND hospital.`amphur` = " . $data['amphur'] . " " : "";
            $field .= (!empty($data['district'])) ? "AND hospital.`district` = " . $data['district'] . " " : "";

        }

        $field .= " GROUP BY hospital_id ";
        // กรณีสำหรับตอนที่ยังไม่ได้กด paging
        if (!isset($data['page'])) {
            $data['page'] = 1;
        }
        $sql = "SELECT medical.* FROM medical " . $field;
        $this->paging_sql = $sql;
        $_SESSION['paging_sql'] = $sql;

        // กรณีเมื่อเปิดจาก paging ข้อมูลจากคำสั่งนี้จะแสดงข้อมูลในตาราง
        $start_record = ($data['page'] - 1) * 10;
        $field .= " LIMIT " . $start_record . ", 10";
        if ($data['province'] != '') {
            $sql = "SELECT hospital.hospital_id, medical.medical_id, AVG(cost) as cost_avg, AVG(rating) as rating_avg FROM medical " . $field;
        } else {
            $sql = "SELECT hospital_id, medical_id, AVG(cost) as cost_avg, AVG(rating) as rating_avg FROM medical " . $field;
        }

        // SQL สำหรับแต่ละหน้า
        // echo $sql;

        $result = $this->query($sql, $rows, $num_rows);
        if ($result) {
            $i = $start_record;
            $html = "";
            if ($num_rows > 0) {
                foreach ($rows as $key => $value) {
                    $hospital = self::get_hospital_detail_by_id($value['hospital_id']);
                    $i++;
                    $html .= "
                        <tr>
                            <td>" . $i . "</td>
                            <td>" . trim($hospital['hospital_name']) . "</td>
                            <td>" . trim(number_format(round($value['cost_avg'], 2))) . "</td>
                            <td>" . trim(round($value['rating_avg'], 2)) . "</td>
                            <td>
                                <a href='hospital_detail.php?hospital_id=" . $value['hospital_id'] . "' title='รายละเอียดทั้งหมด'><i class='fa fa-list'></i> รายละเอียด</a>
                            </td>
                        </tr>
                    ";
                }
            } else {
                $html .= "<tr><td colspan=5 align=center>ไม่พบข้อมูล</td></tr>";
            }

            return $html;
        }
    }

    public function search($search = array()) {
        // $search['province_hidden'] = (empty($search['province_hidden'])) ? "''" : $search['province_hidden'];
        // $search['amphur_hidden'] = (empty($search['amphur_hidden'])) ? "''" : $search['amphur_hidden'];
        // $search['district_hidden'] = (empty($search['district_hidden'])) ? "''" : $search['district_hidden'];
        $search['province_hidden'] = (empty($search['province_hidden'])) ? "" : "AND `province` = " . $search['province_hidden'] . " ";
        $search['amphur_hidden'] = (empty($search['amphur_hidden'])) ? "" : " AND `amphur` = " . $search['amphur_hidden'] . " ";
        $search['district_hidden'] = (empty($search['district_hidden'])) ? "" : "AND `district` = " . $search['district_hidden'] . " ";

        if (!empty($search['medical_type_id'])) {
            $sql = "SELECT * FROM `hospital` INNER JOIN special_medical ON hospital.hospital_id = special_medical.hospital_id WHERE medical_type_id = " . $search['medical_type_id'] . " AND `hospital_name` LIKE '%" . $search['hospital_key'] . "%' " . $search['province_hidden'] . " " . $search['amphur_hidden'] . " " . $search['district_hidden'] . " GROUP BY special_medical.`hospital_id` ";

        } else {
            $sql = "SELECT * FROM `hospital` WHERE `hospital_name` LIKE '%" . $search['hospital_key'] . "%' " . $search['province_hidden'] . " " . $search['amphur_hidden'] . " " . $search['district_hidden'] . " GROUP BY `hospital_id` ";
        }
        // echo $sql;
        $this->paging_sql = $sql;
        // กรณีสำหรับตอนที่ยังไม่ได้กด paging
        if (!isset($search['page'])) {
            $search['page'] = 1;
        }
        // กรณีเมื่อเปิดจาก paging ข้อมูลจากคำสั่งนี้จะแสดงข้อมูลในตาราง
        $start_record = ($search['page'] - 1) * 10;
        $field = " LIMIT " . $start_record . ", 10";
        $sql = $sql . $field;
        // echo $sql;

        $rows = null;
        $num_rows = null;
        $result = $this->query($sql, $rows, $num_rows);
        if ($result === true) {
            return $rows;
        } else {
            print "Search hospital error: " . $result;
            return false;
        }
    }

    public function paging() {

        $sql = $this->paging_sql;
        // echo $sql;
        $perpage = 10;
        $rows = null;
        $num_rows = null;
        $result = $this->query($sql, $rows, $num_rows);
        if ($result) {
            $total_records = $num_rows;
            $total_pages = ceil($total_records / $perpage);
            $href = "";
            if (isset($_GET['page'])) {
                $c = count($_GET) - 1; // ลบ 1 เพราะไม่นับ parameter page
            } else {
                $c = count($_GET);
            }

            $i = 0;
            foreach ($_GET as $key => $value) {
                if ($key != 'page') {
                    $i++;
                    if ($i == 1) {
                        $href .= "?";
                    }
                    $href .= $key . "=" . $value;
                    if ($i != $c) {
                        $href .= "&";
                    }
                }

            }

            // $html = '
            // <li>
            // <a href="?organ=' . $_GET['organ'] . '&cost=' . $_GET['cost'] . '&medical_type_id=' . $_GET['medical_type_id'] . '&hospital_id=' . $_GET['hospital_id'] . '&rating=' . $_GET['rating'] . '&do=s" aria-label="Previous">
            // <span aria-hidden="true">&larr;</span>
            // </a>
            // </li>';
            // for ($i = 1; $i <= $total_pages; $i++) {
            //     $html .= '<li><a href="?organ=' . $_GET['organ'] . '&cost=' . $_GET['cost'] . '&medical_type_id=' . $_GET['medical_type_id'] . '&hospital_id=' . $_GET['hospital_id'] . '&rating=' . $_GET['rating'] . '&do=s&page=' . $i . '">' . $i . '</a></li>';
            // }
            // $html .= '
            // <li>
            // <a href="?organ=' . $_GET['organ'] . '&cost=' . $_GET['cost'] . '&medical_type_id=' . $_GET['medical_type_id'] . '&hospital_id=' . $_GET['hospital_id'] . '&rating=' . $_GET['rating'] . '&do=s&page=' . $total_pages . '" aria-label="Previous">
            // <span aria-hidden="true">&rarr;</span>
            // </a>
            // </li>';

            $html = '
            <li>
            <a href="' . $href . '" aria-label="Previous">
            <span aria-hidden="true">&larr;</span>
            </a>
            </li>';
            for ($i = 1; $i <= $total_pages; $i++) {
                $html .= '<li><a href="' . $href . '&page=' . $i . '">' . $i . '</a></li>';
            }
            $html .= '
            <li>
            <a href="' . $href . '&do=s&page=' . $total_pages . '" aria-label="Previous">
            <span aria-hidden="true">&rarr;</span>
            </a>
            </li>';

            return $html;
        }
    }

    public function get_special_by_hospital_id($hospital_id) {
        $sql = "SELECT t.medical_name FROM special_medical s INNER JOIN typeofmedical t ON s.medical_type_id = t.medical_type_id WHERE s.hospital_id = " . $hospital_id;
        $result = $this->query($sql, $rows, $num_rows);
        if ($result) {
            return $rows;
        } else {
            print "Get special Error: " . $result;
            return false;
        }
    }
}
