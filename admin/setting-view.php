<?php 
ob_start();
session_start(); 
include "../common.php";
//include "lib/pagination.php";
check_user_login();
class listCmp{
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
		
		mysql_query("update company_admin set ca_status='0' where ca_id='".$adid."'");		
	}
	
	function deletelink($id){
		if($_SERVER['QUERY_STRING']==""){
			$dellink="?action=del&aid=".$id;
		}
		else{
			$dellink="setting-view.php?".$_SERVER['QUERY_STRING']."&action=del&aid=".$id;
		}
		return $dellink;
	}		
}

$p=new Pagination;
$page=$p->setpage();

$al=new listCmp;
/********************delete record*********************/
	if(isset($_GET['action']) && $_GET['action']=="del")
	{
		//echo $_GET['aid'];		
		$al->deleterecord($_GET['aid']);
		header("location:setting-view.php");
		//header("location:welcome.php?".rtrim($_SERVER['QUERY_STRING'],"&action=del&id=".$_GET['id']));
	}		
/***********************************************/

$al->limit=$p->setlimit(20);
$al->setsql("select * from site_settings where st_status = '1'");

$totalitems=$al->totalrecord();
$limit=$al->limit;
$al->start=$p->setstart($page,$limit,$totalitems);
$adjacents=1;
$targetpage = "setting-view.php";

$pagestring ="?limit=".$limit."&page=";

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
		mysql_query("delete from company_admin set where ca_id='".$cb."'");		
	}
	header("location:company-view.php");
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
				<a href="setting-view.php">Site Settings</a>
			</li>
			<li class="active">View Settings</li>
		</ul><!-- .breadcrumb -->
		<!-- #nav-search -->
	</div>
<div class="page-content">
<form name="myform" id="myform" method="post"> 
<div class="row">
<div class="col-xs-12">
<!--<div class="table-header">
<button class="btn btn-xs btn-danger" type="submit" onclick="return confirm('Are you sure to delete the record?')" ><i class="icon-trash bigger-120"></i>Delete</button>
&nbsp;&nbsp;&nbsp;&nbsp;
</div>-->

<div class="table-responsive">
<table id="sample-table-2" class="table table-striped table-bordered table-hover">
<!--<thead>
<tr>
	<th class="center"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></th>
	<th>Company Name</th>
    <th>Contact Person</th>
    <th>Phone</th>
    <th>Email</th>
    <th>Reg. Date</th>
    <th>View</th>
    <th>Visit Company</th>
    <th class="action">Action</th>
</thead>-->
<tbody>
    	<?php $j=0;
		$count=mysql_num_rows($recObj);
		if($count >0)
		{
		while($row=mysql_fetch_object($recObj)){?>
        <tr>
        	<td class="center">&nbsp;</td>
            <td><?php
            	$a_c=explode("-",$row->st_field);
				for($i=0;$i<count($a_c);$i++){
                	echo ucfirst($a_c[$i])."&nbsp;";
				} ?>
			</td>
            <td>
            <?php if($row->st_field =='logo') { ?>
            <img src="../sitelogo/<?php echo $row->st_value; ?>"  />
            <?php } else {?>
			<?php echo stripslashes(substr($row->st_value,0,55)); if(strlen($row->st_value)>60) { echo "...&nbsp;&nbsp;"; ?><a href="setting-details.php?sid=<?php echo $row->st_id; ?>">More</a><?php } }?>
            </td>
            <td class="center">
				<a href="setting-edit.php?sid=<?php echo $row->st_id  ?>" title="Edit" style="text-decoration:none;"><img alt="Edit" src="images/edit.jpg" border="0"></a>
            </td>
        </tr>
        <?php $j++;  } } else { ?>
        <table class="items">
		<thead>
         <tr class="row-clr"><td style="text-align:center;" class="action"><font color="#EE0000">No Records.</font></tr>
         </thead></table>
        <?php } ?>
</tbody>
</table>
</div></div></div></form>
	<br clear="all"/>
 </div>

 </div>
 </div>
 <br clear="all" />

 </div>   <?php include "includes/footer.php" ?></div>
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

		
</body>
</html>