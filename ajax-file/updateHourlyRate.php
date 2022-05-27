<?php
ob_start();
session_start();
include "../common.php";

$hourlyRate=$_GET['hourlyRate'];
$sql="update user set usr_hourlyrate = '".$hourlyRate."' where usr_id='".$_SESSION['uid']."'";
mysql_query($sql);
echo number_format($hourlyRate,2);
?>