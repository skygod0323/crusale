<?php
ob_start();
session_start();
include "common.php";

if(isset($_SESSION['msg'])){	$msg=$_SESSION['msg'];	unset($_SESSION['msg']);	}else{ $msg=""; }
if(isset($_SESSION['usr_name'])){	$usr_name=$_SESSION['usr_name'];	unset($_SESSION['usr_name']);	}else{ $usr_name=""; }
if(isset($_SESSION['usr_email'])){	$usr_email=$_SESSION['usr_email'];	unset($_SESSION['usr_email']);	}else{ $usr_email=""; }
if(isset($_SESSION['usr_password'])){	$usr_password=$_SESSION['usr_password'];	unset($_SESSION['usr_password']);	}else{ $usr_password=""; }
if(isset($_SESSION['$usr_type'])){	$usr_type=$_SESSION['$usr_type'];	unset($_SESSION['$usr_type']);	}else{ $usr_type=""; }

class addUser
{
	var $msg;
	var $usr_email;
	var $usr_name;
	var $usr_password;
	var $cnf_password;
      var $usr_type;
	
	function __construct($usr_email, $usr_name, $usr_password, $cnf_password, $usr_type)
	{
		$this->usr_email=$usr_email;
		$this->usr_name=$usr_name;
		$this->usr_password=$usr_password;
		$this->cnf_password=$cnf_password;
            $this->usr_type=$usr_type;
		
		$_SESSION['usr_email']=$this->usr_email;
		$_SESSION['usr_name']=$this->usr_name;
		$_SESSION['usr_password']=$this->usr_password;
		$_SESSION['cnf_password']=$this->cnf_password;
            $_SESSION['usr_type']=$this->usr_type;
	}
	function valid()
	{
        include "language.php";
		$valid=true;	
		
		if($this->usr_email == "")
		{
			$this->msg= '<font color="#CC0000">'.$lang[27].'</font>';
			$valid=false;
		}
		else if(!validate::is_email($this->usr_email))
		{
			$this->msg= '<font color="#CC0000">'.$lang[28].'</font>';
			$valid=false;
		}
		else if($this->usr_name == "")
		{
			$this->msg= '<font color="#CC0000">'.$lang[29].'</font>';
			$valid=false;
		}
		else if($this->usr_password == "")
		{
			$this->msg= '<font color="#CC0000">'.$lang[31].'</font>';
			$valid=false;
		}
		else if(strlen($this->usr_password)<6)
		{
			$this->msg= '<font color="#CC0000">'.$lang[32].'</font>';
			$valid=false;
		}
		else if($this->cnf_password == "")
		{
			$this->msg= '<font color="#CC0000">'.$lang[33].'</font>';
			$valid=false;
		}
		else if(strcmp($this->usr_password,$this->cnf_password) != 0)
		{
			$this->msg= '<font color="#CC0000">'.$lang[34].'</font>';
			$valid=false;
		}
		else
		{
			$valid=true;	
		}
		return $valid;
	}
	function checkExistingUser()
	{
          include "language.php";
		$sql="SELECT * FROM user WHERE usr_name='".$this->usr_name."' or usr_email='".$this->usr_email."'";
		$result=mysql_query($sql);
		if(mysql_num_rows($result)>0)
		{
			$exUser=mysql_fetch_object($result);
			if($exUser->usr_name==$this->usr_name)
			{
				$this->msg= '<font color="#CC0000">'.$lang[35].'</font>';
				return false;
			}
			else if($exUser->usr_email==$this->usr_email)
			{
				$this->msg= '<font color="#CC0000">'.$lang[36].'</font>';
				return false;
			}
		}
		else
		{
			return true;	
		}
	}
	function add()
	{
          include "language.php";
		$sql="insert into user
				set				
					usr_name ='".$this->usr_name."',
					usr_email ='".$this->usr_email."',
					usr_password ='".rand(10,99).md5($this->usr_password)."',
                              usr_type ='".$this->usr_type."',
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


		$res_latest_user=mysql_query("select max(usr_id) from user where usr_status='1'");
		$row_latest_user=mysql_fetch_array($res_latest_user);
		/**** code for email verification start here ****/
		
            
		$sqlemail="select * from admin_user where id='1'";
		$resemail=mysql_query($sqlemail);
		$rowemail=mysql_fetch_object($resemail);
		
$comment='<div style="border:1px solid #999999; width:660px;float:left; padding-bottom:0px;">
		<div style="width:650px;height:100px; padding-bottom:0;">
			'.$lang[37].'<br/>
		<a href=http://'.$_SERVER['HTTP_HOST'].'/emailVerify.php?u='.md5($user_id).' target=_blank>http://'.$_SERVER['HTTP_HOST'].'/emailVerify.php?u='.md5($row->usr_id).'</a>
		</div></div>';


			$from_mail=$rowemail->email;
$to=$this->usr_email; 	

           $subj=$lang[38];
           $headers  = "MIME-Version: 1.0\n";
	       $headers .= "Content-type: text/html; charset=iso-8859-1\n";
           $headers .= 'From: '.$from_mail.'';	
		
		mail($to,$subj,$comment,$headers);
		/**** code for email verification end here ****/
		
		$this->msg='<font color="#009900">'.$lang[39].'</font>';
		
		unset($_SESSION['usr_name']);
		unset($_SESSION['usr_email']);
		unset($_SESSION['usr_password']);
            unset($_SESSION['usr_type']);
            
	}
}

