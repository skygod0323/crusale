<?php
ob_start();
session_start();
include "common.php";

unset($_SESSION['last_page']);

class listCat{
	/*var $start="";
	var $limit="";*/
	var $sqlList="";
	var $start="";
	var $limit="";
	
	function setsql($sql){
		$this->sqlList=$sql;
	}
	function totalrecord(){
		return mysql_num_rows(mysql_query($this->sqlList));
	}
	function listview(){
		$sql=$this->sqlList." limit ".$this->start.",".$this->limit;
		$res=mysql_query($sql);
		return $res;
	}
	function numpage($rowPage){
		 return floor($this->totalrecord()/$rowPage);
	}
}

$p=new Pagination;
$page=$p->setpage();

$al=new listCat;

$al->limit=$p->setlimit(10);

if(!isset($_SESSION['uid']) && $_SESSION['uid']==''){
$al->setsql("select * from project, project_budget,user where prj_id=pb_prj_id and prj_usr_id=usr_id and prj_status = 'open' and prj_expiry>'".date("Y-m-d H:i:s")."' and prj_id not in(select ppo_prj_id from project_promotion_option where ppo_status='1' and ppo_pp_id=(select pp_id from project_promotion where pp_name='private' and pp_status='1')) order by prj_updated_date desc");

}
else
{
$al->setsql("select * from project, project_budget,user where prj_id=pb_prj_id and prj_usr_id=usr_id and prj_status = 'open' and prj_expiry>'".date("Y-m-d H:i:s")."' order by prj_updated_date desc");	
}

$totalitems=$al->totalrecord();
$limit=$al->limit;
$al->start=$p->setstart($page,$limit,$totalitems);
$adjacents=1;
$targetpage = "index.php";
$pagestring ="?limit=".$limit."&page=";

$recObj=$al->listview();

$showitems=$al->start+1 ." - ";
if(($al->start+$limit)<$totalitems){
	$showitems.=$al->start+$limit;
}
else{
	$showitems.=$totalitems;
}
	$showitems.= $lang[759].$al->totalrecord().$lang[760];
	
