<?php 

//$uid, $oauth_provider, $username, $email
function createRandomFbPassword($t)
{
	if($t==1){
    	$chars = "abcdefghijkmnopqrstuvwxyz023456789";
	}
	if($t==2){
    	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ023456789";
	}
	if($t==3){
    	$chars = "abcdefghijkmnopqrstuvwxyz023456789";
	}
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '' ;
	while ($i <= 7)
	{
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }
    return $pass;
}

 
// "SELECT * FROM `user` WHERE oauth_id = '$uid' and oauth_provider = '$oauth_provider'"
        $query = mysql_query("SELECT * FROM user WHERE oauth_id = '".$uid."' and oauth_provider = '".$oauth_provider."'") or die(mysql_error());
        $result = mysql_fetch_array($query);
		
        if (!empty($result))
		{
        	//$query_f = mysql_query("update `user` set usr_oauth_reg = '1' WHERE usr_email = '".$email."'") or die(mysql_error());  
        } 
		else 
		{
            #user not present. Insert a new Record
				$usr_password=createRandomFbPassword('1');
 				$usr_password=rand(10,99).md5($usr_password);
				$parts = explode("@", $email);
				$usr_name = $parts[0];
            					
/*				$query = mysql_query("insert into user
			set
				usr_oauth_reg = '1',
				usr_fname = '".$f_l_name[0]."',
				usr_lname = '".$f_l_name[1]."',
				usr_email = '".$email."',
				usr_pwd = '".$usr_password."',
				usr_reg_date = now(),
				usr_emailVerify =  '1',
				usr_updated_date = now()");
				
				
				
           		$query = mysql_query("SELECT * FROM `user` WHERE usr_oauth_reg = '1' and usr_email = '".$email."' and usr_status = '1'");
            	$result = mysql_fetch_array($query);
            	return $result;*/
//	            $query = mysql_query("INSERT INTO `user` (oauth_provider, oauth_id, usr_name) VALUES ('$oauth_provider', $uid, '$username')") or die(mysql_error());



				$sql_mp="select * from membership_plan where mp_id='1'";	//retrieving the free membership plan details
				$res_mp=mysql_query($sql_mp);
				$row_mp=mysql_fetch_object($res_mp);

				$username = str_replace(' ', '_', $username);
				
				$sql_ins="INSERT INTO user
							set
								usr_email ='".$email."',
								oauth_provider='".$oauth_provider."',
								oauth_id='".$uid."',
								usr_name='".$username."',
								usr_password='".$usr_password."',
								usr_fname='".$usr_fname."',
								usr_lname='".$usr_lname."',
								usr_type ='Both',
								usr_total_bid ='".$row_mp->mp_bidspermonth."',
								usr_left_bid ='".$row_mp->mp_bidspermonth."',
								usr_emailVerified='1',
								usr_mem_expiry =date_add(now(),INTERVAL 1 MONTH),
								usr_updated_date =now(),
			                    usr_creation_date=now()";
						
								
				$query = mysql_query($sql_ins) or die(mysql_error());
				
				
				
				$query = mysql_query("SELECT * FROM `user` WHERE oauth_id = $uid and oauth_provider = 'facebook'");
	            $result = mysql_fetch_array($query);
				
				
			
            return $result;
        }

?>