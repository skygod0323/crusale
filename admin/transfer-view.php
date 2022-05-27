<?php 
ob_start();
session_start(); 
include "../common.php";
//include "lib/pagination.php";

check_user_login();
class listUsers{
	/*var $start="";
	var $limit="";*/
	var $sqlList="";
	var $start="";
	var $limit="";
	
	function setsql($sql){
		$this->sqlList=$sql;
	}
	function totalrecord(){
		return mysql_num_rows(mysql_query($this->sqlList));
	}
	function listview(){
		$sql=$this->sqlList;
		$res=mysql_query($sql);
		return $res;
	}
	/*function fetchRecord(){
		return mysql_fetch_object($this->listview());
	}*/
	function numpage($rowPage){
		 return floor($this->totalrecord()/$rowPage);
	}
	function cancelrecord($adid){
		//mysql_query("delete from news_details where news_id='".$adid."'");
		
		$sql_us="select * from user,escrow,transaction where es_tr_id=tr_id and usr_id=es_from_id and tr_id='".$adid."'";
		$res_us=mysql_query($sql_us);
		$row_us=mysql_fetch_object($res_us);
		
		$new_bal = $row_us->usr_balance + $row_us->es_amount;
		
		$sql_upd="update user
			set
				usr_balance=".$new_bal."
			where
				usr_id='".$row_us->usr_id."'";
			
		mysql_query($sql_upd);
		
		$sql_rel="update transaction
			set
				tr_status = '0'
			where
				tr_id = '".$row_us->es_tr_id."'";
		
		mysql_query($sql_rel);
		
		$sql_esc="delete from escrow 
		where 
			es_id='".$row_us->es_id."'";
		mysql_query($sql_esc);
		
	}
	function releaserecord($adid)
	{
		$sql_us="select * from user,escrow,transaction where es_tr_id=tr_id and usr_id=es_to_id and tr_id='".$adid."'";
		$res_us=mysql_query($sql_us);
		$row_us=mysql_fetch_object($res_us);
		
		$new_bal = $row_us->usr_balance + $row_us->es_amount;
		
		$sql_upd="update user
			set
				usr_balance=".$new_bal."
			where
				usr_id='".$row_us->es_to_id."'";
			
		mysql_query($sql_upd);
		
		$sql_rel="update transaction
			set
				tr_release = '1'
			where
				tr_id = '".$row_us->es_tr_id."'";
		
		mysql_query($sql_rel);
		
		$sql_esc="update escrow 
			set
				es_status = '0'
		where 
			es_id='".$row_us->es_id."'";
		mysql_query($sql_esc);
		
	}
	function cancellink($id){
		if($_SERVER['QUERY_STRING']==""){
			$suslink="?action=can&fid=".$id;
		}
		else{
			$suslink="request-view.php?".$_SERVER['QUERY_STRING']."&action=can&fid=".$id;
		}
		return $suslink;
	}
	function releaselink($id){
		if($_SERVER['QUERY_STRING']==""){
			$actlink="?action=rel&fid=".$id;
		}
		else{
			$actlink="request-view.php?".$_SERVER['QUERY_STRING']."&action=rel&fid=".$id;
		}
		return $actlink;
	}
}

$p=new Pagination;
$page=$p->setpage();

$al=new listUsers;
/********************delete record*********************/

	if($_GET['action']=="can"){
		echo $_GET['fid'];
		$al->cancelrecord($_GET['fid']);
		header("location:transfer-view.php");
		//header("location:welcome.php?".rtrim($_SERVER['QUERY_STRING'],"&action=del&id=".$_GET['id']));
	}
	if($_GET['action']=="rel"){
		echo $_GET['fid'];
		$al->releaserecord($_GET['fid']);
		header("location:transfer-view.php");
		//header("location:welcome.php?".rtrim($_SERVER['QUERY_STRING'],"&action=del&id=".$_GET['id']));
	}
/***********************************************/

$al->limit=$p->setlimit(20);
$al->setsql("select * from transaction order by tr_updated_date desc");
$totalitems=$al->totalrecord();
$limit=$al->limit;
$al->start=$p->setstart($page,$limit,$totalitems);
$adjacents=1;
$targetpage = "transfer-view.php";

$pagestring ="?limit=".$limit."&page=";

$recObj=$al->listview();

$showitems=$al->start+1 ." - ";
if(($al->start+$limit)<$totalitems){
	$showitems.=$al->start+$limit;
}
else{
	$showitems.=$totalitems;
}
	$showitems.= " of ". $al->totalrecord()." items";
	//echo $_SERVER['QUERY_STRING'];
	

