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

$sql_out="select * from invoice,project,user where inv_prj_id=prj_id and prj_usr_id=usr_id and inv_usr_id='".$_SESSION['uid']."' and inv_status='1' order by inv_payment_status,inv_creation_date LIMIT $start, $per_page";
$res_out=mysql_query($sql_out) or die('MySql Error' . mysql_error());
?>
<div class="row" id="CurWrk">
	<div class="col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<thead>
		    		<tr>
						<th style="text-align:center"><?php echo $lang[762]; ?></th>
	                   	<th style="text-align:center"><?php echo $lang[59]; ?></th>
    	               	<th><?php echo $lang[18]; ?></th>
                		<th>Employer</th>
                        <th style="text-align:right"><?php echo $lang[62]; ?> (<?php echo getCurrencyCode(); ?>)</th>
						<th style="text-align:center"><?php echo $lang[61]; ?></th>
		        	</tr>
				</thead>
               	<tbody>
                <?php
					if(mysql_num_rows($res_out)>0)
					{
						while($row_out=mysql_fetch_object($res_out)){
				?>
                   	<tr>
                         <td width="18%" valign="top" style="text-align:center"><?php echo $row_out->inv_id; ?></td>
                         <td width="10%" style="text-align:center"><?php echo date("d-M-y",strtotime($row_out->inv_creation_date)); ?></td>
                         <td width="32%" style="text-align:left"><a href="project.php?p=<?php echo $row_out->prj_id; ?>" target="_blank"><?php echo $row_out->prj_name; ?></a></td>
                         <td width="18%" align="left"><a href="profile.php?u=<?php echo md5($row_out->usr_id); ?>" target="_blank"><?php echo $row_out->usr_name; ?></a></td>
                         <td width="12%" style="text-align:right"><?php echo getCurrencySymbol()." ".$row_out->inv_amount; ?></td>
                         <td width="10%" style="text-align:center"><?php	if($row_out->inv_payment_status=='0'){ echo $lang[69]; }else{ echo $lang[774]; } ?></td>
                    </tr>
               <?php
					}
				}else{
			?>
                   	<tr><td colspan="6" align="center"><p class="alert" style="color:#F00"><?php echo $lang[775]; ?></p></td></tr>
            <?php	}	?>
                     	<style>select { font-size:13px; }</style>
				</tbody>
			</table>
            
            <?php	
					/* -----Total count--- */
					$query_pag_num="select count(*) AS count from invoice,project,user where inv_prj_id=prj_id and prj_usr_id=usr_id and inv_usr_id='".$_SESSION['uid']."' and inv_status='1'"; // Total records
					$result_pag_num = mysql_query($query_pag_num);
					$row = mysql_fetch_array($result_pag_num);
					$count = $row['count'];
					$no_of_paginations = ceil($count / $per_page);

					if ($cur_page >= 7)
					{
					    $start_loop = $cur_page - 3;
					    if ($no_of_paginations > $cur_page + 3)
					        $end_loop = $cur_page + 3;
					    else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6)
						{
					        $start_loop = $no_of_paginations - 6;
					        $end_loop = $no_of_paginations;
					    }
						else
						{
					        $end_loop = $no_of_paginations;
					    }
					}
					else
					{
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
    <li class="prev"><a href="javascript:loadOutgoingInvoice('<?php echo $pre; ?>')"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
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
        <li><a href="javascript:loadOutgoingInvoice('<?php echo $i; ?>')"><?php echo $i; ?></a></li>
	<?php	}
}
	 ?>
<?php
// TO ENABLE THE NEXT BUTTON
if ($next_btn && $cur_page < $no_of_paginations) {
    $nex = $cur_page + 1;	?>
    <li class="next"><a href="javascript:loadOutgoingInvoice('<?php echo $nex; ?>')"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
<?php	} else if ($next_btn) {	?>
    <li class="next disabled"><a><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
<?php	}	?>
	<!--<li class="next">
		<a href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
	</li>-->
</ul>
<?php	}	?>
            
		</div>
	</div>
</div>
<?php	}	?>