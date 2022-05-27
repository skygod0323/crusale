<?php 
ob_start();
session_start(); 
include "../common.php";
//include "lib/pagination.php";

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
	function approverecord($adid){
		//mysql_query("delete from news_details where news_id='".$adid."'");
		mysql_query("update category set cat_status = '1' where cat_id='".$adid."'");
	}
	function approvelink($id){
		if($_SERVER['QUERY_STRING']==""){
			$dellink="?action=appr&fid=".$id;
		}
		else{
			$dellink="category-pending.php?".$_SERVER['QUERY_STRING']."&action=appr&fid=".$id;
		}
		return $dellink;
	}
}

$p=new Pagination;
$page=$p->setpage();

$al=new listCat;
/********************delete record*********************/
	if($_GET['action']=="appr"){
		echo $_GET['fid'];
		$al->approverecord($_GET['fid']);
		header("location:category-pending.php");
		//header("location:welcome.php?".rtrim($_SERVER['QUERY_STRING'],"&action=del&id=".$_GET['id']));
		}
/***********************************************/

$al->limit=$p->setlimit(20);
$al->setsql("select * from category where cat_status = '0'");
$totalitems=$al->totalrecord();
$limit=$al->limit;
$al->start=$p->setstart($page,$limit,$totalitems);
$adjacents=1;
$targetpage = "category-pending.php";

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
		mysql_query("update category set cat_status = 0 where cat_id='".$cb."'");		
	}
	header("location:category-view.php");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Administrative Panel</title>
<script src="js/jquery-1.2.1.min.js" type="text/javascript"></script>
<script src="js/menu-collapsed.js" type="text/javascript"></script>
<script src="js/common.js" language="javascript"></script><!-- Common Validation Function -->
<script language="javascript" type="text/javascript" src="../js/jquery.truncator.js"></script>
<script language="javascript" type="text/javascript">
	$(function() {
	  $('.eID').truncate({max_length: 30});
	});
</script>
<script type="text/javascript">
function deleteAll()
{
	var aa = document.getElementById('test_view');
	var bool = false;
	for(var i=0; i< aa.length; i++)
	{		
		if(aa.elements[i].checked == true)
		{
			bool = bool || true;			
		}
		else
		{
			bool = bool || false;
		}
	}	
	if(bool == false)
	{
		alert("Please ckecked atleast one item for delete!");		
	}
	else
	{
		if(!confirm('Are you sure to delete the records?'))
			bool = false;	
	}
	return bool;
}

function Check()
{
var chk=document.test_view.cb;
	alert(chk);
if(document.test_view.check_all.checked==true)
 {
 for (i = 0; i < chk.length; i++)
 chk[i].checked = true ;
 }
else
 {

 for (i = 0; i < chk.length; i++)
 chk[i].checked = false ;
 }
}
</script>

<script type="text/javascript">
checked=false;
function checkedAll () {
	var aa= document.getElementById('test_view');
	 if (checked == false)
          {
           checked = true
          }
        else
          {
          checked = false
          }
	for (var i =0; i < aa.elements.length; i++) 
	{
	 aa.elements[i].checked = checked;
	}
      }

function toggle(d)
{
	var o=document.getElementById(d);
	o.style.display=(o.style.display=='none')?'block':'none';
}	  
</script>
<link href="style/style.css" type="text/css" rel="stylesheet"/>
<link href="style/pagination.css" type="text/css" rel="stylesheet"/>

</head>

<body>
<div class="main">
<?php include "includes/admin-top.php" ?>
 <div class="control_Panel">