?>
<?php include "includes/admin-top.php" ?>
<div class="main-container" id="main-container">
	<script type="text/javascript">
		try{ace.settings.check('main-container' , 'fixed')}catch(e){}
	</script>

	<div class="main-container-inner">
		<a class="menu-toggler" id="menu-toggler" href="#">
			<span class="menu-text"></span>
		</a>
<?php include "includes/admin-left-con.php" ?>
<div class="main-content">
	<div class="breadcrumbs" id="breadcrumbs">
		<script type="text/javascript">
			try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
		</script>

		<ul class="breadcrumb">
			<li>
				<i class="icon-home home-icon"></i>
					<a href="welcome.php">Home</a>
				</li>
				<li>
					<a>Manage Transaction</a>
				</li>
				<li class="active">View Transfers</li>
		</ul><!-- .breadcrumb -->
					<!-- #nav-search -->
	</div>
<div class="page-content">
<form name="test_view" id="test_view" method="post"> 
<div class="row">
<div class="col-xs-12">
 <div class="table-responsive">
	<table id="sample-table-2" class="table table-striped table-bordered table-hover">
    <thead>
	<tr> 
    <th style="text-align:center"><strong>Date</strong></th>
    <th><strong>Sender</strong></th>
	<th><strong>Receiver</strong></th>
    <th style="text-align:center"><strong>Amount</strong></th>
    <th><strong>Transfer Type</strong></th>
    <th style="text-align:center"><strong>Action</strong></th>
    </tr>
</thead>
<tbody>
    	<?php $j=0;
		$count=mysql_num_rows($recObj);
		if($count >0)
		{
	   		while($row=mysql_fetch_object($recObj)){
		   	?>
    	<tr>
            <td style="text-align:center"><?php echo date("d M,Y",strtotime($row->tr_updated_date)); ?></td>
            <td>
			<?php 
				$sql_from="select * from user where usr_id='".$row->tr_from_id."'";
				$res_from=mysql_query($sql_from);
				if(mysql_num_rows($res_from)>0)
				{
					$row_from=mysql_fetch_object($res_from);
					echo stripslashes($row_from->usr_name);
				}
				else
				{	?>
					<font color="#666666">Admin</font>
			<?php	}
					?>
            </td>
            <td>
			<?php 
				$sql_to="select * from user where usr_id='".$row->tr_to_id."'";
				$res_to=mysql_query($sql_to);
				if(mysql_num_rows($res_to)>0)
				{
					$row_to=mysql_fetch_object($res_to);
					echo stripslashes($row_to->usr_name);
				}
				else
				{	?>
					<font color="#666666">Admin</font>
			<?php	}
					
			?>
            </td>
            <td style="text-align:right"><?php echo number_format($row->tr_amount,2); ?></td>
            <td><?php echo strtoupper(stripslashes($row->tr_type)); ?></td>
            
            <td style="text-align:center">
           <?php
		   	if($row->tr_type == 'escrow' && $row->tr_release =='1'){ echo "<font color='#009900'><strong>Released</strong><font>"; }
			else if($row->tr_type == 'escrow' && $row->tr_release =='0' && $row->tr_status =='0') { echo "<font color='#CC0000'><strong>Cancelled</strong><font>"; }
			else if($row->tr_type != 'escrow') { echo "N/A"; }
			else { ?>
            <a href="<?php echo $al->releaselink($row->tr_id) ?>" title="Release" onclick="return confirm('Are you sure to release the fund?')"><img alt="Release" src="images/active.jpg" border="0"></a>
            <a href="<?php echo $al->cancellink($row->tr_id) ?>" title="Cancel" onclick="return confirm('Are you sure to cancel the transaction?')"><img alt="Cancel" src="images/suspend.jpg" border="0"></a>            
            <?php } ?>
            </td>
	</tr>
        <?php $j++; } }?>
</tbody>
</table>
</div></div></div></form>
	<br clear="all"/>
 </div>

 </div>
 </div>
 <br clear="all" />

 </div>  
  <?php include "includes/footer.php" ?>
<script type="text/javascript">
			window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>
 <script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/typeahead-bs2.min.js"></script>

		<!-- page specific plugin scripts -->

		<script src="assets/js/jquery.dataTables.min.js"></script>
		<script src="assets/js/jquery.dataTables.bootstrap.js"></script>

		<!-- ace scripts -->

		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->

		<script type="text/javascript">
			jQuery(function($) {
				var oTable1 = $('#sample-table-2').dataTable( {
				"aoColumns": [
			      null,null,null,null,null,null
				] } );
				
				
				$('table th input:checkbox').on('click' , function(){
					var that = this;
					$(this).closest('table').find('tr > td:first-child input:checkbox')
					.each(function(){
						this.checked = that.checked;
						$(this).closest('tr').toggleClass('selected');
					});
						
				});
			
			
				$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('table')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
			})
		</script>
</body>
</html>