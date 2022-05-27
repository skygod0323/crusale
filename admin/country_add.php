<?php 
ob_start();
session_start(); 
include "../common.php";
//check_user_login();
$country_add=$_GET['country_add'];
$sql="insert into country set cn_name ='".$country_add."'";							
mysql_query($sql) or die(mysql_error());
?>

