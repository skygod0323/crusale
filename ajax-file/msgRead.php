<?php
include "../common.php";

$msg_id=$_GET['msg_id'];
$sql="update message set msg_read='1' where msg_id='".$msg_id."'";
mysql_query($sql);
?>