?>
<?php include "includes/header.php"; ?>

            <div class="section hero">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="home-title text-center">
                                <h3>Employers</h3>
                                <p>If you have a sales need then you have come to the right place! Sales Projects are accellerated here at Cru.Sale</p>
                                <a href="login.php" class="btn btn-primary">Find Your Worker</a>
                            </div>
                        </div><!-- end col -->

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="home-title rightside text-center">
                                <h3>Freelancers</h3>
                                <p>Sales professionals needing to sell look no further. Sign up, bid, start earning today. </p>
                                <a href="show-category.php" class="btn btn-primary">Browse Jobs</a>
                            </div>
                        </div><!-- end col -->
                    </div><!-- end row -->
                </div><!-- end container -->
            </div><!-- end section -->

            <div class="section lb">
                <div class="container">
                    <div class="section-title text-center clearfix">
                        <h4>Recent & Featured Jobs</h4>
                        <p class="lead"></p>
                    </div>

                    <div class="all-jobs job-listing clearfix">
                        <div class="job-title hidden-sm hidden-xs"><h5>Featured</h5></div>
						<?php 
						$res_pf=mysql_query("select * from project_promotion_option,project,project_budget,user where ppo_prj_id=prj_id and pb_prj_id=prj_id and prj_usr_id=usr_id and  ppo_pp_id=1 limit 2");
						while($row_pf=mysql_fetch_array($res_pf)) {?>
                        <div class="job-tab">
                            <div class="row">
                                

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="badge freelancer-badge"><?php echo $row_pf['pb_type'];  ?> </div>
                                    <h3><a href="project.php?p=<?php echo $row_pf['prj_id'];  ?>" title=""><?php echo $row_pf['prj_name']; ?></a></h3>
                                    <small>
                                        <span>Publisher : <a href="profile.php?u=<?php echo md5($row_pf['usr_id']); ?>"><?php echo $row_pf['usr_name'];  ?></a></span> 
                                        <span>In : Update</span>
                                        <span>Date : <?php echo $row_pf['prj_updated_date'];  ?></span>
                                    </small>
                                </div><!-- end col -->

                                

                                <div class="col-md-4 col-sm-4 col-xs-12" style="float:right;">
                                    <div class="job-meta text-center">
                                        <h4><?php echo getCurrencySymbol(); ?><?php echo $row_pf['pb_minprice'];  ?> - <?php echo getCurrencySymbol(); ?><?php echo $row_pf['pb_maxprice'];  ?></h4>
                                        <a href="project.php?p=<?php echo $row_pf['prj_id'];  ?>" class="btn btn-primary btn-sm btn-block">Bid Now!</a>
                                    </div>
                                </div><!-- end col -->
                            </div><!-- end row -->
                        </div><!-- end job-tab -->
						<?php } ?>
						
                        
                    </div><!-- end all-jobs -->

                    <hr class="largeinvis">

                    <div class="all-jobs job-listing clearfix">
                        <div class="job-title hidden-sm hidden-xs"><h5>Private</h5></div>
						<?php 
						$res_pf=mysql_query("select * from project_promotion_option,project,project_budget,user where ppo_prj_id=prj_id and pb_prj_id=prj_id and prj_usr_id=usr_id and  ppo_pp_id=2 limit 2");
						while($row_pf=mysql_fetch_array($res_pf)) {?>
                        <div class="job-tab">
                            <div class="row">
                                

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="badge freelancer-badge"><?php echo $row_pf['pb_type'];  ?> </div>
                                    <h3><a href="project.php?p=<?php echo $row_pf['prj_id'];  ?>" title=""><?php echo $row_pf['prj_name']; ?></a></h3>
                                    <small>
                                        <span>Publisher : <a href="profile.php?u=<?php echo md5($row_pf['usr_id']); ?>"><?php echo $row_pf['usr_name'];  ?></a></span> 
                                        <span>In : Update</span>
                                        <span>Date : <?php echo $row_pf['prj_updated_date'];  ?></span>
                                    </small>
                                </div><!-- end col -->

                                

                                <div class="col-md-4 col-sm-4 col-xs-12" style="float:right;">
                                    <div class="job-meta text-center">
                                        <h4><?php echo getCurrencySymbol(); ?><?php echo $row_pf['pb_minprice'];  ?> - <?php echo getCurrencySymbol(); ?><?php echo $row_pf['pb_maxprice'];  ?></h4>
                                        <a href="project.php?p=<?php echo $row_pf['prj_id'];  ?>" class="btn btn-primary btn-sm btn-block">Bid Now!</a>
                                    </div>
                                </div><!-- end col -->
                            </div><!-- end row -->
                        </div><!-- end job-tab -->
						<?php } ?>
						
                        
                    </div><!-- end all-jobs -->
					
					<hr class="largeinvis">

                    <div class="all-jobs job-listing clearfix">
                        <div class="job-title hidden-sm hidden-xs"><h5>Sealed</h5></div>
						<?php 
						$res_pf=mysql_query("select * from project_promotion_option,project,project_budget,user where ppo_prj_id=prj_id and pb_prj_id=prj_id and prj_usr_id=usr_id and  ppo_pp_id=3 limit 2");
						while($row_pf=mysql_fetch_array($res_pf)) {?>
                        <div class="job-tab">
                            <div class="row">
                                

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="badge freelancer-badge"><?php echo $row_pf['pb_type'];  ?> </div>
                                    <h3><a href="project.php?p=<?php echo $row_pf['prj_id'];  ?>" title=""><?php echo $row_pf['prj_name']; ?></a></h3>
                                    <small>
                                        <span>Publisher : <a href="profile.php?u=<?php echo md5($row_pf['usr_id']); ?>"><?php echo $row_pf['usr_name'];  ?></a></span> 
                                        <span>In : Update</span>
                                        <span>Date : <?php echo $row_pf['prj_updated_date'];  ?></span>
                                    </small>
                                </div><!-- end col -->

                                

                                <div class="col-md-4 col-sm-4 col-xs-12" style="float:right;">
                                    <div class="job-meta text-center">
                                        <h4><?php echo getCurrencySymbol(); ?><?php echo $row_pf['pb_minprice'];  ?> - <?php echo getCurrencySymbol(); ?><?php echo $row_pf['pb_maxprice'];  ?></h4>
                                        <a href="project.php?p=<?php echo $row_pf['prj_id'];  ?>" class="btn btn-primary btn-sm btn-block">Bid Now!</a>
                                    </div>
                                </div><!-- end col -->
                            </div><!-- end row -->
                        </div><!-- end job-tab -->
						<?php } ?>
						
                        
                    </div><!-- end all-jobs -->
					
					<hr class="largeinvis">
					
                    <div class="all-jobs job-listing clearfix">
                        <div class="job-title hidden-sm hidden-xs"><h5>Urgent</h5></div>
						<?php $res_pf=mysql_query("select * from project_promotion_option,project,project_budget,user where ppo_prj_id=prj_id and pb_prj_id=prj_id and prj_usr_id=usr_id and  ppo_pp_id=4 limit 2");
						while($row_pf=mysql_fetch_array($res_pf)) {?>
                        <div class="job-tab">
                            <div class="row">
                                

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="badge freelancer-badge"><?php echo $row_pf['pb_type'];  ?> </div>
                                    <h3><a href="project.php?p=<?php echo $row_pf['prj_id'];  ?>" title=""><?php echo $row_pf['prj_name']; ?></a></h3>
                                    <small>
                                        <span>Publisher : <a href="profile.php?u=<?php echo md5($row_pf['usr_id']); ?>"><?php echo $row_pf['usr_name'];  ?></a></span> 
                                        <span>In : Update</span>
                                        <span>Date : <?php echo $row_pf['prj_updated_date'];  ?></span>
                                    </small>
                                </div><!-- end col -->

                                

                                <div class="col-md-4 col-sm-4 col-xs-12" style="float:right;">
                                    <div class="job-meta text-center">
                                        <h4><?php echo getCurrencySymbol(); ?><?php echo $row_pf['pb_minprice'];  ?> - <?php echo getCurrencySymbol(); ?><?php echo $row_pf['pb_maxprice'];  ?></h4>
                                        <a href="project.php?p=<?php echo $row_pf['prj_id'];  ?>" class="btn btn-primary btn-sm btn-block">Bid Now!</a>
                                    </div>
                                </div><!-- end col -->
                            </div><!-- end row -->
                        </div><!-- end job-tab -->
						
						
                        
                    </div><!-- end all-jobs -->
					<?php } ?>
                    <div class="text-center clearfix">
                        <a href="show-category.php" class="btn btn-custom" id="">Load More Jobs</a>
                    </div><!-- end loadmore -->
                </div><!-- end container -->
            </div><!-- end section -->

            <div class="parallax section" data-stellar-background-ratio="0.5" style="background-image:url('upload/parallax_01.jpg');" style="height:200px;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row testimonials">
