<?php
ob_start();
session_start();
include "../common.php";

$selected=$_GET['sel'];
$usr_id=$_SESSION['uid'];
$sql="select * from membership_plan where mp_id=(select usr_mp_id from user where usr_id='".$usr_id."')";
$res=mysql_query($sql);
$row=mysql_fetch_object($res);
$remain=$row->mp_skills - $selected;

echo $remain;
?>