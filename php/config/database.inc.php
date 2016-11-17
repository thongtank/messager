<?php
namespace config;
require_once 'setting.inc.php';

class database {
    /**
     * __construct for connect database with mysqli
     * @param string $host   host
     * @param string $user   username
     * @param string $pwd    password
     * @param string $dbname database name
     */
    public $mysqli;

    public function connection() {
        $this->mysqli = mysqli_init();
        $link = $this->mysqli->real_connect(LOCALHOST, USER, PWD, DBNAME);
        if ($link) {
            $this->mysqli->set_charset("UTF8");
            $this->t = 'new';
            return true;
        } else {
            print $this->mysqli->connect_error;
        }
    }

    public function close_connection() {
        $this->mysqli->close();
        $this->mysqli = null;
    }

    public function query($sql, &$rows, &$num_rows) {
        if (self::connection()) {
            // $sql = 'update `itsurvay`.`research` SET `firstname` = \'TONG\' WHERE `research`.`id` = 1;';
            // $sql = 'select * from research;';
            $result = $this->mysqli->query($sql);
            if ($result) {
                if ($result !== true) {
                    while ($data = $result->fetch_assoc()) {
                        $rows[] = $data;
                    }
                    $num_rows = $result->num_rows;
                    $result->free();
                } else {
                    if ($result) {
                        $rows = null;
                        $num_rows = 0;
                    } else {
                        // echo
                        return "Error2 : " . $this->mysqli->errno . " = " . $this->mysqli->error;
                    }
                    $result = null;
                }
            } else {
                // echo "Error : " . $mysqli->errno . " = " . $mysqli->error;
                return "Error1 : " . $this->mysqli->errno . " = " . $this->mysqli->error;
            }
            self::close_connection();
            return true;
        }
    }
}

// $conndb = new database;
/*
ตัวอย่างการเรียกใช้งาน database
$data = new QueryDB;
$data->query('select * from province where 1;', $rows, $num_rows);
 */
?>