<?php
ob_start();
session_start();
include "common.php";

$prj_id=$_GET['p'];


$_SESSION['last_page']="project.php?p=".$prj_id;

$sql="select * from project where md5(prj_id)='".$prj_id."' or prj_id='".$prj_id."'";
$res=mysql_query($sql);
$row=mysql_fetch_object($res);

/**** code for checking remain bid ****/

if(isset($_SESSION['uid']))
{	
	$sql_tot_bid="select count(*) from bid,user where bd_usr_id=usr_id and bd_usr_id='".$_SESSION['uid']."' and bd_date between DATE_SUB(usr_mem_expiry,INTERVAL 1 MONTH) and usr_mem_expiry";
	$res_tot_bid=mysql_query($sql_tot_bid);
	$row_tot_bid=mysql_fetch_array($res_tot_bid);

	$sql_mem="select * from membership_plan,user where usr_mp_id=mp_id and usr_id='".$_SESSION['uid']."'";
	$res_mem=mysql_query($sql_mem);
	$row_mem=mysql_fetch_object($res_mem);

	$remaining_bid=$row_mem->usr_left_bid;

	$today = date("Y-m-d", strtotime("now"));
	$expiry = date("Y-m-d", strtotime($row->prj_expiry));
}
/**** code for checking remain bid end ****/

/**** Calculation for time left ****/

	$expDate = strtotime($row->prj_expiry);
	$curDate = strtotime(date("Y-m-d H:i:s"));
	$second=$expDate - $curDate;
	
	$min=floor($second/60);
	$sec=$second%60;

	$hr=floor($min/60);
	$min=$min%60;
	$dy=floor($hr/24);
	$hr=$hr%24;
	
/**** Calculation for time left ****/


?>
<?php include "includes/header.php"; ?>

	<<div class="section db" style="background-image:url('upload/parallax_02.jpg');">
                <div class="container">
                    <div class="page-title text-center">
                        <div class="heading-holder">
                            <h1><?php echo $lang[114]; ?></h1>
                        </div>
                        
                    </div>
                </div><!-- end container -->
            </div><!-- end section -->

            <div class="section lb">
                <div class="container">
                    <div class="row">
                        <div class="content col-md-1">
						</div>

                        <div class="content col-md-10">
                            <div class="post-padding">
                                <!--div class="job-title nocover hidden-sm hidden-xs"><h5><?php echo $row_sk->sk_name; ?> <?php echo $lang[275]; ?></h5></div>
                                -->
                                    
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">   
                                            
											<div class="row">
		<div class="col-xs-12">
        <div class="right span3 margin-r30" style="position: relative;">
            <ul class="ribbons right">
<?php
$promo_now="select * from project_promotion_option where ppo_prj_id=".$row->prj_id;
$promo_now2=mysql_query($promo_now);
//$total_promo=mysql_num_rows($promo_now2);
if(mysql_num_rows($promo_now2)>0){
                
                while($promo_row=mysql_fetch_object($promo_now2)) { 
                    $promo_name="select pp_name from project_promotion where pp_id=".$promo_row->ppo_pp_id;
                    $promo_name2=mysql_query($promo_name);
                    $promo_name_row=mysql_fetch_object($promo_name2);
                    $pp_name=$promo_name_row->pp_name;
                ?>
                <li class="<?php echo $pp_name;?>"></li>
      <?php  }} ?>
            </ul>
            </div>
            
            
	<div style="padding-top:25px;"><h2 class="header-txt1-style_1"><?php echo $row->prj_name; ?></h2></div>
		<div>
            <!-- AddThis Button BEGIN -->
            <div class="addthis_toolbox addthis_default_style ">
                <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                <a class="addthis_button_tweet"></a>
                <a class="addthis_button_pinterest_pinit"></a>
                <a class="addthis_counter addthis_pill_style"></a>
            </div>
<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4f1dac4b7590342c"></script>

