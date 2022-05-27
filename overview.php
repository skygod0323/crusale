<script type="text/javascript">
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
</script>
<?php if($row->usr_type=="Both"){  ?>
    <div class="ns_right ns_margin-10">
        <a href="javascript:show_FreelancerOverviewDetails()" id="showFreelancerOverviewDet" btntype="seller" class="ns_toggle-btn ns_btn-left ns_left ns_selected"><?php echo $lang[64]; ?></a>
        <a href="javascript:show_EmployerOverviewDetails()" id="showEmployerOverviewDet" btntype="buyer" class="ns_toggle-btn ns_btn-right ns_left"><?php echo $lang[60]; ?></a>
        <div class="ns_clear"></div>
    </div>
<?php } ?>
<div id="freelancer_overview_details" <?php if($row->usr_type=="Employer"){ ?>style="display: none;" <?php } ?>>
          <div class="portfolio-body-nav-section">
               
                <div class="activity-box-str clearfix">
			<div class="activity-col">
				<h4><?php echo $lang[364]; ?></h4>
				<div class="clearfix">
					<div class="activity-lft-col">
						<ul>
							<li>
                        <?php
                            $tot_sql_crf="select * from review_rating,project,bid,user where prj_id=rr_prj_id and prj_id=bd_prj_id and prj_usr_id=usr_id and bd_usr_id='".$row->usr_id."' and rr_from_usr=prj_usr_id and rr_to_usr='".$row->usr_id."' and bd_status=1";

                            $tot_res_crf=mysql_query($tot_sql_crf);
                            $tot_row_crf=mysql_num_rows($tot_res_crf);
				
                            $sql_crf="select * from review_rating,project,bid,user where prj_id=rr_prj_id and prj_id=bd_prj_id and prj_usr_id=usr_id and bd_usr_id='".$row->usr_id."' and rr_from_usr=prj_usr_id and rr_to_usr='".$row->usr_id."' and bd_status=1 and rr_completionrate='1'";

                            $res_crf=mysql_query($sql_crf);
                            $row_crf=mysql_num_rows($res_crf);
				
				?>
			<div class="activity-txt-col"><?php echo $lang[365]; ?></div>
			<div class="activity-percent-col"><?php if($tot_row_crf=='0'){	echo "-";	}else{	echo (($row_crf*100)/$tot_row_crf)."%";	}	?></div>
							</li>
							<li>
                        <?php
				$otim_sql_crf="select * from review_rating,project,bid,user where prj_id=rr_prj_id and prj_id=bd_prj_id and prj_usr_id=usr_id and bd_usr_id='".$row->usr_id."' and rr_from_usr=prj_usr_id and rr_to_usr='".$row->usr_id."' and bd_status=1 and rr_completionrate='1' and rr_updated_date <= prj_expiry";

				$otim_res_crf=mysql_query($otim_sql_crf);
				$otim_row_crf=mysql_num_rows($otim_res_crf);
				?>
							 	<div class="activity-txt-col"><?php echo $lang[366]; ?></div>
                                                <div class="activity-percent-col"><?php if($tot_row_crf=='0'){	echo "-";	}else{	echo (($otim_row_crf*100)/$tot_row_crf)."%";	}	?></div>
								</li>
							</ul>
						</div>
						<div class="activity-rgt-col">
							<ul>
