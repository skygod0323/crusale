<?php
ob_start();
session_start();
include "common.php";

if(isset($_GET['u']))
{
	$usr_id=$_GET['u'];
	$sql="select * from user where md5(usr_id)='".$usr_id."'";
	$_SESSION['last_page']="profile.php?u=".$usr_id;
}
else if($_SESSION['uid']!='')
{
	$usr_id=$_SESSION['uid'];
	$sql="select * from user where usr_id='".$usr_id."'";	
	$_SESSION['last_page']="profile.php";
}
else
{
	header("Location:login.php");
}

$res=mysql_query($sql);
$row=mysql_fetch_object($res);


if(isset($_SESSION['msg'])){	$msg=$_SESSION['msg'];	unset($_SESSION['msg']);	}else{  $msg="";    }
if(isset($_SESSION['up_title'])){ 	$up_title=$_SESSION['up_title'];	unset($_SESSION['up_title']); }else{ $up_title=""; }
if(isset($_SESSION['up_description'])){	$up_description=$_SESSION['up_description'];	unset($_SESSION['up_description']); }else{ $up_description=""; }


class addUserPortfolio{

	var $msg;
	var $up_usr_id;
	var $up_title;
	var $up_description;
	var $skills;
	
	
	function __construct( $up_usr_id, $up_title, $up_description, $skills)
	{
		$this->up_usr_id=$up_usr_id;
		$this->up_title=$up_title;
		$this->up_description=$up_description;
		$this->skills=$skills;
		
		$_SESSION['up_title']=$this->up_title;
		$_SESSION['up_description']=$this->up_description;
	}

	function valid()
	{
	include "language.php";
      $valid=true;
		
		//$ext = substr($this->up_file, strpos($this->up_file,'.'), strlen($this->up_file)-1);

		if($this->up_title == "")
		{
			$this->msg= '<font color="#CC0000">'.$lang[730].'</font>';
			$valid=false;
		}
		else if($this->up_description == "")
		{
			$this->msg= '<font color="#CC0000">'.$lang[731].'</font>';
			$valid=false;
		}
		else if($this->up_file != "")
		{
			$ext = substr($this->up_file, strpos($this->up_file,'.'), strlen($this->up_file)-1);
			if($ext =='jpg' || $ext =='gif' || $ext =='png' || $ext =='jpeg')
			{
//				$this->msg= '<font color="#CC0000">Please enter project details.</font>';
				$valid=true;
			}
			else
			{
				$this->msg= '<font color="#CC0000">'.$lang[385].'</font>';
				$valid=false;
			}
		}
		
		return $valid;
	}
	
	function add()
	{	
            include "language.php";
		if($_FILES["up_file"]["name"] != "")
		{
			if ($_FILES["up_file"]["error"] > 0)
			{
				$msg = "Return Code: " . $_FILES["up_file"]["error"] . "<br />";
			}
			else
			{
				$this->up_file='pfolio'.rand(0,9999).trim(addslashes($_FILES['up_file']['name']));	
				
				$ds = move_uploaded_file($_FILES["up_file"]["tmp_name"], "images/users/portfolio/".$this->up_file) or die('error');
				
				$sql="insert into user_portfolio
					set	
						up_usr_id ='".$this->up_usr_id."',
						up_title ='".$this->up_title."',
						up_description ='".$this->up_description."',								
						up_file ='".$this->up_file."',
						up_skills='".$this->skills."'";
			
				mysql_query($sql) or die(mysql_error());
															
				$this->msg='<font color="#009900">'.$lang[386].'</font>';	
				
				unset($_SESSION['up_title']);
				unset($_SESSION['up_description']);
			}
		}
		else
		{
			$sql="insert into user_portfolio
					set	
						up_usr_id ='".$this->up_usr_id."',
						up_title ='".$this->up_title."',
						up_description ='".$this->up_description."',								
						up_skills='".$this->skills."'";
			
			mysql_query($sql) or die(mysql_error());
						
															
			$this->msg='<font color="#009900">'.$lang[386].'</font>';	
				
			unset($_SESSION['up_title']);
			unset($_SESSION['up_description']);
			
		}
	}	
}

if(isset($_POST['addPortfolio']))
{
    
	$skills="";
	foreach($_POST['up_skills'] as $val)
	{
		$skills.=$val.",";
	}

	$adn=new addUserPortfolio( addslashes(trim($_POST['up_usr_id'])), addslashes(trim($_POST['up_title'])), addslashes(trim($_POST['up_description'])), $skills, trim($_FILES['up_file']['name']));

	if($adn->valid()){	
		$adn->add();		
	}
	//echo $ecms->msg;
	$_SESSION['msg']=$adn->msg;
	header("Location:profile.php");
}


