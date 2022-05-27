<?php 

	 //compare user id in our database
	 //echo "SELECT * FROM user WHERE usr_email='".$google_email."'";
    $result = mysql_query("SELECT * FROM user WHERE usr_email='".$google_email."' and oauth_provider = 'google'");
	if($result === false) { 
		die(mysql_error()); //result is false show db error and exit.
	}
	
	//echo mysql_num_rows($result);
    if(mysql_num_rows($result) > 0) //user id exist in database
    {
		$UserCount = mysql_fetch_array($result);
		$_SESSION['uid']=$UserCount['usr_id'];
		$_SESSION['usr']=$UserCount['usr_name'];
		$_SESSION['psw']=$UserCount['usr_password'];
		$_SESSION['eml']=$UserCount['usr_email'];
		$_SESSION['img']=$UserCount['usr_image'];
		$_SESSION['type']=$UserCount['usr_type'];
		
/*		if(!isset($_SESSION['refresh_pint']))
		{
			$page = $_SERVER['PHP_SELF'];
			$sec = "0";
			$_SESSION['refresh_pint'] = 'close';
			header("Refresh: $sec; url=$page");
		}*/
	
    }
	else
	{ //user is new

		$sql_mp="select * from membership_plan where mp_id='1'";	//retrieving the free membership plan details
		$res_mp=mysql_query($sql_mp);
		$row_mp=mysql_fetch_object($res_mp);
		
		$splitName = explode(' ',$user_name);
		$usr_name = str_replace(' ', '_', $user_name);
		
		$sql_ins="INSERT INTO user
			set
				usr_email ='".$google_email."',
				oauth_provider='google',
				oauth_id='".$user_id."',
				usr_name='".$usr_name."',
				usr_password='".rand(1000000,9999999)."',
				usr_fname = '".$splitName[0]."',
				usr_lname = '".$splitName[1]."',
				usr_type ='Both',
				usr_total_bid ='".$row_mp->mp_bidspermonth."',
				usr_left_bid ='".$row_mp->mp_bidspermonth."',
				usr_emailVerified='1',
				usr_mem_expiry =date_add(now(),INTERVAL 1 MONTH),
				usr_updated_date =now(),
                usr_creation_date=now()";
		
			/*$splitName = explode(' ',$user_name);
			$sql_ins="insert into user
			set
				oauth_id='".$user_id."',
				oauth_provider = 'google',
				usr_fname = '".$splitName[0]."',
				usr_lname = '".$splitName[1]."',
				usr_email = '".$google_email."',
				usr_password = '".rand(1000000,9999999)."',
				usr_creation_date = now(),
				usr_emailVerified =  '1',
				usr_updated_date = now()";*/
				
			mysql_query($sql_ins);
			
			$lastID_gmail = mysql_insert_id();
			
			$res=mysql_query("SELECT * FROM `user` WHERE usr_id='".$lastID_gmail."' and oauth_provider = 'google'");
			$row_usr=mysql_fetch_array($res);
			
			$_SESSION['uid']=$lastID_gmail;
			$_SESSION['usr']=$row_usr['usr_name'];
			$_SESSION['psw']=$row_usr['usr_password'];
			$_SESSION['eml']=$row_usr['usr_email'];
			$_SESSION['img']=$row_usr['usr_image'];
			$_SESSION['type']=$row_usr['usr_type'];
		
			
			
			/*if(!isset($_SESSION['refresh_pint']))
		{
			$page = $_SERVER['PHP_SELF'];
			$sec = "0";
			header("Refresh: $sec; url=$page");
		}*/
		
		
	}

	


?>