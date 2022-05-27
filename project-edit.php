<?php
ob_start();
session_start();
include "common.php";

$dcPrj=mysql_fetch_object(mysql_query("select * from project where md5(prj_id)='".trim($_GET['p'])."'"));

$prj_id=$dcPrj->prj_id;

$_SESSION['last_page']="project-edit.php?p=".md5(prj_id);

$sql="select * from project,subcategory,category,project_budget where prj_scat_id=scat_id and scat_cat_id=cat_id and prj_id=pb_prj_id and prj_id='".$prj_id."'";
$res=mysql_query($sql);
$row=mysql_fetch_object($res);


class editProject{

	var $msg;
	var $prj_id;
	var $cat_id;
	var $prj_scat_id;
	var $skills;
	var $currentDescr;
	var $prj_details;
    var $pb_type;
	var $pb_minprice;
	var $pb_maxprice;
	var $pb_rate;
	var $pb_duration;
	var $fl_name;
		
	
/*	function __construct( $prj_id, $cat_id, $prj_scat_id, $skills, $currentDescr, $prj_details)
	{
		$this->prj_id=$prj_id;
		$this->cat_id=$cat_id;
		$this->prj_scat_id=$prj_scat_id;
		$this->skills=$skills;
		$this->currentDescr=$currentDescr;
		$this->prj_details=$prj_details;
	}*/
	