if(isset($_POST['updatePortfolio']))
{
	$skills="";
	foreach($_POST['up_skills_upd'] as $val)
	{
		$skills.=$val.",";
	}
	$up_id=addslashes(trim($_POST['up_id']));
	$up_title=addslashes(trim($_POST['up_title_upd']));
	$up_description=addslashes(trim($_POST['up_description_upd']));

	if($_FILES["up_file_upd"]["name"] != "")
	{
		if ($_FILES["up_file_upd"]["error"] > 0)
		{
			$msg = "Return Code: " . $_FILES["up_file_upd"]["error"] . "<br />";
		}
		else
		{
			$sqlImg="select * from user_portfolio where up_id = '".$up_id."'";
			$resImg=mysql_query($sqlImg);
			$rowImg=mysql_fetch_object($resImg);
				
			$pathB="images/users/portfolio/".$rowImg->up_file;
	
			if(is_file($pathB))
			{
				unlink($pathB);
			}
			
			
			$up_file='pfolio'.rand(0,9999).trim(addslashes($_FILES['up_file_upd']['name']));
			
			$ds = move_uploaded_file($_FILES["up_file_upd"]["tmp_name"], "images/users/portfolio/".$up_file) or die('error');
			
			$sql="update user_portfolio
				set	
					up_title ='".$up_title."',
					up_description ='".$up_description."',								
					up_file ='".$up_file."',
					up_skills='".$skills."'
				where
					up_id = '".$up_id."'";
			mysql_query($sql) or die(mysql_error());
															
			$msg='<font color="#009900">'.$lang[621].'</font>';	
		
		}
	}
	else
	{
		$sql="update user_portfolio
				set	
					up_title ='".$up_title."',
					up_description ='".$up_description."',								
					up_skills='".$skills."'
				where
					up_id = '".$up_id."'";
            
		mysql_query($sql) or die(mysql_error());
														
		$msg='<font color="#009900">'.$lang[621].'</font>';	
	
	}
	header("location:profile.php");

}

if(isset($_POST['save_skill']))
{
	$i=0;
	$skills=array();
	foreach ($_POST as $value)
	{
		$skills[$i]=$value;
		$i++;
	}
	mysql_query("delete from user_skills where usk_usr_id='".$_SESSION['uid']."'");
	for($j=0;$j<($i-1);$j++)
	{
		
		$sql_usk="insert into user_skills 
			set 
				usk_usr_id ='".$_SESSION['uid']."',
				usk_sk_id ='".$skills[$j]."'";
		
		mysql_query($sql_usk);
	}

}
?>

<script type="text/javascript">
$( document ).ready(function() {
	showRS();
	showPF();
});
function showFreelancerOverview()
{
	////$.noConflict();
	$('.buyer').hide();
	$('.seller').show();
	
	$("#showFreelancerOverview").addClass("ns_selected");
	$("#showEmployerOverview").removeClass("ns_selected");
      
      $('#freel_reputation').css({"display":"block"});
      $('#empl_reputation').css({"display":"none"}); 
	  show_FreelancerOverviewDetails();
//	showFreelancerCompletedWork();
}
function showEmployerOverview()
{
	////$.noConflict();
	$('.buyer').show();
	$('.seller').hide();
	
	$("#showEmployerOverview").addClass("ns_selected");
	$("#showFreelancerOverview").removeClass("ns_selected");
      
      $('#freel_reputation').css({"display":"none"});
      $('#empl_reputation').css({"display":"block"});
	  show_EmployerOverviewDetails();
//	showEmployerCompletedWork();
}

function show_FreelancerOverviewDetails()
{
    //$.noConflict();
    $('#freelancer_overview_details').css({"display":"block"});
    $('#employer_overview_details').css({"display":"none"});
    
    $('#showFreelancerOverviewDet').addClass("ns_selected");
    $('#showEmployerOverviewDet').removeClass("ns_selected");
    
}
function show_EmployerOverviewDetails()
{
    //$.noConflict();

    $('#freelancer_overview_details').css({"display":"none"});
    $('#employer_overview_details').css({"display":"block"});
    
    $('#showFreelancerOverviewDet').removeClass("ns_selected");
    $('#showEmployerOverviewDet').addClass("ns_selected");
    
}
function showAddHourlyForm()
{
	if($('#add_hourly_form').css('display')=='none'){		$('#add_hourly_form').css({"display":"block"});		}
	else{		$('#add_hourly_form').css({"display":"none"});		}	
}
function saveHourlyRate()
{
	////$.noConflict();
	
	var hourlyRate = $("#input_hourly_rate").val();
	
	if(hourlyRate == '' || hourlyRate == ' ' || hourlyRate == '0')
	{
		alert('<?php echo $lang[622]; ?>');	
	}
	else
	{
		$('#ajaxloader').css({"display":"block"});
		$.get("ajax-file/updateHourlyRate.php", {hourlyRate:hourlyRate}, function(data){	
            $('#hrRate').text(data);
			$('#add_hourly_form').css({"display":"none"});
		});
		$('#ajaxloader').css({"display":"none"});
	}
	
}
function cancelHourlyRate()
{
	$('#add_hourly_form').css({"display":"none"});
}
function changeProfilePic()
{
	window.location.href="changeuserinfo.php";
}
function editUsername()
{
	$('#username_span').css({"display":"none"});
	$('#edit_username_div').css({"display":"block"});	
}
function saveUserName()
{
	var uname = $("#usr_name").val();
	
	if(uname != '')
	{
		$.get("ajax-file/updUsername.php", {usr_name:uname}, function(data){	
			$('#username_txt').html(data);
			$("#usr_name").text(data);

			$('#usr_edt_frm').css({"display":"none"});
			$('#edit_username_div > .editableform-loading').css({"display":"block"});
			setTimeout(function(){
				$('#username_span').css({"display":"block"});
				$('#disp_username').html(data);
				$('#usr_edt_frm').css({"display":"block"});
				$('#edit_username_div > .editableform-loading').css({"display":"none"});
				$('#edit_username_div').css({"display":"none"});
			
			},800);
	
		});
	}
	else
	{
		$("#usr_name").focus();
	}
	
	/*$('#edit_displayname_div').hide();
	$('#display_name_id').parent().show();	*/
}
function closeEditUser_div()
{
	$('#username_span').css({"display":"block"});
	$('#edit_username_div').css({"display":"none"});
}
function editUserSummary()
{
	$('#summary_span').css({"display":"none"});
	$('#edit_summary_div').css({"display":"block"});
}
function saveSummary()
{
	var summary = $("#usr_summary").val();
	
	if(summary != '')
	{
		$.get("ajax-file/updUsersummary.php", {usr_summary:summary}, function(data){	
			
			$('#summary_txt').html(data+' <a style="cursor:pointer;text-decoration:none;" onClick="editUserSummary()"><i class="icon-edit green bigger-120" style="vertical-align:middle;"></i></a>');	
			
        	$("#usr_summary").text(data);

			$('#usr_smry_edt_frm').css({"display":"none"});
			$('#edit_summary_div > .editableform-loading').css({"display":"block"});
			setTimeout(function(){
				$('#summary_span').css({"display":"block"});
				
				$('#usr_smry_edt_frm').css({"display":"block"});
				$('#edit_summary_div > .editableform-loading').css({"display":"none"});
				$('#edit_summary_div').css({"display":"none"});
			
			},800);
			
		});
	}
	else
	{
		$("#usr_summary").focus();
	}
}
function closeEditSummary_div()
{
	$('#summary_span').css({"display":"block"});
	$('#edit_summary_div').css({"display":"none"});
}

