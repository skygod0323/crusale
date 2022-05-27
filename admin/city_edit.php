<?php 
include "../common.php";
$hid=$_GET['hid'];
$city_inp=$_GET['city_inp'];


$recObj_sql="update city set ct_name='".$city_inp."' where ct_id= '".$hid."'";
$recObj=mysql_query($recObj_sql);
echo $city_inp;
?>

