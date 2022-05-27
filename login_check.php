<?php
ob_start();
session_start();
include "common.php";

$err_msg="";

	$usr_name=trim(addslashes($_GET['usr_name']));
	$usr_password=trim(addslashes($_GET['usr_password']));
	
	$_SESSION['usr_name']=$usr_name;
	$_SESSION['usr_password']=$usr_password;
	
	$valid=true;
	
	if($usr_name=="")
	{
		$err_msg='<font color="#CC0000">'.$lang[29].'</font>';
		$valid=false;
	}
	else if($usr_password=="")
	{
		$err_msg='<font color="#CC0000">'.$lang[31].'</font>';
		$valid=false;
	}
	else
	{
		$valid=true;	
	}

	if($valid==true)
	{
		$sql="select * from user where usr_name='".$usr_name."' and usr_status=1";
		$res=mysql_query($sql);
		if($row=mysql_fetch_object($res))
		{
			if(substr($row->usr_password,2)==md5($usr_password))
			{
				$_SESSION['uid']=$row->usr_id;
				$_SESSION['usr']=$row->usr_name;
				$_SESSION['psw']=$row->usr_password;
				$_SESSION['eml']=$row->usr_email;
				$_SESSION['img']=$row->usr_image;
				unset($_SESSION['msg']);
				unset($_SESSION['usr_name']);
				unset($_SESSION['usr_password']);
				
				
				$ip = $_SERVER['REMOTE_ADDR'];
				
			/*	$updSql="update user
				set 
					usr_loginip='".$ip."',	
					usr_lastlogin=now() 
				where usr_id=".$row->usr_id;
				mysql_query($updSql);*/
				
				$sql_uld="insert user_login_details
					set
						uld_usr_id='".$row->usr_id."',
						uld_last_login=now(),
						uld_ip='".$ip."'";
				mysql_query($sql_uld);
				
				if(isset($_SESSION['last_page']))
				{
					echo "1|".$_SESSION['last_page'];
				}
				else
				{
			    echo "1|manage.php";
				}
			}
			else
			{
				$err_msg='<font color="#CC0000">'.$lang[50].'</font>';
				unset($_SESSION['usr_name']);
				unset($_SESSION['usr_password']);			
				echo "0|".$err_msg;	
			}
		}
		else
		{
			$err_msg='<font color="#CC0000">'.$lang[50].'</font>';
			unset($_SESSION['usr_name']);
			unset($_SESSION['usr_password']);			
			echo "0|".$err_msg;	
		}
	}
	else
	{
		echo "0|".$err_msg;
	}


?>