function showRS()
{
	show_resume('<?php  echo $usr_id; ?>');
}
function showPF()
{
	show_portfolio('<?php  echo $usr_id; ?>');
}
function show_resume(id)
{
	$.get("resume.php", {uid:id},	function(data){	$("#resume").html(data);	});
}
function show_portfolio(id)
{
	$.get("portfolio.php", {uid:id},	function(data){ $("#portfolio").html(data);	});
}

function delPortfolio(up_id)
{

	//bootbox.confirm("<?php echo $lang[726]; ?>", function(result) {
		if(confirm("<?php echo $lang[726]; ?>")) {
			$.get("ajax-file/delPortfolio.php", {up_id:up_id},function(data){ showPF(); });
		}
	//});
}
</script>
<?php	include "includes/header.php";	?>


		<<div class="section db" style="background-image:url('upload/parallax_02.jpg');">
                <div class="container">
                    <div class="page-title text-center">
                        <div class="heading-holder">
                            <h1>Profile</h1>
                        </div>
                        
                    </div>
                </div><!-- end container -->
            </div><!-- end section -->

            <div class="section lb">
                <div class="container">
                    <div class="row">
                        <div class="sidebar col-md-3">
                            <div class="post-padding clearfix">
                                <ul class="nav nav-pills nav-stacked">
									<li ><a href="changeuserinfo.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[124]; ?></a></li>
                                    <li ><a href="change-email.php"><span class="glyphicon glyphicon-user"></span>  <?php echo $lang[125]; ?></a></li>
                                    <li class="active"><a href="profile.php"><span class="glyphicon glyphicon-briefcase"></span>  <?php echo $lang[126]; ?></a></li>
                                    <li><a href="change-password.php"><span class="glyphicon glyphicon-briefcase"></span>  <?php echo $lang[127]; ?></a></li>
                                    <li><a href="membership.php"><span class="glyphicon glyphicon-refresh"></span>  <?php echo $lang[128]; ?></a></li>
                                </ul>
                            </div><!-- end widget -->
                        </div><!-- end col -->

                        <div class="content col-md-9">
                            <div class="post-padding">
                                <div class="job-title nocover hidden-sm hidden-xs"><h5><?php echo $lang[126]; ?></h5></div>
                                
                                    
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">   
                                            
                                            <div class="col-md-12 col-sm-12" style="border:1px solid #eee;border-radious:20px;padding:20px;">
												<div class="col-md-8 col-sm-12" style="border-right:1px solid #eee;">
													<p class="txt1"><?php echo $lang[460]; ?></p>
												<p><?php echo $lang[461]; ?></p>
												</div>
												<div class="col-md-4 col-sm-12">
													<p class="txt1"><?php echo $lang[337]; ?>&nbsp;<?php echo profileCompleteness($row->usr_id); ?>% <?php echo $lang[338]; ?></p>
													<!--<div><img src="images/account-setup-img.jpg" alt="" /></div>-->
														<div class="progress progress-striped active">
															<div class="progress-bar progress-bar-success" style="width: <?php echo profileCompleteness($row->usr_id); ?>%"></div>
														</div>
													   
												</div>
											</div>
											
                                            
                                        </div>
										<div class="col-md-12 col-sm-12">
											<div id="user-profile-2" class="user-profile">
												<div class="tabbable">
													<ul class="nav nav-tabs padding-18">
														<li class="active">
															<a data-toggle="tab" href="#overview">
																<i class="green icon-user bigger-120"></i>
																<?php echo $lang[707]; ?>
															</a>
														</li>

														<li>
															<a data-toggle="tab" href="#feed">
																<i class="blue icon-group bigger-120"></i>
																<?php echo $lang[520]; ?>
															</a>
														</li>
														<li>
															<a data-toggle="tab" href="#portfolio">
																<i class="pink icon-picture bigger-120"></i>
																<?php echo $lang[387];	?>
															</a>
														</li>
														<li>
															<a data-toggle="tab" href="#resume" onClick="showRS();">
																<i class="green icon-pencil bigger-120"></i>
																<?php echo $lang[469]; 	?>
															</a>
														</li>
														<li>
															<a data-toggle="tab" href="#skills">
																<i class="pink icon-beer bigger-120"></i>
																<?php echo $lang[395]; ?>
															</a>
														</li>
													</ul>

													<div class="tab-content no-border padding-24">
														<div id="overview" class="tab-pane in active"><?php include "overview_new.php"; ?></div><!-- #overview -->
														<div id="feed" class="tab-pane"><?php include "feedback.php";	?></div><!-- /#feed -->
														<div id="portfolio" class="tab-pane"><?php  /*include "portfolio.php";*/ ?>
														<!-- portfolio.php Start -->
														
														
														
														
														
