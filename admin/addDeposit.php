<?php
ob_start();
session_start(); 
include "../common.php";

$usr_id=$_POST['usr_id'];
$df_amount=$_POST['df_amount'];

$sql="select * from user where usr_id='".$usr_id."'";
$res=mysql_query($sql);
$row=mysql_fetch_object($res);

$new_bal=$row->usr_balance+$df_amount;
$sql_upd="update user set usr_balance='".$new_bal."' where usr_id='".$usr_id."'";
if(mysql_query($sql_upd))
{
	echo "1|".getCurrencySymbol().number_format($new_bal,2)." ".getCurrencyCode();
}
else
{
	echo "0|".$row->usr_balance;
}
?>