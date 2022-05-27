<?php 
ob_start();
session_start(); 
include "../common.php";
check_user_login();
$scat_id=$_GET['scat_id'];

$recObj_sql="update subcategory set scat_status=0 where scat_id=".$scat_id;
$recObj=mysql_query($recObj_sql);
//echo "$pt_name";
?>