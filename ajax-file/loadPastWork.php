<?php
ob_start();
session_start();
include "../common.php";

if($_POST['page'])
{
$page = $_POST['page'];
$cur_page = $page;
$page -= 1;
$per_page = 10; // Per page records
$previous_btn = true;
$next_btn = true;
//$first_btn = false;
//$last_btn = false;
$start = $page * $per_page;

/*$query_pag_data = "select * from user,user_images where usr_id=ui_usr_id and usr_status=1 and ui_default=1 order by rand() LIMIT $start, $per_page";
$result_pag_data = mysql_query($query_pag_data) or die('MySql Error' . mysql_error());*/

$sql_pw="select * from project,bid,user where prj_id=bd_prj_id and prj_usr_id=usr_id and bd_usr_id='".$_SESSION['uid']."' and prj_id in(select rr_prj_id from review_rating where rr_from_usr=prj_usr_id and (rr_completionrate='1' or rr_completionrate='0')) and bd_status=1 order by bd_deadline desc LIMIT $start, $per_page";
$res_pw=mysql_query($sql_pw) or die('MySql Error' . mysql_error());

?>
<div class="row" id="PstWrk">
	<div class="col-xs-12">
		<div class="table-responsive">
<table class="table table-striped table-bordered table-hover">
	<thead>
    	<tr>
           	<th><?php echo $lang[18]; ?></th>
			<th><?php echo $lang[20]; ?></th>
			<th><?php echo $lang[60]; ?></th>
			<th><?php echo $lang[606]; ?></th>
			<th><?php echo $lang[600]; ?></th>
			<th><?php echo $lang[617]; ?></th>
		</tr>
	</thead>
    <tbody>
<?php
	if(mysql_num_rows($res_pw)>0)	{
		while($row_pw=mysql_fetch_object($res_pw)){		?>
	

	<tr>
		<td width="24%" align="left" valign="top"><a href="project.php?p=<?php echo $row_pw->prj_id; ?>"><?php echo $row_pw->prj_name; ?></a></td>
        <?php
			$sql_pwb="select count(*) from bid where bd_prj_id='".$row_pw->prj_id."'";
			$res_pwb=mysql_query($sql_pwb);
			$row_pwb=mysql_fetch_row($res_pwb);
		?>
		<td width="12%" align="left" valign="top"><?php echo $row_pwb[0]; ?></td>
		<td width="25%" align="left" valign="top"><a href="profile.php?u=<?php echo md5($row_pw->usr_id); ?>"><?php echo $row_pw->usr_name; ?></a></td>
		<td width="18%" align="left" valign="top"><?php echo $row_pw->bd_amount; ?></td>
	<?php
        	$sql_m="select count(*) from message where msg_prj_id='".$row_pw->prj_id."' and msg_to='".$_SESSION['uid']."'";
            $res_m=mysql_query($sql_m);
            $row_m=mysql_fetch_array($res_m);
					
			$sql_ur="select count(*) from message where msg_prj_id='".$row_pw->prj_id."' and msg_to='".$_SESSION['uid']."' and msg_read='0'";
            $res_ur=mysql_query($sql_ur);
            $row_ur=mysql_fetch_array($res_ur);

			if($row_m[0]==0){	?>
			<td width="8%" align="left" valign="top"><?php echo $row_m[0]; ?></td>
	<?php	}else{	?>
				<td width="8%" align="left" valign="top"><a href="mymessage.php"><?php echo $row_m[0]; ?></a>
				<?php if($row_ur[0]>0){ ?><sup style="color:green; font-weight: bold"> +<?php echo $row_ur[0].$lang[608]; ?></sup><?php	}	?>
	        	</td>
	<?php	}	?>

	<?php
			$sql_rr="select * from review_rating where rr_from_usr='".$row_pw->prj_usr_id."' and rr_prj_id='".$row_pw->prj_id."'";
			$res_rr=mysql_query($sql_rr);
			$row_rr=mysql_fetch_object($res_rr);
			if($row_rr->rr_completionrate == '1'){	
			?>
				<td width="13%" align="left" valign="top"><?php echo $lang[338].' ('.date("d-M-Y",strtotime($row_rr->rr_updated_date)).')'; ?></td>
		<?php	}	
			else{	?>
				<td width="13%" align="left" valign="top" style="color:#F66"><?php echo $lang[615].' ('.date("d-M-Y",strtotime($row_rr->rr_updated_date)).')'; ?></td>
		<?php	}	?>
		</tr>
	 <?php	} 	
}else{	?>
	<tr><td colspan="6"><?php echo $lang[616]; ?>&nbsp;</td></tr>
<?php	}	?>
	
<style>select { font-size:13px; }</style>
	</tbody>
	  		</table>
<!------------------------- pagination start here ----------->
<?php
/* -----Total count--- */
$query_pag_num = "select count(*) AS count from project,bid,user where prj_id=bd_prj_id and prj_usr_id=usr_id and bd_usr_id='".$_SESSION['uid']."' and prj_id in(select rr_prj_id from review_rating where rr_from_usr=prj_usr_id and (rr_completionrate='1' or rr_completionrate='0')) and bd_status=1"; // Total records
$result_pag_num = mysql_query($query_pag_num);
$row = mysql_fetch_array($result_pag_num);
$count = $row['count'];
$no_of_paginations = ceil($count / $per_page);

if ($cur_page >= 7) {
    $start_loop = $cur_page - 3;
    if ($no_of_paginations > $cur_page + 3)
        $end_loop = $cur_page + 3;
    else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
        $start_loop = $no_of_paginations - 6;
        $end_loop = $no_of_paginations;
    } else {
        $end_loop = $no_of_paginations;
    }
} else {
    $start_loop = 1;
    if ($no_of_paginations > 7)
        $end_loop = 7;
    else
        $end_loop = $no_of_paginations;
}
?>

<?php if($count>0){	?>
<ul class="pagination pull-right no-margin">
<?php
// FOR ENABLING THE PREVIOUS BUTTON
if ($previous_btn && $cur_page > 1) {
    $pre = $cur_page - 1;
	?>
    <li class="prev"><a href="javascript:loadPastWork('<?php echo $pre; ?>')"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
<?php	} else if ($previous_btn) {	?>
	<li class="prev disabled"><a><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
<?php	}	?>
	<!--<li class="prev disabled">
		<a href="#"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
	</li>-->
    
    <?php
for ($i = $start_loop; $i <= $end_loop; $i++) {
    if ($cur_page == $i){	?>
        <li class="active"><a><?php echo $i; ?></a></li>
	<?php	}else{	?>
        <li><a href="javascript:loadPastWork('<?php echo $i; ?>')"><?php echo $i; ?></a></li>
	<?php	}
}
	 ?>
	<!--<li class="active">
		<a href="#">1</a>
	</li>
	<li>
		<a href="#">2</a>
	</li>
	<li>
		<a href="#">3</a>
	</li>-->
<?php
// TO ENABLE THE NEXT BUTTON
if ($next_btn && $cur_page < $no_of_paginations) {
    $nex = $cur_page + 1;	?>
    <li class="next"><a href="javascript:loadPastWork('<?php echo $nex; ?>')"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
<?php	} else if ($next_btn) {	?>
    <li class="next disabled"><a><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
<?php	}	?>
	<!--<li class="next">
		<a href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
	</li>-->
</ul>
<?php	}	?>
<!------------------------- pagination end here ----------->
    	</div>
	</div>
</div>
<?php	}	?>