<?php

$sql_pf="select * from user where md5(usr_id)='".$usr_id."' or usr_id='".$usr_id."'";
$res_pf=mysql_query($sql_pf);
$row=mysql_fetch_object($res_pf);

?>
<script language="javascript">
function show_add_portfolio()
{
	//$.noConflict();
	$('#add_portfolio').css({"display":"block"});	
	$('#portfolio_overview').css({"display":"none"});	
}
function hide_add_portfolio()
{
	//$.noConflict();
	$('#add_portfolio').css({"display":"none"});	
	$('#portfolio_overview').css({"display":"block"});	
}

/* $(document).ready(
	function(){		
		$('#savePortfolio').click(function(){	
			$('#addNew_portfolio').submit();		
		});        
	}); */
	 
	function mysubmit(){
			$('#addNew_portfolio').submit();
	}

function showPrFlDetail(up_id)
{
	//$.noConflict();
	$('#portfolio_details_'+up_id).css({"display":"block"});	
	$('#portfolio_overview').css({"display":"none"});	
	
}
function hidePrFlDetail(up_id)
{
	//$.noConflict();
	$('#portfolio_details_'+up_id).css({"display":"none"});	
	$('#portfolio_overview').css({"display":"block"});		
}
function editPortfolio(up_id)
{
	//$.noConflict();
	$('#edit_portfolio_'+up_id).css({"display":"block"});
	$('#portfolio_details_'+up_id).css({"display":"none"});
}
function hideeditPortfolio(up_id)
{
	//$.noConflict();
	$('#edit_portfolio_'+up_id).css({"display":"none"});
	$('#portfolio_details_'+up_id).css({"display":"block"});
}
function updatePortfolioSubmit(up_id)
{
	//$.noConflict();
	$('#update_portfolio_'+up_id).submit();
	$('#edit_portfolio_'+up_id).css({"display":"none"});
	$('#portfolio_details_'+up_id).css({"display":"block"});
}
function validPortfolio()
{
	var up_title= document.getElementById('up_title');
	var up_description=document.getElementById('up_description');
	var up_file=document.getElementById('up_file');
	
	var fileName = up_file.value;
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
	
	var msg="";
    var valid=true;
	alert(up_title.value);
	if(up_title.value=='')
	{
		alert('<?php echo $lang[730]; ?>');
        up_title.value="";
        up_title.focus();
        valid = false;
	}
	else if(up_description.value=='')
	{
		alert('<?php echo $lang[731]; ?>');
        up_description.value="";
        up_description.focus();
        valid = false;
	}
	else if(fileName != '' && (ext != "gif" && ext != "GIF" && ext != "JPEG" && ext != "jpeg" && ext != "jpg" && ext != "JPG" && ext != "png" && ext != "PNG"))
	{
		alert('<?php echo $lang[385]; ?>');
        up_file.value='';
        up_file.focus();
        valid = false;
	}
	else
    {		
        valid=true;
    }	

    return valid;
}
function validUpdatePortfolio()
{
	var up_title= document.getElementById('up_title_upd');
	var up_description=document.getElementById('up_description_upd');
	var up_file=document.getElementById('up_file_upd');
	
	var fileName = up_file.value;
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
	
	var msg="";
    var valid=true;
	if(up_title.value=='')
	{
		alert('<?php echo $lang[730]; ?>');
        up_title.value="";
        up_title.focus();
        valid = false;
	}
	else if(up_description.value=='')
	{
		alert('<?php echo $lang[731]; ?>');
        up_description.value="";
        up_description.focus();
        valid = false;
	}
	else if(fileName != '' && (ext != "gif" && ext != "GIF" && ext != "JPEG" && ext != "jpeg" && ext != "jpg" && ext != "JPG" && ext != "png" && ext != "PNG"))
	{
		alert('<?php echo $lang[385]; ?>');
        up_file.value='';
        up_file.focus();
        valid = false;
	}
	else
    {		
        valid=true;
    }	

    return valid;
}
//function upd()
//{
//document.getElementById("update_portfolio").submit();
//}
</script>

<?php
	$sql_tot_pfolio="select count(*) from user_portfolio where up_usr_id='".$row->usr_id."'";
	$res_tot_pfolio=mysql_query($sql_tot_pfolio);
	$row_tot_pfolio=mysql_fetch_array($res_tot_pfolio);
			
	$sql_avl_pfolio="select * from membership_plan where mp_id=(select usr_mp_id from user where usr_id='".$row->usr_id."')";
	$res_avl_pfolio=mysql_query($sql_avl_pfolio);
	$row_avl_pfolio=mysql_fetch_object($res_avl_pfolio);
?>
<hr class="invis">
<h4><?php echo $row->usr_name; ?>&nbsp;<?php echo $lang[387]; ?>
	<?php			
		if($row_avl_pfolio->mp_portfoliosize > $row_tot_pfolio[0] && ($_SESSION['uid']==$row->usr_id)){
	?>
   		<a href="javascript:show_add_portfolio()" style="cursor:pointer;text-decoration:none;">
           	<i class="fa fa-pencil" aria-hidden="true" ></i>
			<?php /*echo $lang[403];*/ ?>
        </a>
    <?php } ?></h4>

<hr class="invis">


<div class="grid_8 profile_content" id="add_portfolio" style="display:none">