	function valid()
	{
        include "language.php";
          
		$valid=true;
		
		//$ext = substr($this->prj_file, strpos($this->prj_file,'.'), strlen($this->prj_file)-1);

		if($this->cat_id == "0")
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
        else if($this->pb_type=='fixed')
		{
			if($this->pb_minprice == "" || $this->pb_minprice == $lang[434] || $this->pb_minprice == "0.00" || $this->pb_minprice == "0")
			{
				$this->msg= '<font color="#CC0000">'.$lang[417].'</font>';
				$valid=false;
			}
            else if(is_nan($this->pb_minprice))
            {
                $this->msg= '<font color="#CC0000">'.$lang[627].'</font>';
                $valid=false;
            }
			else if($this->pb_maxprice == "" || $this->pb_maxprice == $lang[435] || $this->pb_maxprice == "0.00" || $this->pb_maxprice == "0")
			{
				$this->msg= '<font color="#CC0000">'.$lang[418].'</font>';
				$valid=false;
			}
            else if(is_nan($this->pb_maxprice))
            {
                 $this->msg= '<font color="#CC0000">'.$lang[628].'</font>';
                 $valid=false;
            }
		}
		else if($this->pb_type=='hourly')
		{
			if($this->pb_rate == "" || $this->pb_rate == "0.00" || $this->pb_rate == "0")
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
	
	function update()
	{	
        include "language.php";
		$validity=get_page_settings(6);

		$sql="update project
			set	
				prj_scat_id ='".$this->prj_scat_id."',								
				prj_details ='".$this->currentDescr.$this->prj_details."',
				prj_status ='open',
				prj_updated_date=now()
			where
				prj_id ='".$this->prj_id."'";
					
		mysql_query($sql) or die(mysql_error());
		
		
		/* file upload code */
		if($_FILES["fl_name"]["name"] != "")
		{
			if ($_FILES["fl_name"]["error"] > 0)
			{
				$this->msg = "Return Code: " . $_FILES["fl_name"]["error"] . "<br />";
			}
			else
			{
				$res_file=mysql_query("select * from project_files where pfl_pr_id='".$this->prj_id."'");
				if(mysql_num_rows($res_file)>0)
				{
					$pathF="project_files/".$res_file->pfl_filename;
					if(is_file($pathF))
					{
						unlink($pathF);
					}	
				}
				mysql_query("delete from project_files where pfl_pr_id='".$this->prj_id."'");
				
				
				$this->fl_name='prj'.rand(0,9999).trim(addslashes($_FILES['fl_name']['name']));	
				$ds = move_uploaded_file($_FILES["fl_name"]["tmp_name"], "project_files/".$this->fl_name) or die('error');
				$sql_f="insert into project_files
					set				
						pfl_pr_id =".$this->prj_id.",
						pfl_filename ='".$this->fl_name."'";
							
				mysql_query($sql_f) or die(mysql_error());
			}
		}
		
		
		$sk_id_arr=array();
		$sk_id_arr=explode(",",$this->skills);

		mysql_query("delete from project_skill where ps_prj_id='".$prj_id."'");
		
		foreach($sk_id_arr as $sk_id)
		{
			if($sk_id != '')
			{
				$sql_ps="insert into project_skill
				set					
					ps_prj_id ='".$this->prj_id."',									
					ps_sk_id ='".$sk_id."'";
				mysql_query($sql_ps);
			}
		}
		
            $sql_pb="update project_budget
			set					
				pb_type ='".$this->pb_type."',
				pb_minprice ='".$this->pb_minprice."',
				pb_maxprice ='".$this->pb_maxprice."',
				pb_rate ='".$this->pb_rate."',
				pb_duration ='".$this->pb_duration."',
				pb_status ='1'
                  where
                        pb_prj_id='".$this->prj_id."'";
						
		mysql_query($sql_pb);
															
		$this->msg='<font color="#009900">'.$lang[473].'</font>';	

		unset($_SESSION['cat_id']);
		unset($_SESSION['prj_scat_id']);
				
		unset($_SESSION['prj_details']);
		
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
			$_SESSION['lst_prj']=$prj_id;
		}

	}	
}

if(isset($_POST['updProject']))
{
	
	$skills="";
	foreach($_POST['prj_skills'] as $val)
	{
		$skills.=$val.",";
	}
	

	$adn=new editProject();
	$adn->prj_id=addslashes(trim($_POST['prj_id']));
	$adn->cat_id=addslashes(trim($_POST['cat_id']));
	$adn->prj_scat_id=addslashes(trim($_POST['prj_scat_id']));
	$adn->skills=$skills;
	$adn->currentDescr=addslashes(trim($_POST['currentDescr']));
	$adn->prj_details=addslashes(trim($_POST['prj_details']));
    $adn->pb_type=addslashes(trim($_POST['pb_type']));
    $adn->pb_minprice=addslashes(trim($_POST['pb_minprice']));
    $adn->pb_maxprice=addslashes(trim($_POST['pb_maxprice']));
    $adn->pb_rate=addslashes(trim($_POST['pb_rate']));
    $adn->pb_duration=addslashes(trim($_POST['pb_duration']));
      
	$adn->total_pp=addslashes(trim($_POST['total_pp']));
	
	$_SESSION['cat_id']=$adn->cat_id;
	$_SESSION['prj_scat_id']=$adn->prj_scat_id;
	$_SESSION['prj_details']=$adn->prj_details;

	if($adn->valid())
	{
		$adn->update();		
		$_SESSION['msg']=$adn->msg;
		header("location:post-project-res.php?p=".md5($adn->prj_id));
	}
	else
	{
		$_SESSION['msg']=$adn->msg;
		header("location:project-edit.php?p=".md5($adn->prj_id));
	}
	//echo $ecms->msg;
//	$_SESSION['msg']=$adn->msg;

}

?>
	<?php include "includes/header.php"; ?>
    
	
	
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
							<form id="createform" name="createform" action="" class="form-horizontal" method="post" enctype="multipart/form-data">
							
                            <div class="post-padding">
                                <div class="job-title nocover hidden-sm hidden-xs"><h5><?php echo $lang[441]; ?></h5></div>
								
