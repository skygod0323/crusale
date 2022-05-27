<?php
ob_start();
session_start();
include "../common.php";

$bd_id=$_GET['bd_id'];
$bd_amount=$_GET['bd_amount'];
$sql="update bid
	set
		bd_amount='".$bd_amount."'
		where bd_id='".$bd_id."'";
		
mysql_query($sql);


?>