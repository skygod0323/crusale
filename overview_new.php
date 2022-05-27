<div class="row">
	<div class="col-md-6 col-sm-12 center">
		<span class="profile-picture">
			<img class="editable img-responsive" alt="<?php echo $row->usr_name; ?>" id="" src="images/users/<?php if($row->usr_image != ''){ echo $row->usr_image; }else{ echo "unknown.png"; } ?>" title="<?php echo $row->usr_name; ?>" />
		</span>
        <div class="space space-4"></div>
		<div class="profile-contact-info">
        
        <?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row->usr_id)){ ?>
        <div class="profile-contact-links align-left">
			<a class="btn btn-link" onClick="changeProfilePic()" style="cursor: pointer;">
				<i class="pink icon-picture bigger-120"></i>
				<?php echo $lang[462]; ?>
			</a>
		</div>
        <?php	}	?>
        <div class="space-6"></div>
        
       <!-- <div class="profile-contact-links align-left" style="padding-left:10px;">-->
             <?php if($row->usr_hourlyrate == '0'){ ?>
                <?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row->usr_id)){ ?>
                <div class="profile-contact-links align-left" style="padding-left:10px;">
                    <a href="javascript:void(0)" class="" onClick="showAddHourlyForm()"><?php echo $lang[463]; ?></a>
                </div>
                <?php } ?>
            <?php } else { ?>
            <div class="profile-contact-links align-left" style="padding-left:10px;">
                    <?php echo $lang[464]; ?>&nbsp;<?php echo getCurrencySymbol(); ?><span id="hrRate"><?php echo $row->usr_hourlyrate; ?></span>&nbsp;<?php echo getCurrencyCode(); ?>/<?php echo $lang[437]; ?> 
    			<?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row->usr_id)){ ?>
					&nbsp;<a style="cursor: pointer; text-decoration:none;" onClick="showAddHourlyForm()"><i class="icon-edit green bigger-120"></i><?php /*echo $lang[399];*/ ?> </a>
				<?php } ?>
				</div>	
			<?php } ?>

			<!--</div>-->
            
			
           
            <div class="ns_edit ns_box" id="add_hourly_form" style="display: none;">
            
            <!--<div class="space-6"></div>-->
                 <form class="ns_form ns_pad">
                      <div class="ns_field">
                           <div class="ns_col ns_last">
                                <label for="password"><?php echo $lang[465]; ?></label>
                                 <div class="ns_form-prefix"><?php echo getCurrencyCode(); ?>&nbsp;<?php echo getCurrencySymbol(); ?></div>
                                 <input id="input_hourly_rate" class="ns_short" type="text" />&nbsp;
                           </div>
                           <div class="ns_clear"></div>
                           <img class="ns_left"src="images/ajax-loader.gif" style="display:none;" id="ajaxloader" />
                           <p id="rate_amount_warning" class="ns_color-red ns_pad-none ns_left ns_margin-top-small" style="display: none;"></p>
                       </div>
                       <a href="javascript:void(0)" class="btn btn-sm btn-info" id="save_hourly_rate" onClick="saveHourlyRate()"><i class="icon-ok"></i><?php echo $lang[106]; ?></a> <a href="javascript:void(0)" class="btn btn-white" id="cancel_hourly_rate" onClick="cancelHourlyRate()"><?php echo $lang[398]; ?></a>
                       <div class="ns_clear"></div>
                 </form>
             </div>
             
        
	                               
		</div>
		<div class="space space-4"></div>
        <?php	if(isset($_SESSION['uid']) && $row->usr_id!=$_SESSION['uid']){	?>
		<a href="inviteUser.php?u=<?php echo md5($row->usr_id); ?>" class="btn btn-sm btn-block btn-success">
			<i class="icon-plus-sign bigger-120"></i>
			<span class="bigger-110"><?php echo $lang[328]; ?></span>
		</a>
        <?php	}	?>
		<!--<a href="#" class="btn btn-sm btn-block btn-primary">
			<i class="icon-envelope-alt bigger-110"></i>
			<span class="bigger-110">Send a message</span>
		</a>-->
		
	</div><!-- /span -->
	
    <div class="col-md-6 col-sm-12">
        <div class="freelancer-portfolio-rgt-col">
                     <?php if($row->usr_type=="Both"){  ?> 
                        <div class="ns_right ns_margin-10" style="float: left">
		  <a style="margin:5px;" href="javascript:showFreelancerOverview()" id="showFreelancerOverview" btntype="seller" class="btn btn-primary ns_toggle-btn ns_btn-left ns_left ns_selected"><?php echo $lang[64]; ?></a>
		  <a style="margin:5px;" href="javascript:showEmployerOverview()" id="showEmployerOverview" btntype="buyer" class="btn btn-primary ns_toggle-btn ns_btn-right ns_left"><?php echo $lang[60]; ?></a>
		  <div class="ns_clear"></div>
                        </div>
                     <?php }    ?>
         
                                    
					</div>
    </div>
	<div class="col-md-8 col-sm-12">
		<h4 class="blue col-md-12 col-sm-12">
		
			<span class="middle" id="disp_username"><?php echo $row->usr_name; ?></span>
            <?php
                        $res_cntry=mysql_query("select * from country where cn_id=(select ct_cn_id from city where ct_id='".$row->usr_ct_id."')");
						if(mysql_num_rows($res_cntry)>0)
						{
							$row_cntry=mysql_fetch_object($res_cntry);
						?>
						<span class="bidder-country-flag">&nbsp;<img src="images/country_flag/<?php echo $row_cntry->cn_name; ?>.png" alt="" title="<?php echo $row_cntry->cn_name; ?>" /></span>
                        <?php } ?>
			<!--<span class="label label-purple arrowed-in-right">
				<i class="icon-circle smaller-80 align-middle"></i>
				online
			</span>-->
		</h4>

		<div class="profile-user-info profile-user-info-striped">
			<div class="profile-info-row">
				<div class="profile-info-name col-md-3 col-sm-3"> <?php echo $lang[42]; ?> </div>
				
                    <div class="profile-info-value col-md-9 col-sm-9">
						<span id="username_span" style="display: block;"><span  class="editable" id="username_txt"><?php echo $row->usr_name; ?></span>
                        <?php //if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row->usr_id)){ ?>
                        <a style="cursor:pointer;text-decoration:none;" onClick="editUsername()"><i class="fa fa-pencil-square-o" aria-hidden="true" style="vertical-align:middle;"></i></a>
                        <?php	//}	?>
                        </span>
                        
						<span class="editable-container editable-inline" id="edit_username_div" style="display:none;">
                           	<div style="display: none;" class="editableform-loading"></div>
                            <div id="usr_edt_frm">
                            	<form style="" class="form-inline editableform">
                                	<div class="control-group">
                                    	<div>
                                        	<div style="position: relative;" class="editable-input">
                                            	<input class="input-medium" style="padding-right: 24px;" type="text" id="usr_name" value="<?php echo $row->usr_name; ?>">
                                                <!--<span class="editable-clear-x"></span>-->
											</div>
                                            <div class="editable-buttons" style="padding-top: 10px;">
                                            	<button type="button" class="btn btn-info editable-submit" onClick="saveUserName()"><i class="fa fa-check" aria-hidden="true"></i></button>
                                                <button type="button" class="btn editable-cancel" onClick="closeEditUser_div()"><i class="fa fa-times" aria-hidden="true"></i></button>
	                                        </div>
										</div>
                                        <div style="display: none;" class="editable-error-block help-block"></div>
									</div>
								</form>
							</div>
						</span>
					</div>
				</div>
                
                <?php
                    $sql_ct_cn="select * from city,country where ct_cn_id=cn_id and ct_id='".$row->usr_ct_id."'";
                    $res_ct_cn=  mysql_query($sql_ct_cn);
					if(mysql_num_rows($res_ct_cn)>0){
                    	$row_ct_cn=mysql_fetch_object($res_ct_cn);
                ?>
				<div class="profile-info-row">
					<div class="profile-info-name col-md-3 col-sm-3"> <?php echo $lang[668]; ?> </div>
					<div class="profile-info-value col-md-9 col-sm-9">
                    <?php
                        $sql_ct_cn="select * from city,country where ct_cn_id=cn_id and ct_id='".$row->usr_ct_id."'";
                        $res_ct_cn=  mysql_query($sql_ct_cn);
                        $row_ct_cn=  mysql_fetch_object($res_ct_cn);
                    ?>
						<i class="icon-map-marker light-orange bigger-110"></i>
						<span class="editable" id="country_"><?php echo $row_ct_cn->cn_name; ?></span>
						<span class="editable" id="city_"><?php echo $row_ct_cn->ct_name; ?></span>
                        <?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row->usr_id)){ ?>
                        <a href="changeuserinfo.php" style="cursor:pointer;text-decoration:none;"><i class="fa fa-pencil-square-o" aria-hidden="true" style="vertical-align:middle;"></i></a>
                        <?php	}	?>
					</div>
				</div>
                <?php	}	?>
                
				<div class="profile-info-row">
					<div class="profile-info-name col-md-4 col-sm-4" style="width:112px;padding-right: 0px;"> <?php echo $lang[458]; ?> </div>
					<div class="profile-info-value col-md-8 col-sm-8">
						<span><?php echo date("F, Y",  strtotime($row->usr_creation_date)); ?></span>
					</div>
				</div>
				
				
				<?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row->usr_id)){ ?>
				<div class="profile-info-row">
					<div class="profile-info-name col-md-3 col-sm-12"> <?php echo $lang[457]; ?> </div>
					<div class="profile-info-value col-md-9 col-sm-12">
						<span class="editable" id="summary_span">
	                        <span id="summary_txt">
    	                    <?php if($row->usr_summary != '') { ?>
                        	<?php	echo $row->usr_summary; ?> <a style="cursor:pointer;text-decoration:none;" onClick="editUserSummary()"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
        	                <?php	}else{	?>
            	            	<a style="cursor:pointer;text-decoration:none;" onClick="editUserSummary()"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?php echo $lang[459]; ?></a>
                	        <?php	}	?>
                       		</span>
                        </span>
                        <span class="editable-container editable-inline" id="edit_summary_div" style="display:none;">
                           	<div style="display: none;" class="editableform-loading"></div>
                            <div id="usr_smry_edt_frm">
                            	<form style="" class="form-inline editableform">
                                	<div class="control-group">
                                    	<div>
                                        	<div style="position: relative;" class="editable-input">
                                            	
                                                <textarea class="input-large" id="usr_summary" style="min-height:80px; min-width:200px;"><?php	echo $row->usr_summary; ?></textarea>
                                                <!--<span class="editable-clear-x"></span>-->
											</div>
                                            <div class="editable-buttons" style="padding-top: 10px;">
                                            	<button type="button" class="btn btn-info editable-submit" onClick="saveSummary()"><i class="fa fa-check" aria-hidden="true"></i></button>
                                                <button type="button" class="btn editable-cancel" onClick="closeEditSummary_div()"><i class="fa fa-times" aria-hidden="true"></i></button>
	                                        </div>
										</div>
                                        <div style="display: none;" class="editable-error-block help-block"></div>
									</div>
								</form>
							</div>
						</span>
					</div>
				</div>
                <?php	}else{	?>
                	<?php	if($row->usr_summary != '') {	?>
                    
                    
                    <div class="profile-info-row">
					<div class="profile-info-name col-md-3 col-sm-3"> <?php echo $lang[457]; ?> </div>
					<div class="profile-info-value col-md-9 col-sm-9">
						<span class="editable" id="summary_span"><?php	echo $row->usr_summary; ?></span>
					</div>
				</div>
                    
                    
                    <?php	}	?>
                <?php	}	?>
                
                
			</div>
	</div><!-- /span -->
	<div class="col-md-4 col-sm-12">
		<div id="empl_reputation" <?php if($row->usr_type=="Freelancer"){ ?>style="display:block;" <?php } else{ ?>style="display:none;"<?php } ?>>
                 <?php
                $sql_emp_avg="select count(*),sum(rr_work_quality),sum(rr_communication),sum(rr_expertise), sum(rr_work_hire_again), sum(rr_professionalism),sum(rr_completionrate),count(rr_review) from review_rating where rr_to_usr='".$row_po->usr_id."' and rr_prj_id in(select prj_id from project where prj_usr_id='".$row_po->usr_id."')";
				
			$res_emp_avg=mysql_query($sql_emp_avg);
			$row_emp_avg=mysql_fetch_array($res_emp_avg);
				
			if($row_emp_avg[0] !=0){
				$avg_emp=(((($row_emp_avg[1]+$row_emp_avg[2]+$row_emp_avg[3]+$row_emp_avg[4]+$row_emp_avg[5])/$row_emp_avg[0])*10)+(($row_emp_avg[6]/$row_emp_avg[0])*100))/6;
			}
                ?>
			<h6><?php echo $lang[466]; ?></h6>
				<h2><?php echo number_format(($avg_emp/10),1); ?>/<span>5</span></h2>
				<p><div class="ns_stars ns_small"><div class="ns_active" style="width:<?php if($row_emp_avg[0]==0){ echo "0"; } else { echo $avg_emp; } ?>%;"></div></div></p>
				<p><a href="review.php?u=<?php echo md5($row_po->usr_id); ?>">(<?php echo $row_emp_avg[7]; ?> reviews )</a></p>
                 </div>
                 <div id="freel_reputation" <?php if($row->usr_type=="Freelancer"){ ?>style="display:none;" <?php } ?>>
                 <?php
                $sql_fr_avg="select count(*),sum(rr_work_quality),sum(rr_communication),sum(rr_expertise), sum(rr_work_hire_again), sum(rr_professionalism),sum(rr_completionrate),count(rr_review) from review_rating where rr_to_usr='".$row_po->usr_id."' and rr_prj_id not in(select prj_id from project where prj_usr_id='".$row_po->usr_id."')";
				
				$res_fr_avg=mysql_query($sql_fr_avg);
				$row_fr_avg=mysql_fetch_array($res_fr_avg);
				
				if($row_fr_avg[0] !=0){
					$avg_fr=(((($row_fr_avg[1]+$row_fr_avg[2]+$row_fr_avg[3]+$row_fr_avg[4]+$row_fr_avg[5])/$row_fr_avg[0])*10)+(($row_fr_avg[6]/$row_fr_avg[0])*100))/6;
				}
                ?>
						<h6><?php echo $lang[466]; ?></h6>
						<h2><?php echo number_format(($avg_fr/10),1); ?>/<span>5</span></h2>
						<p><div class="ns_stars ns_small"><div class="ns_active" style="width:<?php if($row_fr_avg[0]==0){ echo "0"; } else { echo $avg_fr; } ?>%;"></div></div></p>
						<p><a href="review.php?u=<?php echo md5($row_po->usr_id); ?>">(<?php echo $row_fr_avg[7]; ?> reviews )</a></p>

                    <!--		<div class="rate-box">Rate: $20 USD/hour </div>
						<p><a href="#">[edit]</a></p>-->
						
                                  </div>
	</div>
        
	</div><!-- /row-fluid -->
	<!--<div class="space-20"></div>
	<div class="col-xs-12" align="right">
		<div class="ns_right ns_margin-10">
			<a href="javascript:show_FreelancerOverviewDetails()" id="showFreelancerOverviewDet" btntype="seller" class="ns_toggle-btn ns_btn-left ns_left ns_selected"><?php /*echo $lang[64];*/ ?></a>
			<a href="javascript:show_EmployerOverviewDetails()" id="showEmployerOverviewDet" btntype="buyer" class="ns_toggle-btn ns_btn-right ns_left"><?php /*echo $lang[60];*/ ?></a>
			<div class="ns_clear"></div>
		</div>
	</div>-->
	<div class="space-20"></div>
	<div id="freelancer_overview_details" <?php if($row->usr_type=="Employer"){ ?>style="display: none;" <?php } ?>>
		<div class="row">
			<div class="col-xs-12 col-sm-6">
				<div class="widget-box transparent">
					<div class="widget-header widget-header-small">
						<h4 class="smaller">
							<i class="icon-check bigger-110"></i>
							<?php	echo $lang[364]; ?>
						</h4>
					</div>
					<div class="widget-body">
						<div class="widget-main">
							<table class="table table-bordered" style="border-top:none; text-align:center">
								<tbody>
									<tr style="border:none">
                                     <?php
                            $tot_sql_crf="select * from review_rating,project,bid,user where prj_id=rr_prj_id and prj_id=bd_prj_id and prj_usr_id=usr_id and bd_usr_id='".$row->usr_id."' and rr_from_usr=prj_usr_id and rr_to_usr='".$row->usr_id."' and bd_status=1";

                            $tot_res_crf=mysql_query($tot_sql_crf);
                            $tot_row_crf=mysql_num_rows($tot_res_crf);
				
                            $sql_crf="select * from review_rating,project,bid,user where prj_id=rr_prj_id and prj_id=bd_prj_id and prj_usr_id=usr_id and bd_usr_id='".$row->usr_id."' and rr_from_usr=prj_usr_id and rr_to_usr='".$row->usr_id."' and bd_status=1 and rr_completionrate='1'";

                            $res_crf=mysql_query($sql_crf);
                            $row_crf=mysql_num_rows($res_crf);
				
									?>
										<td><?php echo $lang[365]; ?></td>
										<td class="hidden-480"><span class="label label-warning arrowed-in arrowed-in-right"><?php if($tot_row_crf=='0'){	echo "-";	}else{	echo (($row_crf*100)/$tot_row_crf)."%";	}	?></span></td>
									</tr>
									<tr>
                                     <?php
								$otim_sql_crf="select * from review_rating,project,bid,user where prj_id=rr_prj_id and prj_id=bd_prj_id and prj_usr_id=usr_id and bd_usr_id='".$row->usr_id."' and rr_from_usr=prj_usr_id and rr_to_usr='".$row->usr_id."' and bd_status=1 and rr_completionrate='1' and rr_updated_date <= prj_expiry";

								$otim_res_crf=mysql_query($otim_sql_crf);
								$otim_row_crf=mysql_num_rows($otim_res_crf);
									?>
										<td><?php echo $lang[366]; ?></td>
										<td class="hidden-480"><span class="label label-warning arrowed-in arrowed-in-right"><?php if($tot_row_crf=='0'){	echo "-";	}else{	echo (($otim_row_crf*100)/$tot_row_crf)."%";	}	?></span></td>
									</tr>
									<tr>
                                    <?php
				$rhr_sql_crf="select * from review_rating,project,bid,user where prj_id=rr_prj_id and prj_id=bd_prj_id and prj_usr_id=usr_id and bd_usr_id='".$row->usr_id."' and rr_from_usr=prj_usr_id and rr_to_usr='".$row->usr_id."' and bd_status=1 and rr_completionrate='1' and rr_work_hire_again='1'";

				$rhr_res_crf=mysql_query($rhr_sql_crf);
				$rhr_row_crf=mysql_num_rows($rhr_res_crf);
				?>
										<td><?php echo $lang[367]; ?></td>
										<td class="hidden-480"><span class="label label-warning arrowed-in arrowed-in-right"><?php if($tot_row_crf=='0'){	echo "-";	}else{	echo (($rhr_row_crf*100)/$tot_row_crf)."%";	}	?></span></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6">
				<div class="widget-box transparent">
					<div class="widget-header widget-header-small header-color-blue2">
						<h4 class="smaller">
							<i class="icon-lightbulb bigger-120"></i>
			                <?php echo $lang[368]; ?>
			            </h4>
			        </div>
			        <div class="widget-body">
                    <?php
						$sql_usk="select * from user_skills,skills where usk_sk_id=sk_id and usk_usr_id='".$row->usr_id."'";
                        $res_usk=mysql_query($sql_usk);
						if(mysql_num_rows($res_usk)){
                    ?>
            			<ul class="list-unstyled spaced inline bigger-110 margin-15">
                        <?php while($row_usk=mysql_fetch_object($res_usk)){ ?>
							<li class="col-sm-6" style="min-width:140px;">
								<i class="icon-hand-right blue"></i>
								<?php echo $row_usk->sk_name; ?>
							</li>
                         <?php	}	?>
							<!--<li>
		                        <i class="icon-hand-right blue"></i>
        		                Give us more info on how this specific error occurred!
                	        </li>-->
                        </ul>
                    <?php } ?>
                    </div>
                </div>
            </div>
		</div>
		<div class="col-sm-12">
		<div class="tabbable">
			<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
				<li class=""><a data-toggle="tab" href="#FreelancerCompletedWork"><?php echo $lang[369]; ?></a></li>
				<li class="active"><a data-toggle="tab" href="#FreelancerWorkInProgress"><?php echo $lang[345]; ?></a></li>
				<li class=""><a data-toggle="tab" href="#LatestBidOn"><?php echo $lang[370]; ?></a></li>
			</ul>
			<div class="tab-content">
				<div id="FreelancerCompletedWork" class="tab-pane">                
					<p style="padding:20px;">
                   
                    <?php
		$sql_fcw="select * from review_rating,project,bid,user where prj_id=rr_prj_id and prj_id=bd_prj_id and prj_usr_id=usr_id and bd_usr_id='".$row->usr_id."' and rr_from_usr=prj_usr_id and rr_to_usr='".$row->usr_id."' and bd_status=1 and rr_completionrate='1' order by bd_deadline desc limit 5";
		$res_fcw=mysql_query($sql_fcw);
		if(mysql_num_rows($res_fcw)>0){ 
			while($row_fcw=mysql_fetch_object($res_fcw)){
      ?> 
                    <div class="widget-container-span ui-sortable">
						<div class="widget-box">
							<div class="widget-header header-color-dark">
								<h5 class="bigger lighter"><a href="project.php?p=<?php echo $row_fcw->prj_id; ?>" style="text-decoration:none;color:#FFF"><?php echo $row_fcw->prj_name; ?></a></h5>
								<div class="widget-toolbar">
									<h5 class="bigger lighter"><?php echo getCurrencySymbol().number_format($row_fcw->bd_amount,2)."&nbsp;".getCurrencyCode(); ?></h5>
								</div>
							</div>
							<div class="widget-body">
                            <div class="widget-toolbox" style="height:22px; vertical-align:middle;">
                        <div class="ns_ratings-new" style="width:250px; position:absolute; margin-left:10px;">
                    <?php
					$sql_rt_rv="select rr_work_quality,rr_communication,rr_expertise,rr_work_hire_again,rr_professionalism from review_rating where rr_id='".$row_fcw->rr_id."'";

					$res_rt_rv=mysql_query($sql_rt_rv);
					$row_rt_rv=mysql_fetch_array($res_rt_rv);

					$avg_rt=0;
					if($row_rt_rv[0] != 0)
					{
						$avg_rt=($row_rt_rv[0]+$row_rt_rv[1]+$row_rt_rv[2]+$row_rt_rv[3]+$row_rt_rv[4])/5;
					}

			?>
                	<div class="ns_ratings-new ns_active-stars" style="width:<?php echo $avg_rt*10; ?>%;"></div>
                    <div style="padding-left:80px;"><?php echo number_format($avg_rt,1); ?></div>
                    
                    </div>
                    
                        <div style="float:right; padding-right:8px;"><?php    echo date("d-M-Y",strtotime($row_fcw->rr_updated_date));	?></div>
						</div>
                        <div class="widget-main padding-16">
                        	<?php	if($row_fcw->usr_image == ''){ ?>
								<img src="images/unknown.jpg" width="58" height="54" align="left">
							<?php	} else { 	?>
								<img src="images/users/<?php echo $row_fcw->usr_image; ?>" width="58" height="54" align="left">
							<?php } ?>
                           	<div style="margin-left:68px;" align="left"><?php	echo stripslashes($row_fcw->rr_review);	?> </div>
                            <div style="margin-top:35px;"><b><?php echo $lang[498]; ?></b>&nbsp;<?php	echo stripslashes($row_fcw->prj_details);	?></div>
                                </div>
							</div>
						</div>
					</div>
                  <?php }    
            }else{     ?>
               <span style="color:#F00"><?php echo $row->usr_name; ?>&nbsp;<?php echo $lang[371]; ?></span>
         <?php } ?>
                  
                    </p>
				</div>
				<div id="FreelancerWorkInProgress" class="tab-pane active">
					<p style="padding:20px;">
                    <!---->
                    <?php
			$sql_fwp="select * from project,bid,user where bd_prj_id=prj_id and prj_usr_id=usr_id and bd_usr_id='".$row->usr_id."' and bd_status=1 and prj_status='running' and prj_id not in(select rr_prj_id from review_rating where rr_from_usr=prj_usr_id) order by bd_deadline desc limit 5";
			$res_fwp=mysql_query($sql_fwp);
			if(mysql_num_rows($res_fwp)>0){
				while($row_fwp=mysql_fetch_object($res_fwp)){
		?>
                    <div class="widget-container-span ui-sortable">
						<div class="widget-box">
							<div class="widget-header header-color-dark">
								<h5 class="bigger lighter"><a style="text-decoration:none; color:#FFF" href="project.php?p=<?php echo $row_fwp->prj_id; ?>"><?php echo $row_fwp->prj_name; ?></a></h5>

								<div class="widget-toolbar">
									<h5 class="bigger lighter"><?php echo getCurrencySymbol().number_format($row_fwp->bd_amount,2)."&nbsp;".getCurrencyCode(); ?></h5>
								</div>
							</div>

							<div class="widget-body">
	                            <div class="widget-toolbox">
									<?php    echo $lang[373]."&nbsp;".date("d-M-Y",strtotime($row_fwp->prj_expiry));	?>							
								</div>
								<div class="widget-main padding-16">
									<?php echo stripslashes($row_fwp->prj_details);?>
								</div>
							</div>
						</div>
					</div>
                     <?php }    
                                                      
                }else{     ?>
                  <span style="color:#F00"><?php echo $row->usr_name; ?>&nbsp;<?php echo $lang[372]; ?></span>
         <?php } ?>
                    <!---->
                    </p>
				</div>
				<div id="LatestBidOn" class="tab-pane">
					<p style="padding:20px;">
                    <!---->
                     <?php
				$sql_ab="select * from project,bid,user where prj_id=bd_prj_id and prj_usr_id=usr_id and bd_usr_id='".$row->usr_id."' and bd_status=0 and prj_status='open' and prj_expiry > now() order by bd_date desc limit 5";
				$res_ab=mysql_query($sql_ab);
				if(mysql_num_rows($res_ab)>0){
					while($row_ab=mysql_fetch_object($res_ab)){
			?>
                    <div class="widget-container-span ui-sortable">
						<div class="widget-box">
							<div class="widget-header header-color-dark">
								<h5 class="bigger lighter"><a style="text-decoration:none; color:#FFF" href="project.php?p=<?php echo $row_ab->prj_id; ?>"><?php echo $row_ab->prj_name; ?></a></h5>

								<div class="widget-toolbar">
									<h5 class="bigger lighter"><?php echo getCurrencySymbol().number_format($row_ab->bd_amount,2)."&nbsp;".getCurrencyCode(); ?></h5>
								</div>
							</div>

							<div class="widget-body">
	                            <div class="widget-toolbox">
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
								<div class="widget-main padding-16">
									<?php echo stripslashes($row_ab->prj_details);?>
								</div>
							</div>
						</div>
					</div>
                    <?php }    
                                                      
                }else{     ?>
                  <span style="color:#F00"><?php echo $row->usr_name; ?>&nbsp;<?php echo $lang[374]; ?></span>
         <?php } ?>
                    <!---->
                    </p>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="employer_overview_details" <?php if($row->usr_type=="Employer"){ ?>style="display: block;" <?php }else{ ?>style="display:none;" <?php } ?>>
