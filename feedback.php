
<script type="text/javascript">
function show_FeedbackFreelancer()
{
    //$.noConflict();
    $('#feedback_freelancer').css({"display":"block"});
    $('#feedback_employer').css({"display":"none"});
    
    $('#showFeedbackFreelancer').addClass("ns_selected");
    $('#showFeedbackEmployer').removeClass("ns_selected");
    
}
function show_FeedbackEmployer()
{
    //$.noConflict();

    $('#feedback_freelancer').css({"display":"none"});
    $('#feedback_employer').css({"display":"block"});
    
    $('#showFeedbackFreelancer').removeClass("ns_selected");
    $('#showFeedbackEmployer').addClass("ns_selected");
    
}
</script>
    
<h2><?php echo $lang[468]; ?></h2>
			
<div class="clearfix">
	<?php if($row->usr_type=="Both"){  ?>
    <div class="ns_right ns_margin-10">
    <a href="javascript:show_FeedbackFreelancer()" id="showFeedbackFreelancer" btntype="seller" class="ns_toggle-btn ns_btn-left ns_left ns_selected"><?php echo $lang[64]; ?></a>
    <a href="javascript:show_FeedbackEmployer()" id="showFeedbackEmployer" btntype="buyer" class="ns_toggle-btn ns_btn-right ns_left"><?php echo $lang[60]; ?></a>
    <div class="ns_clear"></div>
    </div>
    <?php } ?>
          
		<div class="exp-col" id="feedback_freelancer" <?php if($row->usr_type=="Employer"){ ?>style="display: none;" <?php } ?>>
                <?php
                $sql_fr="select count(*),avg(rr_work_quality),avg(rr_communication),avg(rr_expertise), avg(rr_work_hire_again), avg(rr_professionalism),avg(rr_completionrate) from review_rating where rr_to_usr='".$row->usr_id."' and rr_prj_id not in(select prj_id from project where prj_usr_id='".$row->usr_id."')";
               
                $res_fr=mysql_query($sql_fr);
                $row_fr=mysql_fetch_array($res_fr);
				
                if($row_fr[0] !=0){
        			$avg_fr=(((($row_fr[1]+$row_fr[2]+$row_fr[3]+$row_fr[4]+$row_fr[5])/$row_fr[0])*10)+(($row_fr[6]/$row_fr[0])*100))/6;
                }
                ?>
		<ul>
			<li>
                        <div class="lft-con-div"><strong><?php echo $lang[311]; ?></strong></div>
				<div class="rgt-con-div">
                            <div class="ns_stars-container ns_large ns_right">
					<div class="ns_stars ns_large ns_left">
					<div class="ns_active" style="width:<?php if($row_fr[0]==0){ echo "0"; } else { echo $avg_fr; } ?>%;">
					</div>
                            </div> 
			<span class="ns_rating-number ns_right ns_bold"><?php echo number_format(($avg_fr/10),1); ?></span>
			</div>
                     </div>
				</li>
				<li>
					<div class="lft-con-div"><?php echo $lang[312]; ?></div>
					<div class="rgt-con-div">
                                  <div class="ns_stars-container ns_small ns_right">
                    	<div class="ns_stars ns_small ns_left">
                        	<div class="ns_active" style="width:<?php if($row_fr[0]==0){ echo "0"; } else { echo ($row_fr[1])*10; } ?>%;"></div>
                        </div>
                        <span class="ns_rating-number ns_right"><?php echo number_format($row_fr[1],1); ?></span>
                                  </div>
                              </div>
				</li>
                        <li>
					<div class="lft-con-div"><?php echo $lang[313]; ?></div>
					<div class="rgt-con-div">
                                  <div class="ns_stars-container ns_small ns_right">
                    	<div class="ns_stars ns_small ns_left">
                        	<div class="ns_active" style="width:<?php if($row_fr[0]==0){ echo "0"; } else { echo ($row_fr[2])*10; } ?>%;"></div>
                        </div>
                        <span class="ns_rating-number ns_right"><?php echo number_format($row_fr[2],1); ?></span>
                    </div>
                              </div>
				</li>
                        <li>
					<div class="lft-con-div"><?php echo $lang[314]; ?></div>
					<div class="rgt-con-div">
                                  <div class="ns_stars-container ns_small ns_right">
                                    <div class="ns_stars ns_small ns_left">
                                        <div class="ns_active" style="width:<?php if($row_fr[0]==0){ echo "0"; } else { echo ($row_fr[3])*10; } ?>%;"></div>
                                    </div>
                                    <span class="ns_rating-number ns_right"><?php echo number_format($row_fr[3],1); ?></span>
                                  </div>
                              </div>
				</li>
                        <li>
					<div class="lft-con-div"><?php echo $lang[315]; ?></div>
					<div class="rgt-con-div">
                                  <div class="ns_stars-container ns_small ns_right">
                                    <div class="ns_stars ns_small ns_left">
                                        <div class="ns_active" style="width:<?php if($row_fr[0]==0){ echo "0"; } else { echo ($row_fr[4])*10; } ?>%;"></div>
                                    </div>
                                    <span class="ns_rating-number ns_right"><?php echo number_format($row_fr[4],1); ?></span>
                                  </div>
                              </div>
				</li>
                        <li>
					<div class="lft-con-div"><?php echo $lang[316]; ?></div>
					<div class="rgt-con-div">
                                  <div class="ns_stars-container ns_small ns_right">
                                    <div class="ns_stars ns_small ns_left">
                                        <div class="ns_active" style="width:<?php if($row_fr[0]==0){ echo "0"; } else { echo ($row_fr[5])*10; } ?>%;"></div>
                                    </div>
                                    <span class="ns_rating-number ns_right"><?php echo number_format($row_fr[5],1); ?></span>
                                  </div>
                              </div>
				</li>
                        <li>
					<div class="lft-con-div"><?php echo $lang[317]; ?></div>
					<div class="rgt-con-div">
                                  <div class="ns_stars-container ns_small ns_right">
                                    <div class="ns_stars ns_small ns_left">
                                        <div class="ns_active" style="width:<?php if($row_fr[0]==0){ echo "0"; } else { echo ($row_fr[6])*100; } ?>%;"></div>
                                    </div>
                                    <span class="ns_rating-number ns_right"><?php echo number_format(($row_fr[6]*10),1); ?></span>
                                  </div>
                              </div>
				</li>
			</ul>
		</div>
          <div class="exp-col" id="feedback_employer" <?php if($row->usr_type=="Employer"){ ?>style="display: block;" <?php }else{ ?>style="display:none;" <?php } ?>>
                <?php
                $sql_emp="select count(*),avg(rr_work_quality),avg(rr_communication),avg(rr_expertise), avg(rr_work_hire_again), avg(rr_professionalism), avg(rr_completionrate) from review_rating where rr_to_usr='".$row->usr_id."' and rr_prj_id in(select prj_id from project where prj_usr_id='".$row->usr_id."')";

		$res_emp=mysql_query($sql_emp);
		$row_emp=mysql_fetch_row($res_emp);
		
		if($row_emp[0] !=0){
			$avg_emp=(((($row_emp[1]+$row_emp[2]+$row_emp[3]+$row_emp[4]+$row_emp[5])/$row_emp[0])*10)+(($row_emp[6]/$row_emp[0])*100))/6;
		}
                ?>
			<ul>
				<li>
					<div class="lft-con-div"><strong><?php echo $lang[311]; ?></strong></div>
					<div class="rgt-con-div">
                                  <div class="ns_stars-container ns_large ns_right">
						<div class="ns_stars ns_large ns_left">
							<div class="ns_active" style="width:<?php if($row_emp[0]==0){ echo "0"; } else { echo $avg_emp; } ?>%;">
							</div>
						</div> 
						<span class="ns_rating-number ns_right ns_bold"><?php echo number_format(($avg_emp/10),1); ?></span>
					</div>
                              </div>
				</li>
				<li>
					<div class="lft-con-div"><?php echo $lang[312]; ?></div>
					<div class="rgt-con-div">
                                  <div class="ns_stars-container ns_small ns_right">
                    	<div class="ns_stars ns_small ns_left">
                        	<div class="ns_active" style="width:<?php if($row_emp[0]==0){ echo "0"; } else { echo ($row_emp[1])*10; } ?>%;"></div>
                        </div>
                        <span class="ns_rating-number ns_right"><?php echo number_format($row_emp[1],1); ?></span>
                                  </div>
                              </div>
				</li>
                        <li>
					<div class="lft-con-div"><?php echo $lang[313]; ?></div>
					<div class="rgt-con-div">
                                  <div class="ns_stars-container ns_small ns_right">
                    	<div class="ns_stars ns_small ns_left">
                        	<div class="ns_active" style="width:<?php if($row_emp[0]==0){ echo "0"; } else { echo ($row_emp[2])*10; } ?>%;"></div>
                        </div>
                        <span class="ns_rating-number ns_right"><?php echo number_format($row_emp[2],1); ?></span>
                    </div>
                              </div>
				</li>
                <li>
					<div class="lft-con-div"><?php echo $lang[314]; ?></div>
					<div class="rgt-con-div">
                         <div class="ns_stars-container ns_small ns_right">
                              <div class="ns_stars ns_small ns_left">
                                        <div class="ns_active" style="width:<?php if($row_emp[0]==0){ echo "0"; } else { echo ($row_emp[3])*10; } ?>%;"></div>
                                    </div>
                                    <span class="ns_rating-number ns_right"><?php echo number_format($row_emp[3],1); ?></span>
                                  </div>
                              </div>
				</li>
                        <li>
					<div class="lft-con-div"><?php echo $lang[315]; ?></div>
					<div class="rgt-con-div">
                                  <div class="ns_stars-container ns_small ns_right">
                                    <div class="ns_stars ns_small ns_left">
                                        <div class="ns_active" style="width:<?php if($row_emp[0]==0){ echo "0"; } else { echo ($row_emp[4])*10; } ?>%;"></div>
                                    </div>
                                    <span class="ns_rating-number ns_right"><?php echo number_format($row_emp[4],1); ?></span>
                                  </div>
                              </div>
				</li>
                        <li>
					<div class="lft-con-div"><?php echo $lang[316]; ?></div>
					<div class="rgt-con-div">
                                  <div class="ns_stars-container ns_small ns_right">
                                    <div class="ns_stars ns_small ns_left">
                                        <div class="ns_active" style="width:<?php if($row_emp[0]==0){ echo "0"; } else { echo ($row_emp[5])*10; } ?>%;"></div>
                                    </div>
                                    <span class="ns_rating-number ns_right"><?php echo number_format($row_emp[5],1); ?></span>
                                  </div>
                              </div>
				</li>
                        <li>
					<div class="lft-con-div"><?php echo $lang[317]; ?></div>
					<div class="rgt-con-div">
                                  <div class="ns_stars-container ns_small ns_right">
                                    <div class="ns_stars ns_small ns_left">
                                        <div class="ns_active" style="width:<?php if($row_emp[0]==0){ echo "0"; } else { echo ($row_emp[6])*100; } ?>%;"></div>
                                    </div>
                                    <span class="ns_rating-number ns_right"><?php echo number_format(($row_emp[6]*10),1); ?></span>
                                  </div>
                              </div>
				</li>
			</ul>
		</div>
	</div>