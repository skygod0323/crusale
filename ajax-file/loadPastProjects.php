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

$sql_pp="select * from project p,bid where bd_prj_id=p.prj_id and bd_status=1 and p.prj_usr_id='".$_SESSION['uid']."' and (p.prj_id in(select rr_prj_id from review_rating where rr_from_usr=p.prj_usr_id and (rr_completionrate='1' or rr_completionrate='0')) or p.prj_status='close') order by p.prj_updated_date desc LIMIT $start, $per_page";
$res_pp=mysql_query($sql_pp) or die('MySql Error' . mysql_error());

?>
<div class="row" id="PstPrj">
	<div class="col-xs-12">
		<div class="table-responsive">
<table class="table table-striped table-bordered table-hover">
	<thead>
    	<tr>
        	<th><?php echo $lang[18]; ?></th>
			<th><?php echo $lang[20]; ?></th>
			<th><?php echo $lang[64]; ?></th>
			<th><?php echo $lang[606]; ?></th>
			<th><?php echo $lang[600]; ?></th>
           	<th><?php echo $lang[61]; ?></th>
			<th><?php echo $lang[598]; ?></th>

		</tr>
     </thead>
		<tbody>
<?php
if(mysql_num_rows($res_pp)>0)	{
		while($row_pp=mysql_fetch_object($res_pp)){
?>
	<tr>
		<td width="24%" align="left" valign="top" class="project-header-name"><a href="project.php?p=<?php echo $row_pp->prj_id; ?>"><?php echo $row_pp->prj_name; ?></a></td>
		<?php
			$sql_pbd="select count(*) from bid where bd_prj_id='".$row_pp->prj_id."'";
			$res_pbd=mysql_query($sql_pbd);
			$row_pbd=mysql_fetch_row($res_pbd);
		?>
	    <td width="8%" align="left" valign="top"><?php echo $row_pbd[0]; ?></td>
		<?php
			$sql_f="select * from user where usr_id=(select bd_usr_id from bid where bd_prj_id='".$row_pp->prj_id."' and bd_status='1')";
			$res_f=mysql_query($sql_f);

        	if(mysql_num_rows($res_f)>0){	
			$row_f=mysql_fetch_object($res_f);
		?>
        <td width="22%" align="left" valign="top"><a href="profile.php?u=<?php echo md5($row_f->usr_id); ?>"><?php echo $row_f->usr_name; ?></a></td>
        <?php	}else{	?>
        <td width="22%" align="left" valign="top">-</td>
        <?php	} 

        	$sql_awb="select * from bid where bd_prj_id='".$row_pp->prj_id."' and bd_status='1'";
			$res_awb=mysql_query($sql_awb);

			if(mysql_num_rows($res_awb)>0){		
				$row_awb=mysql_fetch_object($res_awb);
				?>
				<td width="13%" align="left" valign="top"><?php echo getCurrencySymbol()."&nbsp;".number_format($row_awb->bd_amount,2); ?></td>
			<?php
			}
			else
			{	?>
				<td width="13%" align="left" valign="top">-</td>
			<?php	}
        	$sql_m="select count(*) from message where msg_prj_id='".$row_pp->prj_id."' and msg_to='".$_SESSION['uid']."'";
            $res_m=mysql_query($sql_m);
            $row_m=mysql_fetch_array($res_m);
					
			$sql_ur="select count(*) from message where msg_prj_id='".$row_pp->prj_id."' and msg_to='".$_SESSION['uid']."' and msg_read='0'";
            $res_ur=mysql_query($sql_ur);
            $row_ur=mysql_fetch_array($res_ur);
		
		if($row_m[0]==0){
			?>
			<td width="8%" align="left" valign="top"><?php echo $row_m[0]; ?></td>
            <?php
			}	else	{
			?>
				<td width="8%" align="left" valign="top"><a href="mymessage.php"><?php echo $row_m[0]; ?></a>
            <?php
				if($row_ur[0]>0){ 
			?>
            <sup style="color:green; font-weight: bold"> +<?php echo $row_ur[0].$lang[608]; ?></sup>
            <?php }	?>
	        	</td>
            <?php
			}

		
		if($row_pp->prj_status=='close' ) { 
		?>
		<td width="15%" align="left" valign="top"><?php echo $lang[613]; ?></td>
		<td width="10%" align="left" valign="top">
    <select class="sellerview-action-on-proj" proj_id="2392241" buyer_id="3954907" style="width:110px;" onChange="takeAction('<?php echo $row_pp->prj_id; ?>',this.value,'<?php echo md5($row_pp->prj_id); ?>')">
        <option value="" selected="selected"><?php echo $lang[526]; ?></option>
        <option value="repostProj"><?php echo $lang[614]; ?></option>
        <option value="delproj"><?php echo $lang[400]; ?></option>
    </select>
		</td>

<?php
		} else {
			$sql_rr="select * from review_rating where rr_from_usr='".$row_pp->prj_usr_id."' and rr_prj_id='".$row_pp->prj_id."'";
			$res_rr=mysql_query($sql_rr);
			$row_rr=mysql_fetch_object($res_rr);
			if($row_rr->rr_completionrate == '1'){
				?><td width="15%" align="left" valign="top"><?php echo $lang[338]; ?></td><?php
			}
			else{
				?><td width="15%" align="left" valign="top" style="color:#F66"><?php echo $lang[615]; ?></td><?php
			}
                  
            if($row_rr->rr_work_quality =='0' && $row_rr->rr_communication =='0' && $row_rr->rr_expertise =='0' && $row_rr->rr_work_hire_again =='0' && $row_rr->rr_professionalism =='0'){
			?>
            <td width="10%" align="left" valign="top"><select class="sellerview-action-on-proj" style="width:110px;" onChange="takeAction('<?php echo $row_pp->bd_id; ?>',this.value,'<?php echo md5($row_pp->bd_id); ?>')">
        <option value="" selected="selected"><?php echo $lang[526]; ?></option>
        <option value="review_rating"><?php echo $lang[609]; ?></option>
    </select></td>
    <?php
                  }
                  
		}
		?>
	</tr>
    <?php
	 } 
}else{	?>
	<tr><td colspan="8"><?php echo $lang[616].'&nbsp'; ?></td></tr>
    <?php
}
	?>
<style>select { font-size:13px; }</style>
	</tbody>
	</table>
    <!------------------------- pagination start here ----------->
<?php
/* -----Total count--- */
$query_pag_num = "select count(*) AS count from project p,bid where bd_prj_id=p.prj_id and bd_status=1 and p.prj_usr_id='".$_SESSION['uid']."' and (p.prj_id in(select rr_prj_id from review_rating where rr_from_usr=p.prj_usr_id and (rr_completionrate='1' or rr_completionrate='0')) or p.prj_status='close')"; // Total records
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
    <li class="prev"><a href="javascript:loadPastProjects('<?php echo $pre; ?>')"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
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
        <li><a href="javascript:loadPastProjects('<?php echo $i; ?>')"><?php echo $i; ?></a></li>
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
    <li class="next"><a href="javascript:loadPastProjects('<?php echo $nex; ?>')"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
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