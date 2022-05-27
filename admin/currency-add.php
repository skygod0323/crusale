<?php 
ob_start();
session_start(); 
include "../common.php";

check_user_login();
class addCurrency{
	var $msg;	
	var $cr_name;
	
	function __construct($cr_name)
	{		
		$this->cr_name=$cr_name;

		$_SESSION['cr_name']=$this->cr_name;
	}
	function valid()
	{
		$valid=true;	

		if($this->cr_name == "0")
		{
			$this->msg= '<font color="#CC0000">Please enter currency</font>';
			$valid=false;
		}
		return $valid;
	}

	function add()
	{	
		$sql="insert into currency
			set			
				cr_name ='".$this->cr_name."',
				cr_status = 1";
			

		mysql_query($sql) or die(mysql_error());
		

		$this->msg='<font color="#009900">Currency added successfully.</font>';
				
		unset($_SESSION['cr_name']);
	}	
}

if(isset($_SESSION['msg'])){	$msg=$_SESSION['msg'];	unset($_SESSION['msg']);	}
if(isset($_SESSION['cr_name'])){	$cr_name=$_SESSION['cr_name'];	unset($_SESSION['cr_name']); }else{ $cr_name=""; }


if(isset($_POST['btnAdd']))
{ 	
	
	$adn=new addCurrency(addslashes(trim($_POST['cr_name'])));
	if($adn->valid())
	{	
		$adn->add();		
	}
	$_SESSION['msg']=$adn->msg;

	header("location:currency-add.php");
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Administrative Panel</title>
<script src="js/jquery-1.2.1.min.js" type="text/javascript"></script>
<script src="js/menu-collapsed.js" type="text/javascript"></script>
<script src="js/add/jquery.pstrength-min.1.2.js" type="text/javascript"></script>
<script src="js/add/validation.js" type="text/javascript"></script>

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
        					<li>&rsaquo;&nbsp;&nbsp;Currency Management</li>
        					<li>&rsaquo;&nbsp;&nbsp;Currency Add</li>
      					</ul>
      					<ul class="right">
       					  <li><a href="currency-view.php">Currency List</a></li>
   					  </ul>
      					<div class="clr"></div>
   				  </div>   
             	<br clear="all"/>
				</div>        
					<div> 
						<div class="admin-dtls">
							<form action="" id="adv_add" name="adv_add" method="post" enctype="multipart/form-data">
								<ul>	
									<li style="line-height:12px">
										<div class="eID">&nbsp;</div>
										<div class="eID" style="width:500px"><strong><?php echo $msg;?></strong></div>		
										<div class="clr"></div>
									</li>	
                                    <li>
										<div class="eID"><strong>Currency:</strong></div>
										<div class="eID" style="margin-top:5px;">
                                        	<input type="text" name="cr_name" id="cr_name" class="reg_txtfld" value="<?php $cr_name; ?>" />
                                        </div>
										<div class="clr"></div>
									</li>
									<li style="text-align:center">										
										<input type="submit" name="btnAdd" id="btnAdd" value="Add" class="butt" style="margin-right:10px;" />								
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
<script src="js/add/smooth-dropdown.js" type="text/javascript"></script>
<script src="js/add/common.js" type="text/javascript"></script>
</html>