if(isset($_POST['submitbtn']))
{
	$adu=new addUser( addslashes(trim($_POST['usr_email'])), addslashes(trim($_POST['usr_name'])), addslashes(trim($_POST['usr_password'])), addslashes(trim($_POST['cnf_password'])),  addslashes(trim($_POST['usr_type'])));
	
	if($adu->valid() && $adu->checkExistingUser())
	{	
		$adu->add();
            
      /*    $fl_name=substr($_SESSION['last_page'],strpos($_SESSION['last_page'],'/',1)+1,strlen($_SESSION['last_page']));
            $file=substr($filename,0,strpos($fl_name,'.'));
            if($file=="post-project-res")
            {
                $_SESSION['temp_proj']="true";
                header("Location:".$_SESSION['last_page']);
            }*/
		header("Location:login.php");
            
	}
		
	$_SESSION['msg']=$adu->msg;
	
	header("location:signup.php");
}
?>
		<?php include "includes/header.php"; ?>
			
<script type="text/javascript">
function validSignup()
{
	var usr_email = document.getElementById('usr_email');
    var usr_name = document.getElementById('usr_name');
	var usr_password = document.getElementById('usr_password');	
	var cnf_password = document.getElementById('cnf_password');	
	var lat = usr_email.value;

	var at = "@";
	var dot = ".";
	var lat = usr_email.value.indexOf(at);
	var lstr = usr_email.value.length;
	var ldot = usr_email.value.indexOf(dot);
	
	var msgContact="";
	var valid=true;	
	
	if (usr_email.value == "" || usr_email.value == null)
    {
		msgContact="<?php echo $lang[27]; ?>";
		usr_email.value="";
        usr_email.focus();
        valid = false;
    }  	
	// check if '@' is at the first position or at last position or absent in given email 
	else if (usr_email.value.indexOf(at) == -1 || usr_email.value.indexOf(at) == 0 || usr_email.value.indexOf(at) == lstr)
	{	
		msgContact="<?php echo $lang[28]; ?>";
		usr_email.value="";
        usr_email.focus();
        valid = false;	
			
	}
	// check if '.' is at the first position or at last position or absent in given email
	else if (usr_email.value.indexOf(dot) == -1 || usr_email.value.indexOf(dot) == 0 || usr_email.value.indexOf(dot) == lstr)
	{
	    msgContact="<?php echo $lang[28]; ?>";
		usr_email.value="";
        usr_email.focus();
        valid = false;
		
	}
    // check if '@' is used more than one times in given email
	else if (usr_email.value.indexOf(at,(lat+1)) != -1)
	{
	    msgContact="<?php echo $lang[28]; ?>";
		usr_email.value="";
        usr_email.focus();
        valid = false;	
	}  
    // check for the position of '.'
	else if (usr_email.value.substring(lat-1,lat) == dot || usr_email.value.substring(lat+1,lat+2) == dot)
	{
	    msgContact="<?php echo $lang[28]; ?>";
		usr_email.value="";
        usr_email.focus();
    	valid = false;	
	}
    // check if '.' is present after two characters from location of '@'
	else if (usr_email.value.indexOf(dot,(lat+2)) == -1)
	{
	    msgContact="<?php echo $lang[28]; ?>";
		usr_email.value="";
        usr_email.focus();
    	valid = false;	
	}	
	// check for blank spaces in given email
	else if (usr_email.value.indexOf(" ") != -1)
	{	
		msgContact="<?php echo $lang[28]; ?>";
		usr_email.value="";
      	usr_email.focus();
       	valid = false;	
	}
	else if (usr_name.value == "" || usr_name.value == null)
    {
		msgContact='<?php echo $lang[29]; ?>';
		usr_name.value="";
        usr_name.focus();
        valid = false;		
    }  
	else if(!isNaN(usr_name.value))
	{
		msgContact='<?php echo $lang[30]; ?>';
		usr_name.value="";
        usr_name.focus();
        valid = false;		
	}
	else if (usr_password.value == "" || usr_password.value == null)
    {
		msgContact='<?php echo $lang[31]; ?>';
		usr_password.value="";
        usr_password.focus();
        valid = false;		
    }
	else if (usr_password.value.length < 6)
    {
		msgContact='<?php echo $lang[32]; ?>';
		usr_password.value="";
        usr_password.focus();
        valid = false;
    }
	else if (cnf_password.value == "" || cnf_password.value == null)
    {
		msgContact='<?php echo $lang[33]; ?>';
		cnf_password.value="";
        cnf_password.focus();
        valid = false;		
    }
	else if (usr_password.value != cnf_password.value)
    {
		msgContact='<?php echo $lang[34]; ?>';
		cnf_password.value="";
        cnf_password.focus();
        valid = false;		
    }
	else
	{		
		valid=true;
	}	
	
	if(!valid)
	{
		document.getElementById("msg").style.color = "red";
		document.getElementById('msg').innerHTML = msgContact;			 				
	}
    return valid;
}
</script>
	<div><h2 class="header-txt1-style align-center-txt"><?php echo $lang[40]; ?></h2></div>
	<div class="clearfix">
		<div class="signup-lft-col">
			<form method="post" action="" id="signupform" onSubmit="return validSignup()">
					<div class="signup-form-str" id="msg"><?php echo $msg; ?></div>
                                
                                <div class="signup-form-str">
						<label class="form-label"><?php echo $lang[41]; ?></label>
						<div class="signup-input-field">
							<input type="text" name="usr_email" id="usr_email" value="<?php echo $usr_email; ?>"/>
                                    </div>
					</div>
								
					<div class="signup-form-str">
						<label class="form-label"><?php echo $lang[42]; ?></label>
						<div class="signup-input-field">
							<input type="text" name="usr_name" id="usr_name" value="<?php echo $usr_name; ?>"/>						</div>
					</div>
								
					<div class="signup-form-str">
						<label class="form-label"><?php echo $lang[43]; ?></label>
						<div class="signup-input-field">
							<input type="password" name="usr_password" id="usr_password" value="<?php echo $usr_password; ?>"/>
						</div>
					</div>
							
					<div class="signup-form-str">
						<label class="form-label"><?php echo $lang[44]; ?></label>
						<div class="signup-input-field">
							<input type="password" name="cnf_password" id="cnf_password" value="<?php echo $cnf_password; ?>"/>
						</div>
					</div>
                              <div class="signup-form-str">
                                  <label class="form-label"><?php echo $lang[631]; ?></label>
                                  <div class="clearfix">
                                  <div class="form-radio-field" style="width: 250px;margin-bottom: 2px;margin-left: 10px;"><input type="radio" id="usr_type_F" name="usr_type" value="<?php echo $lang[64]; ?>" <?php if($usr_type=="Freelancer"){ ?>checked="checked" <?php } ?> />&nbsp;<?php echo $lang[64]; ?></div>
                                    <div class="form-radio-field" style="width: 250px;margin-bottom: 2px;margin-left: 10px;"><input type="radio" id="usr_type_E" name="usr_type" value="Employer" <?php if($usr_type=="Employer"){ ?>checked="checked" <?php } ?>/>&nbsp;<?php echo $lang[60]; ?></div>
                                    <div class="form-radio-field" style="width: 250px;margin-left: 10px;"><input type="radio" id="usr_type_B" name="usr_type" value="Both" checked="checked"/>&nbsp;<?php echo $lang[620]; ?></div>
                                  </div>
					</div>
					<div class="signup-form-str">
                                  <div class="create-acc-btn">
					<input type="submit" id="submitbtn" name="submitbtn" value="<?php echo $lang[45]; ?>"/>
					</div>
					</div>
							</form>
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