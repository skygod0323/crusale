<?php
ob_start();
session_start();
include "common.php";

$usr_email=$_GET['usr_email'];
$usr_name=$_GET['usr_name'];
$usr_password=$_GET['usr_password'];
$cnf_password=$_GET['cnf_password'];
$usr_type=$_GET['usr_type'];

$reg_data=array();

if($usr_email == "")
{
	$reg_data[0]="0";
	$reg_data[1]=$lang[27];
	$valid=false;
}
else if(!validate::is_email($usr_email))
{
	$reg_data[0]="0";
	$reg_data[1]=$lang[28];
	$valid=false;
}
else if($usr_name == "")
{
	$reg_data[0]="0";
	$reg_data[1]=$lang[29];
	$valid=false;
}
else if($usr_password == "")
{
	$reg_data[0]="0";
	$reg_data[1]=$lang[31];
	$valid=false;
}
else if(strlen($usr_password)<6)
{
	$reg_data[0]="0";
	$reg_data[1]=$lang[32];
	$valid=false;
}
else if($cnf_password == "")
{
	$reg_data[0]="0";
	$reg_data[1]=$lang[33];
	$valid=false;
}
else if(strcmp($usr_password,$cnf_password) != 0)
{
	$reg_data[0]="0";
	$reg_data[1]=$lang[34];
	$valid=false;
}
else
{
	$sql_chk_unm="select * from user where usr_name='".$usr_name."'";
	$res_chk_unm=mysql_query($sql_chk_unm);
	
	$sql_chk="select * from user where usr_email='".$usr_email."'";
	$res_chk=mysql_query($sql_chk);
	if(mysql_num_rows($res_chk)>0)
	{
		$reg_data[0]="0";
		$reg_data[1]=$lang[761];
	}
	else if(mysql_num_rows($res_chk_unm)>0)
	{
		$reg_data[0]="0";
		$reg_data[1]=$lang[823];
	}
	else
	{
		$sql_mp="select * from membership_plan where mp_id='1'";	//retrieving the free membership plan details
		$res_mp=mysql_query($sql_mp);
		$row_mp=mysql_fetch_object($res_mp);
		
		$sql="insert into user
				set				
					usr_name ='".$usr_name."',
					usr_email ='".$usr_email."',
					usr_password ='".rand(10,99).md5($usr_password)."',
                    usr_type ='".$usr_type."',
                    oauth_id ='',
                    oauth_provider ='',
                    usr_state ='',
                    usr_phone ='',
                    usr_postalcode =0,
                    usr_loginip ='',
                    usr_lastlogin =now(),
					usr_total_bid ='".$row_mp->mp_bidspermonth."',
					usr_left_bid ='".$row_mp->mp_bidspermonth."',
					usr_mem_expiry =date_add(now(),INTERVAL 1 MONTH),
					usr_updated_date =now(),
                    usr_creation_date=now()";
					
		mysql_query($sql) or die(mysql_error());
		
        $user_id=mysql_insert_id();

        $sql_eml="select * from email_setting where es_status=1";
        $res_eml=mysql_query($sql_eml);
        while ($row_eml=  mysql_fetch_object($res_eml))
        {
            $sql_ues="insert into user_email_setting
                set					
                    ues_usr_id ='".$user_id."',
                    ues_es_id ='".$row_eml->es_id."'";
            mysql_query($sql_ues);
        }


		
		/**** code for email verification start here ****/
		
		$res_latest_user=mysql_query("select * from user where usr_id='".$user_id."' and usr_status='1'");
		$row_latest_user=mysql_fetch_object($res_latest_user);
		
		$sqlemail="select * from admin_user where id='1'";
		$resemail=mysql_query($sqlemail);
		$rowemail=mysql_fetch_object($resemail);
		
		$from=$rowemail->email; 		
		$to=$row_latest_user->usr_email;				
		$cc="";	
		
		include "email/createAccount.php"; //email design with content included
		
		
		/*$comment='<div style="border:1px solid #999999; width:660px;float:left; padding-bottom:0px;">
		<div style="width:650px;height:100px; padding-bottom:0;">
			'.$lang[37].'<br/>
		<a href=http://'.$_SERVER['HTTP_HOST'].'/emailVerify.php?u='.md5($row_latest_user->usr_id).' target=_blank>http://'.$_SERVER['HTTP_HOST'].'/emailVerify.php?u='.md5($row_latest_user->usr_id).'</a>
		</div></div>';*/

		
		

        $subj=$lang[38];
        $headers  = "MIME-Version: 1.0\n";
	    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
        $headers .= 'From: '.$from.'';	
		
//		$v="To: ".$to."<br/>Subject: ".$subj."<br/>Comment: ".$comment."<br/>From: ".$from."<br>Site: ".getWebSiteName();

		mail($to,$subj,$comment,$headers);
		
		
//		validate::send_mail($to, $from, getWebSiteName(), $replay, $cc,  $subj, $comment);
		/**** code for email verification end here ****/
		
		$reg_data[0]="1";
		$reg_data[1]=$lang[39];
//		$reg_data[1]=$v;
		
		/*unset($_SESSION['usr_name']);
		unset($_SESSION['usr_email']);
		unset($_SESSION['usr_password']);
        unset($_SESSION['usr_type']);*/
		
		
		/** Code for auto login after user creation  START HERE **/
		$sql="select * from user where usr_id='".$user_id."'";
		$res=mysql_query($sql);
		$row=mysql_fetch_object($res);
		
		$_SESSION['uid']=$row->usr_id;
			$_SESSION['usr']=$row->usr_name;
			$_SESSION['psw']=$row->usr_password;
			$_SESSION['eml']=$row->usr_email;
			$_SESSION['img']=$row->usr_image;
            $_SESSION['type']=$row->usr_type;
			
				
			$ip = $_SERVER['REMOTE_ADDR'];
				
			$sql_uld="insert user_login_details
				set
					uld_usr_id='".$row->usr_id."',
					uld_last_login=now(),
					uld_ip='".$ip."'";
			mysql_query($sql_uld);
			
			if($row->usr_type=="Employer" || $row->usr_type=="Both")
			{
				$reg_data[1]="post-project.php";	
			}
			else
			{
				$reg_data[1]="manage.php";	
			}
		/** Code for auto login after user creation  END HERE **/
	}
}
echo $reg_data[0]."|".$reg_data[1];
?>