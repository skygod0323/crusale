<?php
ob_start();
session_start();
include "../common.php";

$sql_bd="select * from bid where bd_id='".$_GET['b']."'";
$res_bd=mysql_query($sql_bd);
$row_bd=mysql_fetch_object($res_bd);


$sql_rr="insert into review_rating
			set
				rr_prj_id = '".$row_bd->bd_prj_id."',
				rr_to_usr = '".$row_bd->bd_usr_id."',
				rr_from_usr = '".$_SESSION['uid']."',
				rr_work_quality = '0',
				rr_communication = '0',
				rr_expertise = '0',
				rr_work_hire_again = '0',
				rr_professionalism = '0',
				rr_completionrate = '1',
				rr_updated_date =now()";
mysql_query($sql_rr);
?>
