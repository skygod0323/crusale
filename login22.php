<?php
ob_start();
session_start();
include "common.php";

$msg="";

if(isset($_SESSION['msg'])){	$msg=$_SESSION['msg'];	unset($_SESSION['msg']);	}
if(isset($_SESSION['usr_name'])){	$usr_name=$_SESSION['usr_name'];	unset($_SESSION['usr_name']);	}else{ $usr_name=""; }
if(isset($_SESSION['usr_password'])){	$usr_password=$_SESSION['usr_password'];	unset($_SESSION['usr_password']);	}else{ $usr_password=""; }

if(isset($_POST['login']))
{
	$usr_name=trim(addslashes($_POST['usr_name']));
	$usr_password=trim(addslashes($_POST['usr_password']));
	
	$_SESSION['usr_name']=$usr_name;
	$_SESSION['usr_password']=$usr_password;
	
	$valid=true;
	
	if($usr_name=="")
	{
		$_SESSION['msg']='<font color="#CC0000">'.$lang[29].'</font>';
		$valid=false;
	}
	else if($usr_password=="")
	{
		$_SESSION['msg']='<font color="#CC0000">'.$lang[31].'</font>';
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
                        $_SESSION['type']=$row->usr_type;
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
                            //$fl_name=substr($_SESSION['last_page'],strpos($_SESSION['last_page'],'/',1)+1,strlen($_SESSION['last_page']));
                           /* $file=substr($_SESSION['last_page'],0,strpos($_SESSION['last_page'],'.'));
                            
                            if($file=="post-project-res")
                            {
                                $_SESSION['temp_proj']="true";
                            }*/
					header("Location:".$_SESSION['last_page']);
				}
				else
				{
					header("Location: manage.php");
				}
			}
			else
			{
				$_SESSION['msg']='<font color="#CC0000">'.$lang[50].'</font>';
				unset($_SESSION['usr_name']);
				unset($_SESSION['usr_password']);			
				header("Location: login.php");		
			}
		}
		else
		{
			$_SESSION['msg']='<font color="#CC0000">'.$lang[50].'</font>';
			unset($_SESSION['usr_name']);
			unset($_SESSION['usr_password']);			
			header("Location: login.php");	
		}
	}
	else
	{
		header("Location: login.php");
	}
}
?>
<?php include "includes/header.php"; ?>
			
<script type="text/javascript">
function validLogin()
{
    var usr_name = document.getElementById('usr_name');
	var usr_password = document.getElementById('usr_password');	
	
	var msg="";
	var valid=true;	
	
	if (usr_name.value == "" || usr_name.value == null)
    {
		msg='<?php echo $lang[29]; ?>';
		usr_name.value="";
        usr_name.focus();
        valid = false;		
    }  
	else if(!isNaN(usr_name.value))
	{
		msg='<?php echo $lang[30]; ?>';
		usr_name.value="";
        usr_name.focus();
        valid = false;		
	}
	else if (usr_password.value == "" || usr_password.value == null)
    {
		msg='<?php echo $lang[31]; ?>';
		usr_password.value="";
        usr_password.focus();
        valid = false;		
    }
	else if (usr_password.value.length < 6)
    {
		msg='<?php echo $lang[32]; ?>';
		usr_password.value="";
        usr_password.focus();
        valid = false;
    }
	else
	{		
		valid=true;
	}	
	
	if(!valid)
	{
		document.getElementById("msg").style.color = "red";
		document.getElementById('msg').innerHTML = msg;			 				
	}
    return valid;
}
</script>	
	<!--<div><h2 class="header-txt1-style align-center-txt">Sign up for <span>free</span> today!</h2></div>-->
	<div class="clearfix">
        <div class="signup-lft-col">
		<form method="post" action="" id="loginform" onSubmit="return validLogin()">
			<div class="signup-form-str" id="msg"><?php echo $msg; ?></div>
                                
                    <div class="signup-form-str">
				<label class="form-label"><?php echo $lang[42]; ?></label>
				<div class="signup-input-field">
					<input type="text" name="usr_name" id="usr_name" value="<?php echo $usr_name; ?>"/>
				</div>
			</div>
								
			<div class="signup-form-str">
                    <label class="form-label"><?php echo $lang[43]; ?></label>
                    <div class="signup-input-field">
				<input type="password" name="usr_password" id="usr_password" value="<?php echo $usr_password; ?>"/>
			</div>
		</div>
		<div class="signup-form-str">
                <div class="create-acc-btn">
			<input type="submit" id="login" name="login" value="<?php echo $lang[51]; ?>">
                </div>
		</div>
	</form>
            <a href="forgot-password.php"><?php echo $lang[625]; ?></a>
            <a href="signup.php" style="float: right"><?php echo $lang[626]; ?></a>
	</div>
	<div class="signup-rgt-col"><a href="#"><img src="images/large-fb-btn.jpg" alt="" /></a></div>
						
</div>
	<div class="form-privacy-txt align-center-txt"><?php echo $lang[46]; ?><a href="terms.php"><?php echo $lang[47]; ?></a><?php echo $lang[48]; ?><a href="privacy.php"><?php echo $lang[49]; ?></a></div>
		<div class="pg-bottom-text">
		<?php echo get_page_content('3'); ?>
		<?php
                   $sql_adv="select * from advertisement where adv_status='1' order by rand() limit 1";
                      $res_adv=mysql_query($sql_adv);
                      if(mysql_num_rows($res_adv)>0){
                      ?>
				<ul>
					<li>
                              <?php
                              
                              $row_adv=mysql_fetch_object($res_adv);
                              
                              ?>
                                  <a href="<?php echo $row_adv->adv_link; ?>" target="blank"><img src="upload/advertisement/<?php echo $row_adv->adv_img; ?>" height="<?php echo $row_adv->adv_imageheight; ?>" width="<?php echo $row_adv->adv_imagewidth; ?>"/></a>
                               
                                  </li>
					
				</ul>
                      <?php } ?>
	</div>
	</div>
</div>
<?php include "includes/footer.php"; ?>