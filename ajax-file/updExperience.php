<?php
ob_start();
session_start();
include"../common.php";

	$ue_id=addslashes(trim($_GET['ue_id']));
	$ue_title=addslashes(trim($_GET['ue_title']));
	$ue_company=addslashes(trim($_GET['ue_company']));
	$ue_from_month=addslashes(trim($_GET['ue_from_month']));
	$ue_from_year=addslashes(trim($_GET['ue_from_year']));
	$ue_to_month=addslashes(trim($_GET['ue_to_month']));
	$ue_to_year=addslashes(trim($_GET['ue_to_year']));
	$ue_summary=addslashes(trim($_GET['ue_summary']));
	
	
	if($_GET['ue_current']==true)
	{
		$sql_exp="update user_experience
			set
				ue_title='".$ue_title."',
				ue_company='".$ue_company."',
				ue_from_month='".$ue_from_month."',
				ue_from_year='".$ue_from_year."',
				ue_summary='".$ue_summary."',
				ue_current='1'
			where
				ue_id='".$ue_id."'";
		
		mysql_query($sql_exp);
	}
	else
	{
		$sql_exp="update user_experience
			set
				ue_title='".$ue_title."',
				ue_company='".$ue_company."',
				ue_from_month='".$ue_from_month."',
				ue_from_year='".$ue_from_year."',
				ue_to_month='".$ue_to_month."',
				ue_to_year='".$ue_to_year."',
				ue_summary='".$ue_summary."',
				ue_current='0'
			where
				ue_id='".$ue_id."'";
		
		mysql_query($sql_exp);
	}
?>    