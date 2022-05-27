<?php 

				$result = mysql_query("SELECT * FROM user WHERE usr_email='".$content->screen_name."' and oauth_provider='twitter'");
				 if(mysql_num_rows($result) > 0) //user id exist in database
    			{
					$UserCount = mysql_fetch_array($result);
					$_SESSION['uid']=$UserCount['usr_id'];
					$_SESSION['usr']=$UserCount['usr_name'];
					$_SESSION['psw']=$UserCount['usr_password'];
					$_SESSION['eml']=$UserCount['usr_email'];
					$_SESSION['img']=$UserCount['usr_image'];
					$_SESSION['type']=$UserCount['usr_type'];
    			}
				else
				{
					$sql_ins="INSERT INTO user
							set
								usr_email ='".$content->screen_name."',
								oauth_provider='twitter',
								oauth_id='".$uid."',
								usr_name='".$content->name."',
								usr_password='".rand(1000000,9999999)."',
								usr_fname='".$content->name."',
								usr_type ='Both',
								usr_total_bid ='".$row_mp->mp_bidspermonth."',
								usr_left_bid ='".$row_mp->mp_bidspermonth."',
								usr_emailVerified='1',
								usr_mem_expiry =date_add(now(),INTERVAL 1 MONTH),
								usr_updated_date =now(),
			                    usr_creation_date=now()";
						
						mysql_query($sql_ins);
					
						/*mysql_query("insert into user
					set
						usr_oauth_reg = '3',
						usr_fname = '".$content->name."',
						usr_email = '".$content->screen_name."',
						usr_pwd = '".rand(1000000,9999999)."',
						usr_reg_date = now(),
						usr_emailVerify =  '1',
						usr_updated_date = now()");*/
			
						$lastID_twt = mysql_insert_id();
						$_SESSION['uid']=$lastID_twt;
						
						$res=mysql_query("SELECT * FROM `user` WHERE usr_id='".$lastID_twt."' and oauth_provider = 'google'");
						$row_usr=mysql_fetch_array($res);
			
						$_SESSION['usr']=$row_usr['usr_name'];
						$_SESSION['psw']=$row_usr['usr_password'];
						$_SESSION['eml']=$row_usr['usr_email'];
						$_SESSION['img']=$row_usr['usr_image'];
						$_SESSION['type']=$row_usr['usr_type'];
		
					
				}
				
				
				//redirect to main page.
				header('Location: ../home.php'); 


?>