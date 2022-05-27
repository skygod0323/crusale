<?php 
ob_start();
session_start(); 
include "../common.php";
include '../lib/simpleimage.php';	

check_user_login();
class editProduct{
	
	var $msg;
	var $pd_id;
	var $pd_category;	
	var $pd_product_name;	
	var $pd_description;
	var $pd_standard_price;
	var $pd_mini_price;
	var $pd_image;
	
	function __construct($pd_id){
		$this->pd_id=$pd_id;
	}
	function detailsObj(){
		$sql="select * from products where pd_id=".$this->pd_id;
		$res=mysql_query($sql);
		return mysql_fetch_object($res);
	}
	function valid(){
	
		$valid=true;
		if($this->pd_product_name == "")
		{
			$this->msg= '<font color="#CC0000">Please enter product name.</font>';
			$valid=false;
		}
		else if($this->pd_standard_price == "")
		{
			$this->msg= '<font color="#CC0000">Please enter standard price.</font>';
			$valid=false;
		}
		else if($this->pd_mini_price == "")
		{
			$this->msg= '<font color="#CC0000">Please enter mini price.</font>';
			$valid=false;
		}			
			
		return $valid;
	}
	
	function update()
	{			
		if($_FILES["pd_image"]["name"] != '')
		{
			if ($_FILES["pd_image"]["error"] > 0)
			{
				$msg = "Return Code: " . $_FILES["pd_image"]["error"] . "<br />";
			}
			else
			{	
				$sqlImg="select * from products where pd_id='".$this->pd_id."'";
				$resImg=mysql_query($sqlImg);
				$rowImg=mysql_fetch_object($resImg);
				
				$pathS="../upload/products/small/".$rowImg->pd_image;	
				$pathB="../upload/products/".$rowImg->pd_image;
	
				if(is_file($pathS))
				{
					unlink($pathS);
				}
				
				if(is_file($pathB))
				{
					unlink($pathB);
				}	
				
				$imgSImage = new SimpleImage();			
				$imgSImage->load($_FILES['pd_image']['tmp_name']);			
				$imgSImage->resize(143,124);
				
				$this->pd_image='pd'.rand(0,9999).trim(addslashes($_FILES['pd_image']['name']));	
				$imgSImage->save("../upload/products/small/".$this->pd_image);										
				
				$ds = move_uploaded_file($_FILES["pd_image"]["tmp_name"], "../upload/products/".$this->pd_image) or die('error');
				
				if($ds)
				{																		    	 								
					$sql="update products 
							set					
								pd_category ='".$this->pd_category."',	
								pd_product_name ='".$this->pd_product_name."',									
								pd_description ='".$this->pd_description."',								
								pd_standard_price ='".$this->pd_standard_price."',
								pd_mini_price ='".$this->pd_mini_price."',								
								pd_image ='".$this->pd_image."',
								pd_updated_date=UNIX_TIMESTAMP()
							where pd_id='".$this->pd_id."'";							
					mysql_query($sql) or die(mysql_error());
														
					$this->msg='<font color="#009900">Product added successfully</font>';	
				}
			}		
		}
		else
		{
			$sql="update products 
					set					
						pd_category ='".$this->pd_category."',	
						pd_product_name ='".$this->pd_product_name."',									
						pd_description ='".$this->pd_description."',								
						pd_standard_price ='".$this->pd_standard_price."',
						pd_mini_price ='".$this->pd_mini_price."',								
						pd_image ='".$this->pd_image."',
						pd_updated_date=UNIX_TIMESTAMP()
					where pd_id='".$this->pd_id."'";							
			mysql_query($sql) or die(mysql_error());
												
			$this->msg='<font color="#009900">Product added successfully</font>';
		}						
	}	
}

if(isset($_SESSION['msg'])){
	$msg=$_SESSION['msg'];
	unset($_SESSION['msg']);
}

$ob=new editProduct($_GET['fid']);
$row=$ob->detailsObj();

if(isset($_POST['btnUpdate'])){

	$ob->pd_category=$_POST['pd_category'];	
	$ob->pd_product_name=addslashes(trim($_POST['pd_product_name']));				
	$ob->pd_description=addslashes(trim($_POST['pd_description']));	
	$ob->pd_standard_price=addslashes(trim($_POST['pd_standard_price']));
	$ob->pd_mini_price=addslashes(trim($_POST['pd_mini_price']));
	$ob->pd_image=trim($_FILES['pd_image']['name']);
		
	if($ob->valid()){
		$ob->update();
	}
	//echo $ecms->msg;
	$_SESSION['msg']=$ob->msg;
	
	header("location:product-edit.php?fid=".$ob->pd_id);
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
					        <li>&rsaquo;&nbsp;&nbsp;Product Management</li>
					        <li>&rsaquo;&nbsp;&nbsp;Product Edit</li>
						</ul>
					    <ul class="right">
					        <li><a href="product-view.php">Product List</a></li>
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
										<div class="eID"><strong>Select Category: </strong></div>
										<div class="eID" style="width:400px; padding-top:5px;">
											<select name="pd_category" id="pd_category" class="reg_txtfld">
                                            	<option value="ccc" <?php if($row->pd_category == 'ccc') { ?> selected="selected"<?php } ?>>Cocktail Cup Cakes</option>
                                                <option value="nacc" <?php if($row->pd_category == 'nacc') { ?> selected="selected"<?php } ?>>Non Alcholic Cup Cakes</option>
                                                <option value="cd" <?php if($row->pd_category == 'cd') { ?> selected="selected"<?php } ?>>Custom Display</option>
                                            </select>
										</div>
										<div class="clr"></div>
									</li>  
                                    <li>
										<div class="eID"><strong>Product Name:</strong></div>
										<div class="eID" style="width:400px; padding-top:5px;">
											<input type="text" name="pd_product_name" id="pd_product_name" class="reg_txtfld" value="<?php echo stripslashes($row->pd_product_name); ?>" />
										</div>
										<div class="clr"></div>
									</li>	
                                    <li>
										<div class="eID"><strong>Description: </strong></div>
										<div class="eID" style="margin-top:10px;">
                                        	<textarea name="pd_description" id="pd_description" style="width:400px; height:100px;"><?php echo stripslashes($row->pd_description); ?></textarea>
										</div>
										<div class="clr"></div>
									</li>
                                    <li>
										<div class="eID"><strong>Standard Price:</strong></div>
										<div class="eID" style="margin-top:5px;">
                                        	<input type="text" name="pd_standard_price" id="pd_standard_price" class="reg_txtfld" style="width:130px;" value="<?php echo stripslashes($row->pd_standard_price); ?>" />
										</div>
										<div class="clr"></div>
									</li> 
                                    <li>
										<div class="eID"><strong>Mini Price:</strong></div>
										<div class="eID" style="margin-top:5px;">
                                        	<input type="text" name="pd_mini_price" id="pd_mini_price" class="reg_txtfld" style="width:130px;" value="<?php echo stripslashes($row->pd_mini_price); ?>" />
										</div>
										<div class="clr"></div>
									</li>   
                                    <li>
										<div class="eID">&nbsp;</div>
										<div class="eID" style="width:400px; padding-top:5px;">
											<img src="../upload/products/small/<?php echo $row->pd_image; ?>" />
										</div>
										<div class="clr"></div>
									</li>                            
                                    <li>
										<div class="eID"><strong>Image:</strong></div>
										<div class="eID" style="width:400px; padding-top:5px;">
											<input type="file" name="pd_image" id="pd_image" class="reg_txtfld" />
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
