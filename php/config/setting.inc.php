<?php
if (!defined('LOCALHOST')) {
    // define('LOCALHOST', 'is.utc.ac.th');
    define('LOCALHOST', 'localhost');
}
if (!defined('USER')) {
    // define('USER', 'c43ajtong');
    define('USER', 'root');
}
if (!defined('PWD')) {
    // define('PWD', 'Admin123!^');
    define('PWD', '489329');
}
if (!defined('DBNAME')) {
    // define('DBNAME', 'c43dbAgtong');
    define('DBNAME', 'db_utcmsg');
}

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

if (!defined('WWW_ROOT')) {
    define('WWW_ROOT', dirname(dirname(__FILE__)));
}
// print WWW_ROOT;
$arr_month = array(
    1 => "มกราคม",
    2 => "กุมภาพันธ๋",
    3 => "มีนาคม",
    4 => "เมษายน",
    5 => "พฤษภาคม",
    6 => "มิถุนายน",
    7 => "กรกฎาคม",
    8 => "สิงหาคม",
    9 => "กันยายน",
    10 => "ตุลาคม",
    11 => "พฤศจิกายน",
    12 => "ธันวาคม",
);

function alert_and_back($message = "") {
    echo "
        <script type='text/javascript'>
            alert('" . $message . "');
            history.back();
        </script>
    ";

}