<?php
						$res_testi=mysql_query("select * from testimonials");
						while($row_testi=mysql_fetch_array($res_testi)){
							
                    ?>
                                <div class="col-sm-4">
                                    <blockquote>
<p class="clients-words"><?php echo $row_testi['testi_details']; ?></p>
<span class="clients-name text-primary">— <?php echo $row_testi['testi_name']; ?></span>
<img class="img-circle img-thumbnail" src="testimonial_img/<?php echo $row_testi['testi_image']; ?>" alt="">
                                    </blockquote>
                                </div>
<?php } ?>
                            </div>
                        </div><!--/.col-->  
                    </div><!--/.row-->
                </div><!-- end container -->
            </div><!-- end section -->

            <div class="section lb">
                <div class="container">
                    <div class="section-title text-center clearfix">
                        <h4>Looking for the best Sales Professionals on the Planet?</h4>
                        <p class="lead"></p>
                    </div>

                    <div class="row freelancer-list">
					<?php
						$res_user=mysql_query("select * from user where usr_mp_id=2");
						while($row_user=mysql_fetch_array($res_user)){
							
                    ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="freelancer-wrap row-fluid clearfix">
                                <div class="col-md-3 text-center">
                                    <div class="post-media">
										<?php if($row_user['usr_image']=="") { ?>
										<img class="img-responsive" src="images/users/unknown.png" alt="">
										<?php } else { ?>
                                        <img class="img-responsive" src="images/users/<?php echo $row_user['usr_image']; ?>" alt="">
										<?php } ?>
									</div>
                                </div><!-- end col -->

                                <div class="col-md-9">
                                    
                                    <h4><a href="#"><?php echo $row_user['usr_name']; ?></a></h4>
                                    <ul class="list-inline">
                                        
                                    </ul>
                                    <p><?php echo $row_user['usr_summary']; ?></p>
                                </div><!-- end col -->
                                
                            </div><!-- end freelancer-wrap -->
                        </div><!-- end col -->

                        <?php } ?>
                    </div><!-- end row -->

                    <div class="loadmorebutton margintop text-center clearfix">
                        <a href="find-freelancer.php" class="btn btn-default">See More</a>
                    </div><!-- end loadmore -->
                </div><!-- end container -->
            </div><!-- end section -->

            <div class="section rb">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="custom_fact_item">
                                <div class="custom_fact_name">
									<?php $row_flctotal=mysql_fetch_array(mysql_query("SELECT COUNT(usr_id) AS flc_total FROM user where usr_mp_id=1 "));?>
                                    <h3 class="stat-count"><?php echo $row_flctotal['flc_total']; ?></h3>
                                    <h6>Freelancers</h6>
                                    <span>Finding work today</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="custom_fact_item">
                                <div class="custom_fact_name">
									<?php $row_emptotal=mysql_fetch_array(mysql_query("SELECT COUNT(usr_id) AS emp_total FROM user where usr_mp_id=2"));?>
                                    <h3 class="stat-count"><?php echo $row_emptotal['emp_total']; ?></h3>
                                    <h6>Employers</h6>
                                    <span>Hiring right now</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="custom_fact_item">
                                <div class="custom_fact_name">
									<?php $row_prjtotal=mysql_fetch_array(mysql_query("SELECT COUNT(prj_id) AS prj_total FROM project"));?>
                                    <h3 class="stat-count"><?php echo $row_prjtotal['prj_total']; ?></h3>
                                    <h6>Sales Projects</h6>
                                    <span>Ready to close</span>
                                </div>
                            </div>
                        </div><!-- end col -->
                    </div><!-- end row -->
                </div><!-- end container -->
            </div><!-- end section -->