<?php include "includes/admin-left-con.php" ?>
	<div class="bodyRightCon">
	<form name="test_view" id="test_view" method="post"> 
        <div class="bodyRightightCon_inner">
  <div class="bcMenuCon">
    <div class="bcMenu">
      <ul>
        <li>&rsaquo;&nbsp;&nbsp;Category Management</li>
        <li>&rsaquo;&nbsp;&nbsp;View Pending Categories</li>
      </ul>
      <ul class="right">
        <li><a href="category-add.php">Add Category</a></li>
      </ul>
      <div class="clr"></div>
    </div>
    
    <div class="pagicon">
    	<div class="dlt-btn" style="width:80px;"><input name="btnDelete" id="btnDelete" type="submit" value="Delete" class="delete-btn" onclick="return deleteAll();" /></div>
	    <div class="item-no"><?php echo $showitems ?></div>
        <div class="page-rslt">Result per page: <select name="limit" id="limit" 
        			onchange="javascript:window.location.href='category-view.php?page=<?php echo $page ?>&amp;limit='+this.value;">
        <?php for($i=20; $i<=120; $i=$i+20){ 
        	if($i==$limit){?>
            <option value="<?php echo $i ?>" selected="selected" ><?php echo $i ?></option>
            <?php }else{?>
            <option value="<?php echo $i ?>" ><?php echo $i ?></option>
		 <?php }
         } ?>
        </select></div>
        <div style="float:right; padding:10px 10px 0 0;"><?php echo $p->getPaginationString($page, $totalitems, $limit, $adjacents, $targetpage, $pagestring)?></div>
       <div class="clr"></div>
    </div>
    	<br clear="all"/>
 </div>
   <div>
   
<div class="admin-hdr-bg"  style="margin-top:40px;">
	<div class="checkbox" style="width:3%; padding-top:3px;"><input name="check_all" value="yes" id="check_all" type="checkbox" onClick="return checkedAll();"></div>   
    <div class="eID" style="width:200px"><strong>Category Name</strong></div>
    <div class="action"><strong>Action</strong></div>
    <br clear="all"/>
</div>
<div class="admin-dtls">
	<ul>
	   <?php $j=0;
	   $count=mysql_num_rows($recObj);
	   if($count >0)
	   {		  
	   		while($row=mysql_fetch_object($recObj)){
		   	?>
    	<li <?php if($j % 2 == 1) { ?> class="row-clr" <?php } ?> >
			<div class="checkbox" style="width:3%;  padding-top:2px;"><input name="cb[]" type="checkbox" value="<?php echo $row->cat_id ?>" /></div> 
            <div class="eID" style="width:200px"><?php echo stripslashes($row->cat_name); ?></div>
            <div class="action">
            <a href="<?php echo $al->approvelink($row->cat_id)?>" title="Approve" onclick="return confirm('Are you sure to approve this Category?')">
            <img alt="Approve" src="images/active.jpg" border="0"></a>
            </div>
            <div class="clr"></div>
        </li>
		 <?php $j++; } 
	   } else
       {
		?>
		<div class="admin-dtls" style="text-align:center; color:red; border-bottom:1px solid #ccc; padding-bottom:5px; font-weight:bold; font-size:14px;">No Records.</div>
		<?php } ?>       
    </ul>
    
    <div class="pagicon">
<!--    	<div class="dlt-btn"><input name="Delete" type="button" value="Delete" class="delete-btn" /></div>--> 
	    <div class="item-no"><?php echo $showitems ?></div>
        <div class="page-rslt">Result per page: <select name="limit" id="limit" 
        			onchange="javascript:window.location.href='category-view.php?page=<?php echo $page ?>&amp;limit='+this.value;">
        <?php for($i=20; $i<=120; $i=$i+20){ 
        	if($i==$limit){?>
            <option value="<?php echo $i ?>" selected="selected" ><?php echo $i ?></option>
            <?php }else{?>
            <option value="<?php echo $i ?>" ><?php echo $i ?></option>
 <?php }
 } ?>
        </select></div>
       <div class="page-no"><?php echo $p->getPaginationString($page, $totalitems, $limit, $adjacents, $targetpage, $pagestring)?></div>
        <div class="clr"></div>
    </div>
</div>
    </div>

 </div>
 <br clear="all"/>
 </form>
 </div>
 </div>
  <br clear="all" />
 </div>
    <?php include "includes/footer.php" ?>

</body>
</html>
