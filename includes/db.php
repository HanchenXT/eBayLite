<?php 

$db['db_host'] = "localhost";
$db['db_user'] = "hanchenxt";
$db['db_pass'] = "1988114Ha";
$db['db_name'] = "eBayLite";

foreach($db as $key => $value){
    define(strtoupper($key),$value);
}

$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

include "update.php";
?>