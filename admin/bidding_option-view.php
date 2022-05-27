<?php 
ob_start();
session_start(); 
include "../common.php";

check_user_login();
class listCat{
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
	function enableRecord($adid){
		mysql_query("update bidding_option set bo_status = '1' where bo_id='".$adid."'");
	}
	function disableRecord($adid){
		mysql_query("update bidding_option set bo_status = '0' where bo_id='".$adid."'");
	}
	function enableLink($id){
		if($_SERVER['QUERY_STRING']==""){
			$dellink="?action=ena&fid=".$id;
		}
		else{
			$dellink="bidding_option-view.php?".$_SERVER['QUERY_STRING']."&action=ena&fid=".$id;
		}
		return $dellink;
	}
	function disableLink($id){
		if($_SERVER['QUERY_STRING']==""){
			$dellink="?action=dis&fid=".$id;
		}
		else{
			$dellink="bidding_option-view.php?".$_SERVER['QUERY_STRING']."&action=dis&fid=".$id;
		}
		return $dellink;
	}
}

$p=new Pagination;
$page=$p->setpage();

$al=new listCat;
/********************delete record*********************/
if($_GET['action']=="dis"){
		echo $_GET['fid'];
		$al->disableRecord($_GET['fid']);
		header("location:bidding_option-view.php");
		//header("location:welcome.php?".rtrim($_SERVER['QUERY_STRING'],"&action=del&id=".$_GET['id']));
		}
	if($_GET['action']=="ena"){
		echo $_GET['fid'];
		$al->enableRecord($_GET['fid']);
		header("location:bidding_option-view.php");
		//header("location:welcome.php?".rtrim($_SERVER['QUERY_STRING'],"&action=del&id=".$_GET['id']));
		}
/***********************************************/

$al->limit=$p->setlimit(20);
$al->setsql("select * from bidding_option order by bo_id");
$totalitems=$al->totalrecord();
$limit=$al->limit;
$al->start=$p->setstart($page,$limit,$totalitems);
$adjacents=1;
$targetpage = "bidding_option-view.php";

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
		mysql_query("update bidding_option set bo_status = 0 where bo_id='".$cb."'");		
	}
	header("location:bidding_option-view.php");
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
					<a href="bidding_option-view.php">Manage Bidding-Option</a>
				</li>
				<li class="active">View Category</li>
		</ul><!-- .breadcrumb -->
					<!-- #nav-search -->
	</div>
<div class="page-content">
<form name="test_view" id="test_view" method="post"> 
<div class="row">
<div class="col-xs-12">
<div class="table-header">
<button class="btn btn-xs btn-danger" name="btnDelete" type="submit" onClick="return confirm('Are you sure to delete the record?')" ><i class="icon-trash bigger-120"></i>Disable</button>
 </div>
 <div class="table-responsive">
	<table id="sample-table-2" class="table table-striped table-bordered table-hover">
    
    <thead>
	<tr>
	<th class="center"><label><input type="checkbox" class="ace" ><span class="lbl"></span></label></th>
	<th><strong>Heading</strong></th>
	<th><strong>Description</strong></th>
	<th><strong>Price</strong></th>
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
	        <td class="center"><label><input name="cb[]"  class="ace" type="checkbox" value="<?php echo $row->bo_id; ?>" /><span class="lbl"></span></label></td>
            <td><strong><?php echo $row->bo_option;	?></strong></td>
			<td><?php echo $row->bo_description;	?></td>
			<td><?php echo $row->bo_amount; ?>&nbsp;<?php echo getCurrencyCode(); ?></td>
            
            <td><a href="bidding_option-edit.php?aid=<?php echo $row->bo_id ?>" title="Edit"><img alt="Edit" src="images/edit.jpg" border="0"></a>
			<?php if($row->bo_status=='1'){ ?>
               <a href="<?php echo $al->disableLink($row->bo_id); ?>" title="Disable" onclick="return confirm('Are you sure to disable the option?')"><img alt="Disable" src="images/suspend.jpg" border="0"></a>            
            <?php } else{ ?>
               <a href="<?php echo $al->enableLink($row->bo_id); ?>" title="Enable" onclick="return confirm('Are you sure to enable the option?')"><img alt="Enable" src="images/active.jpg" border="0"></a>
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
			      { "bSortable": false },
			      null,null,null,
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