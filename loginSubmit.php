<?php
ob_start();
session_start();
include "common.php";


$usr_name=$_POST['usr_name'];
$usr_password=$_POST['usr_password'];
$remember=$_POST['remember'];

if($remember=='yes')
{
	setcookie("fr_usr",$usr_name, time()+3600);
	setcookie("fr_psw",$usr_password, time()+3600);
}
else
{
	setcookie("fr_usr",$usr_email, time()-60);
	setcookie("fr_psw",$usr_password, time()-60);
}

$data=array();

if($usr_name == "")
{
	$data[0]="0";
	$data[1]=$lang[29];
	$valid=false;
}
else if($usr_password == "")
{
	$data[0]="0";
	$data[1]=$lang[31];
	$valid=false;
}
else
{
	$sql="select * from user where usr_name='".$usr_name."' and usr_status=1";
	$res=mysql_query($sql);
	if($row=mysql_fetch_object($res))
	{
		if(substr($row->usr_password,2)==md5($usr_password))
		{
			$data[0]="1";
			
			$_SESSION['uid']=$row->usr_id;
			$_SESSION['usr']=$row->usr_name;
			$_SESSION['psw']=$row->usr_password;
			$_SESSION['eml']=$row->usr_email;
			$_SESSION['img']=$row->usr_image;
            $_SESSION['type']=$row->usr_type;
			
			/*unset($_SESSION['msg']);
			unset($_SESSION['usr_name']);
			unset($_SESSION['usr_password']);*/
				
				
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
				//$fl_name=substr($_SESSION['last_page'],strpos($_SESSION['last_page'],'/',1)+1,strlen($_SESSION['last_page']));
                /* $file=substr($_SESSION['last_page'],0,strpos($_SESSION['last_page'],'.'));
                            
                if($file=="post-project-res")
                {
                	$_SESSION['temp_proj']="true";
                }*/
				$lst_page=$_SESSION['last_page'];
				
			//	header("Location:".$lst_page);
				$data[1]=$lst_page;
			}
			else
			{
				$data[1]="manage.php";
			}
		}
		else
		{
			$data[0]="0";
			$data[1]=$lang[50];
			/*$_SESSION['msg']='<font color="#CC0000">'.$lang[50].'</font>';
			unset($_SESSION['usr_name']);
			unset($_SESSION['usr_password']);			
			header("Location:login.php");*/		
		}
	}
	else
	{
		$data[0]="0";
		$data[1]=$lang[50];
		/*$_SESSION['msg']='<font color="#CC0000">'.$lang[50].'</font>';
		unset($_SESSION['usr_name']);
		unset($_SESSION['usr_password']);			
		header("Location:login.php");*/	
	}
}
unset($_SESSION['last_page']);
echo $data[0]."|".$data[1];
?>