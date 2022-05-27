<?php 
ob_start();
session_start(); 
include "../common.php";

check_user_login();

class listGateway{
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
	function deleterecord($adid){		
		mysql_query("update payment_gateway set pg_status=0 where id='".$adid."'");		
	}
      function activerecord($adid){		
		mysql_query("update payment_gateway set pg_status=1 where id='".$adid."'");		
	}
	function deletelink($id){
		if($_SERVER['QUERY_STRING']==""){
			$dellink="?action=del&aid=".$id;
		}
		else{
			$dellink="gateway-view.php?".$_SERVER['QUERY_STRING']."&action=del&aid=".$id;
		}
		return $dellink;
	}	
		function activelink($id){
		if($_SERVER['QUERY_STRING']==""){
			$actlink="?action=act&aid=".$id;
		}
		else{
			$actlink="gateway-view.php?".$_SERVER['QUERY_STRING']."&action=act&aid=".$id;
		}
		return $actlink;
	}		

}

$p=new Pagination;
$page=$p->setpage();

$al=new listGateway;
/********************delete record*********************/
	if($_GET['action']=="del")
	{
		//echo $_GET['aid'];		
		$al->deleterecord($_GET['aid']);
		header("location:gateway-view.php");
		//header("location:welcome.php?".rtrim($_SERVER['QUERY_STRING'],"&action=del&id=".$_GET['id']));
	}	
		if($_GET['action']=="act")
	{
		//echo $_GET['aid'];		
		$al->activerecord($_GET['aid']);
		header("location:gateway-view.php");
	}
/***********************************************/

$al->limit=$p->setlimit(10);
$al->setsql("select * from payment_gateway");
$totalitems=$al->totalrecord();
$limit=$al->limit;
$al->start=$p->setstart($page,$limit,$totalitems);
$adjacents=1;
$targetpage = "gateway-view.php";

$pagestring ="&limit=".$limit."&page=";

$recObj=$al->listview();

$showitems=$al->start+1 ."-";
if(($al->start+$limit)<$totalitems){
	$showitems.=$al->start+$limit;
}
else{
	$showitems.=$totalitems;
}
	$showitems.= " of ". $al->totalrecord()." items";
	//echo $_SERVER['QUERY_STRING'];
	
if(isset($_POST['btnDelete']))
{ 
	foreach($_POST['cb'] as $cb)
	{				
		$al->deleterecord($cb);			
		mysql_query("delete from payment_gateway where id='".$cb."'");		
	}
	header("location:gateway-view.php");
}	

function splitdeptid($x)
{
	$cid=split(',', $x);
	$dtname="";	
				
	foreach($cid as $c_id)   	 	
	{				
		$sqld="select * from department where dept_id='".$c_id."'";
		$resd=mysql_query($sqld);
		$rowd=mysql_fetch_object($resd);							
		$dtname.=$rowd->dept_short_name.', ';		
	}	
	
	$dtname=substr($dtname, 0, strlen($dtname)-2);
	
	return $dtname;		
}

function designame($x)
{								
	$sqld="select * from designation where desig_id='".$x."'";
	$resd=mysql_query($sqld);
	$rowd=mysql_fetch_object($resd);							
	$dtname=$rowd->desig_name;	
	return $dtname;		
}

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
					<a href="gateway-view.php">Manage Gateway</a>
				</li>
				<li class="active">View Gateway</li>
		</ul><!-- .breadcrumb -->
					<!-- #nav-search -->
	</div>
<div class="page-content">
<form name="fac_view" id="fac_view" method="post" >
<div class="row">
<div class="col-xs-12">
<div class="table-header">
<button class="btn btn-xs btn-danger" name="btnDelete" type="submit" onClick="return confirm('Are you sure to delete the record?')" ><i class="icon-trash bigger-120"></i>Delete</button>
 <button type="button" class="btn btn-xs btn-success" onClick="window.location='gateway-add.php' "><i class="icon-pencil align-top bigger-120"></i>Add Gateway</button>
 </div>
 <div class="table-responsive">
<table id="sample-table-2" class="table table-striped table-bordered table-hover">
<thead>
	<tr>
		<th class="center"><label><input type="checkbox" class="ace" ><span class="lbl"></span></label></th>
		<th><strong>Image</strong></th>
		<th><strong>Name</strong></th>
		<th><strong>Deposit Fee</strong></th>
		<th><strong>Withdrawal Fee</strong></th>
		<th><strong>ID</strong></th>
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
	        <td class="center"><label><input name="cb[]"  class="ace" type="checkbox" value="<?php echo $row->id; ?>" /><span class="lbl"></span></label></td>
			<?php
				if($row->pg_deposit_fee_type=="fixed"){	$d_type=get_page_settings(7);	}
				if($row->pg_withdraw_fee_type =="fixed"){	$w_type=get_page_settings(7);	}
				if($row->pg_deposit_fee_type=="percent"){	$d_type="Percent";	}
				if($row->pg_withdraw_fee_type =="percent"){		$w_type="Percent";	}
			?>
			<td><img src="../paymentgateway/<?php echo $row->pg_logo; ?>" style="width:100px;"  /></td>
			<td><?php echo stripcslashes(ucwords($row->pg_name)); ?></td>
			<td><?php echo stripcslashes($row->pg_deposit_fee);  ?> (<?php echo $d_type; ?>)</td>
			<td><?php echo stripcslashes($row->pg_withdraw_fee);  ?> (<?php echo $w_type; ?>)</td>
			<td><?php echo stripcslashes($row->pg_id);  ?></td>
			<td>
                 <a href="gateway-edit.php?aid=<?php echo $row->id; ?>" title="edit"><img alt="edit" src="images/edit.jpg" border="0"></a>
				<?php if($row->pg_status==1){?>
				<a href="<?php echo $al->deletelink($row->id)?>" title="Disable Gateway" onclick="return confirm('Are you sure to Disable the payment gateway?')"><img alt="delete" src="images/delete.jpg" border="0"></a>
				<?php } ?>    
				<?php if($row->pg_status==0){?>
				<a href="<?php echo $al->activelink($row->id)?>" title="Enable Gateway" onclick="return confirm('Are you sure to Enable the payment gateway?')"><img alt="delete" src="images/active.jpg" border="0"></a>
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
			      { "bSortable": false },{ "bSortable": false },
			      null,null,null,null,
				  { "bSortable": false }
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