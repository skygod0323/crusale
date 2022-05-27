<?php
ob_start();
session_start();
include "common.php";


class editUser{
	
	var $msg;	
	var $usr_id;
	var $usr_image;
	var $usr_fname;
	var $usr_lname;
	var $usr_address;
	var $cn_id;
	var $usr_ct_id;
	var $usr_state;
	var $usr_postalcode;
	var $usr_phone;
	
	
	function __construct($usr_id){
		$this->usr_id=$usr_id;
	}
	function detailsObj(){
		$sql="select * from user,city,country where usr_id='".$this->usr_id."' and usr_ct_id=ct_id and ct_cn_id=cn_id";
		$res=mysql_query($sql);
		return mysql_fetch_object($res);
	}
	function valid(){
	
		$valid=true;
			
		if($this->usr_fname == "")
		{
			$this->msg= '<font color="#CC0000">Please enter first name</font>';
			$valid=false;
		}
		else if($this->usr_lname == "")
		{
			$this->msg= '<font color="#CC0000">Please enter last name</font>';
			$valid=false;
		}
		else if($this->usr_address == "")
		{
			$this->msg= '<font color="#CC0000">Please enter address</font>';
			$valid=false;
		}
		else if($this->cn_id == "" || $this->cn_id == "0")
		{
			$this->msg= '<font color="#CC0000">Please select your country</font>';
			$valid=false;
		}
		else if($this->usr_ct_id == "" || $this->usr_ct_id == "0")
		{
			$this->msg= '<font color="#CC0000">Please select your city</font>';
			$valid=false;
		}
		else if($this->usr_state == "" || $this->usr_state == NULL)
		{
			$this->msg= '<font color="#CC0000">Please enter your state</font>';
			$valid=false;
		}
		else if($this->usr_postalcode == "" || $this->usr_postalcode == NULL)
		{
			$this->msg= '<font color="#CC0000">Please enter your postal code</font>';
			$valid=false;
		}
		else if($this->usr_phone == "" || $this->usr_phone == NULL)
		{
			$this->msg= '<font color="#CC0000">Please enter your phone number</font>';
			$valid=false;
		}
		
		return $valid;
	}
	
	function update()
	{			
		if($_FILES["usr_image"]["name"] != '')
		{
			if ($_FILES["usr_image"]["error"] > 0)
			{
				$msg = "Return Code: " . $_FILES["usr_image"]["error"] . "<br />";
			}
			else
			{	
				$sqlImg="select * from user where usr_id='".$this->usr_id."'";
				$resImg=mysql_query($sqlImg);
				$rowImg=mysql_fetch_object($resImg);
				
//				$pathS="../upload/logo/small/".$rowImg->al_logo;	
				$pathB="images/users/".$rowImg->usr_image;
	
				if(is_file($pathS))
				{
					unlink($pathS);
				}
				
				if(is_file($pathB))
				{
					unlink($pathB);
				}	
				
				//$imgSImage = new SimpleImage();			
				//$imgSImage->load($_FILES['ar_profile_img']['tmp_name']);			
//				$imgSImage->resize(119,70);

				$this->usr_image='usr-'.rand(0,9999).trim(addslashes($_FILES['usr_image']['name']));	
//				$imgSImage->save("../upload/logo/small/".$this->al_logo);
				
				$ds = move_uploaded_file($_FILES["usr_image"]["tmp_name"], "images/users/".$this->usr_image) or die('error');	
						
				if($ds)
				{
					$sql="update user
						set				
							usr_image ='".$this->usr_image."',
							usr_fname ='".$this->usr_fname."',
							usr_lname ='".$this->usr_lname."',
							usr_address ='".$this->usr_address."',
							usr_ct_id ='".$this->usr_ct_id."',
							usr_state='".$this->usr_state."',
							usr_postalcode='".$this->usr_postalcode."',
							usr_phone='".$this->usr_phone."',
							usr_updated_date = now()
						where usr_id='".$this->usr_id."'";
					mysql_query($sql) or die(mysql_error());
					
					$_SESSION['img']=$this->usr_image;
					
					$this->msg='<font color="#009900">Account updated successfully</font>';	
				}
				else
				{
					$this->msg='<font color="#CC0000">Error occured</font>';	
				}
			}		
		}
		else
		{
			$sql="update user
			set					
				usr_fname ='".$this->usr_fname."',
				usr_lname ='".$this->usr_lname."',						
				usr_address ='".$this->usr_address."',
				usr_ct_id ='".$this->usr_ct_id."',
				usr_state='".$this->usr_state."',
				usr_postalcode='".$this->usr_postalcode."',
				usr_phone='".$this->usr_phone."',
				usr_updated_date = now()
			where
				usr_id='".$this->usr_id."'";
	
			mysql_query($sql) or die(mysql_error());
															
			$this->msg='<font color="#009900">Account updated successfully</font>';	
		}						
	}	
}

