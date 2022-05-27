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


$sql_dp="select * from deposit_fund where df_usr_id='".$_SESSION['uid']."' order by df_paydate desc LIMIT $start, $per_page";
$res_dp=mysql_query($sql_dp) or die('MySql Error' . mysql_error());
?>
<div style="padding-bottom:20px;"><!--<a href="#" class="export-transation-txt">+ Export Transaction</a>--></div>
<div class="clearfix" style="padding-bottom:30px;">
	<div class="show-tran-col"><!--Show&nbsp;&nbsp;<img src="images/tran-list-img.jpg" alt="" />--></div>
	<div class="top-pagination-col"><!--<img src="images/pagination.jpg" alt="" />--></div>
</div>
<div class="tran-history-detail-box">
	<table class="table table-striped table-bordered table-hover">
		<thead>
    		<tr>
				<th><?php echo $lang[59]; ?></th>
				<th><?php echo $lang[66]; ?></th>
				<th><?php echo $lang[62]; ?> (<?php echo getCurrencyCode(); ?>)</th>
			</tr>
		</thead>
		<tbody>
        <?php
			if(mysql_num_rows($res_dp)>0)	{
				$c=1;
				while($row_dp=mysql_fetch_object($res_dp)){	
		?>
			<tr>
				<td width="15%" align="left" valign="top"><?php echo date("d-F-Y",strtotime($row_dp->df_paydate)); ?></td>
				<td width="65%" align="left" valign="top"><?php echo strtoupper($row_dp->df_method); ?></td>
				<td width="20%" align="left" valign="top" ><?php echo getCurrencySymbol()."&nbsp;".strtoupper($row_dp->df_amount); ?></td>
			</tr>
		<?php } 
		}else{	?>
			<tr>
		       	<td width="100%" colspan="3" valign="top"><?php echo $lang[67]; ?></td>
			</tr>
			<?php } ?>
		<style>select { font-size:13px; }</style>
	</tbody>
	</table>
    
<!------------------------- pagination start here ----------->
<?php
/* -----Total count--- */
$query_pag_num = "select count(*) AS count from deposit_fund where df_usr_id='".$_SESSION['uid']."'"; // Total records
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
    <li class="prev"><a href="javascript:loadAllDepositTrans('<?php echo $pre; ?>')"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
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
        <li><a href="javascript:loadAllDepositTrans('<?php echo $i; ?>')"><?php echo $i; ?></a></li>
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
    <li class="next"><a href="javascript:loadAllDepositTrans('<?php echo $nex; ?>')"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
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
		</div>
	
<?php
}
?>
