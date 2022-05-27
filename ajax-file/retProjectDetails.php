<?php
ob_start();
session_start();
include "../common.php";

$prj_id=$_POST['prj'];
$sql_p="select * from project,project_budget,bid where prj_id=pb_prj_id and bd_prj_id=prj_id and prj_id='".$prj_id."' and bd_status='1'";
$res_p=mysql_query($sql_p);
$row_p=mysql_fetch_object($res_p);

$sql_tr="select COALESCE(sum(tr_amount),0) from transaction where tr_prj_id='".$prj_id."' and tr_status='1' and tr_to_id='".$row_p->bd_usr_id."' and tr_from_id='".$row_p->prj_usr_id."'";
$res_tr=mysql_query($sql_tr);
$row_tr=mysql_fetch_array($res_tr);

$sql_inv="select COALESCE(sum(inv_amount),0) from invoice where inv_usr_id='".$row_p->bd_usr_id."' and inv_prj_id='".$prj_id."' and inv_payment_status='0' and inv_status='1'";
$res_inv=mysql_query($sql_inv);
$row_inv=mysql_fetch_array($res_inv);


if($row_p->pb_type=='hourly')
{
	$remain_amount=($row_p->pb_rate * $row_p->bd_amount)-$row_tr[0]-$row_inv[0];
}
else
{
    $remain_amount=$row_p->bd_amount-$row_tr[0]-$row_inv[0];
}
echo $remain_amount;

?>