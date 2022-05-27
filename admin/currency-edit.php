<?php 
ob_start();
session_start(); 
include "../common.php";

check_user_login();
class editAdvertisement{
	
	var $msg;
	var $adv_id;
	var $adv_img;
	var $adv_link;
	var $adv_imagewidth;
	var $adv_imageheight;
	
	
	function __construct($adv_id){
		$this->adv_id=$adv_id;
	}
	function detailsObj(){
		$sql="select * from advertisement where adv_id=".$this->adv_id;
		$res=mysql_query($sql);
		return mysql_fetch_object($res);
	}
	function valid(){
	
		$valid=true;
			
		return $valid;
	}
	
	function update()
	{			
		if($_FILES["adv_img"]["name"] != '')
		{
			if ($_FILES["adv_img"]["error"] > 0)
			{
				$msg = "Return Code: " . $_FILES["adv_img"]["error"] . "<br />";
			}
			else
			{	
				$sqlImg="select * from advertisement where adv_id='".$this->ht_id."'";
				$resImg=mysql_query($sqlImg);
				$rowImg=mysql_fetch_object($resImg);
				
//				$pathS="../upload/logo/small/".$rowImg->ht_logo;	
				$pathB="../upload/advertisement/".$rowImg->adv_img;
	
				if(is_file($pathS))
				{
					unlink($pathS);
				}
				
				if(is_file($pathB))
				{
					unlink($pathB);
				}	
				
				$imgSImage = new SimpleImage();			
				$imgSImage->load($_FILES['adv_img']['tmp_name']);			
				$imgSImage->resize($this->adv_imagewidth,$this->adv_imageheight);
				
				$this->adv_img='adv'.rand(0,9999).trim(addslashes($_FILES['adv_img']['name']));	
				$imgSImage->save("../upload/advertisement/".$this->adv_img);											
				
//				$ds = move_uploaded_file($_FILES["adv_img"]["tmp_name"], "../upload/advertisement/".$this->adv_img) or die('error');
				
				/*if($ds)
				{*/	
										
					$sql="update advertisement
							set
								adv_img ='".$this->adv_img."',
								adv_link ='".$this->adv_link."',
								adv_imagewidth ='".$this->adv_imagewidth."',
								adv_imageheight ='".$this->adv_imageheight."'
							where adv_id='".$this->adv_id."'";							
					mysql_query($sql) or die(mysql_error());
														
					$this->msg='<font color="#009900">Advertisement updated successfully</font>';	
				/*}*/
			}		
		}
		else
		{
			$sql="update advertisement
								set
									adv_link ='".$this->adv_link."'
								where adv_id='".$this->adv_id."'";
								
			mysql_query($sql) or die(mysql_error());
						
			$this->msg='<font color="#009900">Advertisement updated successfully</font>';
		}						
	}	
}

if(isset($_SESSION['msg'])){
	$msg=$_SESSION['msg'];
	unset($_SESSION['msg']);
}

$ob=new editAdvertisement($_GET['aid']);
$row=$ob->detailsObj();

if(isset($_POST['btnUpdate'])){
	
	$ob->adv_imagewidth=addslashes(trim($_POST['adv_imagewidth']));	
	$ob->adv_imageheight=addslashes(trim($_POST['adv_imageheight']));	
	$ob->adv_img=trim($_FILES['adv_img']['name']);
	$ob->adv_link=addslashes(trim($_POST['adv_link']));	
		
	if($ob->valid()){
		$ob->update();
	}
	$_SESSION['msg']=$ob->msg;
	
	header("location:advertisement-edit.php?aid=".$ob->adv_id);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Administrative Panel</title>
<script src="js/jquery-1.2.1.min.js" type="text/javascript"></script>
<script src="js/menu-collapsed.js" type="text/javascript"></script>
<script src="js/common.js" language="javascript"></script><!-- Common Validation Function -->		
<link href="style/style.css" type="text/css" rel="stylesheet"/>


</head>

<body>
<div class="main">
	<?php include "includes/admin-top.php" ?>
	<div class="control_Panel">
	<?php include "includes/admin-left-con.php" ?>
		<div class="bodyRightCon" style="margin-bottom:45px;">
        	<div class="bodyRightightCon_inner">
				<div class="bcMenuCon">
    				<div class="bcMenu">
      					<ul>
					        <li>&rsaquo;&nbsp;&nbsp;Advertisement Management</li>
					        <li>&rsaquo;&nbsp;&nbsp;Advertisement Edit</li>
						</ul>
					    <ul class="right">
					        <li><a href="advertisement-view.php">Advertisement List</a></li>
      					</ul>
      					<div class="clr"></div>
    				</div>  
                 <br clear="all"/>
				</div>  
   					<div>   
						<!--<div class="admin-hdr-bg">   
							<div class="eID"><strong>&nbsp;</strong></div>
							<div class="eID"><strong><?php //echo $msg;?></strong></div>
							<div class="clr"></div>
						</div>-->
						<div class="admin-dtls">
							<form action="" id="test_edit" name="test_edit" method="post" enctype="multipart/form-data" onsubmit="return filling();">
								<ul>	
									<li style="line-height:12px">
										<div class="eID">&nbsp;</div>
										<div class="eID" style="width:500px"><strong><?php echo $msg;?></strong></div>		
										<div class="clr"></div>
									</li>                                                                        
                                    <li>
										<div class="eID"><strong>Image Size:</strong></div>
										<div class="eID" style="width:400px; padding-top:5px;">
                                        	<input type="hidden" name="adv_imagewidth" value="<?php echo $row->adv_imagewidth; ?>" />
                                            <input type="hidden" name="adv_imageheight" value="<?php echo $row->adv_imageheight; ?>" />
                                        	<?php echo $row->adv_imagewidth." x ".$row->adv_imageheight; ?>
										</div>
										<div class="clr"></div>
									</li>	
                                    <li>									
                                    	<div class="eID"><strong>Previous Image:</strong></div>
										<div class="eID" style="width:400px; padding-top:5px;">											
											<img src="../upload/advertisement/<?php echo $row->adv_img; ?>" />
										</div>
										<div class="clr"></div>										
									</li>                                                                
                                    <li>
										<div class="eID"><strong>Upload Image:</strong></div>
										<div class="eID" style="width:400px; padding-top:5px;">
											<input type="file" name="adv_img" id="adv_img" class="reg_txtfld" />
										</div>
										<div class="clr"></div>
									</li>  
                                    <li>
										<div class="eID"><strong>Associted Link:</strong></div>
										<div class="eID" style="margin-top:5px;">
                                        	<input type="text" name="adv_link" id="adv_link" class="reg_txtfld" value="<?php echo stripslashes($row->adv_link); ?>" />
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
		</div>
        <br clear="all" />
	</div>  	   	
</div>
<?php include "includes/footer.php" ?>
</body>
</html>