<div class="row">
<div class="col-xs-12 col-sm-6">
    <div class="widget-box transparent">
        <div class="widget-header widget-header-small">
            <h4 class="smaller">
                <i class="icon-check bigger-110"></i>
                <?php	echo $lang[364];	?>
            </h4>
        </div>

        <div class="widget-body">
            <div class="widget-main">
                <table class="table table-bordered" style="border-top:none; text-align:center">


<tbody>
    <tr style="border:none">
    <?php
		$sql_ope="select count(*) from project where prj_usr_id='".$row->usr_id."' and now()<prj_expiry and prj_id not in(select bd_prj_id from bid where bd_status=1) and prj_status='open'";
        $res_ope=mysql_query($sql_ope);
        $row_ope=mysql_fetch_row($res_ope);
	?>
        <td><?php echo $lang[375]; ?></td>

        <td class="hidden-480">
            <span class="label label-warning arrowed-in arrowed-in-right"><?php echo $row_ope[0]; ?></span>
        </td>
    </tr>

    <tr>
	<?php
		$sql_ape="select count(*) AS count from project,bid,user where bd_prj_id=prj_id and bd_usr_id=usr_id and prj_usr_id='".$row->usr_id."' and  bd_status=1 and prj_status='running' and prj_id not in(select rr_prj_id from review_rating where rr_from_usr=prj_usr_id)";
        $res_ape=mysql_query($sql_ape);
        $row_ape=mysql_fetch_row($res_ape);
    ?>

        <td><?php echo $lang[376]; ?></td>

        <td class="hidden-480">
            <span class="label label-warning arrowed-in arrowed-in-right"><?php echo $row_ape[0]; ?></span>
        </td>
    </tr>

    <tr>
	<?php
		$sql_ppe="select count(*) AS count from project p where p.prj_usr_id='".$row->usr_id."' and (p.prj_id in(select rr_prj_id from review_rating where rr_from_usr=p.prj_usr_id) or p.prj_status='close')";
        $res_ppe=mysql_query($sql_ppe);
		$row_ppe=mysql_fetch_row($res_ppe);
	?>
        <td><?php echo $lang[377]; ?></td>

        <td class="hidden-480">
            <span class="label label-warning arrowed-in arrowed-in-right"><?php echo $row_ppe[0]; ?></span>
        </td>
    </tr>
