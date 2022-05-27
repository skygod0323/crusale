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

$sql_ob="select * from project where prj_usr_id='".$_SESSION['uid']."' and now()<prj_expiry and prj_id not in(select bd_prj_id from bid where bd_status=1) and prj_status='open' order by prj_updated_date desc LIMIT $start, $per_page";

$res_ob=mysql_query($sql_ob) or die('MySql Error' . mysql_error());


?>
<div class="row" id="OpnBid">
	<div class="col-xs-12">
		<div class="table-responsive">
<table class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th><?php echo $lang[610]; ?></th>
			<th><?php echo $lang[488]; ?></th>
			<th><?php echo $lang[489]; ?></th>
			<th><?php echo $lang[600]; ?></th>
			<th><?php echo $lang[601]; ?></th>
			<th><?php echo $lang[598]; ?></th>
		</tr>
	</thead>
    <tbody>
		
<?php
	if(mysql_num_rows($res_ob)>0)	{
		while($row_ob=mysql_fetch_object($res_ob)){
	

			?>
            <tr>
				<td  width="26%" align="left" valign="top"><a href="project.php?p=<?php echo $row_ob->prj_id; ?>"><?php echo $row_ob->prj_name; ?></a></td>
        <?php
	        $sql_ca="select count(*),avg(bd_amount) from bid where bd_prj_id='".$row_ob->prj_id."'";
			$res_ca=mysql_query($sql_ca);
			$row_ca=mysql_fetch_array($res_ca);
			?>
		
				<td width="13%" align="left" valign="top"><?php echo $row_ca[0]; ?></td>
				<td width="14%" align="left" valign="top">
                <?php
					if($row_ca[1]=='' || $row_ca[1]==0)	{	echo "-";	}
					else	{	echo getCurrencySymbol()."&nbsp;".number_format($row_ca[1],2);	}
        		?>
                </td>
                <?php
                    $sql_m="select count(*) from message where msg_prj_id='".$row_ob->prj_id."' and msg_to='".$_SESSION['uid']."'";
                    $res_m=mysql_query($sql_m);
                    $row_m=mysql_fetch_array($res_m);
					
					$sql_ur="select count(*) from message where msg_prj_id='".$row_ob->prj_id."' and msg_to='".$_SESSION['uid']."' and msg_read='0'";
                    $res_ur=mysql_query($sql_ur);
                    $row_ur=mysql_fetch_array($res_ur);
                
			    if($row_m[0]==0){
				?>
                <td width="12%" align="left" valign="top"><?php echo $row_m[0]; ?></td>
                <?php
				}
				else
				{
					?>
                    <td width="12%" align="left" valign="top">
                    	<a href="mymessage.php"><?php echo $row_m[0]; ?></a>
                    <?php if($row_ur[0]>0){ ?>
					<sup style="color:green; font-weight: bold"> +<?php echo $row_ur[0].$lang[608]; ?></sup>
                    <?php	}	?>
	        		</td>
                <?php
				}
				?>
                <td width="20%" align="left" valign="top">
    		    <?php
					$diff=dateDifference(date("Y-m-d h:i:s"),$row_ob->prj_expiry);
					if($diff>0){
					echo 'in '.$diff.' days';
					}
					else {
						echo 'Today';
					}
				?>
        		</td>
				<td width="15%" align="left" valign="top">
			<select id="project-action" class="action-on-proj" style="width:110px;" onChange="takeAction(<?php echo $row_ob->prj_id; ?>,this.value,'<?php echo md5($row_ob->prj_id); ?>')">
				<option value="" selected="selected"><?php echo $lang[526]; ?></option>
				<option value="delproj"><?php echo$lang[400]; ?></option>
				<option value="awardproj"><?php echo $lang[611]; ?></option>
				<option value="editproj"><?php echo $lang[399]; ?></option>
				<option value="closeProj"><?php echo $lang[612]; ?></option>
			</select>
		</td>
	</tr>
<?php	 } 
	}else{	?>
	<tr><td colspan="6"><?php echo $lang[605]; ?>&nbsp;</td></tr>
    <?php
}	?>
<style>select { font-size:13px; }</style>
	
          </tbody>
	  		</table>
<!------------------------- pagination start here ----------->
<?php
/* -----Total count--- */
$query_pag_num = "select count(*) AS count from project where prj_usr_id='".$_SESSION['uid']."' and now()<prj_expiry and prj_id not in(select bd_prj_id from bid where bd_status=1) and prj_status='open'"; // Total records
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
    if ($no_of_paginations > 7){
        $end_loop = 7;
	}
    else{
        $end_loop = $no_of_paginations;
	}
}
?>

<?php if($count>0){	?>
<ul class="pagination pull-right no-margin">
<?php
// FOR ENABLING THE PREVIOUS BUTTON
if ($previous_btn && $cur_page > 1) {
    $pre = $cur_page - 1;
	?>
    <li class="prev"><a href="javascript:loadOpenForBidding('<?php echo $pre; ?>')"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
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
        <li><a href="javascript:loadOpenForBidding('<?php echo $i; ?>')"><?php echo $i; ?></a></li>
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
    <li class="next"><a href="javascript:loadOpenForBidding('<?php echo $nex; ?>')"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
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