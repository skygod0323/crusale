<?php
include "../common.php";


$up_id=$_GET['up_id'];
$sql="delete from user_portfolio where up_id='".$up_id."'";

mysql_query($sql);

?>