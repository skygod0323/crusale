<?php
ob_start();
session_start();
include "../common.php";

$bd_id=$_GET['bd_id'];
$sql="delete from bid where bd_id='".$bd_id."'";
mysql_query($sql);

?>