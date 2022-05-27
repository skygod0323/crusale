<?php
ob_start();
session_start();
include "common.php";

if(isset($_SESSION['msg'])){	$msg=$_SESSION['msg'];	unset($_SESSION['msg']); }
if(isset($_SESSION['usr_email'])){ $usr_email=$_SESSION['usr_email']; unset($_SESSION['usr_email']); } else { $usr_email=""; }

if(isset($_POST['submitbutton']))
{
	$usr_email=trim($_POST['usr_email']);

	$_SESSION['usr_email']=$usr_email;
	
	$msg="";	
	$valid=true;
	
	if($usr_email=="")
	{
		$msg="<font color=red>".$lang[250]."</font>";
		$valid=false;	
	}
	else
	{
		$valid=true;
	}
	
	
	if($valid==true)
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
			$mailfrom=$admin_row[email];
			
			$mailsubject = $lang[251];
			$mailbody = $lang[252]."<br>";
			$mailbody .= $lang[253].$usr_email;
			$mailbody .= "<br>".$lang[254].$pass;
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$headers .= "From: ". $mailfrom."\r\n";
			mail($mailto,$mailsubject,$mailbody,$headers);	


			$msg="<font color='green'>".$lang[255]."</font>";
		}
		else
		{
			$msg="<font color='red'>".$lang[256].getWebSiteName()."</font>";
		}
	}
	
	$_SESSION['msg']=$msg;
	header("location:forgot-password.php");
}
?>

<?php include "includes/header.php"; ?>

<div><h2 class="header-txt1-style align-center-txt"><?php echo $lang[257]; ?></h2></div>
      <form name="changeuserinfoform" id="changeuserinfoform" method="POST" action="" enctype="multipart/form-data" >
		<div class="clearfix">
      		<div style="width:785px;float:left;margin:0 0 0 100px;">
				<div class="signup-form-str" id="msg"><?php echo $msg; ?></div>
                                
                        <div class="signup-form-str">
					<label class="form-label"><?php echo $lang[258]; ?></label>
					<div class="signup-input-field">
						<input name="usr_email" id="usr_email" type="text" value="<?php echo $usr_email; ?>"/>
					</div>
				</div>
								
	           		<div class="signup-form-str">
					<div class="create-acc-btn">
						<input type="submit" name="submitbutton" id="submitbutton" value="<?php echo $lang[259]; ?>">
					</div>
				</div>
							
			</div>
						
		</div>
      </form>
					
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