<!--								<li>
								 	<div class="activity-txt-col">On Time   </div>
									<div class="activity-percent-col">100%</div>
								</li>-->
								<li>
                        <?php
				$rhr_sql_crf="select * from review_rating,project,bid,user where prj_id=rr_prj_id and prj_id=bd_prj_id and prj_usr_id=usr_id and bd_usr_id='".$row->usr_id."' and rr_from_usr=prj_usr_id and rr_to_usr='".$row->usr_id."' and bd_status=1 and rr_completionrate='1' and rr_work_hire_again='1'";

				$rhr_res_crf=mysql_query($rhr_sql_crf);
				$rhr_row_crf=mysql_num_rows($rhr_res_crf);
				?>
								<div class="activity-txt-col"><?php echo $lang[367]; ?></div>
								<div class="activity-percent-col"><?php if($tot_row_crf=='0'){	echo "-";	}else{	echo (($rhr_row_crf*100)/$tot_row_crf)."%";	}	?></div>
								</li>
							</ul>
						</div>
					</div>
				</div>
                
				<div class="my-skill-col">
					<h4><?php echo $lang[368]; ?> </h4>
						<div class="clearfix">
                                        <?php
                                        $sql_usk="select * from user_skills,skills where usk_sk_id=sk_id and usk_usr_id='".$row->usr_id."'";
                                        $res_usk=mysql_query($sql_usk);
                                        if(mysql_num_rows($res_usk)){
                                        ?>
						<ul>
                                        <?php while($row_usk=mysql_fetch_object($res_usk)){ ?>
							<li><!--<img src="images/bullet-1.png" alt="" />&nbsp;&nbsp;--><?php echo $row_usk->sk_name; ?></li>
                                        <?php } ?>
        <!--	<li><img src="images/bullet-6.png" alt="" />&nbsp;&nbsp;Other Skills</li>-->
						</ul>
                                        <?php } ?>
<!--								<div class="pic-chart-col"><img src="images/pie-chart.png" alt="" /></div>-->
								</div>
							</div>
						</div>
