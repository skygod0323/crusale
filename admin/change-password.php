<?php 
ob_start();
session_start(); 
include "../common.php";
include "lib/pagination.php";

check_user_login();

class editPage{
	
	var $msg;
	var $su_id;
	var $cp_o_password;
	var $cp_n_password;
	var $cp_c_password;
	
	function __construct($su_id){
		$this->su_id=$su_id;
	}
	function detailsObj(){
		$sql="select * from users where su_id=".$this->su_id;
		$res=mysql_query($sql);
		return mysql_fetch_object($res);
	}
	function valid(){
	
		$valid=true;
		
		$sqlChkUser="select * from users where su_id='".$this->su_id."'";
		$resChkUser=mysql_query($sqlChkUser);
		$rowChkUser=mysql_fetch_array($resChkUser);	
		
		if($this->cp_o_password == "")
		{
			$this->msg= '<font color="#CC0000">Please enter name.</font>';
			$valid=false;
		}
		else if(md5($this->cp_o_password) != $rowChkUser['su_password'])
		{						
			$this->msg= '<font color="#CC0000">Old password do not match.</font>';
			$valid=false;				
		}
		else if($this->cp_n_password == "")
		{
			$this->msg= '<font color="#CC0000">Please enter new password.</font>';
			$valid=false;
		}		
		else if($this->cp_c_password == "")
		{
			$this->msg= '<font color="#CC0000">Please enter confirm new password.</font>';
			$valid=false;
		}
		else if($this->cp_n_password != $this->cp_c_password)
		{
			$this->msg= '<font color="#CC0000">Password do not match.</font>';
			$valid=false;
		}					
					
		return $valid;
	}
	
	function update()	
	{				
		$sql="update users 
				set						
					su_password='".md5($this->cp_n_password)."',							
					su_updated_date = UNIX_TIMESTAMP()
				where su_id='".$this->su_id."'";
		mysql_query($sql) or die(mysql_error());
		
		$sqlId="select * from users where su_id='".$this->su_id."'";																	
		$resId=mysql_query($sqlId);
		$rowId=mysql_fetch_array($resId);
		
		$comment1='Hello '.$rowId['su_name'].', <br /><br />';
		$comment1.='Your password is changed.'.'<br /><br />';			
		
		$comment1.='New Password : '.$this->cp_n_password.'<br /><br />';
		$comment1.='Administrator <br /> Farouk2012.com <br />';
		//$comment1.='Email: '.$to.'<br />';		
				
		validate::send_mail($rowId['su_email'], $from, 'Regenerated Password', $replay, $cc, 'Coffee Divination | Change Password', $comment1);
		//function send_mail($mailto, $from_mail, $from_name, $replyto, $cc, $subject, $message, $filename =  NULL, $path = NULL)	
		
		$this->msg='<font color="#009900">Password changed successfully.</font>';				
	}	
}

if(isset($_SESSION['msg'])){
	$msg=$_SESSION['msg'];
	unset($_SESSION['msg']);
}

$ob=new editPage($_GET['kyid']);
$row=$ob->detailsObj();

if(isset($_POST['btnUpdate'])){			
	$ob->cp_o_password=trim(addslashes($_POST['cp_o_password']));
	$ob->cp_n_password=trim(addslashes($_POST['cp_n_password']));	
	$ob->cp_c_password=trim(addslashes($_POST['cp_c_password']));	
	
	if($ob->valid()){
		$ob->update();
	}
	//echo $ecms->msg;
	$_SESSION['msg']=$ob->msg;
	
	header("location:change-password.php?kyid=".$ob->su_id);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Administrative Panel</title>
<link rel="icon" href="images/favicon.ico" type="image/ico" />
<script src="js/jquery-1.2.1.min.js" type="text/javascript"></script>
<script src="js/menu-collapsed.js" type="text/javascript"></script>
<link href="style/style.css" type="text/css" rel="stylesheet"/>

</head>

<body>
<div class="main">
	<?php include "includes/admin-top.php" ?>
	<div class="control_Panel">
	<?php include "includes/admin-left-con.php" ?>
		<div class="bodyRightCon">
        	<div class="bodyRightightCon_inner">
				<div class="bcMenuCon">
    				<div class="bcMenu">
      					<ul>
					        <li>&rsaquo;&nbsp;&nbsp;Member Management</li>
					        <li>&rsaquo;&nbsp;&nbsp;Member Change Password</li>
						</ul>
					    <ul class="right">
				          <li><a href="member-view.php">Member List</a></li>
      					</ul>
      					<div class="clr"></div>
    				</div>    
				</div>
   					<div>   						
						<div class="admin-dtls">
							<form action="" id="su_cpassword" name="su_cpassword" method="post" enctype="multipart/form-data">
								<ul>	
									<li style="line-height:12px">
										<div class="eID">&nbsp;</div>
										<div class="eID" style="width:500px"><strong><?php echo $msg;?></strong></div>		
										<div class="clr"></div>
									</li>                                       
                                    <li>
										<div class="eID"><strong>Old Password: </strong></div>
										<div class="eID">
											<input type="password" name="cp_o_password" id="cp_o_password" class="ed1-textfild" />
										</div>
										<div class="clr"></div>
									</li>	                                   
                                    <li>
										<div class="eID"><strong>New Password: </strong></div>
										<div class="eID">
                                        	<input type="password" name="cp_n_password" id="cp_n_password" class="ed1-textfild" />											
										</div>
										<div class="clr"></div>
									</li>
                                    <li>
										<div class="eID"><strong>Confirm New Password: </strong></div>
										<div class="eID">
                                        	<input type="password" name="cp_c_password" id="cp_c_password" class="ed1-textfild" />											
										</div>
										<div class="clr"></div>
									</li>                                     							
									<li style="text-align:center">										
										<input type="submit" name="btnUpdate" id="btnUpdate" value="Update" class="butt" style="margin-right:10px; margin-top:5px;" />								
										<div class="clr"></div>
									</li>									    
								</ul>
							</form> 
						</div>
					</div>

			</div>
			<br clear="all"/>
		</div>
	</div>
  	<br clear="all" />   	
</div>
<?php include "includes/footer.php" ?>
</body>
</html>