<!--<link href="css/jquery-ui-1_002.css" rel="stylesheet" type="text/css">
<link href="css/jquery.css" rel="stylesheet" type="text/css">-->
		  
<form class="ns_form form-horizontal" id="addNew_portfolio" method="post" action="" enctype="multipart/form-data" onsubmit="return validPortfolio();">
<!--<h4><?php echo $lang[387]; ?></h4>-->
    
    
    
    
<!--<div class="ns_right ns_align-r">
		<div class="ns_bold">Added:</div>
		<div class="ns_largest"><span id="addedItemCount"></span>
					 /5</div>
			</div>-->
			<hr>
     		<div class="ns_form ns_box">
				
     			<h4 id="editTitle"  isfeature="N"><?php echo $lang[388]; ?></h4>
     			<div class="ns_clear"></div>
     			<!--<div class="ns_field ns_pad-none ns_margin-20 non-feature">
     				<label class="ns_pad-5">Content Type:</label>
     				<ul class="ns_field ns_inline">
     					<li><input name="content_type" id="content_new_pic" value="new_pic" checked="checked" type="radio"> Image</li>
     					<li><input name="content_type" id="content_new_article" value="new_article" type="radio"> Article</li>
     					<li><input name="content_type" id="content_new_code" value="new_code" type="radio"> Code</li>
     					<li><input name="content_type" id="content_new_vid" value="new_vid" type="radio"> Video</li>
						<li><input name="content_type" id="content_new_aud" value="new_aud" type="radio"> Audio</li>
						<li><input name="content_type" id="content_new_other" value="new_other" type="radio"> Others</li>
     				</ul>
     			</div>-->
     			<input type="hidden" name="up_usr_id" value="<?php echo $_SESSION['uid']; ?>"/>
				<label class=" control-label no-padding-right"><?php echo $lang[389]; ?></label>
     			<div class="ns_field  non-feature">
					
     				
					<input class="ns_full inline-error form-control" id="up_title" maxlength="60" type="text" name="up_title">
					<!--<div class="ns_note-right"><span id="title_count">60</span> <?php /*echo $lang[390];*/ ?></div>-->
     			</div>
     			<label id="descr_head"><?php echo $lang[391]; ?></label>
     			<div class="ns_field">
     				
					<textarea class="ns_full inline-error form-control" name="up_description" id="up_description" rows="10" maxlength="1000"></textarea>
					<!--<div class="ns_note-right"><span id="descr_count">1000</span> <?php /*echo $lang[390];*/ ?></div>-->
     			</div>
                
                <!--<div class="ace-file-input">
                	<input id="id-input-file-2" type="file">
                    <label class="file-label" data-title="Choose">
                    	<span class="file-name" data-title="No File ..."><i class="icon-upload-alt"></i></span>
                    </label>
                    <a class="remove" href="#"><i class="icon-remove"></i></a>
				</div>-->
     			<label id="uploadItemLable" class="ns_left"><?php echo $lang[392]; ?> <span id="uploadExtTxt"></span></label>
				<div class="ns_field ns_upload ns_margin-30">

     				
						<div class="ns_field ns_left " style="width:521px; margin-top:10px">
                            <div id="uploadContainer" class="">
                                <input id="up_file" name="up_file" type="file">
                                
                            </div>
                        </div>

     			</div>
     			<label class="ns_margin-10"><?php echo $lang[395]; ?></label>
				<div class="ns_field ns_upload ns_margin-30">
					
					<div>
		        		<!--<input class="input-skill ns_half ns_clear ns_border-bottom ns_round-none" name="skill" value="Enter a skill ..." type="text">-->
                        <?php
					$sql_skp="select * from skills where sk_id in(select usk_sk_id from user_skills where usk_usr_id='".$_SESSION['uid']."')";
					$res_skp=mysql_query($sql_skp);
				?>
                
					<select class="form-control" id="up_skills" name="up_skills[]" data-placeholder="<?php echo $lang[703]; ?>"  class="ns_half ns_clear ns_round-none" multiple="multiple">
                        <?php while($row_skp=mysql_fetch_object($res_skp)) { ?>
                        <option value="<?php echo $row_skp->sk_id; ?>"><?php echo $row_skp->sk_name; ?></option>
                        <?php } ?>
                        </select>
					</div>
					<div class="ns_col ns_last ns_half">
						<label class="ns_margin-10 inline-error" id="selectSkillsLabel"><?php /*echo $lang[396];*/ ?> <!--<span>(<?php /*echo $lang[397];*/ ?> <span id="jobsLeft" class="ns_color-red">5</span>)</span>--></label>
						<ul id="skills_selected" class="ns_skills-bubble">
						</ul>
					</div>
				</div>
				