</div>

			<div class="bidding-info-col">
				<div class="tabber-nav_2">
                            <ul>
					<li class="tabber-nav-normal_2"><?php echo $lang[369]; ?></li>
					<li><?php echo $lang[345]; ?></li>
					<li><?php echo $lang[370]; ?></li>
                            </ul>
				</div>
				<div class="">
				<div class="tabber-con-area_2">
					<div class="bid-detail" id="FreelancerCompletedWork">
						<ul>
     <?php
		$sql_fcw="select * from review_rating,project,bid,user where prj_id=rr_prj_id and prj_id=bd_prj_id and prj_usr_id=usr_id and bd_usr_id='".$row->usr_id."' and rr_from_usr=prj_usr_id and rr_to_usr='".$row->usr_id."' and bd_status=1 and rr_completionrate='1' order by bd_deadline desc limit 5";
		$res_fcw=mysql_query($sql_fcw);
		if(mysql_num_rows($res_fcw)>0){ 
			while($row_fcw=mysql_fetch_object($res_fcw)){
      ?>    
			<li>
				<div style="padding-bottom:10px;">           
    				 <span class="t-txt"><a href="project.php?p=<?php echo $row_fcw->prj_id; ?>"><?php echo $row_fcw->prj_name; ?></a></span>
				 <span class="p-txt"><?php echo getCurrencySymbol().number_format($row_fcw->bd_amount,2)."&nbsp;".getCurrencyCode(); ?></span>
                        <!--<span><img src="images/star-rating.png" alt="" /></span>-->
				</div>
				<div class="clearfix">
					<div class="work-txt-col">
                                  <p><?php echo stripslashes($row_fcw->prj_details);?></p>
                                  <div class="days_txt1"><?php echo stripslashes($row_fcw->prj_details);?></div>
                              </div>	
				</div>
				</li>
                         <?php }    
            }else{     ?>
               <li><div style="padding-bottom:10px;"><?php echo $row->usr_name; ?>&nbsp;<?php echo $lang[371]; ?></div></li>                                
         <?php } ?>
									
		</ul>
	</div>
	<div class="bid-detail" id="FreelancerWorkInProgress">
		<ul>
             <?php
			$sql_fwp="select * from project,bid,user where bd_prj_id=prj_id and prj_usr_id=usr_id and bd_usr_id='".$row->usr_id."' and bd_status=1 and prj_status='running' and prj_id not in(select rr_prj_id from review_rating where rr_from_usr=prj_usr_id) order by bd_deadline desc limit 5";
			$res_fwp=mysql_query($sql_fwp);
			if(mysql_num_rows($res_fwp)>0){
				while($row_fwp=mysql_fetch_object($res_fwp)){
		?>
		<li>
			<div style="padding-bottom:10px;">           
				 <span class="t-txt"><a href="project.php?p=<?php echo $row_fwp->prj_id; ?>"><?php echo $row_fwp->prj_name; ?></a></span>
				 <span><?php echo getCurrencySymbol().number_format($row_fwp->bd_amount,2)."&nbsp;".getCurrencyCode(); ?></span>

			</div>
			<div class="clearfix">
        			<div class="work-txt-col">
                             <p><?php echo stripslashes($row_fwp->prj_details);?></p>
					<div class="days_txt1"><?php    echo $lang[373]."&nbsp;".date("d-M-Y",strtotime($row_fwp->prj_expiry));	?></div>
				</div>	
			</div>
			</li>
                  <?php }    
                                                      
                }else{     ?>
                  <li><div style="padding-bottom:10px;"><?php echo $row->usr_name; ?>&nbsp;<?php echo $lang[372]; ?></div></li>                                
         <?php } ?>
									
	</ul>
	</div>
	<div class="bid-detail" id="LatestBidOn">
		<ul>
                <?php
				$sql_ab="select * from project,bid,user where prj_id=bd_prj_id and prj_usr_id=usr_id and bd_usr_id='".$row->usr_id."' and bd_status=0 and prj_status='open' and prj_expiry > now() order by bd_date desc limit 5";
				$res_ab=mysql_query($sql_ab);
				if(mysql_num_rows($res_ab)>0){
					while($row_ab=mysql_fetch_object($res_ab)){
			?>
			<li>
				<div style="padding-bottom:10px;">           
                    		 <span class="t-txt"><a href="project.php?p=<?php echo $row_ab->prj_id; ?>"><?php echo $row_ab->prj_name; ?></a></span>
					 <span><?php echo getCurrencySymbol().number_format($row_ab->bd_amount,2)."&nbsp;".getCurrencyCode(); ?></span>
                        </div>
				<div class="clearfix">
															
					<div class="work-txt-col">
                                  <p><?php echo stripslashes($row_ab->prj_details);?></p>
						<div class="days_txt1">
                                        <?php                    
                    	$diff=dateDifference($row_ab->bd_date,date("Y-m-d h:i:s"));
						if($diff==0){
							echo $lang[354];
						}
						else{
							echo $diff.$lang[74];
						}
					?>
                                    </div>
					</div>	
				</div>
			</li>
                  <?php }    
                                                      
                }else{     ?>
                  <li><div style="padding-bottom:10px;"><?php echo $row->usr_name; ?>&nbsp;<?php echo $lang[374]; ?></div></li>                                
         <?php } ?>
									
            </ul>
	</div>
</div>
	</div>
	</div>
    
