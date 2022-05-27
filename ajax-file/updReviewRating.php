<?php
ob_start();
session_start();
include "../common.php";


	$rr_id = addslashes(trim($_GET['rr_id']));
	$rr_work_quality = addslashes(trim($_GET['rr_work_quality']));
	$rr_communication = addslashes(trim($_GET['rr_communication']));
	$rr_expertise = addslashes(trim($_GET['rr_expertise']));
	$rr_work_hire_again = addslashes(trim($_GET['rr_work_hire_again']));
	$rr_professionalism = addslashes(trim($_GET['rr_professionalism']));
	$rr_review = addslashes(trim($_GET['rr_review']));
	
	
	$sql_rr="update review_rating
			set
				rr_work_quality = '".$rr_work_quality."',
				rr_communication = '".$rr_communication."',
				rr_expertise = '".$rr_expertise."',
				rr_work_hire_again = '".$rr_work_hire_again."',
				rr_professionalism = '".$rr_professionalism."',
				rr_review = '".$rr_review."',
				rr_updated_date =now()
                  where
                        rr_id='".$rr_id."'";

	if(mysql_query($sql_rr))
	{
		echo "true";	
	}
	else
	{
		echo "false";
	}

	

?>