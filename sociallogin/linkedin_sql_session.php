<?php 
	$res = mysql_query("select * from user where usr_oauth_reg = '4' and usr_email = '".$email."' and usr_status = '1'");
	
	if(mysql_num_rows($res) > 0)
	{
		$row = mysql_fetch_object($res);
		
		$_SESSION['uid_pint'] = $row->usr_id;
		$_SESSION['login_pint'] = 'true';
		
		
	}
	else
	{
			mysql_query("insert into user
					set
						usr_oauth_reg = '4',
						usr_fname = '".$fname."',
						usr_lname = '".$lname."',
						usr_email = '".$email."',
						usr_pwd = '".rand(1000000,9999999)."',
						usr_reg_date = now(),
						usr_emailVerify =  '1',
						usr_updated_date = now()");
			
						$lastID_liknd = mysql_insert_id();
						$_SESSION['uid_pint']=$lastID_liknd;
						$_SESSION['login_pint'] = 'true';
	}
	
header("location:../home.php");
?>