<!--				<a id="saveBtn" href="../fake.php" class="ns_btn ns_blue ns_left">Save</a> <a href="#" class="ns_btn">Cancel</a>-->
				<!--<input type="submit" class="ns_btn ns_blue ns_left" value="Save" />-->
				<a id="savePortfolio" onClick="mysubmit();" class="btn btn-info btn-sm"><i class="icon-ok"></i><?php echo $lang[106]; ?></a> 
				<a id="cancelBtn" href="javascript:hide_add_portfolio()" class="btn btn-white"><?php echo $lang[398]; ?></a>
				<img id="portfolioSaveLoading" style="display: none; padding-left: 75px;" src="images/ajax-loader_002.gif">
     			
	    	</div>
            <input type="hidden" name="addPortfolio" value="1" >
			</form>
			
	</div>
    
    <div class="row">
    <?php
		$sql_pdet="select * from user_portfolio where up_usr_id='".$row->usr_id."'";
		$res_pdet=mysql_query($sql_pdet);
		while($row_pdet=mysql_fetch_object($res_pdet)) {
	?>
    <div class="col-xs-12 col-sm-6 widget-container-span ui-sortable">
		<div class="widget-box">
			<div class="widget-header widget-header-small header-color-orange">
			
            <?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row->usr_id)){ ?>
				<div class="widget-toolbar" style="background:#eee; border-radius: 5px 5px 0 0;">
					<span style="padding-left:10px;"><?php echo $row_pdet->up_title; ?></span>
              		<!--<a href="#" data-action="collapse">
						<i class="icon-chevron-up"></i>
					</a>-->
					<span style="padding-right:10px;float:right;">
					<a href="javascript:editPortfolio(<?php echo $row_pdet->up_id; ?>);">
						<i class="fa fa-pencil-square-o" aria-hidden="true" style="vertical-align:middle;"></i>
					</a>
					<a href="javascript:delPortfolio(<?php echo $row_pdet->up_id; ?>)" >
						<i class="fa fa-times" aria-hidden="true"></i>
					</a>
					</span>
				</div>
             <?php	}	?>
			</div>
			<div class="widget-body">
        	    <div class="widget-toolbox">
            	<?php	if($row_pdet->up_skills!='' && $row_pdet->up_skills!=','){	?>
					<div class="btn-toolbar" style="padding-left:10px;">
					<?php
						$cc=0;
						$sk_arr=explode(",",$row_pdet->up_skills);
						foreach($sk_arr as $sk_id)
    					{
							if($sk_id != '')
							{
								if($cc>0){	echo ", ";	}
								$sql_sk="select * from skills where sk_id='".$sk_id."'";
								$res_sk=mysql_query($sql_sk);
								$row_sk=mysql_fetch_object($res_sk);
								echo $row_sk->sk_name;
								$cc++;
							}
	    				}
					?>
					</div>
    			<?php	}	?>
				</div>
    	        <div style="display: block;" class="widget-body-inner">
					<div class="widget-main">
						<p class="alert alert-info">
                	        <?php if($row_pdet->up_file != ''){ ?>
							<img src="images/users/portfolio/<?php echo $row_pdet->up_file; ?>" width="80" height="79" />
							<?php } ?>
							<?php echo $row_pdet->up_description; ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
    
    
	<hr class="invis">
    <div class="grid_8 profile_content" id="edit_portfolio_<?php echo $row_pdet->up_id; ?>" style="display:none">

		<link href="css/jquery-ui-1_002.css" rel="stylesheet" type="text/css">
		<link href="css/jquery.css" rel="stylesheet" type="text/css">
	
		  
	<form class="ns_form" id="update_portfolio_<?php echo $row_pdet->up_id; ?>" method="post" action="" enctype="multipart/form-data" onsubmit="return validUpdatePortfolio()">
     		<br><br><br><br><br><br><hr>
			<!--<h1><?php echo $lang[387]; ?></h1>-->
<!--     		<div class="ns_right ns_align-r">
				<div class="ns_bold">Added:</div>
				<div class="ns_largest"><span id="addedItemCount"></span>
					 /5</div>
			</div>-->
     		<div class="ns_form ns_box">
     			<h4 id="editTitle" isfeature="N"><?php echo $lang[658]; ?></h4>
     			<div class="ns_clear"></div>
     			
     			<input type="hidden" id="up_id" name="up_id" value="<?php echo $row_pdet->up_id; ?>"/>
				<label><?php echo $lang[389]; ?></label>
     			<div class="ns_field  non-feature">
     				
					<input class="ns_full inline-error form-control" id="up_title_upd" maxlength="60" type="text" name="up_title_upd" value="<?php echo $row_pdet->up_title; ?>"/>
					<!--<div class="ns_note-right"><span id="title_count">60</span> <?php /*echo $lang[390];*/ ?></div>-->
     			</div>
     			<label id="descr_head"><?php echo $lang[391]; ?></label>
     			<div class="ns_field">
     				
					<textarea class="ns_full inline-error form-control" name="up_description_upd" id="up_description_upd" rows="10" maxlength="1000"><?php echo $row_pdet->up_description; ?></textarea>
					<!--<div class="ns_note-right"><span id="descr_count">1000</span> <?php /*echo $lang[390];*/ ?></div>-->
     			</div>
     			<label id="uploadItemLable" class="ns_left"><?php echo $lang[825]; ?> <span id="uploadExtTxt"></span></label>
                <?php if($row_pdet->up_file!=''){	?>
				<div class="ns_field ns_upload ns_dotted-bottom ns_margin-30">
                
					<div class="ns_field ns_left " style="width:521px; margin-top:10px">
                		<img src="images/users/portfolio/<?php echo $row_pdet->up_file; ?>" style="max-width:250px;"/>
                    </div>
                </div>
                <?php } ?>
				<label id="uploadItemLable" class="ns_left"><?php echo $lang[826]; ?> <span id="uploadExtTxt"></span></label>
				<div class="ns_field ns_upload ns_dotted-bottom ns_margin-30">
     				
						<div class="ns_field ns_left " style="width:521px; margin-top:10px">
                            <div id="uploadContainer" class="inline-error dropzone dropzone-ui" style="height:15px; width:103px">
                                <input id="up_file_upd" name="up_file_upd" type="file">
                                
                            </div>
                            <div id="files-bucket" class="files-bucket">

								<ul class="ns_added-items" id="added_items"></ul>
								
                            </div>
                        </div>
						

     				<div class="ns_clear"></div>
					

     			</div>
     			<label class="ns_margin-10"><?php echo $lang[395]; ?></label>
				<div class="ns_field ns_margin-30  non-feature">
					
                    <?php

					$skills=explode(",",substr($row_pdet->up_skills,0,strlen($row_pdet->up_skills)-1));
					
					?>
					<div class="ns_col">
                        <?php
						$sql_skp="select * from skills where sk_id in(select usk_sk_id from user_skills where usk_usr_id='".$_SESSION['uid']."')";
						$res_skp=mysql_query($sql_skp);
						?>
						<select id="up_skills_upd" name="up_skills_upd[]" size="10" class="form-control ns_half ns_clear ns_round-none" multiple="multiple">
                        <?php while($row_skp=mysql_fetch_object($res_skp)) { 
                        $sel=0;
                        	foreach($skills as $val){
								if($row_skp->sk_id == $val){
									$sel=1;
								}
							}
							?>
                        <option value="<?php echo $row_skp->sk_id; ?>" <?php if($sel==1){ ?> selected="selected"<?php } ?>><?php echo $row_skp->sk_name; ?></option>
                        <?php } ?>
                        </select>
					</div>
					
					
				</div>
				<a id="saveeditPortfolio" class="btn btn-info btn-sm" href="javascript:updatePortfolioSubmit(<?php echo $row_pdet->up_id; ?>)"><i class="icon-ok"></i><?php echo $lang[106]; ?></a> 
				<a id="cancelBtn" href="javascript:hideeditPortfolio(<?php echo $row_pdet->up_id; ?>)"  class="btn btn-white"><?php echo $lang[398]; ?></a>
				<img id="portfolioSaveLoading" style="display: none; padding-left: 75px;" src="images/ajax-loader_002.gif">
     			
	    	</div>
            <input type="hidden" name="updatePortfolio" value="1" >
			</form>
			
	</div>
    <?php } ?>
    </div>
    
    <div class="grid_8 profile_content " id="portfolio_overview" style="display:block">
            
			<div class="ns_clear"></div>
		
			
		<div id="limitWarningDiv" class="ns_notify ns_warning ns_edit" <?php	if($row_avl_pfolio->mp_portfoliosize==$row_tot_pfolio[0] && ($_SESSION['uid']==$row->usr_id)){	?>style="display:block"<?php	}else{	?>style="display:none"<?php	}	?>>