</div><!-- end of freelancer overview -->
<div id="employer_overview_details" <?php if($row->usr_type=="Employer"){ ?>style="display: block;" <?php }else{ ?>style="display:none;" <?php } ?>>
          <div class="portfolio-body-nav-section">
               
                <div class="activity-box-str clearfix">
			<div class="activity-col">
				<h4><?php echo $lang[364]; ?></h4>
				<div class="clearfix">
					<div class="activity-lft-col">
						<ul>
							<li>
                                          <?php
                                            $sql_ope="select count(*) from project where prj_usr_id='".$row->usr_id."' and now()<prj_expiry and prj_id not in(select bd_prj_id from bid where bd_status=1) and prj_status='open'";
                                            $res_ope=mysql_query($sql_ope);
                                            $row_ope=mysql_fetch_row($res_ope);
                                          ?>
							 	<div class="activity-txt-col"><?php echo $lang[375]; ?> </div>
								<div class="activity-percent-col"><?php echo $row_ope[0]; ?></div>
							</li>
							<li>
                                        <?php
                                            $sql_ape="select count(*) AS count from project,bid,user where bd_prj_id=prj_id and bd_usr_id=usr_id and prj_usr_id='".$row->usr_id."' and  bd_status=1 and prj_status='running' and prj_id not in(select rr_prj_id from review_rating where rr_from_usr=prj_usr_id)";
                                            $res_ape=mysql_query($sql_ape);
                                            $row_ape=mysql_fetch_row($res_ape);
                                        ?>
							 	<div class="activity-txt-col"><?php echo $lang[376]; ?></div>
								<div class="activity-percent-col"><?php echo $row_ape[0]; ?></div>
							</li>
						</ul>
					</div>
					<div class="activity-rgt-col">
						<ul>
							<li>
                                        <?php
                                            $sql_ppe="select count(*) AS count from project p where p.prj_usr_id='".$row->usr_id."' and (p.prj_id in(select rr_prj_id from review_rating where rr_from_usr=p.prj_usr_id) or p.prj_status='close')";
                                            $res_ppe=mysql_query($sql_ppe);
                                            $row_ppe=mysql_fetch_row($res_ppe);
                                        ?>
							 	<div class="activity-txt-col"><?php echo $lang[377]; ?>   </div>
								<div class="activity-percent-col"><?php echo $row_ppe[0]; ?></div>
							</li>
<!--										<li>
										 	<div class="activity-txt-col">Repeat Hire Rate</div>
											<div class="activity-percent-col">19%</div>
										</li>-->
						</ul>
					</div>
				</div>
			</div>
			<div class="my-skill-col">
				<h4><?php echo $lang[378]; ?></h4>
					<div class="clearfix">
						<ul>
                                        <?php
                                        $sql_myskill="select * from skills where sk_id in(select distinct ps_sk_id from  project_skill where ps_prj_id in(select prj_id from project where prj_usr_id='".$row->usr_id."')) order by rand() limit 6";
                                        $res_myskill=  mysql_query($sql_myskill);
                                        while($row_myskill=  mysql_fetch_object($res_myskill))
                                        {
                                        ?>
							<li><img src="images/bullet-1.png" alt="" />&nbsp;&nbsp;<?php echo $row_myskill->sk_name; ?></li>
                                        <?php } ?>

						</ul>
					</div>
							</div>
						</div>
