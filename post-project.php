<?php
ob_start();
session_start();
include "common.php";
$_SESSION['last_page']="post-project.php";
//if($_SESSION['uid']==''){	header("location:login.php");	}

if($_SESSION['uid']=='')
{
     $uid='';
/*    $uid=$_SESSION['temp_usr'];
    $_SESSION['temp_proj']="true";*/
}
else
{
    $uid=$_SESSION['uid'];
}
if(isset($_SESSION['msg'])){	$msg=$_SESSION['msg'];	unset($_SESSION['msg']);	}
if(isset($_SESSION['prj_name'])){ 	$prj_name=$_SESSION['prj_name'];	unset($_SESSION['prj_name']); }else{ $prj_name=""; }
if(isset($_SESSION['cat_id'])){	$cat_id=$_SESSION['cat_id'];	unset($_SESSION['cat_id']); }else{ $cat_id=""; }
if(isset($_SESSION['prj_scat_id'])){ 	$prj_scat_id=$_SESSION['prj_scat_id'];	unset($_SESSION['prj_scat_id']); }else{ $prj_scat_id=""; }
if(isset($_SESSION['prj_details'])){	$prj_details=$_SESSION['prj_details'];	unset($_SESSION['prj_details']); }else{ $prj_details=""; }

if(isset($_SESSION['pb_type'])){	$pb_type=$_SESSION['pb_type'];	unset($_SESSION['pb_type']); }else{ $pb_type=""; }
if(isset($_SESSION['pb_minprice'])){	$pb_minprice=$_SESSION['pb_minprice'];	unset($_SESSION['pb_minprice']); }else{ $pb_minprice=$lang[434]; }
if(isset($_SESSION['pb_maxprice'])){ 	$pb_maxprice=$_SESSION['pb_maxprice'];	unset($_SESSION['pb_maxprice']); }else{ $pb_maxprice=$lang[435]; }
if(isset($_SESSION['pb_rate'])){	$pb_rate=$_SESSION['pb_rate'];	unset($_SESSION['pb_rate']); }else{ $pb_rate=$lang[436]; }
if(isset($_SESSION['pb_duration'])){	$pb_duration=$_SESSION['pb_duration'];	unset($_SESSION['pb_duration']); }else{ $pb_duration=""; }

class addProduct{

	var $msg;
	var $prj_id;
	var $prj_usr_id;
	var $prj_name;
	var $cat_id;
	var $prj_scat_id;
	var $skills;
	var $prj_details;
	var $prj_file;
	var $pb_type;
	var $pb_minprice;
	var $pb_maxprice;
	var $pb_rate;
	var $pb_duration;
	var $total_pp;
	var $fl_name;
	
	
	function __construct( $prj_usr_id, $prj_name, $cat_id, $prj_scat_id, $skills, $prj_details, $prj_file, $pb_type, $pb_minprice, $pb_maxprice, $pb_rate, $pb_duration, $total_pp, $fl_name)
	{
		
		$this->prj_usr_id=$prj_usr_id;
		$this->prj_name=$prj_name;
		$this->cat_id=$cat_id;
		$this->prj_scat_id=$prj_scat_id;
		$this->skills=$skills;
		$this->prj_details=$prj_details;
		$this->prj_file=$prj_file;
		$this->pb_type=$pb_type;
		$this->pb_minprice=$pb_minprice;
		$this->pb_maxprice=$pb_maxprice;
		$this->pb_rate=$pb_rate;
		$this->pb_duration=$pb_duration;
		$this->total_pp=$total_pp;
		$this->fl_name=$fl_name;
		
		
        $_SESSION['prj_usr_id']=$this->prj_usr_id;
		$_SESSION['prj_name']=$this->prj_name;
		$_SESSION['cat_id']=$this->cat_id;
		$_SESSION['prj_scat_id']=$this->prj_scat_id;
        $_SESSION['skills']=$this->skills;
		$_SESSION['prj_details']=$this->prj_details;
		$_SESSION['pb_type']=$this->pb_type;
		$_SESSION['pb_minprice']=$this->pb_minprice;
		$_SESSION['pb_maxprice']=$this->pb_maxprice;
		$_SESSION['pb_rate']=$this->pb_rate;
		$_SESSION['pb_duration']=$this->pb_duration;

	}

