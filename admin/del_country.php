<?php 
ob_start();
session_start(); 
include "../common.php";
//check_user_login();
$cn_id=$_GET['hid'];
$delObj_sql="delete from country where cn_id=".$cn_id;
$delObj=mysql_query($delObj_sql);

mysql_query("delete from city where ct_cn_id='".$cn_id."'");
?>