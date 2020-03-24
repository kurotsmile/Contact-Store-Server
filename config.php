<?php
error_reporting(E_ERROR | E_PARSE);
$urls='https://contact.carrotstore.com';
define('URLS','https://contact.carrotstore.com');

$url='http://contact.carrotstore.com';
define('URL','http://contact.carrotstore.com');
$mysql_host='localhost';
$mysql_pass='28091993';
$mysql_user='carrotsy_carrot';
$mysql_database='carrotsy_contacts';
$url_work='http://work.carrotstore.com';
$url_carrot_store='http://carrotstore.com';


$link_app_contact = mysql_connect($mysql_host, $mysql_user,$mysql_pass);
if (!$link_app_contact) {
    die('Could not connect: ' . mysql_error());
}
mysql_selectdb($mysql_database,$link_app_contact);

mysql_set_charset("utf8", $link_app_contact);
mysql_query("SET NAMES 'utf8';",$link_app_contact); 
mysql_query("SET CHARACTER SET 'utf8';",$link_app_contact); 
mysql_query("SET SESSION collation_connection = 'utf8_general_ci';",$link_app_contact); 
?>