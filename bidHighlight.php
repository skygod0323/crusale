<?php
ob_start();
session_start();
include "common.php";

if(isset($_GET['bd']) && isset($_GET['amt']))
{
   
    $bd_id=$_GET['bd'];
    $amount=$_GET['amt'];
    $_SESSION['tot_bo_amt']=$amount;
    
    $_SESSION['last_page']="bidHighlight.php?bd="+$bd_id+"&amt="+$amount;
    
    $sql_bd="select * from bid where bd_id='".$bd_id."'";
    $res_bd=mysql_query($sql_bd);
    $row_bd=mysql_fetch_object($res_bd);
    
    $sql_chb="select * from user where usr_id=".$_SESSION['uid'];
    $res_chb=mysql_query($sql_chb);
    $row_chb=mysql_fetch_object($res_chb);
	
    if($row_chb->usr_balance < $amount)
	{
          $_SESSION['promotion_msg']=$lang[701];
		header("location:payment-deposit.php");
	}
	else
	{
		$sql_upd="update bid set bd_highlight='1' where bd_id='".$bd_id."'";
            mysql_query($sql_upd);
		
		$sql_tr="insert into transaction
			set					
				tr_to_id ='0',
				tr_from_id ='".$_SESSION['uid']."',
				tr_prj_id ='".$row_bd->bd_prj_id."',
				tr_amount ='".$_SESSION['tot_bo_amt']."',	
				tr_type ='bid promotion',	
				tr_updated_date=now(),
				tr_status=1";
		mysql_query($sql_tr);
		
		$sql_us="select * from user where usr_id='".$_SESSION['uid']."'";
		$res_us=mysql_query($sql_us);
		$row_us=mysql_fetch_object($res_us);
		
		$new_bal = $row_us->usr_balance - $_SESSION['tot_bo_amt'];
		
		$sql_upd="update user
			set
				usr_balance = '".$new_bal."'
			where
				usr_id='".$_SESSION['uid']."'";
		mysql_query($sql_upd);
		

		unset($_SESSION['tot_bo_amt']);
            
            $resp=mysql_query("select * from project where prj_id='".$prj_id."'");
		$rowp=mysql_fetch_object($resp);
            
            /**** code for email sending start here ****/
		
            $chk_es_sql="select * from user_email_setting where ues_usr_id='".$row_us->usr_id."' and ues_es_id='1'";
            $chk_es_res=mysql_query($chk_es_sql);
            if(mysql_num_rows($chk_es_res))
            {
            
		$sqlemail="select * from admin_user where id='1'";
		$resemail=mysql_query($sqlemail);
		$rowemail=mysql_fetch_object($resemail);
		
		include "email/bidHighlight.php"; //email design with content included
		
        /*$comment='<div style="border:1px solid #999999; width:660px;float:left; padding-bottom:0px;">
		<div style="width:650px;height:100px; padding-bottom:0;">'.$lang[702].'</div></div>';*/


			$from_mail=$rowemail->email;
			$to=$row_us->usr_email; 	

           $subj=$lang[699];
           $headers  = "MIME-Version: 1.0\n";
	       $headers .= "Content-type: text/html; charset=iso-8859-1\n";
           $headers .= 'From: '.$from_mail.'';	
		
		mail($to,$subj,$comment,$headers);
            }            
		/**** code for email sending end here ****/
		header("Location:project.php?p=".$row_bd->bd_prj_id);
	}	
}
else
{
    header("Location:".$_SESSION['last_page']);
}
?>