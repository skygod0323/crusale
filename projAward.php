<?php
ob_start();
session_start();
include "common.php";

	/**** Code for project Award start ****/

	if(isset($_GET['bid']))
	{
        include "language.php";
		$bd_id=$_GET['bid'];

		$res=mysql_query("select * from bid where bd_id='".$bd_id."'");
		$row=mysql_fetch_object($res);

		$sql="insert into temp_proj_award
			set
				tpa_bd_id=".$bd_id.",
				tpa_updated_date=now()";
			
		mysql_query($sql);	
		
		/******* Code for notification start here *********/
		
		$sql_un="insert into user_notification
		set
			un_usr_id='".$row->bd_usr_id."',
			un_from_usr_id='".$_SESSION['uid']."',
			un_type='awardproject',
			un_content='".$_SESSION['usr'].$lang[470]."',
			un_prj_id='".$row->bd_prj_id."',
			un_updated_date=now()";
			
		mysql_query($sql_un);
		
		/******* Code for notification end here *********/
            
            /**** code for email sending start here ****/
		
            $chk_es_sql="select * from user_email_setting where ues_usr_id='".$row->bd_usr_id."' and (ues_es_id='1' or ues_es_id='5')";
            $chk_es_res=mysql_query($chk_es_sql);
            if(mysql_num_rows($chk_es_res))
            {
            
				$sqlemail="select * from admin_user where id='1'";
				$resemail=mysql_query($sqlemail);
				$rowemail=mysql_fetch_object($resemail);
            
				$sql_us="select * from user where usr_id='".$row->bd_usr_id."'";
				$res_us=mysql_query($sql_us);
				$row_us=mysql_fetch_object($res_us);
		
				include "email/projAward.php"; //email design with content included		
		
        		/*$comment1='<div style="border:1px solid #999999; width:660px;float:left; padding-bottom:0px;">
				<div style="width:650px;height:100px; padding-bottom:0;">'.$_SESSION['usr'].$lang[470].'</div></div>';*/


				$from_mail=$rowemail->email;
        	    $to=$row_us->usr_email; 	

				$subj=$lang[665];
				$headers  = "MIME-Version: 1.0\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\n";
				$headers .= 'From: '.$from_mail.'';	
		
				mail($to,$subj,$comment1,$headers);
            }
		/**** code for email sending end here ****/
	
	}

	/**** Code for project Award end ****/


	/**** Code for project Accept and Decline start ****/
	
	if(isset($_GET['tpa_id']) && isset($_GET['stat']))
	{
		if($_GET['stat']=="accept")
		{
			$sql_b="select * from bid where bd_id=(select tpa_bd_id from temp_proj_award where tpa_id=".$_GET['tpa_id'].")";
			$res_b=mysql_query($sql_b);
			$row_b=mysql_fetch_object($res_b);
			
			$sql="update bid
			set
				bd_deadline = date_add(NOW(),INTERVAL ".$row_b->bd_days." DAY),
				bd_status='1'
			where
				bd_id='".$row_b->bd_id."'";	
			mysql_query($sql);
				
			$sql_p="update project
			set
				prj_expiry = date_add(NOW(),INTERVAL ".$row_b->bd_days." DAY),
				prj_status='running'
			where
				prj_id='".$row_b->bd_prj_id."'";
			mysql_query($sql_p);
			
			
			/**** Start code for freelancer fee deduction ****/
			$sql_bd_u="select * from user,membership_plan where usr_mp_id=mp_id and usr_id='".$row_b->bd_usr_id."'";
			$res_bd_u=mysql_query($sql_bd_u);
			$row_bd_u=mysql_fetch_object($res_bd_u);
			
			$new_balance_fr=$row_bd_u->usr_balance - ($row_b->bd_amount*$row_bd_u->mp_freelancerfee/100);
			
			mysql_query("update user set usr_balance='".$new_balance_fr."' where usr_id='".$row_bd_u->usr_id."'");
			
			$sql_tr_freel="insert into transaction
			set					
				tr_to_id ='0',
				tr_from_id ='".$row_bd_u->usr_id."',
				tr_prj_id ='".$row_b->bd_prj_id."',
				tr_amount ='".($row_b->bd_amount*$row_bd_u->mp_freelancerfee/100)."',	
				tr_type ='freelancer fee',	
				tr_updated_date=now(),
				tr_status=1";
			mysql_query($sql_tr_freel);
			
			
			/**** End code for freelancer fee deduction ****/
			
			
			/**** Start code for employer fee deduction ****/
			$sql_bd_e="select * from user,membership_plan where usr_mp_id=mp_id and usr_id=(select prj_usr_id from project where prj_id='".$row_b->bd_prj_id."')";
			$res_bd_e=mysql_query($sql_bd_e);
			$row_bd_e=mysql_fetch_object($res_bd_e);
			
			$new_balance_emp=$row_bd_e->usr_balance - ($row_b->bd_amount*$row_bd_e->mp_employerfee/100);
			
			mysql_query("update user set usr_balance='".$new_balance_emp."' where usr_id='".$row_bd_e->usr_id."'");
			
			$sql_tr_employ="insert into transaction
			set					
				tr_to_id ='0',
				tr_from_id ='".$row_bd_e->usr_id."',
				tr_prj_id ='".$row_b->bd_prj_id."',
				tr_amount ='".($row_b->bd_amount*$row_bd_e->mp_employerfee/100)."',	
				tr_type ='employer fee',	
				tr_updated_date=now(),
				tr_status=1";
			mysql_query($sql_tr_employ);
			
			
			/**** End code for employer fee deduction ****/


			$sql_d="delete from temp_proj_award where tpa_id=".$_GET['tpa_id'];
			mysql_query($sql_d);
			
			/******* Code for notification start here *********/
		
			$sql_un="insert into user_notification
			set
				un_usr_id='".$row_bd_e->usr_id."',
				un_from_usr_id='".$_SESSION['uid']."',
				un_type='accept project',
				un_content='".$_SESSION['usr'].$lang[471]."',
				un_prj_id='".$row_b->bd_prj_id."',
				un_updated_date=now()";
			
			mysql_query($sql_un);
		
		/******* Code for notification end here *********/
		
		
		/********************************** Code for email to freelancer & employer start here **********************************/
		
			$sqlemail="select * from admin_user where id='1'";
			$resemail=mysql_query($sqlemail);
			$rowemail=mysql_fetch_object($resemail);
					
			$sql_prj="select * from project where prj_id='".$row_b->bd_prj_id."'";
			$res_prj=mysql_query($sql_prj);
			$row_prj=mysql_fetch_object($res_prj);
					
			$sql_usr_freelanc="select * from user where usr_id='".$row_bd_u->usr_id."'";
			$res_usr_freelanc=mysql_query($sql_usr_freelanc);
			$row_usr_freelanc=mysql_fetch_object($res_usr_freelanc);
				
			$sql_usr_employer="select * from user where usr_id='".$row_bd_e->usr_id."'";
			$res_usr_employer=mysql_query($sql_usr_employer);
			$row_usr_employer=mysql_fetch_object($res_usr_employer);
				
			
			include "email/projAward.php"; //email design with content included
				
       		/*$comment2='<div style="border:1px solid #999999; width:660px;float:left; padding-bottom:0px;">
			<div style="width:650px;height:100px; padding-bottom:0;">'.$lang[802].'<br>
			<b>'.$lang[18].':</b>&nbsp;'.$row_prj->prj_name.'<br>
			<b>'.$lang[60].':</b>&nbsp;'.$row_usr_employer->usr_name.'<br>
			<b>'.getWebSiteName().$lang[804].' '.$lang[803].':</b>&nbsp;'.($row_b->bd_amount*$row_bd_u->mp_freelancerfee/100).'<br>
			</div></div>';*/
		

			$from_mail=$rowemail->email;
   		    $to=$row_usr_freelanc->usr_email; 	
	
    	    $subj=$lang[805];
			$headers  = "MIME-Version: 1.0\n";
		    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
		    $headers .= 'From: '.$from_mail.'';	
		
			mail($to,$subj,$comment2,$headers);
				
			/****************************************/
			
			include "email/projAward.php"; //email design with content included
		
			/*$comment3='<div style="border:1px solid #999999; width:660px;float:left; padding-bottom:0px;">
			<div style="width:650px;height:100px; padding-bottom:0;">'.$lang[806].':<br>
			<b>'.$lang[18].':</b>&nbsp;'.$row_prj->prj_name.'<br>
			<b>Employer:</b>&nbsp;'.$row_usr_freelanc->usr_name.'<br>
			<b>'.getWebSiteName().$lang[804].' '.$lang[803].':</b>&nbsp;'.($row_b->bd_amount*$row_bd_e->mp_employerfee/100).'<br>
			</div></div>';*/
		

			$from_mail=$rowemail->email;
   	    	$to=$row_usr_employer->usr_email; 	

	        $subj=$lang[805];
			$headers  = "MIME-Version: 1.0\n";
	    	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		    $headers .= 'From: '.$from_mail.'';	
		
			mail($to,$subj,$comment3,$headers);
		
		/********************************** Code for email to freelancer & employer end here ************************************/
		
		
			
		}
		else if($_GET['stat']=="decline")
		{
			$sql_b="select * from bid,project where bd_prj_id=prj_id and bd_id=(select tpa_bd_id from temp_proj_award where tpa_id='".$_GET['tpa_id']."')";
			$res_b=mysql_query($sql_b);
			$row_b=mysql_fetch_object($res_b);
			
			$sql_d="delete from temp_proj_award where tpa_id=".$_GET['tpa_id'];
			mysql_query($sql_d);
			
			/******* Code for notification start here *********/
		
			$sql_un="insert into user_notification
			set
				un_usr_id='".$row_b->prj_usr_id."',
				un_from_usr_id='".$_SESSION['uid']."',
				un_type='decline project',
				un_content='".$_SESSION['usr'].$lang[472]."',
				un_prj_id='".$row_b->bd_prj_id."',
				un_updated_date=now()";
			
			mysql_query($sql_un);

		}
	}
	/**** Code for project Accept and Decline end ****/
?>