<?php
$db_host = 'localhost';
$db_name = 'project22';  // 資料庫名稱
$db_user = 'winnie';
$db_pass = '11111';

$dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8";
//data source name:需要一個字串跟資料庫連線，＊＊＄dsn這行不可空格！！

$pdo_options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"

];
//PDO是MYSQL的外掛，是php連接資料庫的介面
// php講義p.34
// ::是引用裡面的屬性的意思

$pdo = new PDO($dsn, $db_user, $db_pass, $pdo_options);

if (!isset($_SESSION)) {
    session_start();
}
