<?php
include "../common.php";

$fid=$_GET['f'];
$sql="delete from temp_file_post where fl_id='".$fid."'";
echo $sql;
mysql_query($sql);

?>