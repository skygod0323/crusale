<?php 
ob_start();
session_start(); 
include "../common.php";
//---------------Abdul---------------

check_user_login();
class addContent{

	var $msg;
	var $cms_title;	
	var $cms_content;	
	
	
	function __construct($cms_title, $cms_content) 
	{
		$this->cms_title=$cms_title;
		$this->cms_content=$cms_content;		
	}

	function valid()
	{
		$valid=true;
		if($this->cms_content == "")
		{
			$this->msg= '<font color="#CC0000">Please enter contents.</font>';
			$valid=false;
		}
				
		return $valid;
	}
	
	function add()
	{				
		$sql="insert into cms 
			set					
				cms_title ='".$this->cms_title."',
				cms_page ='".$this->cms_title."',
				cms_content ='".$this->cms_content."',				
				cms_updated_date=now()";							
		mysql_query($sql) or die(mysql_error());
													
		$this->msg='<font color="#009900">Content added successfully</font>';	

	}	
}


if(isset($_SESSION['msg'])){
	$msg=$_SESSION['msg'];
	unset($_SESSION['msg']);
}

if(isset($_POST['btnAdd'])){ 
		
	$adn=new addContent($_POST['cms_title'],$_POST['cms_page'], addslashes(trim($_POST['cms_content'])),  
				addslashes(trim($_POST['pd_standard_price'])), addslashes(trim($_POST['pd_mini_price'])), trim($_FILES['pd_image']['name']));

	if($adn->valid()){	
		$adn->add();		
	}
	//echo $ecms->msg;
	$_SESSION['msg']=$adn->msg;
	
	header("location:cms-add.php");
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administrative Panel</title>
<script src="js/jquery-1.2.1.min.js" type="text/javascript"></script>
<script src="js/menu-collapsed.js" type="text/javascript"></script>
<script src="js/common.js" language="javascript"></script>
<link href="style/style.css" type="text/css" rel="stylesheet"/>
</head>

<body>
	<div class="main">
		<?php include "includes/admin-top.php" ?>
		<div class="control_Panel">
		    <?php include "includes/admin-left-con.php" ?>
			<div class="bodyRightCon" style="margin-bottom:45px;">
			    <div class="bcMenuCon">
    				<div class="bcMenu">
      					<ul>
        					<li>&rsaquo;&nbsp;&nbsp;CMS Management</li>
        					<li>&rsaquo;&nbsp;&nbsp;CMS Add</li>
      					</ul>      					
      					<div class="clr">
						</div>
    				</div> 
				</div>        
                
                <div> 
						<div class="admin-dtls">
							<form action="" id="test_add" name="test_add" method="post" >
								<ul>	
									<li style="line-height:12px">
										<div class="eID">&nbsp;</div>
										<div class="eID" style="width:500px"><strong><?php echo $msg; ?></strong></div>		
										<div class="clr"></div>
									</li>
                                    <li>
										<div class="eID"><strong>Select CMS: </strong></div>
										<div class="eID" style="width:400px; padding-top:5px;">
											<select name="cms_title" id="cms_title" class="reg_txtfld">
                                            	<option value="aboutus">About Us</option>
                                                <option value="pickup">Pick Up</option>
                                                <option value="delivery">Delivery</option>
                                            </select>
										</div>
										<div class="clr"></div>
									</li>  
                                    	
                                    <li>
										<div class="eID"><strong>Content: </strong></div>
										<div class="eID" style="margin-top:10px;">
                                        	<textarea name="cms_content" id="cms_content" style="width:400px; height:100px;"></textarea>
										</div>
										<div class="clr"></div>
									</li>                                                                  
                                    <li style="text-align:center;">																				
											<input type="submit" name="btnAdd" id="btnAdd" value="Add" class="butt" style="margin-right:10px; margin-top:5px;" />									
										<div class="clr"></div>
									</li>																		    
								</ul>
							</form>   
						</div>
    				</div>
    
    
            </div>
			<br clear="all" />	
    	</div>
	</div>
	<?php include "includes/footer.php" ?>
</body>
</html>