								<?php
									$sql_ppo="select * from project_promotion_option where ppo_prj_id='".$prj_id."'";
									$res_ppo=mysql_query($sql_ppo);
									$act_ppo=array();
									$x=-1;
									while($row_ppo=mysql_fetch_object($res_ppo))
									{
										$x++;
										$act_ppo[$x]=$row_ppo->ppo_pp_id;
									}
									
								
									$sql_pp="select * from project_promotion where pp_status='1' order by pp_id";
									$res_pp=mysql_query($sql_pp);
									$pp=0;
									while($row_pp=mysql_fetch_object($res_pp)){
								?>
								<?php	if(in_array($row_pp->pp_id,$act_ppo)){	?>
                                <div class="job-tab submitform">
                                    <div class="row">
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <h3><?php echo stripslashes(strtoupper($row_pp->pp_name)); ?></h3>
                                            <small><?php echo $row_pp->pp_dispText; ?></small>
                                        </div><!-- end col -->

                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="job-meta text-center">
                                                <h4><?php echo getCurrencySymbol(); ?>&nbsp;<?php echo number_format($row_pp->pp_amount,2); ?></h4>
												<input id="nonpublic" name="chkbx_pp_<?php echo $row_pp->pp_id; ?>" type="checkbox" checked="checked" disabled="disabled">
                                                
                                            </div>
                                        </div><!-- end col -->
                                    </div><!-- end row -->
                                </div><!-- end job-tab -->
								<hr>
								<?php }else{ ?>
								<div class="job-tab submitform">
                                    <div class="row">
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <h3><?php echo stripslashes(strtoupper($row_pp->pp_name)); ?></h3>
                                            <small><?php echo $row_pp->pp_dispText; ?></small>
                                        </div><!-- end col -->

                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <div class="job-meta text-center">
                                                <h4><?php echo getCurrencySymbol(); ?>&nbsp;<?php echo number_format($row_pp->pp_amount,2); ?></h4>
												<input id="nonpublic" name="chkbx_pp_<?php echo $row_pp->pp_id; ?>" type="checkbox" > 
                                                
                                            </div>
                                        </div><!-- end col -->
                                    </div><!-- end row -->
                                </div><!-- end job-tab -->
								<hr>
								<?php } ?>
								<?php $pp++; } ?>
								<input type="hidden" name="total_pp" id="total_pp" value="<?php echo $pp; ?>"/>
								
								
								
                            </div><!-- end post-padding -->
                            <div class="prj-detail-form-margin_1"><div id="msg"><?php echo $msg; ?></div></div>
                            <div class="post-padding">
                                <div class="job-title nocover hidden-sm hidden-xs"><h5><?php echo $lang[423]; ?></h5></div>
									<input type="hidden" id="prj_id" name="prj_id" value="<?php echo $prj_id; ?>"/>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <label class="control-label"><?php echo $lang[424]; ?> </label>
                                            <input value="<?php echo $row->prj_name; ?>" size="45" maxlength="60" name="prj_name" disabled="disabled" type="text" class="form-control"/>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <label class="control-label"><?php echo $lang[425]; ?> </label>
                                            <?php
												$sql_cat="select * from category where cat_status=1 order by cat_name";
												$res_cat=mysql_query($sql_cat);
											?>
											<select id="cat_id" class="form-control" name="cat_id" onChange="showSubcat(this.value)">
												<option value="0"><?php echo $lang[426]; ?></option>
												<?php while($row_cat=mysql_fetch_object($res_cat)) { ?>
												<option value="<?php echo $row_cat->cat_id; ?>" <?php if($row_cat->cat_id == $row->cat_id){ ?> selected="selected" <?php } ?> ><?php echo ucfirst($row_cat->cat_name); ?></option>
												<?php } ?>
											</select>
                                        </div>
                                    </div><!-- end row -->

                                    <hr class="invis">

									<div class="form-group" id="scat" style="display:none;">
										<label class="col-sm-4 control-label no-padding-right"></label>
										<div class="col-sm-6">
											<select id="prj_scat_id" class="form-control" name="prj_scat_id">
												<option value="0"><?php echo $lang[427]; ?></option>
												<?php
												$sql_scat="select * from subcategory where scat_cat_id='".$row->cat_id."'"; 
												$res_scat=mysql_query($sql_scat);
												while($row_scat=mysql_fetch_object($res_scat)){
												?>
												<option value="<?php echo $row_scat->scat_id; ?>" <?php if($row_scat->scat_id == $row->prj_scat_id){ ?> selected="selected" <?php } ?> ><?php echo ucfirst($row_scat->scat_name); ?></option>
												<?php	}	?>
											</select>
										</div>
									</div>
									