if(isset($_SESSION['msg'])){
	$msg=$_SESSION['msg'];
	unset($_SESSION['msg']);
}

$ob=new editUser($_SESSION['uid']);
$row=$ob->detailsObj();

if(isset($_POST['submit_id'])){
	

	$ob->usr_image=trim($_FILES['usr_image']['name']);
	$ob->usr_fname=addslashes(trim($_POST['usr_fname']));	
	$ob->usr_lname=addslashes(trim($_POST['usr_lname']));	
	$ob->usr_address=addslashes(trim($_POST['usr_address']));	
	$ob->cn_id=addslashes(trim($_POST['cn_id']));	
	$ob->usr_ct_id=addslashes(trim($_POST['usr_ct_id']));	
	$ob->usr_state=addslashes(trim($_POST['usr_state']));	
	$ob->usr_postalcode=addslashes(trim($_POST['usr_postalcode']));	
	$ob->usr_phone=addslashes(trim($_POST['usr_phone']));	


		
	if($ob->valid()){
		$ob->update();
	}
	$_SESSION['msg']=$ob->msg;
	
	header("location:changeuserinfo.php");
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html id="ns-sky" xmlns="http://www.w3.org/1999/xhtml" lang="en"><head>

<title><?php echo getWebSiteTitle(); ?></title>

<meta name="title" content="<?php echo getWebSiteTitle(); ?>">
<meta name="keywords" content="<?php echo get_page_settings(2); ?>">
<meta name="description" content="<?php echo get_page_settings(3); ?>">
 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<script src="js/jquery-1.js" type="text/javascript"></script>
<script src="js/functions.js" type="text/javascript"></script>
<script src="js/jquery-1.2.1.min.js" type="text/javascript"></script>
<script src="js/ga.js" async="" type="text/javascript"></script>

<link href="css/gaf_style2.css" rel="stylesheet" type="text/css">
<!--[if !IE]> -->
<link href="css/gaf_style.css" rel="stylesheet" type="text/css">
<!-- <![endif]-->
<!--[if IE]>
<link href="//cdn6.freelancer.com/css/gaf_style.css?v31487ce116978bd7ebfe71a11faabc72f94&v=fc7df52e5c67ba6db5998adb501c359c" rel="stylesheet" type="text/css" />
<![endif]-->


<!--[if lt IE 7]>
    <link rel="stylesheet" type="text/css" href="//cdn2.freelancer.com/css/ie6.css?6&v=ca953d9ef0dacc0aeab208c20fbca20b" />
    <link href="//cdn6.freelancer.com/css/pngfix.css?3&v=c562497a335154954f8de84f79bf90fa" media="screen" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="//cdn2.freelancer.com/js/pngfix.js?1&v=80284bcf19629e23c04b9b56d62403a0"></script>
<![endif]-->
<link href="css/ui.css" rel="stylesheet" type="text/css">

<script src="js/jquery-1.js" type="text/javascript"></script>
<script src="js/jquery-ui-1.js" type="text/javascript"></script>
<script language="javascript">

function showCity(str)
{
	$.get("showCity.php", {q:str},		function(data){		$('#usr_ct_id').html(data);	 });
}
</script>
<script language="javascript">
$(document).ready(
	function(){		
		$('#submit').click(function(){	
			$('#changeuserinfoform').submit();		
		});        
	});


</script>
</head>


<body id="ns-clouds">

<div id="ns_wrapper">
    <div class="container_12">
      <div class="grid_12" id="ns_to-top" style="">
      </div>
    </div>
   	<?php include "includes/header.php"; ?>
	<div class="ns_clear"></div>
	<div class="grid">
	

<div id="ns_content"> 
<link href="css/gaf_style_new.css" rel="stylesheet" type="text/css">
<style>
a{text-decoration:none;}
.imgareaselect-border1 { background: url("//cdn3.freelancer.com/img/internal/border-anim-v.gif?v=a786bb7ed6d1cdc6146f086a22d0342d") repeat-y left top; }
.imgareaselect-border2 { background: url("//cdn5.freelancer.com/img/internal/border-anim-h.gif?v=50da31b23fdd3f5585dffd363c310456") repeat-x left top; }
.imgareaselect-border3 { background: url("//cdn3.freelancer.com/img/internal/border-anim-v.gif?v=a786bb7ed6d1cdc6146f086a22d0342d") repeat-y right top; }
.imgareaselect-border4 { background: url("//cdn5.freelancer.com/img/internal/border-anim-h.gif?v=50da31b23fdd3f5585dffd363c310456") repeat-x left bottom; }
.imgareaselect-border1, .imgareaselect-border2, .imgareaselect-border3, .imgareaselect-border4 {
    opacity: 0.5; filter: alpha(opacity=50);
}

.imgareaselect-handle {
	background-color: #fff; border: solid 1px #000;
    opacity: 0.5; filter: alpha(opacity=50);
}

.imgareaselect-outer {
	background-color: #000;
    opacity: 0.5; filter: alpha(opacity=50);
}

.imgareaselect-selection { }
#profile_table_id, #pic_upload_tbl{ }
#profile_table_id td{}
#pic_upload_tbl td{vertical-align:top }
#remove_logo_id{ text-align:right;  }
.profile_error{color:red;width:400px;}

</style>

<script type="text/javascript" src="js/jquery_002.js"></script> 


<form name="changeuserinfoform" id="changeuserinfoform" method="POST" action="" enctype="multipart/form-data">

<div class="ns_layout ns_two-thirds">
    <div class="ns_col-1"> 
        <div class="ns_pad" style="padding-left:50px;"> 
        <div id="msg"><strong><?php echo $msg; ?></strong></div>
            <h1>Edit Account Details</h1> 
            

            <table id="profile_table_id">
<tbody><tr>
	<td style="vertical-align: top; width: 115px;">
		<strong>Picture or Logo</strong> 
        <div class="txt-rgt">
        <a style="font-size: 12px;" href="javascript:void(0)" title="remove" class="hide" id="pic_action_id"></a></div>
		<strong style="visibility:hidden;">PictureLorLogo</strong> 
	</td>
	<td width="16px">
	</td>
	<td style="vertical-align: top;">
        <table>
            <tbody><tr>
            <input type="hidden" name="usr_id" value="<?php echo $_SESSION['uid']; ?>"/>
                <td style="vertical-align: top; height: 300px;">
                <?php if($row->usr_image == ''){ ?>
                    <img id="unknow_img_id" class="" style="border: 1px solid rgb(204, 204, 204);" src="images/unknown_002.png" width="280px" height="280px"/>
                <?php } else { ?>
                    <img id="unknow_img_id" class="" style="border: 1px solid rgb(204, 204, 204);" src="images/users/<?php echo $row->usr_image; ?>" width="280px" height="280px"/>
                <?php } ?>
                    <div id="facebook_profile_pic_id" class="hide" style="border: 1px solid rgb(204, 204, 204); text-align: center; width: 280px; height: 280px; overflow: hidden;">
                        <div style="cursor: url(&quot;../images/openhand.cur&quot;), default;" id="profile_img_cnter_id">
                            <img id="profile_img_id" title="Drag image to adjust">
                        </div>
                    </div>
                    <div class="hide txt-cnt" style="font-size:12px" id="drag_img_hint_text_id">Drag image to adjust</div>
                   
                </td>
                <td style="vertical-align: bottom;">
                    <a title="" id="switch_logo_btn_id" class="ns_btn-small hide" href="javascript:void(0)"><span class="ns_facebook">Import Picture</span></a>
                    <br>
                    <br>
                    <input size="1" id="usr_image" name="usr_image" type="file">
                    <br>
                    <small id="small_txt_id">(maximum 500kb)</small>
                    <div style="font-size:12px">&nbsp;</div>
                </td>
            </tr>
        </tbody></table>
	</td>
</tr>
<tr>
	<td>
		<strong>First Name: *</strong> 
	</td>
	<td width="16px">
	</td>
	<td>
		<input style="width: 380px;" class="gaf_textbox" name="usr_fname" id="usr_fname" type="text" value="<?php echo $row->usr_fname; ?>"/>
		<div class="profile_error" id="firstname_error_id"></div>
	</td>
</tr>
<tr>
	<td><strong>Last Name: *</strong></td>
	<td></td>
	<td>
		<input style="width: 380px;" class="gaf_textbox" name="usr_lname" id="usr_lname" type="text" value="<?php echo $row->usr_lname; ?>"/>
		<div class="profile_error" id="lastname_error_id"></div>
	</td>
</tr>
<tr>
	<td><strong>Address: *</strong></td>
	<td></td>
	<td>
		<input style="width: 380px;" class="gaf_textbox" name="usr_address" id="usr_address" type="text" value="<?php echo $row->usr_address; ?>"/>
		<div class="profile_error" id="address1_error_id"></div>
	</td>
</tr>
<tr>
	<td><strong>Country: *</strong></td>
	<td></td>
	<td style="height: 50px;">
    <?php
		$sql_cn="select * from country where cn_status=1 order by cn_name";
		$res_cn=mysql_query($sql_cn);
	?>
		<select name="cn_id" style="width:390px" class="" id="cn_id" onChange="showCity(this.value)"> 
			<option value="0">(Please select country)</option> 
			<?php	while($row_cn=mysql_fetch_object($res_cn)){	?>
			 <option value="<?php echo $row_cn->cn_id; ?>" <?php if($row_cn->cn_id == $cn_id){ ?> selected="selected" <?php } else if($row_cn->cn_id == $row->cn_id){ ?> selected="selected" <?php } ?>><?php echo ucfirst($row_cn->cn_name); ?></option>
             <?php } ?>
		</select>
		<div class="profile_error" id="country_error_id"></div>
	</td>
</tr>
<tr>
	<td><strong>City: *</strong></td>
	<td></td>
	<td> 
    <?php
	if($cn_id != ''){
		$sql_ct="select * from city where ct_cn_id='".$cn_id."' order by ct_name";
	}
	else{
		$sql_ct="select * from city where ct_cn_id='".$row->cn_id."' order by ct_name";
	}
		$res_ct=mysql_query($sql_ct);
	?>
		<select name="usr_ct_id" style="width:390px" class="" id="usr_ct_id"> 
			<option value="0">(Please select city)</option>
			<?php	while($row_ct=mysql_fetch_object($res_ct)){	?>
			 <option value="<?php echo $row_ct->ct_id; ?>" <?php if($row_ct->ct_id == $usr_ct_id){ ?> selected="selected" <?php } else if($row_ct->ct_id == $row->usr_ct_id){ ?> selected="selected" <?php } ?>><?php echo ucfirst($row_ct->ct_name); ?></option>
             <?php } ?>
		</select>
		<div class="profile_error" id="city_error_id"></div>
	</td>
</tr>
<tr>
	<td><strong>State: *</strong></td>
	<td>
	</td>
	<td><input style="width: 380px;" name="usr_state" id="usr_state" class="gaf_textbox" type="text" value="<?php echo $row->usr_state; ?>"/>
		<div class="profile_error" id="state_code_error_id"></div>
	</td>
</tr>

<tr>
	<td><strong>Postal code: *</strong></td>
	<td>
	</td>
	<td><input style="width: 380px;" name="usr_postalcode" id="usr_postalcode" class="gaf_textbox" type="text" value="<?php echo $row->usr_postalcode; ?>"/>
		<div class="profile_error" id="zip_error_id"></div>
	</td>
</tr>
<tr>
	<td><strong>Phone: *</strong></td>
	<td>
	</td>
	<td><input style="width: 380px;" class="gaf_textbox" id="usr_phone" name="usr_phone" type="text" value="<?php echo $row->usr_phone; ?>"/>
    <br>
	<div id="phone-err" style="display:none;color:red;">Incorrect format of phone</div>
    </td>
</tr>

</tbody></table>

            <br>
            <input type="hidden" name="submit_id" value="1"/>
            <a href="javascript:void(0)" id="submit" class="ns_btn ns_blue">Save</a>
<!--            <input type="submit" name="submit_id" id="submit_id" class="ns_btn ns_blue" value="Save"/>-->
           
           
        </div> 
    </div> 
    
</div> 


</form>

</div> 

	</div>
	<div class="ns_clear"></div>

	<?php include "includes/footer.php"; ?>

<script type="text/javascript" src="js/conversion.js">
</script><img src="images/a.gif" border="0" width="1" height="1">

	<div class="ns_clear"></div>

</div>

</body>
</html>