<?php 
$h=1;
$res_hp=mysql_query("select * from home_pic order by rand() limit 8");
while($row_hp=mysql_fetch_object($res_hp)) {
			$ctgsql="select * from category where cat_id='".$row_hp->pic_cat."'"; 
			$ctgres=mysql_query($ctgsql);
			$scrow=mysql_fetch_object($ctgres);
?>
<?php if($h==1){?>
                    <div class="row">
<?php } ?>
                        <div class="col-sm-3 col-xs-12">
                            <div class="service-tab">
                                <div class="post-media">
                                    <a href="category.php?sk=<?php echo $row_hp->pic_cat; ?>"><img src="home_pic/<?php echo $row_hp->pic_img; ?>" alt="" class="img-responsive"></a>
                                </div>
                                <div class="service-title">
                                    <h4><a href="category.php?sk=<?php echo $row_hp->pic_cat; ?>"><?php echo ucfirst($scrow->cat_name); ?></a></h4>
                                </div>
                            </div><!-- end service-tab -->
                        </div><!-- end col -->
<?php if($h==4){?>
                    </div><!-- end row -->
                    <hr class="invis hidden-xs">
<?php } ?>
<?php 
$h++;
if($h==5){$h=1;}
} ?>
                    
                </div><!-- end container -->
            </div><!-- end section -->

            <div class="parallax section parallax-off" style="background-image:url('upload/parallax.jpg');">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-6">
                            <div class="section-title text-left clearfix">
                                <h4>Why Cru.Sale?</h4>
                                <p class="lead">We are the global leader in connecting the world's best sales talent with companies focused on accellerating their growth.</p>
                            </div>

                            <div class="about-widget">
                                <h5>Let's face it - Money matters. What to expect:</h5>
                                <ul class="customlist">
                                    <li>Employers post a sales project</li>
                                    <li>Freelancers bid on those projects</li>
                                    <li>Employers select their top choice</li>
                                    <li>The Freelancer accepts</li>
                                    <li>Employer places funds into escrow</li>
                                    <li>Freelancer completes the project successfully (obviously)</li>
                                    <li>Employers releases the funds to the Freelancer</li>
                                    <li>Woo Hoo - 5 Star ratings all around</li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- end row -->
                </div><!-- end container -->
            </div><!-- end section -->

            <div class="section wb">
                <div class="container">
                    <div class="section-title text-center clearfix">
                        <h4>Pricing & Membership Plans</h4>
                        <p class="lead"><?php echo $lang[769]; ?></p>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row pricing-tables text-center">
								<?php
													$back_color=array("red","blue","orange","green","gray");
													$btn_color=array("danger","primary","warning","success","gray");
													
													$sql_mp="select * from membership_plan where mp_status=1";
													$res_mp=mysql_query($sql_mp);
													$col=0;
													while($row_mp=mysql_fetch_object($res_mp)){
														if($col==5){	$col=0;	}
								?>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <div class="pricing-box">
														
														<div class="pricing-price" >
															<p style="padding:20px 0;font-size:20px;"><?php echo stripslashes(ucfirst($row_mp->mp_name)); ?></p>
														</div>
														<!-- end price -->
														
														<div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">
															<div class="panel panel-default">
																<div class="panel-heading" role="tab" id="headingOne">
																	<h4 class="panel-title" style="padding:8px 0;">
																		<p style="color:#000;margin:0 0 0px;"><?php echo $lang[763]; ?>  <?php echo stripslashes(ucfirst($row_mp->mp_freelancerfee)); ?>% </p>
																	</h4>
																</div>
																<!-- end heading -->
																
															</div>
															<!-- end panel -->
															<div class="panel panel-default">
																<div class="panel-heading" role="tab" id="headingOne">
																	<h4 class="panel-title" style="padding:5px 0;">
																		<p style="color:#000;margin:0 0 0px;"><?php echo $lang[764]; ?>  <?php echo stripslashes(ucfirst($row_mp->mp_employerfee)); ?>% </p>
																	</h4>
																</div>
																<!-- end heading -->
																
															</div>
															<!-- end panel -->
															<div class="panel panel-default">
																<div class="panel-heading" role="tab" id="headingOne">
																	<h4 class="panel-title" style="padding:5px 0;">
																		<p style="color:#000;margin:0 0 0px;"><?php echo $lang[765]; ?>  <?php echo stripslashes(ucfirst($row_mp->mp_bidspermonth)); ?></p>
																	</h4>
																</div>
																<!-- end heading -->
																
															</div>
															<!-- end panel -->
															<div class="panel panel-default">
																<div class="panel-heading" role="tab" id="headingOne">
																	<h4 class="panel-title" style="padding:5px 0;">
																		<p style="color:#000;margin:0 0 0px;"><?php echo $lang[395]; ?>  <?php echo stripslashes(ucfirst($row_mp->mp_skills)); ?></p>
																	</h4>
																</div>
																<!-- end heading -->
																
															</div>
															<!-- end panel -->
															<div class="panel panel-default">
																<div class="panel-heading" role="tab" id="headingOne">
																	<h4 class="panel-title" style="padding:5px 0;">
																		<p style="color:#000;margin:0 0 0px;"><?php echo $lang[766]; ?>  <?php echo stripslashes(ucfirst($row_mp->mp_portfoliosize)); ?> <?php echo $lang[800]; ?></p>
																	</h4>
																</div>
																<!-- end heading -->
																
															</div>
															<!-- end panel -->
															<div class="panel panel-default">
																<div class="panel-heading" role="tab" id="headingOne">
																	<h4 class="panel-title" style="padding:5px 0;">
																		<p style="color:#000;margin:0 0 0px;"><?php echo getCurrencySymbol().stripslashes($row_mp->mp_rate); ?>
														<small><?php echo $lang[799]; ?></small></p>
																	</h4>
																</div>
																<!-- end heading -->
																
															</div>
															<!-- end panel -->
															
														</div>
														<!-- end panel-group -->
														<div class="pricing-footer text-center">
														
														</div>
														<!-- end desc -->
													</div>
													<!-- end pricing-box -->
                                </div>
                                <!-- end col -->
								<?php	}	?>

                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div><!-- end container -->
            </div><!-- end section -->

            

<?php include "includes/footer.php"; ?>    