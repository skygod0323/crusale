<?php
ob_start();
session_start();
include "../common.php";


	$ucr_id = addslashes(trim($_GET['ucr_id']));
	$ucr_certificate = addslashes(trim($_GET['ucr_certificate']));
	$ucr_organization = addslashes(trim($_GET['ucr_organization']));
	$ucr_year = addslashes(trim($_GET['ucr_year']));
	$ucr_description = addslashes(trim($_GET['ucr_description']));

	
	$sql_cert="update user_certification
			set
				ucr_certificate = '".$ucr_certificate."',
				ucr_organization = '".$ucr_organization."',
				ucr_year = '".$ucr_year."',
				ucr_description = '".$ucr_description."'
			where
				ucr_id = '".$ucr_id."'";

	mysql_query($sql_cert);
    
    ?>