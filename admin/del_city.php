<?php 
include "../common.php";
$hid=$_GET[hid];

$recObj_sql="select ct_cn_id from city where ct_id='".$hid."'";
$recObj=mysql_query($recObj_sql);
$row=mysql_fetch_array($recObj);
$ct_cn_id=$row['ct_cn_id'];
$delObj_sql="delete from city where ct_id='".$hid."'";
$delObj=mysql_query($delObj_sql);
echo $ct_cn_id;
?>