<!--	           	<a href="#" class="ns_close">x</a>-->
	            <div class="ns_icon"></div>
	            <div class="ns_pad">
					<h3><?php echo $lang[404]; ?></h3>
					<p><?php echo $lang[405]; ?></p> 	
					<p class="ns_block ns_margin-tops"><a href="membership.php" class="ns_right ns_margin-r"><?php echo $lang[406]; ?></a></p>
				</div>
		</div>
		
		
       
         	
	</div>
    
<script type="text/javascript">
jQuery(function($) {
	$('#id-input-file-1 , #id-input-file-2').ace_file_input({
		no_file:'No File ...',
		btn_choose:'Choose',
		btn_change:'Change',
		droppable:true,
		onchange:null,
		thumbnail:false //| true | large
		//whitelist:'gif|png|jpg|jpeg'
		//blacklist:'exe|php'
		//onchange:''
		//
	});
});
</script>
														
														
														
														
														
														
														
														
														<!-- portfolio.php End -->
														</div><!-- /#friends -->
														<div id="resume" class="tab-pane"><?php	/*include "resume.php";*/	?></div><!-- /#resume -->
														<div id="skills" class="tab-pane"><?php include "skills.php"; ?></div><!-- /#skills -->
													</div>
												</div>
											</div>
										</div>
                                    </div><!-- end row -->
                                    
                                
								
                            </div><!-- end post-padding -->
                        </div><!-- end col -->
                    </div><!-- end row -->  
                </div><!-- end container -->
            </div><!-- end section -->




        
        


		<!-- inline scripts related to this page -->

        <script type="text/javascript">
			jQuery(function($) {
				$('#id-disable-check').on('click', function() {
					var inp = $('#form-input-readonly').get(0);
					if(inp.hasAttribute('disabled')) {
						inp.setAttribute('readonly' , 'true');
						inp.removeAttribute('disabled');
						inp.value="This text field is readonly!";
					}
					else {
						inp.setAttribute('disabled' , 'disabled');
						inp.removeAttribute('readonly');
						inp.value="This text field is disabled!";
					}
				});
			
			
				$(".chosen-select").chosen(); 
				$('#chosen-multiple-style').on('click', function(e){
					var target = $(e.target).find('input[type=radio]');
					var which = parseInt(target.val());
					if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
					 else $('#form-field-select-4').removeClass('tag-input-style');
				});
			
			
				$('[data-rel=tooltip]').tooltip({container:'body'});
				$('[data-rel=popover]').popover({container:'body'});
				
				$('textarea[class*=autosize]').autosize({append: "\n"});
				$('textarea.limited').inputlimiter({
					remText: '%n character%s remaining...',
					limitText: 'max allowed : %n.'
				});
			
				$.mask.definitions['~']='[+-]';
				$('.input-mask-date').mask('99/99/9999');
				$('.input-mask-phone').mask('(999) 999-9999');
				$('.input-mask-eyescript').mask('~9.99 ~9.99 999');
				$(".input-mask-product").mask("a*-999-a999",{placeholder:" ",completed:function(){alert("You typed the following: "+this.val());}});
			
			
			
				$( "#input-size-slider" ).css('width','200px').slider({
					value:1,
					range: "min",
					min: 1,
					max: 8,
					step: 1,
					slide: function( event, ui ) {
						var sizing = ['', 'input-sm', 'input-lg', 'input-mini', 'input-small', 'input-medium', 'input-large', 'input-xlarge', 'input-xxlarge'];
						var val = parseInt(ui.value);
						$('#form-field-4').attr('class', sizing[val]).val('.'+sizing[val]);
					}
				});
			
				$( "#input-span-slider" ).slider({
					value:1,
					range: "min",
					min: 1,
					max: 12,
					step: 1,
					slide: function( event, ui ) {
						var val = parseInt(ui.value);
						$('#form-field-5').attr('class', 'col-xs-'+val).val('.col-xs-'+val);
					}
				});
				
				
				$( "#slider-range" ).css('height','200px').slider({
					orientation: "vertical",
					range: true,
					min: 0,
					max: 100,
					values: [ 17, 67 ],
					slide: function( event, ui ) {
						var val = ui.values[$(ui.handle).index()-1]+"";
			
						if(! ui.handle.firstChild ) {
							$(ui.handle).append("<div class='tooltip right in' style='display:none;left:16px;top:-6px;'><div class='tooltip-arrow'></div><div class='tooltip-inner'></div></div>");
						}
						$(ui.handle.firstChild).show().children().eq(1).text(val);
					}
				}).find('a').on('blur', function(){
					$(this.firstChild).hide();
				});
				
				$( "#slider-range-max" ).slider({
					range: "max",
					min: 1,
					max: 10,
					value: 2
				});
				
				$( "#eq > span" ).css({width:'90%', 'float':'left', margin:'15px'}).each(function() {
					// read initial values from markup and remove that
					var value = parseInt( $( this ).text(), 10 );
					$( this ).empty().slider({
						value: value,
						range: "min",
						animate: true
						
					});
				});
			
				
				$('#id-input-file-1 , #id-input-file-2').ace_file_input({
					no_file:'No File ...',
					btn_choose:'Choose',
					btn_change:'Change',
					droppable:false,
					onchange:null,
					thumbnail:false //| true | large
					//whitelist:'gif|png|jpg|jpeg'
					//blacklist:'exe|php'
					//onchange:''
					//
				});
				
				$('#id-input-file-3').ace_file_input({
					style:'well',
					btn_choose:'Drop files here or click to choose',
					btn_change:null,
					no_icon:'icon-cloud-upload',
					droppable:true,
					thumbnail:'small'//large | fit
					//,icon_remove:null//set null, to hide remove/reset button
					/**,before_change:function(files, dropped) {
						//Check an example below
						//or examples/file-upload.html
						return true;
					}*/
					/**,before_remove : function() {
						return true;
					}*/
					,
					preview_error : function(filename, error_code) {
						//name of the file that failed
						//error_code values
						//1 = 'FILE_LOAD_FAILED',
						//2 = 'IMAGE_LOAD_FAILED',
						//3 = 'THUMBNAIL_FAILED'
						//alert(error_code);
					}
			
				}).on('change', function(){
					//alert('OK');
					//console.log($(this).data('ace_input_files'));
					//console.log($(this).data('ace_input_method'));
				});
			
				$('#spinner1').ace_spinner({value:0,min:0,max:200,step:10, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
				.on('change', function(){
					//alert(this.value)
				});
				$('#spinner2').ace_spinner({value:0,min:0,max:10000,step:100, touch_spinner: true, icon_up:'icon-caret-up', icon_down:'icon-caret-down'});
				$('#spinner3').ace_spinner({value:0,min:-100,max:100,step:10, on_sides: true, icon_up:'icon-plus smaller-75', icon_down:'icon-minus smaller-75', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
			
			
				
				$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				$('input[name=date-range-picker]').daterangepicker().prev().on(ace.click_event, function(){
					$(this).next().focus();
				});
				
				$('#timepicker1').timepicker({
					minuteStep: 1,
					showSeconds: true,
					showMeridian: false
				}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				
				$('#colorpicker1').colorpicker();
				$('#simple-colorpicker-1').ace_colorpicker();
			
				
				$(".knob").knob();
				
				
				//we could just set the data-provide="tag" of the element inside HTML, but IE8 fails!
				var tag_input = $('#form-field-tags');
				if(! ( /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase())) ) 
				{
					tag_input.tag(
					  {
						placeholder:tag_input.attr('placeholder'),
						//enable typeahead by specifying the source array
						source: ace.variable_US_STATES,//defined in ace.js >> ace.enable_search_ahead
					  }
					);
				}
				else {
					//display a textarea for old IE, because it doesn't support this plugin or another one I tried!
					tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
					//$('#form-field-tags').autosize({append: "\n"});
				}
				
				
				
			
				/////////
				$('#modal-form input[type=file]').ace_file_input({
					style:'well',
					btn_choose:'Drop files here or click to choose',
					btn_change:null,
					no_icon:'icon-cloud-upload',
					droppable:true,
					thumbnail:'large'
				})
				
				//chosen plugin inside a modal will have a zero width because the select element is originally hidden
				//and its width cannot be determined.
				//so we set the width after modal is show
				$('#modal-form').on('shown.bs.modal', function () {
					$(this).find('.chosen-container').each(function(){
						$(this).find('a:first-child').css('width' , '210px');
						$(this).find('.chosen-drop').css('width' , '210px');
						$(this).find('.chosen-search input').css('width' , '200px');
					});
				})
				/**
				//or you can activate the chosen plugin after modal is shown
				//this way select element becomes visible with dimensions and chosen works as expected
				$('#modal-form').on('shown', function () {
					$(this).find('.modal-chosen').chosen();
				})
				*/
			
			});
		</script>

		
<?php include "includes/footer.php"; ?>
