<?php 
ob_start();
session_start(); 
include "../common.php";
include '../lib/simpleimage.php';	

check_user_login();
class addProduct{

	var $msg;
	var $cat_id;
	var $prj_scat_id;
	var $prj_name;
	var $prj_skills;
	var $prj_details;
	var $prj_type;
	
	function __construct( $cat_id, $prj_scat_id, $prj_name, $prj_skills, $prj_details, $prj_type) 
	{
		$this->cat_id=$cat_id;
		$this->prj_scat_id=$prj_scat_id;
		$this->prj_name=$prj_name;		
		$this->prj_skills=$prj_skills;
		$this->prj_details=$prj_details;
		$this->prj_type=$prj_type;
	}

	function valid()
	{
		$valid=true;
		if($this->cat_id == "0")
		{
			$this->msg= '<font color="#CC0000">Please select category.</font>';
			$valid=false;
		}
		else if($this->prj_scat_id == "")
		{
			$this->msg= '<font color="#CC0000">Please select sub category.</font>';
			$valid=false;
		}
		else if($this->prj_name == "")
		{
			$this->msg= '<font color="#CC0000">Please enter product name.</font>';
			$valid=false;
		}
		else if($this->prj_skills == "")
		{
			$this->msg= '<font color="#CC0000">Please enter skills.</font>';
			$valid=false;
		}
		else if($this->prj_details == "")
		{
			$this->msg= '<font color="#CC0000">Please enter project details.</font>';
			$valid=false;
		}
		else if($this->pd_image == "")
		{
			$this->msg= '<font color="#CC0000">Please upload an image.</font>';
			$valid=false;
		}				
				
		return $valid;
	}
	
	function add()
	{				
		if ($_FILES["pd_image"]["error"] > 0)
		{
			$msg = "Return Code: " . $_FILES["pd_image"]["error"] . "<br />";
		}
		else
		{	
			$imgSImage = new SimpleImage();			
			$imgSImage->load($_FILES['pd_image']['tmp_name']);			
			$imgSImage->resize(143,124);
			
			$this->pd_image='pd'.rand(0,9999).trim(addslashes($_FILES['pd_image']['name']));	
			$imgSImage->save("../upload/products/small/".$this->pd_image);										
			
			$ds = move_uploaded_file($_FILES["pd_image"]["tmp_name"], "../upload/products/".$this->pd_image) or die('error');
			
			if($ds)
			{																		    	 								
				$sql="insert into products 
						set					
							pd_category ='".$this->pd_category."',	
							prj_name ='".$this->prj_name."',									
							pd_description ='".$this->pd_description."',								
							pd_standard_price ='".$this->pd_standard_price."',
							pd_mini_price ='".$this->pd_mini_price."',								
							pd_image ='".$this->pd_image."',
							pd_updated_date=UNIX_TIMESTAMP()";							
				mysql_query($sql) or die(mysql_error());
													
				$this->msg='<font color="#009900">Product added successfully</font>';	
			}
		}			
	}	
}

if(isset($_SESSION['msg'])){
	$msg=$_SESSION['msg'];
	unset($_SESSION['msg']);
}

if(isset($_POST['btnAdd']))
{
	print_r($_POST);
	exit;
	$adn=new addProduct($_POST['pd_category'], addslashes(trim($_POST['prj_name'])), addslashes(trim($_POST['pd_description'])), 
				addslashes(trim($_POST['pd_standard_price'])), addslashes(trim($_POST['pd_mini_price'])), trim($_FILES['pd_image']['name']));

	if($adn->valid()){	
		$adn->add();		
	}
	//echo $ecms->msg;
	$_SESSION['msg']=$adn->msg;
	
	header("location:product-add.php");
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
<script language="javascript">
function showSubcat(str)
{
	$.get("showSubcat.php", {q:str},
		function(data){
		$('#prj_scat_id').html(data);
	 });
}
</script>
<link href="style/style.css" type="text/css" rel="stylesheet"/>
<!-- <link href="style/style_cms.css" type="text/css" rel="stylesheet"/> -->
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
        					<li>&rsaquo;&nbsp;&nbsp;Product Add</li>
      					</ul>
      					<ul class="right">
        					<li><a href="product-view.php">Product List</a></li>
      					</ul>
      					<div class="clr">
						</div>
    				</div> 
				</div>                       
					<div> 
						<div class="admin-dtls">
							<form action="" id="test_add" name="test_add" method="post" enctype="multipart/form-data">
								<ul>	
									<li style="line-height:12px">
										<div class="eID">&nbsp;</div>
										<div class="eID" style="width:500px"><strong><?php echo $msg;?></strong></div>		
										<div class="clr"></div>
									</li>
                                    <li>
                                    	<?php
											$sql_cat="select * from category order by cat_id";
											$res_cat=mysql_query($sql_cat);
										?>
										<div class="eID"><strong>Catagory: <span>*</span></strong></div>
										<div class="eID">
											<select name="cat_id" id="cat_id" style="width:280px;" class="reg_txtfld" onchange="showSubcat(this.value)">
                                            	<option value="select" selected="selected">-Select-</option>
                                                <?php while($row_cat=mysql_fetch_object($res_cat)) { ?>
                                                	<option value="<?php echo $row_cat->cat_id; ?>" <?php if($cat_id==$row_cat->cat_id) { ?> selected="selected"<?php } ?> ><?php echo ucfirst($row_cat->cat_name); ?></option>
                                                <?php } ?>
                                            </select>
										</div>
										<div class="clr"></div>
									</li>
                                    <li>
                                    	<?php
											$sql_scat="select * from subcatagory where scat_cat_id=".$cat_id." and scat_status=1 order by scat_name";  
											$res_scat=mysql_query($sql_scat);
										?>
										<div class="eID"><strong>Sub-Category: <span>*</span></strong></div>
										<div class="eID">
											<select name="prj_scat_id" id="prj_scat_id" class="reg_txtfld" style="width:280px;">
                                            	<option value="0">-Select-</option>
                                            </select>
										</div>
										<div class="clr"></div>
									</li>
                                    <li>
										<div class="eID"><strong>Project Name:</strong></div>
										<div class="eID" style="width:400px; padding-top:5px;">
											<input type="text" name="prj_name" id="prj_name" class="reg_txtfld" />
										</div>
										<div class="clr"></div>
									</li>	
                                    <li>
										<div class="eID"><strong>Skills:</strong></div>
										<div class="eID" style="margin-top:5px;">
                                        	<input type="text" name="prj_skills" id="prj_skills" class="reg_txtfld" style="width:400px;" />
										</div>
										<div class="clr"></div>
									</li>
                                    <li>
										<div class="eID"><strong>Details: </strong></div>
										<div class="eID" style="margin-top:10px;">
                                        	<textarea name="prj_details" id="prj_details" style="width:400px; height:100px;"></textarea>
										</div>
										<div class="clr"></div>
									</li>                           
                                    <li>
										<div class="eID"><strong>Project Type:</strong></div>
										<div class="eID" style="width:400px; padding-top:5px;">
                                        	<input type="radio" name="prj_type" id="prj_type" />Fixed Price&nbsp;&nbsp;
                                            <input type="radio" name="prj_type" id="prj_type" />Hourly Budget                                
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
		</div>
		<br clear="all" />	
	</div>
</div>
<?php include "includes/footer.php" ?>
</body>
</html>
