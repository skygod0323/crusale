<?php 
ob_start();
session_start(); 
include "../common.php";
//check_user_login();
$hid=$_GET['hid'];
$country_inp=$_GET['country_inp'];
$recObj_sql="update country set cn_name='".$country_inp."' where cn_id=".$hid;
$recObj=mysql_query($recObj_sql);
echo $country_inp;
?>