</tbody>
</table>
            </div>
        </div>
    </div>
</div>


<div class="col-xs-12 col-sm-6">
    <div class="widget-box transparent">
        <div class="widget-header widget-header-small header-color-blue2">
            <h4 class="smaller">
                <i class="icon-lightbulb bigger-120"></i>
                <?php echo $lang[87]; ?>
            </h4>
        </div>
        <div class="widget-body">
            <ul class="list-unstyled spaced inline bigger-110 margin-15">
            <?php
				$sql_myskill="select * from skills where sk_id in(select distinct ps_sk_id from  project_skill where ps_prj_id in(select prj_id from project where prj_usr_id='".$row->usr_id."')) order by rand() limit 6";
                $res_myskill=  mysql_query($sql_myskill);
                while($row_myskill=  mysql_fetch_object($res_myskill))
                {
			?>
				<li class="col-sm-6">
					<i class="icon-hand-right blue"></i>
					<?php echo $row_myskill->sk_name; ?>
				</li>
			<?php } ?>
<!--<li>
<i class="icon-hand-right blue"></i>
Give us more info on how this specific error occurred!
</li>-->
</ul>
        </div>
    </div>
</div>
</div>
<div class="col-sm-12">
<div class="tabbable">
	<ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
		<li class=""><a data-toggle="tab" href="#EmployerCompletedWork"><?php echo $lang[369]; ?></a></li>
		<li class="active"><a data-toggle="tab" href="#EmployerWorkInProgress"><?php echo $lang[345]; ?></a></li>
		<li class=""><a data-toggle="tab" href="#EmployerOpenProjects"><?php echo $lang[379]; ?></a></li>
	</ul>
	<div class="tab-content">
		<div id="EmployerCompletedWork" class="tab-pane">
			<p>
            <!---->
            <?php
				$sql_ecw="select * from bid,review_rating,project p,user where bd_prj_id=prj_id and rr_from_usr=usr_id and bd_status='1' and p.prj_usr_id='".$row->usr_id."' and p.prj_id=rr_prj_id and rr_from_usr=p.prj_usr_id and rr_to_usr='".$row->usr_id."' order by p.prj_updated_date desc limit 5";
				$res_ecw=mysql_query($sql_ecw);
				if(mysql_num_rows($res_ecw)>0){
					while($row_ecw=mysql_fetch_object($res_ecw)){
			?>
            <div class="widget-container-span ui-sortable">
				<div class="widget-box">
					<div class="widget-header header-color-dark">
						<h5 class="bigger lighter"><a style="text-decoration:none; color:#FFF" href="project.php?p=<?php echo $row_ecw->prj_id; ?>"><?php echo $row_ecw->prj_name; ?></a></h5>
                        <div class="widget-toolbar">
                        
							<h5 class="bigger lighter"><?php echo getCurrencySymbol().number_format($row_ecw->bd_amount,2)."&nbsp;".getCurrencyCode(); ?></h5>
						</div>
					</div>

					<div class="widget-body">
	                    <div class="widget-toolbox" style="height:22px; vertical-align:middle;">
                        <div class="ns_ratings-new" style="width:250px; position:absolute; margin-left:10px;">
                    <?php
					$sql_rt_rv="select count(*),sum(rr_work_quality),sum(rr_communication),sum(rr_expertise), sum(rr_work_hire_again), sum(rr_professionalism), sum(rr_completionrate),count(rr_review) from review_rating where rr_id='".$row_ecw->rr_id."'";

					$res_rt_rv=mysql_query($sql_rt_rv);
					$row_rt_rv=mysql_fetch_array($res_rt_rv);

					$avg_rt=0;
					if($row_rt_rv[0] != 0)
					{
						$avg_rt=((($row_rt_rv[1]+$row_rt_rv[2]+$row_rt_rv[3]+$row_rt_rv[4]+$row_rt_rv[5])+($row_rt_rv[6]*10)))/$row_rt_rv[0]/6;
					}

			?>
                	<div class="ns_ratings-new ns_active-stars" style="width:<?php echo $avg_rt*10; ?>%;"></div><div style="padding-left:80px;"><?php echo number_format($avg_rt,1); ?></div>
                    
                    </div>
                    
                        <div style="float:right; padding-right:8px;"><?php    echo date("d-M-Y",strtotime($row_ecw->rr_updated_date));	?></div>
						</div>
						<div class="widget-main padding-16" style="min-height:70px;">
                        <?php	if($row_ecw->usr_image == ''){ ?>
							<img src="images/unknown.jpg" width="58" height="54" align="left">
						<?php	} else { 	?>
							<img src="images/users/<?php echo $row_ecw->usr_image; ?>" width="58" height="54" align="left">
						<?php } ?>
                        
                        	<div style="margin-left:68px;" align="left"><?php	echo stripslashes($row_ecw->rr_review);	?> </div>
                            <div style="margin-top:35px;"><b><?php echo $lang[498]; ?></b>&nbsp;<?php	echo stripslashes($row_ecw->prj_details);	?></div>
						</div>
					</div>
				</div>
			</div>
            <?php }    
                                                      
                }else{     ?>
                   <span style="color:#F00"><?php echo $row->usr_name; ?>&nbsp;<?php echo $lang[371]; ?></span>
         <?php } ?>	
            <!---->
            </p>
		</div>
		<div id="EmployerWorkInProgress" class="tab-pane active">
			<p>
            <!---->
            <?php
				$sql_ewp="select * from project,bid,user where bd_prj_id=prj_id and bd_usr_id=usr_id and prj_usr_id='".$row->usr_id."' and  bd_status=1 and prj_status='running' and prj_id not in(select rr_prj_id from review_rating where rr_from_usr=prj_usr_id) order by prj_expiry desc limit 5";
				$res_ewp=mysql_query($sql_ewp);
				if(mysql_num_rows($res_ewp)>0){
					while($row_ewp=mysql_fetch_object($res_ewp)){
			?>
            <div class="widget-container-span ui-sortable">
				<div class="widget-box">
					<div class="widget-header header-color-dark">
						<h5 class="bigger lighter"><a style="text-decoration:none; color:#FFF" href="project.php?p=<?php echo $row_ewp->prj_id; ?>"><?php echo $row_ewp->prj_name; ?></a></h5>
						<div class="widget-toolbar">
							<h5 class="bigger lighter"><?php echo getCurrencySymbol().number_format($row_ewp->bd_amount,2)."&nbsp;".getCurrencyCode(); ?></h5>
						</div>
					</div>

					<div class="widget-body">
	                    <div class="widget-toolbox">
							<?php echo $lang[373]; ?>&nbsp;<?php    echo date("d-M-Y",strtotime($row_ewp->prj_expiry));	?>		
						</div>
						<div class="widget-main padding-16">
							<?php echo stripslashes($row_ewp->prj_details);?>
						</div>
					</div>
				</div>
			</div>
            <?php }    
                }else{     ?>
                     <span style="color:#F00"><?php echo $row->usr_name; ?>&nbsp;<?php echo $lang[380]; ?></span>
         <?php } ?>	
            <!---->
            </p>
		</div>
		<div id="EmployerOpenProjects" class="tab-pane">
			<p>
            <!---->
            <?php
				$sql_eop="select * from project where prj_usr_id='".$row->usr_id."' and now()<prj_expiry and prj_id not in(select bd_prj_id from bid where bd_status=1) and prj_status='open' order by prj_updated_date desc limit 5";
				$res_eop=mysql_query($sql_eop);
				if(mysql_num_rows($res_eop)>0){
					while($row_eop=mysql_fetch_object($res_eop)){
			?>
            <div class="widget-container-span ui-sortable">
				<div class="widget-box">
					<div class="widget-header header-color-dark">
						<h5 class="bigger lighter"><a style="text-decoration:none; color:#FFF" href="project.php?p=<?php echo $row_eop->prj_id; ?>"><?php echo $row_eop->prj_name; ?></a></h5>
						
					</div>

					<div class="widget-body">
	                    <div class="widget-toolbox">
							<?php                    
                                 $diff=dateDifference($row_eop->prj_expiry,date("Y-m-d h:i:s"));
                                 if($diff==0){   echo $lang[381]."&nbsp;".$lang[354];    }
                                 else{   echo $lang[381]." ".date("d-M-Y",strtotime($row_eop->prj_expiry));   }
                            ?> 
						</div>
						<div class="widget-main padding-16">
							<?php echo stripslashes($row_eop->prj_details);?>
						</div>
					</div>
				</div>
			</div>
            <?php }    
                }else{     ?>
					<span style="color:#F00"><?php echo $row->usr_name; ?>&nbsp;<?php echo $lang[382]; ?></span>
         <?php } ?>		
            <!---->
            </p>
		</div>
	</div>
</div>
</div>
</div>