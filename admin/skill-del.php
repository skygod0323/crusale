<?php 
ob_start();
session_start(); 
include "../common.php";
check_user_login();
$sk_id=$_GET['sk_id'];

$recObj_sql="update skills set sk_status='0' where sk_id=".$sk_id;
$recObj=mysql_query($recObj_sql);
//echo "$pt_name";
?>