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


$sql_prj="select * from project,bid,user where prj_id=bd_prj_id and prj_usr_id=usr_id and bd_usr_id='".$_SESSION['uid']."' and bd_status=0 and prj_status='open' and prj_expiry > now() order by bd_date desc LIMIT $start, $per_page";
$res_prj=mysql_query($sql_prj) or die('MySql Error' . mysql_error());

?>
<div class="row" id="ActBid">
	<div class="col-xs-12">
		<div class="table-responsive">
<table class="table table-striped table-bordered table-hover">
	<thead>
    	<tr>
            <th><?php echo $lang[18]; ?></th>
	        <th><?php echo $lang[20]; ?></th>
            <th><?php echo $lang[599]; ?></th>
            <th><?php echo $lang[60]; ?></th>
            <th><?php echo $lang[489]; ?></th>
            <th><?php echo $lang[600]; ?></th>
            <th><?php echo $lang[601]; ?></th>
			<th><?php echo $lang[598]; ?></th>
    	</tr>
	</thead>

<?php
	if(mysql_num_rows($res_prj)>0)	{
		while($row_prj=mysql_fetch_object($res_prj)){
?>
		<tr>
			<td width="24%" align="left" valign="top"><a href="project.php?p=<?php echo $row_prj->prj_id; ?>"><?php echo $row_prj->prj_name; ?></a></td>

<?php
	        $sql_ca2="select count(*),avg(bd_amount) from bid where bd_prj_id='".$row_prj->prj_id."'";
			$res_ca2=mysql_query($sql_ca2);
			$row_ca2=mysql_fetch_array($res_ca2);
?>			

			<td width="6%" align="left" valign="top"><?php echo $row_ca2[0]; ?></td>
			<td width="12%" align="left" valign="top"><?php echo getCurrencySymbol().'&nbsp'.$row_prj->bd_amount; ?>
        
<?php		if($row_prj->usr_balance<$row_prj->bd_amount){	?>
			<img style="vertical-align: middle;" title="<?php echo $lang[602]; ?>" src="images/cross.png" border="0">
	<?php	}	?>
			</td>
			<td width="13%" align="left" valign="top"><a href="profile.php?u=<?php echo md5($row_prj->usr_id); ?>"><?php echo $row_prj->usr_name; ?></a></td>

	<?php	if($row_ca2[1]=='' || $row_ca2[1]==0)	{	?><td width="14%" align="left" valign="top">-</td><?php	}	
			else	{	?>
            	<td width="14%" align="left" valign="top"><?php echo getCurrencySymbol().'&nbsp;'.number_format($row_ca2[1],2); ?></td>
	<?php	}
        	$sql_m="select count(*) from message where msg_prj_id='".$row_prj->prj_id."' and msg_to='".$_SESSION['uid']."'";
            $res_m=mysql_query($sql_m);
            $row_m=mysql_fetch_array($res_m);
					
			$sql_ur="select count(*) from message where msg_prj_id='".$row_prj->prj_id."' and msg_to='".$_SESSION['uid']."' and msg_read='0'";
            $res_ur=mysql_query($sql_ur);
            $row_ur=mysql_fetch_array($res_ur);
		
			if($row_m[0]==0){
		?>
			<td width="6%" align="left" valign="top"><?php echo $row_m[0]; ?></td>
		<?php	}
			else
			{	?>
				<td width="6%" align="left" valign="top"><a href="mymessage.php"><?php echo $row_m[0]; ?></a>
                <?php	if($row_ur[0]>0){ ?><sup style="color:green; font-weight: bold"> +<?php echo $row_ur[0].' unread'; ?></sup><?php	}	?>
	        	</td>
		<?php	}
			$diff=dateDifference(date("Y-m-d h:i:s"),$row_prj->prj_expiry);
			if($diff>0){	?>
				<td width="14%" align="left" valign="top"><?php echo 'in '.$diff.' days'; ?></td>
		<?php
			}
			else {	?>
				<td width="14%" align="left" valign="top">Today</td>
		<?php	}	?>
		
			<td width="11%" align="left" valign="top">
    <select class="sellerview-action-on-proj" proj_id="2392241" buyer_id="3954907" style="width:110px;" onChange="takeAction('<?php echo $row_prj->bd_id; ?>',this.value,'<?php echo md5($row_prj->prj_id); ?>')">
        <option value="" selected="selected"><?php echo $lang[526]; ?></option>
        <option value="retract"><?php echo $lang[603]; ?></option>
        <option value="edit_bid"><?php echo $lang[604]; ?></option>
        <option value="send_message"><?php echo $lang[353]; ?></option>
    </select>
</td>
	</tr>
    <tr id="edit_bid_<?php echo $row_prj->bd_id; ?>" style="display:none;">
    <td style="text-align: left;width:100%" colspan="8">
	    <!--<div style="padding-left:10px;">
			<span class="project_tag"><a href="project.php?p=<?php /*echo $row_prj->prj_id;*/ ?>"><?php /*echo $row_prj->prj_name;*/ ?></a></span>
		</div>-->
    <?php echo $lang[667]; ?>:<input type="text" id="new_bid_amt" />&nbsp;&nbsp;<input type="button" value="Bid" onClick="editBidSubmit('<?php echo $row_prj->bd_id; ?>')" class="btn btn-info btn-sm" style="margin:1px 1px 1px 1px;"/>&nbsp;<input type="button" onClick="editBidCancel('<?php echo $row_prj->bd_id; ?>')" value="<?php echo $lang[398]; ?>" class="btn btn-info btn-sm" style="margin:1px 1px 1px 1px;"/>
    </td>
    </tr>
<?php
	 } 
}else{
	?><tr><td colspan="8"><?php echo $lang[605].'&nbsp;'; ?></td></tr>
    <?php
}
	?>
<style>select { font-size:13px; }</style>

	</table>
<!------------------------- pagination start here ----------->
<?php
/* -----Total count--- */
$query_pag_num = "select count(*) AS count from project,bid,user where prj_id=bd_prj_id and prj_usr_id=usr_id and bd_usr_id='".$_SESSION['uid']."' and bd_status=0 and prj_status='open' and prj_expiry > now()"; // Total records
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
    <li class="prev"><a href="javascript:loadActiveBids('<?php echo $pre; ?>')"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
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
        <li><a href="javascript:loadActiveBids('<?php echo $i; ?>')"><?php echo $i; ?></a></li>
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
    <li class="next"><a href="javascript:loadActiveBids('<?php echo $nex; ?>')"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
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
<?php
}
?>