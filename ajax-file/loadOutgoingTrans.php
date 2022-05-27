<?php
ob_start();
session_start();
include "../common.php";

if($_POST['page'])
{
$page = $_POST['page'];
$cur_page = $page;
$page -= 1;
$per_page = 15; // Per page records
$previous_btn = true;
$next_btn = true;
//$first_btn = false;
//$last_btn = false;
$start = $page * $per_page;

$sql_out="select * from transaction where tr_from_id='".$_SESSION['uid']."' order by tr_updated_date desc LIMIT $start, $per_page";
$res_out=mysql_query($sql_out) or die('MySql Error' . mysql_error());

?>
<table class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
            <th><?php echo $lang[59]; ?></th>
			<th><?php echo $lang[64]; ?></th>
			<th><?php echo $lang[18]; ?></th>
			<th><?php echo $lang[61]; ?></th>
        	<th><?php echo $lang[62]; ?> (<?php echo getCurrencyCode(); ?>)</th>
		</tr>
	</thead>
    <tbody>
	<?php
		if(mysql_num_rows($res_out)>0){
			$c=1;
			while($row_out=mysql_fetch_object($res_out)){	
			?>
				<tr>
					<td width="10%" align="left" valign="top"><?php echo date("d-M-Y",strtotime($row_out->tr_updated_date)); ?></td>
					<td width="25%" align="left" valign="top">
					<?php
						if($row_out->tr_to_id != '0'){
							$sql_out_u="select usr_name from user where usr_id='".$row_out->tr_to_id."'";
							$res_out_u=mysql_query($sql_out_u);
							if(mysql_num_rows($res_out_u)){
								$row_out_u=mysql_fetch_object($res_out_u);
								echo ucfirst($row_out_u->usr_name);
							}else{
								echo "-";
							}
						}else{	echo "-";	}
					?>
                    </td>
					<td width="30%" align="left" valign="top">
                    <?php
							if($row_out->tr_prj_id != '0'){
								$sql_out_p="select prj_name from project where prj_id='".$row_out->tr_prj_id."'";
								$res_out_p=mysql_query($sql_out_p);
								if(mysql_num_rows($res_out_p)){
									$row_out_p=mysql_fetch_object($res_out_p);
									echo ucfirst($row_out_p->prj_name);
													}else{
														echo "-";
													}
												}else{	echo "-";	}
											?>
                                            </td>
											<td width="20%" align="left" valign="top">
											<?php	if($row_out->tr_type=='escrow'){	
													
													$sql_esc="select * from escrow where es_tr_id='".$row_out->tr_id."' and es_status='0'";
													$res_esc=mysql_query($sql_esc);
													if(mysql_num_rows($res_esc)>0)
													{
														echo "PAID";
													}
													else
													{
														echo strtoupper($row_out->tr_type);
													}
                                            	}else{
												echo strtoupper($row_out->tr_type);
                                            	}	?>
                                            </td>
											<td width="15%" align="left" valign="top"><?php echo getCurrencySymbol()."&nbsp;".$row_out->tr_amount; ?></td>
										  </tr>
										 <?php }
											}else{	?>
										<tr>
											<td colspan="5" valign="top"><?php echo $lang[65]; ?></td>
										</tr>
        <?php } ?>
	<style>select { font-size:13px; }</style>
	</tbody>
</table>
<!------------------------- pagination start here ----------->
<?php
/* -----Total count--- */
$query_pag_num = "select count(*) AS count from transaction where tr_from_id='".$_SESSION['uid']."'"; // Total records
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

<?php if($count>$per_page){	?>
<ul class="pagination pull-right no-margin">
<?php
// FOR ENABLING THE PREVIOUS BUTTON
if ($previous_btn && $cur_page > 1) {
    $pre = $cur_page - 1;
	?>
    <li class="prev"><a href="javascript:showTransOut('<?php echo $pre; ?>')"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
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
        <li><a href="javascript:showTransOut('<?php echo $i; ?>')"><?php echo $i; ?></a></li>
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
    <li class="next"><a href="javascript:showTransOut('<?php echo $nex; ?>')"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
<?php	} else if ($next_btn) {	?>
    <li class="next disabled"><a><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
<?php	}	?>
	<!--<li class="next">
		<a href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
	</li>-->
</ul>
<div style="text-align:right; padding-bottom:50px;"><!--<img src="images/pagination.jpg" alt="" />--></div>
<?php	}	?>
<!------------------------- pagination end here ----------->

<?php	}	?>