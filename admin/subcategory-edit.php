<?php 
ob_start();
session_start(); 
include "../common.php";
check_user_login();
$scat_id=$_GET['scat_id'];
$scat_name=$_GET['scat_name'];

$recObj_sql="update subcategory set scat_name='".$scat_name."' where scat_id=".$scat_id;
$recObj=mysql_query($recObj_sql);
echo "$scat_name";
?>

