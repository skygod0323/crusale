<?php 
ob_start();
session_start(); 
include "../common.php";
check_user_login();
$sk_id=$_GET['sk_id'];
$sk_name=$_GET['sk_name'];

$recObj_sql="update skills set sk_name='".$sk_name."' where sk_id=".$sk_id;
$recObj=mysql_query($recObj_sql);
echo "$sk_name";
?>

