<?php
ob_start();
session_start();
include "../common.php";

if($_POST['page'])
{
$page = $_POST['page'];
$cur_page = $page;
$page -= 1;
$per_page = 20; // Per page records
$previous_btn = true;
$next_btn = true;
//$first_btn = false;
//$last_btn = false;
$start = $page * $per_page;

if(isset($_POST['sender']) && $_POST['sender']!='')
{
	$sql_sender=" and tr_from_id in(select usr_id from user where usr_name like '%".$_POST['sender']."%')";
}
else
{
	$sql_sender="";
}
if(isset($_POST['receiver']) && $_POST['receiver']!='')
{
	$sql_rec=" and tr_to_id in(select usr_id from user where usr_name like '%".$_POST['receiver']."%')";
}
else
{
	$sql_rec="";
}
if(isset($_POST['transfer_type']) && $_POST['transfer_type']!='')
{
	$sql_type=" and tr_type like '%".$_POST['transfer_type']."%'";
}
else
{
	$sql_type="";
}

$sql="select * from transaction where tr_status='1' ".$sql_sender.$sql_rec.$sql_type." order by tr_updated_date desc LIMIT $start, $per_page";	
$recObj=mysql_query($sql) or die('MySql Error' . mysql_error());

?>


<ul>
   <?php $j=0;
   $count=mysql_num_rows($recObj);
   if($count >0)
   {		  
   		while($row=mysql_fetch_object($recObj)){
	   	?>
	<li <?php if($j % 2 == 1) { ?> class="row-clr" <?php } ?> >
		<!--<div class="checkbox" style="width:3%;  padding-top:2px;"><input name="cb[]" type="checkbox" value="<?php /*echo $row->usr_id*/ ?>" /></div>-->
        <div class="eID" style="width:120px"><?php echo date("d M,Y",strtotime($row->tr_updated_date)); ?></div>
        <div class="eID" style="width:150px">
		<?php 
			$sql_from="select * from user where usr_id='".$row->tr_from_id."'";
			$res_from=mysql_query($sql_from);
			$row_from=mysql_fetch_object($res_from);
			echo stripslashes($row_from->usr_name);
		?>
        </div>
        <div class="eID" style="width:150px">
		<?php 
			$sql_to="select * from user where usr_id='".$row->tr_to_id."'";
			$res_to=mysql_query($sql_to);
			$row_to=mysql_fetch_object($res_to);
			echo stripslashes($row_to->usr_name); 
		?>
        </div>
        <div class="eID" style="width:120px"><?php echo number_format($row->tr_amount,2); ?></div>
        <div class="eID" style="width:120px"><?php echo strtoupper(stripslashes($row->tr_type)); ?></div>
        <div class="action">
        <?php
		   	if($row->tr_type == 'escrow' && $row->tr_release =='1'){ echo "<font color='#009900'><strong>Released</strong><font>"; }
			else if($row->tr_type == 'escrow' && $row->tr_release =='0' && $row->tr_status =='0') { echo "<font color='#CC0000'><strong>Cancelled</strong><font>"; }
			else if($row->tr_type != 'escrow') { echo "N/A"; }
			else { ?>
            <a href="<?php echo $al->releaselink($row->tr_id) ?>" title="Release" onclick="return confirm('Are you sure to release the fund?')"><img alt="Release" src="../images/active.jpg" border="0"></a>
            <a href="<?php echo $al->cancellink($row->tr_id) ?>" title="Cancel" onclick="return confirm('Are you sure to cancel the transaction?')"><img alt="Cancel" src="../images/suspend.jpg" border="0"></a>            
            <?php } ?>
        </div>
            
        <div class="clr"></div>
    </li>
	<?php $j++; } 
	} else {
	?>
	<div class="admin-dtls" style="text-align:center; color:red; border-bottom:1px solid #ccc; padding-bottom:5px; font-weight:bold; font-size:14px;">No Records.</div>
	<?php } ?>       
</ul>
<div class="pagicon">
<!--<div class="dlt-btn"><input name="Delete" type="button" value="Delete" class="delete-btn" /></div>--> 
	<div class="item-no"><?php /*echo ($start+1)." to ".($start+$per_page)." of ".$count;*/ ?></div>
    
	<div class="page-no">
       	
        <!------------------------- pagination start here ----------->
<?php
/* -----Total count--- */


if(isset($_POST['sender']) && $_POST['sender']!='')
{
	$sql_sender_cnt=" and tr_from_id in(select usr_id from user where usr_name like '%".$_POST['sender']."%')";
}
else
{
	$sql_sender_cnt="";
}
if(isset($_POST['receiver']) && $_POST['receiver']!='')
{
	$sql_rec_cnt=" and tr_to_id in(select usr_id from user where usr_name like '%".$_POST['receiver']."%')";
}
else
{
	$sql_rec_cnt="";
}
if(isset($_POST['transfer_type']) && $_POST['transfer_type']!='')
{
	$sql_type_cnt=" and tr_type like '%".$_POST['transfer_type']."%'";
}
else
{
	$sql_type_cnt="";
}


$query_pag_num="select count(*) as count from transaction where tr_status='1' ".$sql_sender_cnt.$sql_rec_cnt.$sql_type_cnt."";	// Total records
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
		<div class="pagination">
        <?php
// FOR ENABLING THE PREVIOUS BUTTON
if ($previous_btn && $cur_page > 1) {
    $pre = $cur_page - 1;
	?>
		<a href="javascript:loadTransferView('<?php echo $pre; ?>');">« prev</a>
<?php	} else if ($previous_btn) {	?>
			<span class="disabled">« prev</span>
<?php	}	?>


 <?php
for ($i = $start_loop; $i <= $end_loop; $i++) {
    if ($cur_page == $i){	?>
        <span class="current"><?php echo $i; ?></span>
	<?php	}else{	?>
       <a href="javascript:loadTransferView('<?php echo $i; ?>')"><?php echo $i; ?></a>
	<?php	}
}
	 ?>
     
     
<!--           	<span class="disabled">« prev</span>
            <span class="current">1</span>
            <a href="../transfer-view.php?limit=20&page=2">2</a>
            <a href="../transfer-view.php?limit=20&page=3">3</a>
            <a href="../transfer-view.php?limit=20&page=4">4</a>
            <a href="../transfer-view.php?limit=20&page=2">next »</a>-->
<?php
// TO ENABLE THE NEXT BUTTON
if ($next_btn && $cur_page < $no_of_paginations) {
    $nex = $cur_page + 1;	?>
    <a href="javascript:loadTransferView('<?php echo $nex; ?>');">next »</a>
<?php	} else if ($next_btn) {	?>
   <span class="disabled">next »</span>
<?php	}	?>


		</div>
<?php	}	?>            
		
        <!------------------------- pagination end here ----------->

	</div>
	<div class="clr"></div>
</div>

<?php	}	?>