									<hr class="invis">

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <label class="control-label"><?php echo $lang[428]; ?></label>
											<?php
											$sql_sk="select * from skills where sk_status=1";
											$res_sk=mysql_query($sql_sk);
									
											$sql_psk="select * from project_skill where ps_prj_id='".$row->prj_id."'";
											$res_psk=mysql_query($sql_psk);
									
											$p_sk=array();
											$x=-1;
											while($row_psk=mysql_fetch_object($res_psk))
											{
												$x++;
												$p_sk[$x]=$row_psk->ps_sk_id;
											}

											function actSkill($a)
											{
												for($x=0;$x<count($p_sk);$x++)
												{
													if($a == $p_sk[$x])
													{
														return true;	
													}
												}
												return false;
											}
											//echo actSkill($row_sk->sk_id);
											?>
											<br>
                                            
											<select class="form-control" multiple="multiple" id="prj_skills" name="prj_skills[]" class="chosen-select" placeholder="<?php echo $lang[475]; ?>" style="">
												<?php while($row_sk=mysql_fetch_object($res_sk)) { ?>
												<option value="<?php echo $row_sk->sk_id; ?>" <?php if(in_array($row_sk->sk_id, $p_sk)){?> selected="selected" <?php } ?> ><?php echo $row_sk->sk_name; ?></option>
												<?php } ?>
											</select>
                                        </div>
                                    </div><!-- end row -->
									
									<hr class="invis">

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <label class="control-label"><?php echo $lang[476]; ?></label>
                                            <textarea name="currentDescr" readonly="readonly" class="form-control"><?php echo $row->prj_details; ?></textarea>
                                        </div>
                                    </div><!-- end row -->
									
									<hr class="invis">

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <label class="control-label"><?php echo $lang[477]; ?></label>
                                            <textarea name="prj_details" id="prj_details" class="form-control"></textarea>
                                        </div>
                                    </div><!-- end row -->
									
                                    <hr class="invis">
									
									
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
											
                                            <label class="control-label"><?php echo $lang[502]; ?></label>
											<?php
											$sql_fl1="select * from project_files where pfl_pr_id=".$row->prj_id;
											$res_fl1=mysql_query($sql_fl1);
									
											if(mysql_num_rows($res_fl1)>=1){
											?>
											<?php while($row_fl1=mysql_fetch_object($res_fl1)){		?>
											<a target="_blank" class="" href="project_files/<?php echo $row_fl1->pfl_filename ; ?>"><?php echo $row_fl1->pfl_filename ; ?></a>
											<?php	}	?>
											<?php } ?>
											<input type="file" id="id-input-file-3" name="fl_name" class="fileupload-new" value="Select Files">
                                               
                                        </div>
                                    </div><!-- end row -->
									
									<hr class="invis">
									
									<div class="row">
										<div class="col-md-12 col-sm-12">
											<label class="control-label" style="margin-right:10px;"><?php echo $lang[430]; ?></label>
														<input id="fixedBudgetPeriod_option" name="pb_type" value="fixed" checked="checked" type="radio" onChange="showFixdBud(this.value)" class="ace"/>
														<span class="lbl" style="width:150px;">&nbsp;<?php echo $lang[431]; ?></span>
														
														<input id="hourlyBudgetPeriod_option" name="pb_type" value="hourly" type="radio" <?php if($row->pb_type=='hourly'){ ?>checked="checked"<?php } ?> onChange="showHourBud(this.value)" class="ace"/>
														<span class="lbl" style="width:150px;">&nbsp;<?php echo $lang[432]; ?></span>
														
										</div>
									</div>

                                    <hr class="invis">
									

