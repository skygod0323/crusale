<?php 
include "../common.php";
$city_add = $_GET['city_add'];

$cun=$_GET['cun'];
$sql="insert into city set ct_cn_id='".$cun."', ct_name = '".$city_add."'";
mysql_query($sql) or die(mysql_error());
?>