	function valid()
	{
        include "language.php";
		$valid=true;
		//$ext = substr($this->prj_file, strpos($this->prj_file,'.'), strlen($this->prj_file)-1);

		if($this->prj_name == "" || $this->prj_name == $lang[412])
		{
			$this->msg= '<font color="#CC0000">'.$lang[383].'</font>';
			$valid=false;
		}
		else if($this->cat_id == "0")
		{
			$this->msg= '<font color="#CC0000">'.$lang[384].'</font>';
			$valid=false;
		}
		else if($this->prj_scat_id == "")
		{
			$this->msg= '<font color="#CC0000">'.$lang[413].'</font>';
			$valid=false;
		}
		else if($this->skills == "")
		{
			$this->msg= '<font color="#CC0000">'.$lang[414].'</font>';
			$valid=false;
		}
		else if($this->prj_details == "")
		{
			$this->msg= '<font color="#CC0000">'.$lang[415].'</font>';
			$valid=false;
		}
		else if($this->prj_file != "")
		{
			$ext = substr($this->prj_file, strpos($this->prj_file,'.'), strlen($this->prj_file)-1);
			if($ext =='doc' || $ext =='txt' || $ext =='docx' )
			{
//				$this->msg= '<font color="#CC0000">Please enter project details.</font>';
				$valid=true;
			}
			else
			{
				$this->msg= '<font color="#CC0000">'.$lang[416].'</font>';
				$valid=false;
			}
		}
		else if($this->pb_type=='fixed')
		{
			if($this->pb_minprice == "" || $this->pb_minprice == $lang[434])
			{
				$this->msg= '<font color="#CC0000">'.$lang[417].'</font>';
				$valid=false;
			}
                  else if(is_nan($this->pb_minprice))
                  {
                        $this->msg= '<font color="#CC0000">'.$lang[627].'</font>';
                        $valid=false;
                  }
			else if($this->pb_maxprice == "" || $this->pb_maxprice == $lang[435])
			{
				$this->msg= '<font color="#CC0000">'.$lang[418].'</font>';
				$valid=false;
			}
                  else if(is_nan($this->pb_maxprice))
                  {
                        $this->msg= '<font color="#CC0000">'.$lang[628].'</font>';
                        $valid=false;
                  }
                  else if($this->pb_maxprice <= $this->pb_minprice)
			{
				$this->msg= '<font color="#CC0000">'.$lang[674].'</font>';
				$valid=false;
			}
		}
		else if($this->pb_type=='hourly')
		{
			if($this->pb_rate == "")
			{
				$this->msg= '<font color="#CC0000">'.$lang[419].'</font>';
				$valid=false;
			}
            else if(is_nan($this->pb_rate))
            {
                $this->msg= '<font color="#CC0000">'.$lang[629].'</font>';
                $valid=false;
            }
		}
        else if($this->pb_duration == "")
		{
			$this->msg= '<font color="#CC0000">'.$lang[420].'</font>';
			$valid=false;
		}
        else if(is_nan($this->pb_duration))
        {
            $this->msg= '<font color="#CC0000">'.$lang[630].'</font>';
            $valid=false;
        }
		return $valid;
	}
	
	function add()
	{	
        include "language.php";
		if($_FILES["fl_name"]["name"] != "")
		{
		
			if ($_FILES["fl_name"]["error"] > 0)
			{
				$this->msg = "Return Code: " . $_FILES["fl_name"]["error"] . "<br />";
			}
			else
			{
				$this->fl_name='prj'.rand(0,9999).trim(addslashes($_FILES['fl_name']['name']));	
				$ds = move_uploaded_file($_FILES["fl_name"]["tmp_name"], "project_files/".$this->fl_name) or die('error');
				
				$sql="insert into temp_file_post
					set				
						fl_uid =".$_SESSION['uid'].",
						fl_filename ='".$this->fl_name."'";
							
				mysql_query($sql) or die(mysql_error());
			}
		}
		
		
		$validity=get_page_settings(6);
		
		$total=0;
		$j=-1;
		$pp=array();
		for($i=1; $i<=$this->total_pp; $i++)
		{
			if(isset($_POST['chkbx_pp_'.$i]))
			{
				$j++;
				$pp[$j]=$i;
				$total=$total+$_POST['pp_amount_'.$i];
			}
		}
		if($j>=0)
		{
			$_SESSION['pp']=$pp;
			$_SESSION['tot_pp_amt']=$total;
			$_SESSION['lst_prj']=$row_prj[0];
		}
	}	
}

