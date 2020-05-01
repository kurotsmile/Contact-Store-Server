<?php
error_reporting(E_ERROR | E_PARSE);
$urls='http://localhost/app_mobile/contactstore';
define('URLS','http://localhost/app_mobile/contactstore');

$url='http://localhost/app_mobile/contactstore';
define('URL','http://localhost/app_mobile/contactstore');
$mysql_host='localhost';
$mysql_pass='';
$mysql_user='root';
$mysql_database='carrotsy_contacts';
$url_work='http://work.carrotstore.com';
$url_carrot_store='http://carrotstore.com';


$link = mysqli_connect($mysql_host, $mysql_user,$mysql_pass);
if (!$link) {
    die('Could not connect: ' . mysqli_error());
}
mysqli_select_db($link,$mysql_database);

mysqli_set_charset($link,"utf8");
mysqli_query($link,"SET NAMES 'utf8';");
mysqli_query($link,"SET CHARACTER SET 'utf8';");
mysqli_query($link,"SET SESSION collation_connection = 'utf8_general_ci';");
?>