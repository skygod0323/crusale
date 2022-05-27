<?php
ob_start();
session_start(); 
include "../common.php";
//include "lib/pagination.php";

check_user_login();
class listService{
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
		//mysql_query("delete from news_details where news_id='".$adid."'");
		mysql_query("update service set ser_status = '0' where ser_id='".$adid."'");
	}
	function suspendrecord($adid){
		//mysql_query("delete from news_details where news_id='".$adid."'");
		mysql_query("update service set ser_status = '0' where ser_id='".$adid."'");
	}
	function activerecord($adid){
		//mysql_query("delete from news_details where news_id='".$adid."'");
		mysql_query("update service set ser_status = '1' where ser_id='".$adid."'");
	}
	function deletelink($id){
		if($_SERVER['QUERY_STRING']==""){
			$dellink="?action=del&fid=".$id;
		}
		else{
			$dellink="service-view.php?".$_SERVER['QUERY_STRING']."&action=del&fid=".$id;
		}
		return $dellink;
	}
	function suspendlink($id){
		if($_SERVER['QUERY_STRING']==""){
			$suslink="?action=sus&fid=".$id;
		}
		else{
			$suslink="service-view.php?".$_SERVER['QUERY_STRING']."&action=sus&fid=".$id;
		}
		return $suslink;
	}
	function activelink($id){
		if($_SERVER['QUERY_STRING']==""){
			$actlink="?action=act&fid=".$id;
		}
		else{
			$actlink="service-view.php?".$_SERVER['QUERY_STRING']."&action=act&fid=".$id;
		}
		return $actlink;
	}
}

$p=new Pagination;
$page=$p->setpage();

$al=new listService;
/********************delete record*********************/
	if($_GET['action']=="del"){
		echo $_GET['fid'];
		$al->deleterecord($_GET['fid']);
		header("location:service-view.php");
		//header("location:welcome.php?".rtrim($_SERVER['QUERY_STRING'],"&action=del&id=".$_GET['id']));
		}
	if($_GET['action']=="sus"){
		echo $_GET['fid'];
		$al->suspendrecord($_GET['fid']);
		header("location:service-view.php");
		//header("location:welcome.php?".rtrim($_SERVER['QUERY_STRING'],"&action=del&id=".$_GET['id']));
	}
	if($_GET['action']=="act"){
		echo $_GET['fid'];
		$al->activerecord($_GET['fid']);
		header("location:service-view.php");
		//header("location:welcome.php?".rtrim($_SERVER['QUERY_STRING'],"&action=del&id=".$_GET['id']));
	}
/***********************************************/

$al->limit=$p->setlimit(20);
$al->setsql("select * from service,user,subcategory,category where ser_scat_id=scat_id and scat_cat_id=cat_id and ser_usr_id=usr_id and usr_status='1' and ser_status='1'");
$totalitems=$al->totalrecord();
$limit=$al->limit;
$al->start=$p->setstart($page,$limit,$totalitems);
$adjacents=1;
$targetpage = "service-view.php";

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
	
if(isset($_POST['btnDelete']))
{ 
	foreach($_POST['cb'] as $cb)
	{		
		mysql_query("update project set prj_status = 0 where ser_id='".$cb."'");		
	}
	header("location:service-view.php");
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
					<a>Service Management</a>
				</li>
				<li class="active">Service View</li>
		</ul><!-- .breadcrumb -->
					<!-- #nav-search -->
	</div>
<div class="page-content">
<form name="test_view" id="test_view" method="post"> 
<div class="row">
<div class="col-xs-12">
<div class="table-header">
<button class="btn btn-xs btn-danger" name="btnDelete" type="submit" onClick="return confirm('Are you sure to delete the record?')" ><i class="icon-trash bigger-120"></i>Delete</button>
 
 </div>
 <div class="table-responsive">        
<table id="sample-table-2" class="table table-striped table-bordered table-hover">
<thead>
<tr>
	<th><label><input type="checkbox" class="ace" ><span class="lbl"></span></label></th>
    <th><strong>Headline</strong></th>
    <th><strong>Business Name</strong></th>
    <th><strong>Category</strong></th>
    <th style="text-align:center"><strong>Details</strong></th>
    <th style="text-align:center"><strong>Action</strong></th>
</thead>
<tbody>

	   <?php $j=0;
	   $count=mysql_num_rows($recObj);
	   if($count >0)
	   {		  
	   		while($row=mysql_fetch_object($recObj)){
		   	?>
		<tr>
			<td class="center"><label><input name="cb[]"  class="ace" type="checkbox" value="<?php echo $row->ser_id; ?>" /><span class="lbl"></span></label></td>
			<td><?php echo stripslashes($row->ser_headline); ?></td>
			<td><?php echo stripslashes($row->ser_businessName); ?></td>
			<td><?php echo stripslashes(ucfirst($row->scat_name)); ?><br /><?php echo "(".stripslashes(ucfirst($row->cat_name)).")"; ?></td>
			<td align="center"><a href="service-details.php?fid=<?php echo $row->ser_id; ?>"><img src="images/details.png" /></a></td>
			<td align="center">
				<a href="<?php echo $al->suspendlink($row->ser_id) ?>" title="Suspend" onclick="return confirm('Are you sure to suspend the Request?')"><img alt="Suspend" src="images/suspend.jpg" border="0"></a>
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
			      { "bSortable": false },
			      null,null,null, { "bSortable": false },
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