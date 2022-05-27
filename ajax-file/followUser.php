<?php
ob_start();
session_start();
include "../common.php";

	$fl = addslashes(trim($_GET['fld']));
	$ued_cn_id = addslashes(trim($_GET['fldby']));
	
	$sql_qual="insert into following
			set
				flw_followed = '".$fl."',
				flw_followed_by = '".$ued_cn_id."',
				flw_updated_date = now()";

	if(mysql_query($sql_qual))
	{
		echo 1;	
	}
	else
	{
		echo 0;	
	}

?>