<?php
	if($_SESSION['uid']!=''){
		$chk_bid_sql="select * from bid where bd_usr_id='".$_SESSION['uid']."' and bd_prj_id='".$row->prj_id."'";
		$chk_bid_res=mysql_query($chk_bid_sql);
			
		$chk_bid_sql2="select * from temp_proj_award,bid where tpa_bd_id=bd_id and bd_prj_id='".$row->prj_id."'";
		$chk_bid_res2=mysql_query($chk_bid_sql2);

		if(mysql_num_rows($chk_bid_res)==0 && mysql_num_rows($chk_bid_res2)==0)
		{
			
			if($row->prj_usr_id != $_SESSION['uid'] && ($row->prj_status=="open" && $expDate>$curDate)){
				if($remaining_bid>0 && $today<=$expiry){
						
					if($second>0) { ?>
					<div class="pg-header-rgt-col" align="right" style="margin-bottom:20px;margin-right:10px;margin-top:5px;">
                    <?php	if(profileCompleteness($_SESSION['uid'])>=40){	?>
                    	<a href="placebid.php?p=<?php echo $row->prj_id; ?>" class="btn btn-success"><?php echo $lang[486]; ?></a>
                   <?php	}else{	?>
	                    <div class="alert alert-warning" style="text-align:left">
							<?php	echo $lang[723];	?>
                            <ul>
                            <li><a href="profile.php"><?php echo $lang[724]; ?></a></li>
                            </ul>
						</div>
                   <?php	}	?>
                    
                    </div>
                    <?php } ?>
                    
				<?php } else { ?>
    	            <div class="pg-header-rgt-col" align="right" style="margin-bottom:25px;"><a href="membership.php" class="btn btn-success"><?php echo $lang[487]; ?></a></div>
                <?php 		} 
				}
			}
		}
		
		?>
                <!-- AddThis Button END -->
                  
     </div>
		
                    <!-- Place of previous bid button -->
		<!--</div>-->
        
        </div>
   </div>
        
	<div class="clearfix bid-box-str">
    
		<div class="bids-detail-col ">
        <table class="table  table-bordered" style="background-color:#E8F8FF">
			<tbody>
				<tr>
                <?php
				$sql_ba="select count(*),avg(bd_amount) from bid where bd_prj_id='".$prj_id."'";
		
				$res_ba=mysql_query($sql_ba);
				$bd=0;
				if(mysql_num_rows($res_ba)>0)	{	$bd=1;		}
    				$row_ba=mysql_fetch_array($res_ba);
				?>
					<td class="center">
                    <div>
						<p class="bid-margin"><?php echo $lang[488]; ?></p>
						<p class="bid-price-txt"><?php if($bd==1){ echo $row_ba[0]; } else { echo "0"; } ?></p>
					</div>
                    </td>
					<td>
                    <div>
						<p class="bid-margin"><?php echo $lang[489]; ?> (<?php echo getCurrencyCode(); ?>)</p>
						<p class="bid-price-txt"><?php if($bd==1){ echo getCurrencySymbol().number_format($row_ba[1],0); } else { echo "-"; } ?></p>
					</div>
                    </td>
					<td class="hidden-xs">
                    <div>
                            <?php
						$sql_pb="select * from project_budget,project where pb_prj_id='".$row->prj_id."' and pb_prj_id=prj_id and pb_status=1";
						$res_pb=mysql_query($sql_pb);
						$row_pb=mysql_fetch_object($res_pb);
					?>
						<p class="bid-margin"><?php echo $lang[490]; ?> (<?php echo getCurrencyCode(); ?>)</p>
								<p class="bid-price-txt">
                                <?php
                                if($row_pb->pb_type=='hourly') {
						echo getCurrencySymbol().number_format($row_pb->pb_rate,0)." / ".$lang[437];
					}else { 
						echo getCurrencySymbol().number_format($row_pb->pb_minprice,0)." - ".getCurrencySymbol().number_format($row_pb->pb_maxprice,0);
					}
					?>
                                </p>
					</div>
                    </td>
                    <td class="center">
                    <div class=" ">
                         <h4><b><?php if($row->prj_status=="open" && $expDate>$curDate) { 

							$sql_pstat="select * from temp_proj_award,bid where tpa_bd_id=bd_id and bd_prj_id='".$row->prj_id."'";
							$res_pstat=mysql_query($sql_pstat);
							if(mysql_num_rows($res_pstat)>0){	echo $lang[491]; 	}else{	echo $lang[492];	}	?></b></h4>
	                       
					    	<div id="bid_time_left" <?php if($dy<1){ ?>style="color:#F00;font-size:12px;"<?php }else{ ?>style="color:#090;font-size:12px;"<?php } ?>>
							<?php echo datetimeDifference(date("Y-m-d H:i:s"),$row->prj_expiry)." ".$lang[669]; ?>
                            </div>
		                 <?php }else{	?>	<h4><b><span style="color:#F00"><?php echo $lang[493];	?></span></b></h4> <?php	} ?>
	        			</div>
           
                    </td>
				</tr>
			</tbody>
		</table>
						
	</div>
    
            <?php
            $sql_us="select * from user where usr_id=".$row->prj_usr_id;
			$res_us=mysql_query($sql_us);
			$row_us=mysql_fetch_object($res_us);
		?>
        
        <div class="col-xs-12 col-sm-4 widget-container-span ui-sortable">
			<div class="widget-box">
				<div class="widget-header" align="left">
					<h5 class="smaller"><b><?php echo $lang[494]; ?>&nbsp;&nbsp;</b><a href="profile.php?u=<?php echo md5($row_us->usr_id); ?>"><?php echo $row_us->usr_name; ?></a></h5>
                    <?php
                        $res_cntry=mysql_query("select * from country where cn_id=(select ct_cn_id from city where ct_id='".$row_us->usr_ct_id."')");
						if(mysql_num_rows($res_cntry)>0)
						{
							$row_cntry=mysql_fetch_object($res_cntry);
						?>
						<span class="bidder-country-flag">&nbsp;<img src="images/country_flag/<?php echo $row_cntry->cn_name; ?>.png" alt="" title="<?php echo $row_cntry->cn_name; ?>" /></span>
                        <?php } ?>
					<!--<div class="widget-toolbar">
						<span class="label label-success">
												16%
							<i class="icon-arrow-up"></i>
						</span>
					</div>-->
				</div>
				<div class="widget-body">
					<div class="widget-main padding-6" style="min-height:75px;">
                    <?php if($row_us->usr_image==''){ ?>
					<img src="images/contractor-img.jpg" alt="" width="76" height="75" align="left" />
                        <?php }else{ ?>
                    <img src="images/users/<?php echo $row_us->usr_image; ?>" width="76" height="75" align="left">
                    
                        <?php } ?>
                        <div class="ns_ratings-new" style="margin-left:90px; margin-bottom:10px; margin-top:10px;">
                        <?php
							$sql_rt_rv="select count(*),sum(rr_work_quality),sum(rr_communication),sum(rr_expertise), sum(rr_work_hire_again), sum(rr_professionalism), sum(rr_completionrate),count(rr_review) from review_rating where rr_to_usr='".$row->usr_id."'";

							$res_rt_rv=mysql_query($sql_rt_rv);
							$row_rt_rv=mysql_fetch_array($res_rt_rv);

							$avg_rt=0;
							if($row_rt_rv[0] != 0)
							{
								$avg_rt=((($row_rt_rv[1]+$row_rt_rv[2]+$row_rt_rv[3]+$row_rt_rv[4]+$row_rt_rv[5])+($row_rt_rv[6]*10)))/$row_rt_rv[0]/6;
							}

						?>
							<div class="ns_ratings-new ns_active-stars" style="width:<?php echo $avg_rt*10; ?>%;"></div>
                            <span></span>
                            <div style="padding-left:80px;"><?php echo number_format($avg_rt,1); ?>&nbsp;<a href="review.php?u=<?php echo md5($row_us->usr_id); ?>" class="review">(<?php if($row_rt_rev[7]==''){echo "0"; }else{ echo $row_rt_rev[7]; } ?>&nbsp;<?php echo $lang[323]; ?>)</a></div>
                        </div>
                    <ul class="ns_verify ns_margin-tops" style="margin-left:90px;margin-bottom:10px;margin-top:10px;">
                        <span class="hoverable" hover_type="upgrade_now">
                        <?php
					$sql_pver="select count(*) from transaction where tr_from_id='".$row_us->usr_id."' or tr_to_id='".$row_us->usr_id."'";
					$res_pver=mysql_query($sql_pver);
					$row_pver=mysql_fetch_row($res_pver);
				?>
                        <li class="ns_payment<?php if($row_pver[0]>0){ ?> ns_active<?php } ?>"></li>
                        <li class="ns_email<?php if($row_us->usr_emailVerified == '1'){	?> ns_active<?php }	?>"></li>
                        <!--<li class="ns_profile"></li>-->
                        <div class="generic_hover upgrade_now" style="display: none; width: 150px;">
                            <div class="generic_hover_arrow" style="top: 14px; left: -10px; "></div>
                            <div><?php echo $lang[495]; ?>
                            <div>&nbsp;&nbsp;<?php echo $lang[496]; ?></div>
                            <div>&nbsp;&nbsp;<?php echo $lang[497]; ?></div>
                            </div>
                            </div>
                        </span>
                    </ul>
                   
                   
      <?php	if($_SESSION['uid']!='' && $row_us->usr_id != $_SESSION['uid']){	
					
			$chk_flw_sql="select * from following where flw_followed='".$row_us->usr_id."' and flw_followed_by='".$_SESSION['uid']."'";
			$chk_flw_res=mysql_query($chk_flw_sql);
			if(mysql_num_rows($chk_flw_res)<=0){
	?> <div style="margin-left:90px;margin-bottom:10px;" id="followUser"><a class="btn btn-minier btn-purple" data-action="on" onClick="followUser(<?php echo $row_us->usr_id; ?>,<?php echo $_SESSION['uid']; ?>)"><?php echo $lang[725]; ?></a></div>
          <?php } ?>
    <?php } ?>
                    
						
					</div>
				</div>
			</div>
		</div>
			
		</div>
			
            
            
            <div class="profile-user-info profile-user-info-striped">
				<div class="profile-info-row">
					<div class="profile-info-name" style="font-weight:bold;width:250px;"> <?php echo $lang[498]; ?> </div>
					<div class="profile-info-value" style="" align="left">
						<span class="" ><?php echo stripslashes($row->prj_details); ?></span>
					</div>
				</div>

				<div class="profile-info-row">
					<div class="profile-info-name" style="font-weight:bold;width:250px;"> <?php echo $lang[499]; ?> </div>
					<div class="profile-info-value" style="" align="left">
						<span class="" ><?php echo $row->prj_id; ?></span>
					</div>
				</div>

				<div class="profile-info-row">
					<div class="profile-info-name" style="font-weight:bold;width:250px;"> <?php echo $lang[500]; ?> </div>
					<div class="profile-info-value" style="" align="left">
						<span class="" ><?php echo " ".ucfirst($row_pb->pb_type); ?></span>
					</div>
				</div>

				<div class="profile-info-row">
					<div class="profile-info-name" style="font-weight:bold;width:250px;"> <?php echo $lang[501]; ?> </div>
					<div class="profile-info-value" style="" align="left">
						<span class=""> <?php
							$sql_sk="select * from skills where sk_id in(select ps_sk_id from project_skill where ps_prj_id=".$row->prj_id.")";
							$res_sk=mysql_query($sql_sk);
							$c=0;
							while($row_sk=mysql_fetch_object($res_sk)){	?>
				            <?php if($c>0){ ?>,&nbsp;<?php } ?>
						        <a style="text-decoration:none" href="category.php?sk=<?php echo $row_sk->sk_id; ?>"><?php echo $row_sk->sk_name; ?></a>
							<?php	$c++;	}	?>
                   		</span>
					</div>
				</div>
                <?php
					$sql_fl1="select * from project_files where pfl_pr_id=".$row->prj_id;
					$res_fl1=mysql_query($sql_fl1);
	
					if(mysql_num_rows($res_fl1)>=1)
					{
						?>
                <div class="profile-info-row">
					<div class="profile-info-name" style="font-weight:bold;width:250px;"> <?php echo $lang[502]; ?> </div>
					<div class="profile-info-value"  style="" align="left">
						<span class="" ><?php while($row_fl1=mysql_fetch_object($res_fl1)){		?>
 		    		    <a target="_blank" class="" href="project_files/<?php echo $row_fl1->pfl_filename ; ?>"><?php echo $row_fl1->pfl_filename ; ?></a>
						<?php	}	?></span>
					</div>
				</div>
                <?php } ?>  
                
			</div>
             
            

			<div class="public-clarifi-sec">
				<div class="row">
							<div class="col-xs-12">
					<div class="lft-col" style="width:250px;"><h4><?php echo $lang[503]; ?></h4></div>
                    
                    <!--<a href="#" class="btn btn-app btn-primary no-radius">
												<i class="icon-edit "></i>
												Edit
												
											</a>-->
                    
                        <?php if($_SESSION['uid']!=''){ ?>
					<div class="rgt-col" id="btnMsgP" align="right"><a href="javascript:showhideMessage(1)" class="btn btn-info"><i class="icon-edit "></i><?php echo $lang[504]; ?></a></div>
                        <?php } ?>
                 		<div class="rgt-col" id="btnMsgM" style="display:none;" align="right"><a href="javascript:showhideMessage(0)" class="btn btn-info"><i class="icon-edit "></i><?php echo $lang[504]; ?></a></div>
					</div>
                    </div>
					<div>
                    	<!--<img src="images/clarification-img.jpg" alt="" />-->
      <?php
		$sql_cmt="select * from comment,user where usr_id=cmt_usr_id and cmt_prj_id=".$row->prj_id." order by cmt_id desc";
		$res_cmt=mysql_query($sql_cmt);
		$num_cmt=mysql_num_rows($res_cmt);
	?>
            <span id="showHideClarificationBoard" class="ns_left ns_pointer ns_pad-5">
                <p class="msg_count ns_left"><span class="count ns_collapse" id="tot_msg"><?php echo $num_cmt; ?></span> <?php echo $lang[505]; ?></p>
                
                   <!-- <span class="ns_icon-16 ns_margin-l ns_collapse"></span>-->
            </span>
            <div id="messagebox" class="ns_add-message" style="display:none;">
          
			<?php if($_SESSION['img']=='' || $_SESSION['img']==NULL){?>
					<img class="ns_user-logo" src="images/users/unknown.png" border="0" width="60px" height="60px" />
			<?php } else { ?>
				<img class="ns_user-logo" src="images/users/<?php echo $_SESSION['img']; ?>" border="0" width="60px" height="60px" />
			<?php } ?>
            
				<!--<img class="ns_user-logo" src="project_files/profile_logo_4033222.jpg" border="0" height="60px" width="60px">-->
                <form class="ns_form">
                    <textarea class="new_message" name="cmt_text" id="cmt_text"></textarea>
                    
                <div class="ns_left" style="color: red">
                    <?php echo $lang[506]; ?>
                </div>
                    
                <div class="ns_right">
                    <a href="javascript:postMsg(<?php echo $_SESSION['uid'];?>,<?php echo $prj_id; ?>)" class="btn btn-sm btn-primary"><?php echo $lang[507]; ?></a>
                </div>
                </form>
                <div class="ns_clear"></div>
            </div>
               <ul class="ns_messages clarification_board" id="all_cmt">
                
                <div class="row">
					<div class="col-xs-12">
						<div class="row">
                <?php
				while($row_cmt=mysql_fetch_object($res_cmt)){
				?>
                
                <div class="col-xs-12 col-sm-6 widget-container-span">
					<div class="widget-box">
						<div class="widget-header" align="left">
							<h5><a href="profile.php?u=<?php echo md5($row->usr_id); ?>"><?php echo $row_cmt->usr_name; ?></a></h5>
                            <?php
                        $res_cntry=mysql_query("select * from country where cn_id=(select ct_cn_id from city where ct_id='".$row_cmt->usr_ct_id."')");
						if(mysql_num_rows($res_cntry)>0)
						{
							$row_cntry=mysql_fetch_object($res_cntry);
						?>
						<span class="bidder-country-flag">&nbsp;<img src="images/country_flag/<?php echo $row_cntry->cn_name; ?>.png" alt="" title="<?php echo $row_cntry->cn_name; ?>" /></span>
                        <?php } ?>
							<div class="widget-toolbar">
        	                    <?php	/*$dy=dateDifference($row_cmt->cmt_updated_date,date("Y-m-d"));*/	?>
		                        <?php /*if($dy==0){ echo $lang[73]; }else{ echo $dy.$lang[74]; }*/ ?>
                                <?php echo datetimeDifference($row_cmt->cmt_updated_date,date("Y-m-d h:i:s")).$lang[511]; ?>
							</div>
						</div>
						<div class="widget-body">
							<div class="widget-main" style="min-height:80px;">
                            <?php	if($row_cmt->usr_image == ''){ ?>
								<img src="images/unknown.jpg" width="88" height="79" align="left">
								<?php	} else { 	?>
	                            <img src="images/users/<?php echo $row_cmt->usr_image; ?>" alt="<?php echo $row_cmt->usr_name; ?>" class="ns_user-logo" border="0" width="88" height="79" align="left"/>
                            <?php	}	?>
								<div style="margin-left:110px;" align="left">
									<p class="alert alert-info" style="min-height:47px;"><?php echo $row_cmt->cmt_text; ?></p>
                                </div>
							</div>
						</div>
					</div>
				</div>
                
                <?php } ?>
                </div>
                </div></div>
            </ul>    
                    
                    
            </div>
		</div>
				
                <?php
				$act_award=true;
				$sql_chk="select * from bid where bd_prj_id='".$row->prj_id."' and bd_status=1";
				$res_chk=mysql_query($sql_chk);
				if(mysql_num_rows($res_chk)==1)
				{
					$act_award=false;
					$row_chk=mysql_fetch_object($res_chk);
				}
				
				$sql_pp_seal="select * from project_promotion_option where ppo_prj_id='".$row->prj_id."' and  ppo_pp_id=(select pp_id from project_promotion where pp_name='sealed' and pp_status='1') and ppo_status='1'";
				$res_pp_seal=mysql_query($sql_pp_seal);
						
				if(mysql_num_rows($res_pp_seal)>0)
				{
					$sql_bid="select * from bid,user,project where bd_prj_id=prj_id and bd_prj_id=".$row->prj_id." and bd_usr_id=usr_id and (bd_usr_id='".$_SESSION['uid']."' or prj_usr_id='".$_SESSION['uid']."') order by bd_uplift desc, bd_date";
				}
				else
				{
					$sql_bid="select * from bid,user where bd_prj_id=".$row->prj_id." and bd_usr_id=usr_id order by bd_uplift desc, bd_date";
				}

					$res_bid=mysql_query($sql_bid);
					$num_bid=mysql_num_rows($res_bid);
				?>
                
				
	<div style="margin-top:25px;">
		<table class="table  table-bordered">
        <thead>
			<tr>
            	<th><?php echo $lang[508]; ?> (<?php if($bd==1){ echo $row_ba[0]; } else { echo "0"; } ?>)</th>
                <th><?php echo $lang[509]; ?></th>
                <th><?php echo $lang[510]; ?> (<?php echo getCurrencyCode(); ?>)</th>
            </tr>
        </thead>
        <tbody>
            <?php	while($row_bid=mysql_fetch_object($res_bid)){	?>
               <tr <?php if($row_bid->bd_highlight=='1'){ ?> bgcolor="#FFFFD9" <?php } ?>>
			<td  width="52%">
                <div class="widget-main" style="margin-bottom:-25px;">
					<img src="images/users/<?php if($row_bid->usr_image==''){ echo "unknown.png"; } else { echo $row_bid->usr_image; } ?>" align="left" height="79" width="88">
					<div style="margin-left:110px;" align="left">
                    
                    	<p class="alert alert-info" style="min-height:47px;">
                        <span class="bidder-name"><a href="profile.php?u=<?php echo md5($row_bid->usr_id); ?>"><?php echo $row_bid->usr_name; ?></a></span>
                        <?php
                        $res_cntry=mysql_query("select * from country where cn_id=(select ct_cn_id from city where ct_id='".$row_bid->usr_ct_id."')");
						if(mysql_num_rows($res_cntry)>0)
						{
							$row_cntry=mysql_fetch_object($res_cntry);
						?>
						<span class="bidder-country-flag"><img src="images/country_flag/<?php echo $row_cntry->cn_name; ?>.png" alt="" title="<?php echo $row_cntry->cn_name; ?>" /></span>
                        <?php } ?>
                        <br/>
						<span class="bidding-date"><?php 
					$diff=dateDifference($row_bid->bd_date,date("Y-m-d h:i:s"));
					if($diff>0){
						if(round($diff/365)>=1){	echo round($diff/365).$lang[704];	}
						else if($diff/30>=1){	echo round($diff/30).$lang[705];	}
						else{	echo $diff.$lang[74];	}
					}
					else {	echo $lang[354];	}
				?>   
                        </span>
                        
                        </p>
						
                    </div>
                    <div align="left">
                    	<p class="alert alert-info" style="min-height:47px;"><?php echo $row_bid->bd_details; ?>
                        </p>
                    </div>
				</div>
                <div class="bidder-txt-con">
					<div class="bidder-body-text"><p></p></div>
					 <div>
						<a href="profile.php?u=<?php echo md5($row_bid->usr_id); ?>" class="btn"><?php echo $lang[387]; ?></a>
					
                
                 <?php if($row->prj_usr_id==$_SESSION['uid'] && $row->prj_status=="open"){ 
	
					$sql_tpa="select * from temp_proj_award where tpa_bd_id='".$row_bid->bd_id."'";
					$res_tpa=mysql_query($sql_tpa);
					if(mysql_num_rows($res_tpa)>0){?>
						<a class="btn disabled btn-info" ><span><?php echo $lang[513]; ?></span></a>
					<?php	}else{	?>
						<a class="btn" onClick="projAward(<?php echo $row_bid->bd_id; ?>)"><span><font size="0.5"><?php echo $lang[512]; ?></font></span></a>	
					<?php	}	 ?> 
                 
                 
                 <!---->  
    
     <!---->

		<?php }else if($row_bid->bd_usr_id==$_SESSION['uid']){ 
		
		$sql_tpa="select * from temp_proj_award where tpa_bd_id='".$row_bid->bd_id."'";
		$res_tpa=mysql_query($sql_tpa);
		if(mysql_num_rows($res_tpa)>0){	
			$row_tpa=mysql_fetch_object($res_tpa);
		?>
		&nbsp;&nbsp;
        <input type="button" onClick="actdecProj(<?php echo $row_tpa->tpa_id; ?>,'accept')" value="<?php echo $lang[514]; ?>" class="btn btn-sm btn-success"/>&nbsp;<input type="button" onClick="actdecProj(<?php echo $row_tpa->tpa_id; ?>,'decline')" class="btn btn-sm btn-danger" value="<?php echo $lang[515]; ?>"/>
		<?php	}?>
<!--		<a style="float: right; margin: 16px 18px 0px 0px;" class="awd_btn gaf-button-green btn-10p5px-bold" bidinfo="bid22276564"><span>AWARDED</span></a>-->
		<?php 		?>
        
        <?php }?>
               </div>									
		</div>
	</td>
	<td width="24%">
    <div class="">
		<div class="widget-main" style="min-height:80px;">
         <?php
		$sql_rt_rev_b="select count(*),sum(rr_work_quality),sum(rr_communication),sum(rr_expertise), sum(rr_work_hire_again), sum(rr_professionalism), sum(rr_completionrate),count(rr_review) from review_rating where rr_to_usr='".$row_bid->bd_usr_id."'";
		$res_rt_rev_b=mysql_query($sql_rt_rev_b);
		$row_rt_rev_b=mysql_fetch_array($res_rt_rev_b);

		if($row_rt_rev_b[0]>0){
			$avg_rt_b=((($row_rt_rev_b[1]+$row_rt_rev_b[2]+$row_rt_rev_b[3]+$row_rt_rev_b[4]+$row_rt_rev_b[5])+($row_rt_rev_b[6]*10)))/$row_rt_rev_b[0]/6;
		}else{
			$avg_rt_b=0;
		}
	?>
		<div class="ns_ratings-new">
        	<div class="ns_ratings-new ns_active-stars" style="width:<?php echo $avg_rt_b*10; ?>%;"></div>
			<!--<p><img src="images/earning-img.png" alt="" /></p>-->
			<div style="padding-left:80px;width:200px;"><a href="#" ><?php echo $row_rt_rev_b[7]; ?> <?php echo $lang[516]; ?></a></div>
        </div>
		<p class="complete-txt" style="margin-top:10px;">
            <?php 
			if($row_rt_rev_b[0]>0){
                    echo number_format(((($row_rt_rev_b[6]*10)/$row_rt_rev_b[0])*10),1); 
			}else{
                    echo "0";
			}
		?>% <?php echo $lang[365]; ?></p>
            
            <?php 
			if($row->prj_status=="open" && $expDate>$curDate){
				if($row_bid->bd_usr_id==$_SESSION['uid'] && $row_bid->bd_uplift=='0'){ 
            
            $row_bo1=mysql_fetch_object(mysql_query("select * from bidding_option where bo_id='1'"));
                 ?>
            <a  style="padding-bottom:5px;margin:1px 1px 1px 1px;" class="btn btn-sm" href="javascript:bidUplift('<?php echo $row_bid->bd_id; ?>','1','<?php echo $row_bo1->bo_amount; ?>')"><?php echo $lang[696]; ?>&nbsp;<i class="icon-arrow-up icon-on-right"></i></a>
            <?php } 
			}
			?>
            
            <?php
			if($row->prj_status=="open" && $expDate>$curDate){
			if($row_bid->bd_usr_id==$_SESSION['uid'] && $row_bid->bd_highlight=='0'){ 
            $row_bo2=mysql_fetch_object(mysql_query("select * from bidding_option where bo_id='2'"));    
            ?>
            <a style="padding-bottom:5px;margin:1px 1px 1px 1px;" class="btn btn-sm" href="javascript:bidHightight('<?php echo $row_bid->bd_id; ?>','2','<?php echo $row_bo2->bo_amount; ?>')"><?php echo $lang[697]; ?></a>
            <?php } 
			}
			?>
            <?php if($row_bid->bd_usr_id==$_SESSION['uid'] || $row->prj_usr_id==$_SESSION['uid']){ ?> <!--create-message-btn-->
            <a  style="padding-bottom:5px;margin:1px 1px 1px 1px;" class="btn btn-primary btn-sm" href="javascript:sendMessage('<?php echo $row_bid->bd_id; ?>');" ><?php echo $lang[353]; ?></a>
            <?php } ?>
	            </div>
            </div>
		</td>           
		<td width="24%">
			<span class="bid-price-txt"><?php echo getCurrencySymbol().$row_bid->bd_amount; ?></span>
			<span class="bid-date"><?php echo $lang[518].$row_bid->bd_days.$lang[517]; ?> </span>
		</td>
	</tr>
	<?php } ?>
    </tbody>
	</table>	

