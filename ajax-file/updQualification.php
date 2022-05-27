<?php
ob_start();
session_start();
include "../common.php";

	$ued_id = addslashes(trim($_GET['ued_id']));
	$ued_cn_id = addslashes(trim($_GET['ued_cn_id']));
	$ued_institute = addslashes(trim($_GET['ued_institute']));
	$ued_degree = addslashes(trim($_GET['ued_degree']));
	$ued_from_year = addslashes(trim($_GET['ued_from_year']));
	$ued_to_year = addslashes(trim($_GET['ued_to_year']));
	
	$sql_qual="update user_education
			set
				ued_cn_id = '".$ued_cn_id."',
				ued_institute = '".$ued_institute."',
				ued_degree = '".$ued_degree."',
				ued_from_year = '".$ued_from_year."',
				ued_to_year = '".$ued_to_year."'
			where
				ued_id = '".$ued_id."'";

	mysql_query($sql_qual);
    
    ?>