</div>

			<div class="bidding-info-col">
                    <div class="tabber-nav_2">
                        <ul>
					<li class="tabber-nav-normal_2"><?php echo $lang[369]; ?></li>
					<li><?php echo $lang[345]; ?></li>
					<li><?php echo $lang[379]; ?></li>
                        </ul>
			  </div>
                    <div class="">
				<div class="tabber-con-area_2">
					<div class="bid-detail" id="EmployerCompletedWork">
						<ul>
                                        <?php
				$sql_ecw="select * from bid,review_rating,project p where bd_prj_id=prj_id and bd_status='1' and p.prj_usr_id='".$row->usr_id."' and p.prj_id=rr_prj_id and  rr_from_usr=p.prj_usr_id order by p.prj_updated_date desc limit 5";
				$res_ecw=mysql_query($sql_ecw);
				if(mysql_num_rows($res_ecw)>0){
					while($row_ecw=mysql_fetch_object($res_ecw)){
			?>
						<li>
							<div style="padding-bottom:10px;">           
							 <span class="t-txt"><a href="project.php?p=<?php echo $row_ecw->prj_id; ?>"><?php echo $row_ecw->prj_name; ?></a></span>
                             
                              
							 <span class="p-txt"><?php echo getCurrencySymbol().number_format($row_ecw->bd_amount,2)."&nbsp;".getCurrencyCode(); ?></span>
									 
							</div>
							<div class="clearfix">
								<div class="work-txt-col">
									<p><?php echo stripslashes($row_ecw->prj_details);?></p>
									<div class="days_txt1"><?php    echo date("d-M-Y",strtotime($row_ecw->rr_updated_date));	?> </div>
								</div>	
								</div>
							</li>
                               <?php }    
                                                      
                }else{     ?>
                                          <li><div style="padding-bottom:10px;"><?php echo $row->usr_name; ?>&nbsp;<?php echo $lang[371]; ?></div></li>                                
         <?php } ?>	
									
				</ul>
			</div>
			<div class="bid-detail" id="EmployerWorkInProgress">
				<ul>
                      <?php
				$sql_ewp="select * from project,bid,user where bd_prj_id=prj_id and bd_usr_id=usr_id and prj_usr_id='".$row->usr_id."' and  bd_status=1 and prj_status='running' and prj_id not in(select rr_prj_id from review_rating where rr_from_usr=prj_usr_id) order by prj_expiry desc limit 5";
				$res_ewp=mysql_query($sql_ewp);
				if(mysql_num_rows($res_ewp)>0){
					while($row_ewp=mysql_fetch_object($res_ewp)){
			?>
                            <li>
					<div style="padding-bottom:10px;">           
						 <span class="t-txt"><a href="project.php?p=<?php echo $row_ewp->prj_id; ?>"><?php echo $row_ewp->prj_name; ?></a></span>
						 <span class="p-txt"><?php echo getCurrencySymbol().number_format($row_ewp->bd_amount,2)."&nbsp;".getCurrencyCode(); ?></span>
					</div>
					<div class="clearfix">
						<div class="work-txt-col">
							<p><?php echo stripslashes($row_ewp->prj_details);?></p>
							<div class="days_txt1"><?php    echo "Deadline: ".date("d-M-Y",strtotime($row_ewp->prj_expiry));	?></div>
						</div>	
					</div>
				</li>
				<?php }    
                }else{     ?>
                        <li><div style="padding-bottom:10px;"><?php echo $row->usr_name; ?>&nbsp;<?php echo $lang[380]; ?></div></li>                                
         <?php } ?>					
				
			</ul>
		</div>
		<div class="bid-detail" id="EmployerOpenProjects">
				<ul>
                            <?php
				$sql_eop="select * from project where prj_usr_id='".$row->usr_id."' and now()<prj_expiry and prj_id not in(select bd_prj_id from bid where bd_status=1) and prj_status='open' order by prj_updated_date desc limit 5";
				$res_eop=mysql_query($sql_eop);
				if(mysql_num_rows($res_eop)>0){
					while($row_eop=mysql_fetch_object($res_eop)){
			?>
					<li>
						<div style="padding-bottom:10px;">           
							 <span class="t-txt"><a href="project.php?p=<?php echo $row_eop->prj_id; ?>"><?php echo $row_eop->prj_name; ?></a></span>
							 		 
						</div>
						<div class="clearfix">
							<div class="work-txt-col">
								<p><?php echo stripslashes($row_eop->prj_details);?></p>
								<div class="days_txt1">
                                                    <?php                    
                                                $diff=dateDifference($row_eop->prj_expiry,date("Y-m-d h:i:s"));
                                                if($diff==0){   echo $lang[381]."&nbsp;".$lang[354];    }
                                                else{   echo $lang[381]." ".date("d-M-Y",strtotime($row_eop->prj_expiry));   }
                                            ?>  </div>
							</div>	
						</div>
					</li>
					<?php }    
                }else{     ?>
                              <li><div style="padding-bottom:10px;"><?php echo $row->usr_name; ?>&nbsp;<?php echo $lang[382]; ?></div></li>                                
         <?php } ?>					
					
					</ul>
				</div>
			</div>
		</div>
	</div>
</div><!-- end of employer overview -->