									<div class="row">
										<div class="col-md-4 col-sm-12">
											<label class="control-label"><?php echo $lang[433]; ?>(<?php echo getCurrencyCode(); ?>)</label>
										</div>
										<div id="fbud" class="col-md-8 col-sm-12" <?php if($row->pb_type=='hourly'){ ?>style="display:none;"<?php }?> >
											<div class="col-md-4 col-sm-12">
											<input type="text" id="pb_minprice" name="pb_minprice" onBlur="if(this.value == '') { this.value='<?php echo $lang[434]; ?>'}" onFocus="if (this.value == '<?php echo $lang[434]; ?>') {this.value=''}" value="<?php echo $row->pb_minprice; ?>" class="form-control"/>
											</div>
											<div class="col-md-4 col-sm-12">
											<input type="text" id="pb_maxprice" name="pb_maxprice" onBlur="if(this.value == '') { this.value='<?php echo $lang[435]; ?>'}" onFocus="if (this.value == '<?php echo $lang[435]; ?>') {this.value=''}" value="<?php echo $row->pb_maxprice; ?>" class="form-control"/>
											</div>
										</div>
										<div id="hbud" class="col-md-4 col-sm-12" <?php if($row->pb_type=='hourly'){ ?>style="display:block;"<?php } else {?>style="display:none;"<?php } ?> class="col-xs-5">
											<input type="text" id="pb_rate" name="pb_rate" onBlur="if(this.value == '') { this.value='<?php echo $lang[436]; ?>'}" onFocus="if (this.value == '<?php echo $lang[436]; ?>') {this.value=''}" value="<?php echo $row->pb_rate; ?>" class="form-control"/>
										</div>
									</div>
                                    <hr class="invis">

									
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <label class="control-label"><?php echo $lang[438]." (".$lang[439].")"; ?></label>
                                            <input type="text" id="pb_duration" name="pb_duration" class="form-control" value="<?php echo $row->pb_duration; ?>" />
                                        </div>
                                    </div><!-- end row -->
								
									<hr class="invis">
									
                                    <div class="form-privacy-txt" align="center"><?php echo $lang[46]; ?><a href="terms.php"><?php echo $lang[47]; ?></a><?php echo $lang[48]; ?><a href="privacy.php"><?php echo $lang[49]; ?></a></div>
                                    <hr class="invis">
                                    <input type="submit" class="btn btn-primary btn-block" value="<?php echo $lang[478]; ?>" id="btn-preview-project" name="updProject">
									
                            
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
    
<script language="javascript">
function showSubcat(str)
{
	//$.noConflict();

	$.get("showSubcat.php",  {q:str},    function(data){     $('#prj_scat_id').html(data);  });
	//$('#prj_scat_id').show();
}
function showFixdBud()
{
      document.getElementById('fbud').style.display='block';
      document.getElementById('hbud').style.display='none';
}
function showHourBud()
{
      document.getElementById('hbud').style.display='block';
      document.getElementById('fbud').style.display='none';
}
</script>		
			
	

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
					//console.log($(this).data('ace_input_files'));
					//console.log($(this).data('ace_input_method'));
				});
				
			
				//dynamically change allowed formats by changing before_change callback function
				$('#id-file-format').removeAttr('checked').on('change', function() {
					var before_change
					var btn_choose
					var no_icon
					if(this.checked) {
						btn_choose = "Drop images here or click to choose";
						no_icon = "icon-picture";
						before_change = function(files, dropped) {
							var allowed_files = [];
							for(var i = 0 ; i < files.length; i++) {
								var file = files[i];
								if(typeof file === "string") {
									//IE8 and browsers that don't support File Object
									if(! (/\.(jpe?g|png|gif|bmp)$/i).test(file) ) return false;
								}
								else {
									var type = $.trim(file.type);
									if( ( type.length > 0 && ! (/^image\/(jpe?g|png|gif|bmp)$/i).test(type) )
											|| ( type.length == 0 && ! (/\.(jpe?g|png|gif|bmp)$/i).test(file.name) )//for android's default browser which gives an empty string for file.type
										) continue;//not an image so don't keep this file
								}
								
								allowed_files.push(file);
							}
							if(allowed_files.length == 0) return false;
			
							return allowed_files;
						}
					}
					else {
						btn_choose = "Drop files here or click to choose";
						no_icon = "icon-cloud-upload";
						before_change = function(files, dropped) {
							return files;
						}
					}
					var file_input = $('#id-input-file-3');
					file_input.ace_file_input('update_settings', {'before_change':before_change, 'btn_choose': btn_choose, 'no_icon':no_icon})
					file_input.ace_file_input('reset_input');
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