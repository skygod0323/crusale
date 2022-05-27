<?php
ob_start();
session_start();
include "../common.php";


	$rr_prj_id = addslashes(trim($_GET['rr_prj_id']));
	$rr_to_usr = addslashes(trim($_GET['rr_to_usr']));
	$rr_from_usr = addslashes(trim($_GET['rr_from_usr']));
	$rr_work_quality = addslashes(trim($_GET['rr_work_quality']));
	$rr_communication = addslashes(trim($_GET['rr_communication']));
	$rr_expertise = addslashes(trim($_GET['rr_expertise']));
	$rr_work_hire_again = addslashes(trim($_GET['rr_work_hire_again']));
	$rr_professionalism = addslashes(trim($_GET['rr_professionalism']));
	$rr_completionrate = addslashes(trim($_GET['rr_completionrate']));
	$rr_review = addslashes(trim($_GET['rr_review']));
	
	
	$sql_rr="insert into review_rating
			set
				rr_prj_id = '".$rr_prj_id."',
				rr_to_usr = '".$rr_to_usr."',
				rr_from_usr = '".$rr_from_usr."',
				rr_work_quality = '".$rr_work_quality."',
				rr_communication = '".$rr_communication."',
				rr_expertise = '".$rr_expertise."',
				rr_work_hire_again = '".$rr_work_hire_again."',
				rr_professionalism = '".$rr_professionalism."',
				rr_completionrate = '".$rr_completionrate."',
				rr_review = '".$rr_review."',
				rr_updated_date =now()";

	if(mysql_query($sql_rr))
	{
		echo "true";	
	}
	else
	{
		echo "false";
	}

	

?>