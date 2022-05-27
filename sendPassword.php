<?php
ob_start();
session_start();
include "common.php";

$usr_email=trim($_GET['usr_email']);

if($usr_email=="")
{
	$data[0]="0";
	$data[1]=$lang[250];
	$valid=false;	
}
else
{
	$login_sql="select * from user where usr_email='".$usr_email."' and usr_status=1";
	
	$login_res=mysql_query($login_sql);		
	if(mysql_num_rows($login_res)>0)
	{
		$pass=createRandomPassword(1);
		$newpass=rand(10,99).md5($pass);
			
		$sq="update user set usr_password='$newpass' where usr_email='$usr_email'";
		$result2=mysql_query($sq);
		$mailto =$usr_email;
			
		$admin="select email from admin_user where id=1";
		$admin_res=mysql_query($admin);
		$admin_row=mysql_fetch_array($admin_res);
		$mailfrom=$admin_row['email'];
			
			

		$mailsubject = $lang[251];
		$mailbody = $lang[252]."<br>";
		$mailbody .= $lang[253].$usr_email;
		$mailbody .= "<br>".$lang[254].$pass;
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= "From: ". $mailfrom."\r\n";
//		echo $mailto." ".$mailsubject." ".$mailbody." ".$headers;
		mail($mailto,$mailsubject,$mailbody,$headers);

		$data[0]="1";
		$data[1]=$lang[255];
	}
	else
	{
		$data[0]="0";
		$data[1]=$lang[256].getWebSiteName();
	}
}
echo $data[0]."|".$data[1];
?>