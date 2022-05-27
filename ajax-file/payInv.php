<?php
ob_start();
session_start();
include "../common.php";

$inv_id=$_POST['inv'];
$sql="select * from invoice,project where inv_prj_id=prj_id and inv_id='".$inv_id."'";
$res=mysql_query($sql);
$row=mysql_fetch_object($res);

$sql_to_usr="select * from user where usr_id='".$row->inv_usr_id."'";
$res_to_usr=mysql_query($sql_to_usr);
$row_to_usr=mysql_fetch_object($res_to_usr);

$sql_from_usr="select * from user where usr_id='".$row->prj_usr_id."'";
$res_from_usr=mysql_query($sql_from_usr);
$row_from_usr=mysql_fetch_object($res_from_usr);



$sql_tr="insert into transaction
	set					
		tr_to_id ='".$row_to_usr->usr_id."',
		tr_from_id ='".$row_from_usr->usr_id."',
		tr_prj_id ='".$row->prj_id."',
		tr_amount ='".$row->inv_amount."',	
		tr_type ='invoice',	
		tr_inv_id='".$row->inv_id."',
		tr_updated_date=now(),
		tr_status=1";
		
mysql_query($sql_tr);


$to_new_bal=$row_to_usr->usr_balance + $row->inv_amount;
$sql_upd_to="update user
		set
			usr_balance='".$to_new_bal."'
		where
				usr_id='".$row_to_usr->usr_id."'";
mysql_query($sql_upd_to);


$from_new_bal=$row_from_usr->usr_balance - $row->inv_amount;
$sql_upd_from="update user
		set
			usr_balance='".$from_new_bal."'
		where
				usr_id='".$row_from_usr->usr_id."'";
mysql_query($sql_upd_from);

$sql_inv="update invoice
	set
		inv_payment_status='1'
	where
		inv_id='".$row->inv_id."'";
mysql_query($sql_inv);


/******* Code for notification start here *********/
		
			$sql_un="insert into user_notification
			set
				un_usr_id='".$row_to_usr->usr_id."',
				un_from_usr_id='".$row_from_usr->usr_id."',
				un_type='invoice',
				un_content='".$row_from_usr->usr_name.$lang[779]."(".$lang[777]." ".$row->inv_id.")',
				un_prj_id='".$row->prj_id."',
				un_updated_date=now()";
				
			mysql_query($sql_un);
		
/******* Code for notification end here *********/

/****** code for email sending start here ******/
		$sqlemail="select * from admin_user where id='1'";
		$resemail=mysql_query($sqlemail);
		$rowemail=mysql_fetch_object($resemail);
            
       	
		include "../email/payInv.php"; //email design with content included
		
        /*$comment='<div style="border:1px solid #999999; width:660px;float:left; padding-bottom:0px;">
		<div style="width:650px;height:100px; padding-bottom:0;">
			'.$lang[778].''.$row_to_usr->usr_name.',<br/><br/>'.$row_from_usr->usr_name.''.$lang[779].'('.$lang[777].' '.$row->inv_id.').<br/><br/>'.getWebSiteName().'
		</div></div>';*/


		$from_mail=$rowemail->email;
        $to=$row_to_usr->usr_email; 	

        $subj=$lang[780];
        $headers  = "MIME-Version: 1.0\n";
	    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
        $headers .= 'From: '.$from_mail.'';	
		
		mail($to,$subj,$comment,$headers);
/****** code for email sending start here ******/

?>