if(isset($_POST['postproj']))
{
	$skills="";
	$w=0;
	foreach($_POST['prj_skills'] as $val)
	{
          if($w>0){ $skills.=",";   }
		$skills.=$val;
            $w++;
	}

	$adn=new addProduct( addslashes(trim($_POST['prj_usr_id'])), addslashes(trim($_POST['prj_name'])), addslashes(trim($_POST['cat_id'])), addslashes(trim($_POST['prj_scat_id'])), $skills, addslashes(trim($_POST['prj_details'])), trim($_FILES['prj_file']['name']), addslashes(trim($_POST['pb_type'])), addslashes(trim($_POST['pb_minprice'])), addslashes(trim($_POST['pb_maxprice'])), addslashes(trim($_POST['pb_rate'])), addslashes(trim($_POST['pb_duration'])), addslashes(trim($_POST['total_pp'])), trim($_FILES['fl_name']['name']));

	if($adn->valid())
	{
		$adn->add();		
		$_SESSION['msg']=$adn->msg;
//		header("location:post-project-res.php?p=".$adn->prj_id);
        header("location:post-project-confirmation.php");
	}
	else
	{
		$_SESSION['msg']=$adn->msg;
		header("location:post-project.php");
	}
	
}

?>
<?php include "includes/header.php"; ?>
<script language="javascript">
function showSubcat(str)
{
	$.get("showSubcat.php", {q:str},function(data){	$('#prj_scat_id').html(data);	 });
	$('#scat').show();
}

