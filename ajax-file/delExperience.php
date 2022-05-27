<?php
include "../common.php";


$ue_id=$_GET['ue_id'];
$sql="delete from user_experience where ue_id='".$ue_id."'";

mysql_query($sql);

?>