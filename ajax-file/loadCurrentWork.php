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



$sql_cw="select * from project,bid,user where bd_prj_id=prj_id and prj_usr_id=usr_id and bd_usr_id='".$_SESSION['uid']."' and bd_status=1 and prj_status='running' and prj_id not in(select rr_prj_id from review_rating where rr_from_usr=prj_usr_id and (rr_completionrate='1' or rr_completionrate='0')) order by bd_deadline desc LIMIT $start, $per_page";
$res_cw=mysql_query($sql_cw) or die('MySql Error' . mysql_error());

?>
<div class="row" id="CurWrk">
	<div class="col-xs-12">
		<div class="table-responsive">
<table class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
        	<th><?php echo $lang[18]; ?></th>
		    <th><?php echo $lang[60]; ?></th>
            <th><?php echo $lang[606]; ?></th>
		    <th><?php echo $lang[373]; ?></th>
            <th><?php echo $lang[600]; ?></th>
		    <th><?php echo $lang[607]; ?></th>
            <th><?php echo $lang[598]; ?></th>
		</tr>
	</thead>
    <tbody>
<?php
	if(mysql_num_rows($res_cw)>0)	{
		while($row_cw=mysql_fetch_object($res_cw)){
?>			
	<tr>
		<td width="24%" align="left" valign="top"><a href="project.php?p=<?php echo $row_cw->prj_id; ?>"><?php echo $row_cw->prj_name; ?></a></td>
		<td width="21%" align="left" valign="top"><a href="profile.php?u=<?php echo md5($row_cw->usr_id); ?>"><?php echo $row_cw->usr_name; ?></a></td>
		<td width="12%" align="left" valign="top"><?php echo getCurrencySymbol().'&nbsp;'.number_format($row_cw->bd_amount,2);	?>
        <?php
        if($row_prj->usr_balance < $row_prj->bd_amount){	?>
			&nbsp;<img style="vertical-align: bottom;" title="The employer does not have sufficient funds in their account yet to pay for this project in full." src="images/cross.png" border="0">
		<?php	} 	?>
		</td>
        <?php
		$diff=dateDifference(date("Y-m-d h:i:s"),$row_cw->bd_deadline);
			if($diff>0){	?>
				<td width="15%" align="left" valign="top"><?php echo date("d-M-Y",strtotime($row_cw->bd_deadline)); ?></td>
			<?php	}else{	?>
				<td width="15%" align="left" valign="top" style="color:#F00"><?php echo date("d-M-Y",strtotime($row_cw->bd_deadline)); ?></td>
			<?php	}	?>

		<?php
				
       	$sql_m="select count(*) from message where msg_prj_id='".$row_cw->prj_id."' and msg_to='".$_SESSION['uid']."'";
        $res_m=mysql_query($sql_m);
        $row_m=mysql_fetch_array($res_m);
					
		$sql_ur="select count(*) from message where msg_prj_id='".$row_cw->prj_id."' and msg_to='".$_SESSION['uid']."' and msg_read='0'";
        $res_ur=mysql_query($sql_ur);
        $row_ur=mysql_fetch_array($res_ur);

		
		if($row_m[0]==0){	?>
			<td width="8%" align="left" valign="top"><?php echo $row_m[0]; ?></td>
		<?php }else	{	?>
			<td width="8%" align="left" valign="top"><a href="mymessage.php"><?php echo $row_m[0]; ?></a>
		<?php	if($row_ur[0]>0){ ?><sup style="color:green; font-weight: bold"> +<?php echo $row_ur[0].$lang[608]; ?></sup><?php	}	?>
        	</td>
		<?php	}	?>
		<td width="10%" align="left" valign="top"><?php echo getCurrencySymbol().'&nbsp;'.number_format(($row_cw->bd_amount*$row_cw->bd_milestone/100),2); ?></td>
		<td>
		<?php
			$sql_chk_rr="select count(*) from review_rating where rr_prj_id='".$row_cw->prj_id."' and rr_to_usr='".$row_cw->usr_id."' and rr_from_usr='".$_SESSION['uid']."'";
			$res_chk_rr=mysql_query($sql_chk_rr);
			$row_chk_rr=mysql_fetch_array($res_chk_rr);
		?>
    	<select class="sellerview-action-on-proj" proj_id="2392241" buyer_id="3954907" style="width:110px;" onChange="takeAction('<?php echo $row_cw->bd_id; ?>',this.value,'<?php echo md5($row_cw->prj_id); ?>')">
        <option value="" selected="selected"><?php echo $lang[526]; ?></option>
		<?php if($row_chk_rr[0]==0){ ?>
        <option value="review_rating"><?php echo $lang[609]; ?></option>
        <?php }	?>
        <option value="send_message"><?php echo $lang[353]; ?></option>
	    </select>
		</td>
	</tr>
<?php	} 
}else{	?>
	<tr><td colspan="7"><?php echo $lang[616].'&nbsp;'; ?></td></tr>
<?php	}	?>
	
<style>select { font-size:13px; }</style>
	 </tbody>
	  		</table>
<!------------------------- pagination start here ----------->
<?php
/* -----Total count--- */
$query_pag_num = "select count(*) AS count from project,bid,user where prj_id=bd_prj_id and prj_usr_id=usr_id and bd_usr_id='".$_SESSION['uid']."' and bd_status='1' and prj_status='running' and prj_id not in(select rr_prj_id from review_rating where rr_from_usr=prj_usr_id and (rr_completionrate='1' or rr_completionrate='0'))"; // Total records
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
    <li class="prev"><a href="javascript:loadCurrentWork('<?php echo $pre; ?>')"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
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
        <li><a href="javascript:loadCurrentWork('<?php echo $i; ?>')"><?php echo $i; ?></a></li>
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
    <li class="next"><a href="javascript:loadCurrentWork('<?php echo $nex; ?>')"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
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