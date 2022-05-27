<?php
include "../common.php";


$prj_id=$_GET['prj_id'];
$sql="delete from project where prj_id='".$prj_id."'";

mysql_query($sql);
?>