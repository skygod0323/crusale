<?php
ob_start();
session_start();
include "common.php";

$un_id=$_GET['id'];

$sql="select * from user_notification,project where un_prj_id=prj_id and un_id='".$un_id."'";
$res=mysql_query($sql);
$row=mysql_fetch_object($res);

$sql_upd="update user_notification
		set
			un_status='0'
		where
			un_id='".$un_id."'";
mysql_query($sql_upd);

if($row->un_type=='dispute')
{
	$id=substr($row->un_content,(strpos($row->un_content, "|")+1));
	
//	onClick="goLink('fDispute.php?pds=<?php echo $id; ')";
	header("Location:fDispute.php?pds=".$id);
}
else if($row->un_type=='invoice')
{
	header("Location:invoice.php");	
}
else
{  
//	onClick="goLink('project.php?p=<?php echo $row->prj_id; ')";
	header("Location:project.php?p=".$row->prj_id);
} 

?>