function showhide(str)
{
	if(str=='hourly')
	{
		$('#hbud').show();
		$('#pdur').show();
		$('#fbud').hide();
	}
	else
	{	
		$('#hbud').hide();	
		$('#pdur').hide();
		$('#fbud').show();
	}
}
function validProjectPost()
{
    var prj_name = document.getElementById('prj_name');
    var cat_id = document.getElementById('cat_id');
    var prj_scat_id = document.getElementById('prj_scat_id');
    var prj_skills = document.getElementById('prj_skills');
    var prj_details = document.getElementById('prj_details');
   // var pb_type = document.getElementById('pb_type');
    
    var pb_minprice = document.getElementById('pb_minprice');
    var pb_maxprice = document.getElementById('pb_maxprice');
    
    var pb_rate = document.getElementById('pb_rate');
    var pb_duration = document.getElementById('pb_duration');
    
    var msg="";
    var valid=true;
    
    if (prj_name.value == "" || prj_name.value == null || prj_name.value=="<?php echo $lang[412]; ?>")
    {
        msg="<?php echo $lang[383]; ?>";
        prj_name.value="";
        prj_name.focus();
        valid = false;
    }
    else if(cat_id.value == '0')
    {
        msg="<?php echo $lang[384]; ?>";
        cat_id.focus();
        valid=false;
    }
    else if(prj_scat_id.value == '0' || prj_scat_id.value == "" || prj_scat_id.value == null)
    {
        msg="<?php echo $lang[413]; ?>";
        prj_scat_id.focus();
        valid=false;
    }
    else if(prj_skills.value == "" || prj_skills.value == null)
    {
        msg="<?php echo $lang[414]; ?>";
        prj_skills.focus();
        valid=false;
    }
    else if(prj_details.value == "" || prj_details.value == null)
    {
        msg="<?php echo $lang[415]; ?>";
        valid=false;
    }
    else if($('#fixedBudgetPeriod_option').is(':checked'))
    {
        if(pb_minprice.value == "" || pb_minprice.value == null || pb_minprice.value == "<?php echo $lang[434]; ?>")
        {
            msg= "<?php echo $lang[417]; ?>";
            pb_minprice.focus();
		valid=false;
        }
        else if(isNaN(pb_minprice.value))
        {
            msg= "<?php echo $lang[627]; ?>";
            pb_minprice.value='';
            pb_minprice.focus();
		valid=false;
        }
        else if(pb_maxprice.value == "" || pb_maxprice.value == null || pb_maxprice.value == "<?php echo $lang[435]; ?>")
        {
            msg= "<?php echo $lang[418]; ?>";
            pb_maxprice.focus();
		valid=false;
        }
        else if(isNaN(pb_maxprice.value))
        {
            msg= "<?php echo $lang[628]; ?>";
            pb_maxprice.value='';
            pb_maxprice.focus();
		valid=false;
        }
        else if(parseFloat(pb_maxprice.value) <= parseFloat(pb_minprice.value))
        {
            msg= "<?php echo $lang[674]; ?>";
            pb_maxprice.value='';
            pb_maxprice.focus();
		valid=false;
        }
    }
    else if($('#hourlyBudgetPeriod_option').is(':checked'))
    {
        if(pb_rate.value == "" || pb_rate.value =="<?php echo $lang[436]; ?>")
        {
            msg= "<?php echo $lang[419]; ?>";
            pb_rate.focus();
            valid=false;
        }
        else if(isNaN(pb_rate.value))
        {
            msg= "<?php echo $lang[629]; ?>";
            pb_rate.value='';
            pb_rate.focus();
		valid=false;
        }
    }
    else if(pb_duration.value == "" || pb_duration.value == null)
    {
        msg= "<?php echo $lang[420]; ?>";
        pb_duration.focus();
        valid=false;
    }
    else if(pb_duration.value!='' && isNaN(pb_duration.value))
    {
        msg= "<?php echo $lang[630]; ?>";
        pb_duration.value='';
        pb_duration.focus();
        valid=false;
    }
    else
    {		
        valid=true;
    }	
	
    if(!valid)
    {
        document.getElementById("msg").style.color = "red";
        document.getElementById('msg').innerHTML = msg;			 				
    }
    return valid;
}
</script>

            <<div class="section db" style="background-image:url('upload/parallax_02.jpg');">
                <div class="container">
                    <div class="page-title text-center">
                        <div class="heading-holder">
                            <h1><?php echo $lang[422]; ?></h1>
                        </div>
                        <p class="lead"><?php echo $lang[423]; ?></p>
                    </div>
                </div><!-- end container -->
            </div><!-- end section -->

            <div class="section lb">
                <div class="container">
                    <div class="row">
                        <div class="content col-md-8">
							<form id="createform" name="createform" action="" method="post" enctype="multipart/form-data" class="form-horizontal" onSubmit="return validProjectPost()">
							<input type="hidden" name="prj_usr_id" id="prj_usr_id" value="<?php echo $uid; ?>"/>
                            <div class="post-padding">
                                <div class="job-title hidden-sm hidden-xs"><h5>Select List</h5></div>
								
								<?php
										$sql_pp="select * from project_promotion where pp_status='1' order by pp_id";
										$res_pp=mysql_query($sql_pp);
										$pp=0;
										while($row_pp=mysql_fetch_object($res_pp)){
											?>
                                <div class="job-tab submitform">
                                    <div class="row">
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <h3><?php echo stripslashes(strtoupper($row_pp->pp_name)); ?></h3>
                                            <small><?php echo $row_pp->pp_dispText; ?></small>
                                        </div><!-- end col -->

                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="job-meta text-center">
                                                <h4><?php echo getCurrencySymbol(); ?>&nbsp;<?php echo number_format($row_pp->pp_amount,2); ?></h4>
												<input class="btn btn-primary btn-sm btn-block" type="checkbox" id="nonpublic" name="chkbx_pp_<?php echo $row_pp->pp_id; ?>"/>
                                                
                                            </div>
                                        </div><!-- end col -->
                                    </div><!-- end row -->
                                </div><!-- end job-tab -->
								<hr>
								<?php 
								$pp++; } ?>
                                <input type="hidden" name="total_pp" id="total_pp" value="<?php echo $pp; ?>"/>
								
                            </div><!-- end post-padding -->
                            <div class="prj-detail-form-margin_1"><div id="msg"><?php echo $msg; ?></div></div>
                            <div class="post-padding">
                                <div class="job-title hidden-sm hidden-xs"><h5>Job Details</h5></div>
                                
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <label class="control-label"><?php echo $lang[424]; ?> </label>
                                            <input type="text" id="prj_name" name="prj_name" onBlur="if(this.value=='') this.value='<?php echo $lang[412]; ?>'" onFocus="if(this.value =='<?php echo $lang[412]; ?>' ) this.value=''" <?php if($prj_name != '') { ?>value="<?php echo $prj_name; ?>" <?php } else { ?> value="<?php echo $lang[412]; ?>" <?php } ?> class="form-control" />
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <label class="control-label"><?php echo $lang[425]; ?> </label>
                                            <?php
												$sql_cat="select * from category where cat_status=1 order by cat_name";
												$res_cat=mysql_query($sql_cat);
											?>
											<select id="cat_id" name="cat_id" onChange="showSubcat(this.value)" class="form-control">
												<option value="0"><?php echo $lang[426]; ?></option>
												<?php while($row_cat=mysql_fetch_object($res_cat)) { ?>
												<option value="<?php echo $row_cat->cat_id; ?>" <?php if($row_cat->cat_id == $cat_id){ ?> selected="selected"<?php } ?>><?php echo ucfirst($row_cat->cat_name); ?></option>
												<?php } ?>
											</select>
                                        </div>
                                    </div><!-- end row -->

                                    <hr class="invis">

									<div class="form-group" id="scat" style="display:none;">
										<label class="col-sm-4 control-label no-padding-right"></label>
										<div class="col-sm-6">
											<select class="form-control" id="prj_scat_id" name="prj_scat_id" class="form-control">
												<option value="0"><?php echo $lang[427]; ?></option>
											</select>
										</div>
									</div>
									
									<hr class="invis">

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <label class="control-label"><?php echo $lang[428]; ?></label>
											<?php
												$sql_sk="select * from skills,category where sk_cat_id=cat_id and sk_status='1' and cat_status='1'";
												$res_sk=mysql_query($sql_sk);
											?>
											<br>
                                            <select class="form-control" multiple="" class="chosen-select" id="prj_skills" name="prj_skills[]" data-placeholder="<?php echo $lang[703]; ?>" style="direction:ltr;text-align:left;">
												<?php while($row_sk=mysql_fetch_object($res_sk)) { ?>
												<option value="<?php echo $row_sk->sk_id; ?>"><?php echo $row_sk->sk_name; ?></option>                         
												<?php } ?>
											</select>
                                        </div>
                                    </div><!-- end row -->
									
									<hr class="invis">

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <label class="control-label"><?php echo $lang[429]; ?></label>
                                            <textarea id="prj_details" name="prj_details" class="form-control"><?php echo $prj_details; ?></textarea>
                                        </div>
                                    </div><!-- end row -->
									
                                    <hr class="invis">

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <label class="control-label">Upload Files</label>
											<input type="file" id="id-input-file-3" name="fl_name" class="fileupload-new" value="Select Files">
                                               
                                        </div>
                                    </div><!-- end row -->
									
									<hr class="invis">
									
									<div class="row">
										<div class="col-md-12 col-sm-12">
											<label class="control-label" style="margin-right:10px;"><?php echo $lang[430]; ?></label>
														<input id="fixedBudgetPeriod_option" name="pb_type" value="fixed"  type="radio" onChange="showhide(this.value)" class="ace" checked="checked" />
														<span class="lbl" style="width:150px;"><?php echo $lang[431]; ?></span>
													
														<input id="hourlyBudgetPeriod_option" name="pb_type" value="hourly" type="radio" <?php if($pb_type=='hourly'){ ?>checked="checked"<?php } ?> onChange="showhide(this.value)" class="ace" />
														<span class="lbl" style="width:150px;"> <?php echo $lang[432]; ?></span>
										</div>
									</div>

                                    <hr class="invis">
									

									<div class="row">
										<div class="col-md-4 col-sm-12">
											<label class="control-label"><?php echo $lang[433]; ?>(<?php echo getCurrencyCode(); ?>)</label>
										</div>
										<div id="fbud" class="col-md-8 col-sm-12" <?php if($pb_type=='hourly'){ ?>style="display:none;"<?php }?> >
											<div class="col-md-4 col-sm-12">
											<input type="text" id="pb_minprice" name="pb_minprice" onBlur="if(this.value == '') { this.value='<?php echo $lang[434]; ?>'}" onFocus="if (this.value == '<?php echo $lang[434]; ?>') {this.value=''}" value="<?php echo $pb_minprice; ?>" class="form-control"/> 
											</div>
											<div class="col-md-4 col-sm-12">
											<input type="text" id="pb_maxprice" name="pb_maxprice" onBlur="if(this.value == '') { this.value='<?php echo $lang[435]; ?>'}" onFocus="if (this.value == '<?php echo $lang[435]; ?>') {this.value=''}" value="<?php echo $pb_maxprice; ?>" class="form-control"/>
											</div>
										</div>
										<div id="hbud" class="col-md-4 col-sm-12" <?php if($pb_type=='hourly'){ ?>style="display:block;"<?php } else {?>style="display:none;"<?php } ?> class="col-xs-5">
											<input type="number" id="pb_rate" name="pb_rate" onBlur="if(this.value == '') { this.value='<?php echo $lang[436]; ?>'}" onFocus="if (this.value == '<?php echo $lang[436]; ?>') {this.value=''}" value="<?php echo $pb_rate; ?>" class="form-control"/>
										</div>
									</div>
                                    <hr class="invis">

									
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <label class="control-label"><?php echo $lang[438]." (".$lang[439].")"; ?></label>
                                            <input type="text" id="pb_duration" name="pb_duration" class="form-control" value="<?php echo $pb_duration; ?>" />
                                        </div>
                                    </div><!-- end row -->
								
									<hr class="invis">
									
                                    <div class="form-privacy-txt" align="center"><?php echo $lang[46]; ?><a href="terms.php"><?php echo $lang[47]; ?></a><?php echo $lang[48]; ?><a href="privacy.php"><?php echo $lang[49]; ?></a></div>
                                    <hr class="invis">
                                    <input type="submit" class="btn btn-primary btn-block" value="<?php echo $lang[443]; ?>" id="formSubmitBtn" name="postproj">
									
                            
                            </div><!-- end post-padding -->
							</form>
                        </div><!-- end col -->

                        <!--<div class="sidebar col-md-4">
                            <div class="widget clearfix">
                                <div class="widget-title">
                                    <h4>We Are YourJob</h4>
                                </div><!-- end widget-title -->

                                <!--<div class="text-widget">   
                                    <p>This is a professional responsive HTML5 job listing, job board and freelancer website template. This template available only Envato marketplace!</p>

                                    <ul class="list-inline social-small">
                                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                        <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                                        <li><a href="#"><i class="fa fa-rss"></i></a></li>
                                    </ul>
                                </div><!-- end text-widget -->
                            </div><!-- end widget -->

                            <!--<div class="widget clearfix">
                                <div class="widget-title">
                                    <h4>Popular Jobs</h4>
                                </div><!-- end widget-title -->

                                <!--<div class="owl-job-carousel owl-job-widget owl-carousel owl-theme text-center">
                                    <div class="job-tab">
                                        <div class="post-media">
                                            <a href="job-single.html"><img src="upload/job_01.jpg" alt="" class="img-responsive"></a>
                                            <div class="badge part-badge">Part Time</div>
                                        </div><!-- end media -->
                                        <!--<div class="job-big-meta">
                                            <h3><a href="job-single.html" title="">Hiring Online English Teachers</a></h3>
                                            <small>
                                                <span>Publisher : <a href="#">Bob Sturan</a></span> 
                                                <span>In : <a href="#">Web Design</a></span>
                                            </small>
                                        </div><!-- end job-big-meta -->
                                    </div><!-- end job-tab -->

                                    <!--<div class="job-tab">
                                        <div class="post-media">
                                            <a href="job-single.html"><img src="upload/job_02.jpg" alt="" class="img-responsive"></a>
                                            <div class="badge freelancer-badge">Freelancer</div>
                                        </div><!-- end media -->
                                        <!--<div class="job-big-meta">
                                            <h3><a href="job-single.html" title="">Looking Logo Designer</a></h3>
                                            <small>
                                                <span>Publisher : <a href="#">Patrick</a></span> 
                                                <span>In : <a href="#">Graphic Design</a></span>
                                            </small>
                                        </div><!-- end job-big-meta -->
                                    </div><!-- end job-tab -->
                                </div><!-- end job-widget -->
                            </div><!-- end widget -->

                            <!--<div class="widget clearfix">
                                <div class="widget-title">
                                    <h4>Popular Freelancers</h4>
                                </div><!-- end widget-title -->

                                <!--<div class="owl-freelancer-carousel owl-job-widget owl-carousel owl-theme">
                                    <div class="freelancer-wrap row clearfix">
                                        <div class="col-md-4">
                                        <div class="post-media">
                                            <img class="img-responsive" src="upload/testi_05.png" alt="">
                                        </div>
                                        </div>

                                        <div class="col-md-8">
                                            <div class="rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <h4><a href="#">Amanda Pelt</a></h4>
                                            <ul class="list-inline">
                                                <li><small>Web Designer</small></li>
                                                <li><small>98 Jobs Done</small></li>
                                            </ul>        
                                        </div>                            
                                    </div><!-- end freelancer-wrap -->

                                    <!--<div class="freelancer-wrap row clearfix">
                                        <div class="col-md-4">
                                        <div class="post-media">
                                            <img class="img-responsive" src="upload/testi_01.png" alt="">
                                        </div>
                                        </div>

                                        <div class="col-md-8">
                                            <div class="rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <h4><a href="#">Jenny Lisbon</a></h4>
                                            <ul class="list-inline">
                                                <li><small>Graphic Designer</small></li>
                                                <li><small>21 Jobs Done</small></li>
                                            </ul>        
                                        </div>                            
                                    </div><!-- end freelancer-wrap -->

                                </div><!-- end job-widget -->
                            </div><!-- end widget -->

                            <!--<div class="widget clearfix">
                                <div class="widget-title">
                                    <h4>From the Blog</h4>
                                </div><!-- end widget-title -->

                                <!--<div class="postpager liststylepost">
                                    <ul class="post-blog">
                                        <li>
                                            <div class="post">
                                                <a href="job-single.html">
                                                    <img alt="" src="upload/pager_01.png" class="img-responsive alignleft">
                                                    <h4>Learning Professional English in 20 Days</h4>
                                                </a>
                                                <div class="blog-meta clearfix">
                                                    <ul class="list-inline">
                                                        <li><a href="#"><i class="fa fa-clock-o"></i> 17 March 2016</a></li>
                                                        <li><a href="#"><i class="fa fa-comment-o"></i> 44</a></li>
                                                    </ul>
                                                </div>
                                            </div>  
                                        </li>
                                        <li>
                                            <div class="post">
                                                <a href="job-single.html">
                                                    <img alt="" src="upload/pager_02.png" class="img-responsive alignleft">
                                                    <h4>Selecting Material Design and Colors</h4>
                                                </a>
                                                <div class="blog-meta clearfix">
                                                    <ul class="list-inline">
                                                        <li><a href="#"><i class="fa fa-clock-o"></i> 15 March 2016</a></li>
                                                        <li><a href="#"><i class="fa fa-comment-o"></i> 22</a></li>
                                                    </ul>
                                                </div>
                                            </div>  
                                        </li>
                                        <li>
                                            <div class="post">
                                                <a href="job-single.html">
                                                    <img alt="" src="upload/pager_03.jpg" class="img-responsive alignleft">
                                                    <h4>Getting Starting Web Design</h4>
                                                </a>
                                                <div class="blog-meta clearfix">
                                                    <ul class="list-inline">
                                                        <li><a href="#"><i class="fa fa-clock-o"></i> 11 March 2016</a></li>
                                                        <li><a href="#"><i class="fa fa-comment-o"></i> 12</a></li>
                                                    </ul>
                                                </div>
                                            </div>  
                                        </li>
                                    </ul>   
                                </div><!-- end postpager -->
                            </div><!-- end widget -->

                            <!--<div class="widget clearfix">
                                <div class="widget-title">
                                    <h4>Job Categories</h4>
                                </div><!-- end widget-title -->
                                <!--<ul class="check">
                                    <li><a href="#">Coding <span>(12)</span></a></li>                                             
                                    <li><a href="#">Design & Development <span>(21)</span></a></li>        
                                    <li><a href="#">Branding <span>(44)</span></a></li>     
                                    <li><a href="#">Social Marketing <span>(09)</span></a></li>       
                                    <li><a href="#">Form Elements <span>(31)</span></a></li>         
                                    <li><a href="#">LifeStyle <span>(41)</span></a></li>     
                                </ul>
                            </div><!-- end widget -->
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