</div>
											
										</div>	
									</div>
                            </div><!-- end row -->
                                <hr class="invis">
									
								
                            </div><!-- end post-padding -->
                        </div><!-- end col -->
						<div class="content col-md-1">
						</div>
                    </div><!-- end row -->  
                </div><!-- end container -->
            </div><!-- end section -->

<script type="text/javascript" src="js/jquery-1.8.1.min.js"></script>
<script src="new_design/js/bootbox.min.js"></script>
<script language="javascript">
function showhideMessage(val)
{
	if(val=='1')
	{
		$('#messagebox').show('slow');
		$('#btnMsgP').hide();
		$('#btnMsgM').show();
	}
	else if(val=='0')
	{
		$('#messagebox').hide('slow');
		$('#btnMsgP').show();
		$('#btnMsgM').hide();		
	}
}
function postMsg(uid,pid)
{
	var text = $('textarea#cmt_text').val(); 
	$.get("postMsg.php", { uid:uid,pid:pid,text:text } ,function(data){	
		showhideMessage('0');
		showAllComment(pid);
	});	
}
function showAllComment(id)
{

	$.post("ajax-file/showAllComment.php", {id:id}, function(data){	
		newData=data.split('|');
		$('#all_cmt').html(newData[0]);	
		$('#tot_msg').html(newData[1]);	
	});	
}
function projAward(bid)
{
	$.get("projAward.php", {bid:bid}, function(data){	window.location.reload();	});	
}
function followUser(fld,fldby)
{
	bootbox.confirm("<?php echo $lang[719]; ?>", function(result) {
		if(result)
		{
			$.get("ajax-file/followUser.php", {fld:fld,fldby:fldby}, function(data){	if(data==1){	$("#followUser").css("display","none");	}	});	
       	}
	 });
	

}
function actdecProj(tpa_id,stat)
{
	//$.noConflict();
	$.get("projAward.php", {tpa_id:tpa_id,stat:stat}, function(data){	window.location.reload();	});
}
function sendMessage(id)
{
    window.open("private.php?b="+id,'','width=640, height=540, resizable=yes, left=100,top=100,menu=no, toolbar=no,scrollbars=yes');
}
function bidUplift(bd,bo,amt)
{
	bootbox.confirm("<?php echo getCurrencySymbol() ?>"+amt+"<?php echo $lang[716]; ?>", function(result) {
		if(result)
		{
			location.href="bidUplift.php?bd="+bd+"&amt="+amt;
       	}
	 });
}
function bidHightight(bd,bo,amt)
{
	 bootbox.confirm("<?php echo getCurrencySymbol() ?>"+amt+"<?php echo $lang[717]; ?>", function(result) {
		if(result)
		{
			location.href="bidHighlight.php?bd="+bd+"&amt="+amt;
       	}
	 });
}
</script>
	<!--<div class="clearfix">-->


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