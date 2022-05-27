<?php
ob_start();
session_start();
include "../common.php";

	$ucr_usr_id = addslashes(trim($_GET['ucr_usr_id']));
	$ucr_certificate = addslashes(trim($_GET['ucr_certificate']));
	$ucr_organization = addslashes(trim($_GET['ucr_organization']));
	$ucr_year = addslashes(trim($_GET['ucr_year']));
	$ucr_description = addslashes(trim($_GET['ucr_description']));

	
	$sql_cert="insert into user_certification
			set
				ucr_usr_id = '".$ucr_usr_id."',
				ucr_certificate = '".$ucr_certificate."',
				ucr_organization = '".$ucr_organization."',
				ucr_year = '".$ucr_year."',
				ucr_description = '".$ucr_description."'";

	mysql_query($sql_cert);
    
?>