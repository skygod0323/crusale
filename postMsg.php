<?php
include "common.php";

$usr_id=$_GET['uid'];
$prj_id=$_GET['pid'];
$cmt_text=$_GET['text'];

$sql="insert into comment
	set
		cmt_prj_id='".$prj_id."',
		cmt_usr_id='".$usr_id."',
		cmt_text='".$cmt_text."',
		cmt_updated_date=now()";

mysql_query($sql);

?>