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

//$sql="select * from user where usr_id='".$usr_id."'";
$res=mysql_query($sql);
$row=mysql_fetch_object($res);


if(isset($_POST['updatePortfolio']))
{
    
	$skills="";
	foreach($_POST['up_skills'] as $val)
	{
		$skills.=$val.",";
	}
	$up_id=addslashes(trim($_POST['up_id']));
	$up_title=addslashes(trim($_POST['up_title']));
	$up_description=addslashes(trim($_POST['up_description']));

	if($_FILES["up_file"]["name"] != "")
	{
		if ($_FILES["up_file"]["error"] > 0)
		{
			$msg = "Return Code: " . $_FILES["up_file"]["error"] . "<br />";
		}
		else
		{
			$up_file='pfolio'.rand(0,9999).trim(addslashes($_FILES['up_file']['name']));	
			
			$ds = move_uploaded_file($_FILES["up_file"]["tmp_name"], "images/users/portfolio/".$up_file) or die('error');
			
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
<?php include "includes/header.php"; ?>
<script language="javascript">
function showFreelancerOverview()
{
	////$.noConflict();
	$('.buyer').hide();
	$('.seller').show();
	
	$("#showFreelancerOverview").addClass("ns_selected");
	$("#showEmployerOverview").removeClass("ns_selected");
      
      $('#freel_reputation').css({"display":"block"});
      $('#empl_reputation').css({"display":"none"}); 
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
//	showEmployerCompletedWork();
}
function showFreelancerFeedback()
{
	////$.noConflict();
	$('#freelancer_reputation').css({"display":"block"});
	$('#showFreelancerFeedback').addClass('ns_selected');
	$('#employer_reputation').css({"display":"none"});			
	$('#showEmployerFeedback').removeClass('ns_selected');
	$('#freelancerWorkFeedback').css({"display":"block"});
	$('#employerWorkFeedback').css({"display":"none"});
      
          
}
function showEmployerFeedback()
{
	////$.noConflict();
	$('#employer_reputation').css({"display":"block"});
	$('#showEmployerFeedback').addClass('ns_selected');
	$('#freelancer_reputation').css({"display":"none"});			
	$('#showFreelancerFeedback').removeClass('ns_selected');
	$('#freelancerWorkFeedback').css({"display":"none"});
	$('#employerWorkFeedback').css({"display":"block"});
      
      
      
}
//$(document).ready(
//	function(){		
//		$('#showFreelancerFeedback').click(function(){	
//		});        
//});
//$(document).ready(
//	function(){		
//		$('#showEmployerFeedback').click(function(){	
//			
//		});        
//});


function changeProfilePic()
{
	window.location.href="changeuserinfo.php";
}
function showOV()
{
	////$.noConflict();
	$('#overview_section').css({"display":"block"});
	$('#feedback_section').css({"display":"none"});
	$('#portfolio-section').css({"display":"none"});
	$('#resume').css({"display":"none"});
	$('#edit-skills').css({"display":"none"});
}
function showFB()
{
	////$.noConflict();
	$('#overview_section').css({"display":"none"});
	$('#feedback_section').css({"display":"block"});
	$('#portfolio-section').css({"display":"none"});
	$('#resume').css({"display":"none"});
	$('#edit-skills').css({"display":"none"});
}
function showPO()
{
	////$.noConflict();
	$('#overview_section').css({"display":"none"});
	$('#feedback_section').css({"display":"none"});
	$('#portfolio-section').css({"display":"block"});
	$('#resume').css({"display":"none"});
	$('#edit-skills').css({"display":"none"});
}
function showRS()
{
	////$.noConflict();
	$('#overview_section').css({"display":"none"});
	$('#feedback_section').css({"display":"none"});
	$('#portfolio-section').css({"display":"none"});
	$('#resume').css({"display":"block"});
	show_resume('<?php  echo $usr_id; ?>');
	$('#edit-skills').css({"display":"none"});
}
function showSK()
{
	////$.noConflict();
	$('#overview_section').css({"display":"none"});
	$('#feedback_section').css({"display":"none"});
	$('#portfolio-section').css({"display":"none"});
	$('#resume').css({"display":"none"});
	$('#edit-skills').css({"display":"block"});
}

function showAddHourlyForm()
{
	////$.noConflict();
	$('#add_hourly_form').css({"display":"block"});
}
function saveHourlyRate()
{
	////$.noConflict();
	$('#ajaxloader').css({"display":"block"});
	var hourlyRate = $("#input_hourly_rate").val();
	
	if(hourlyRate == '' || hourlyRate == ' ' || hourlyRate == '0')
	{
		alert('<?php echo $lang[622]; ?>');	
	}
	else
	{
		$.get("ajax-file/updateHourlyRate.php", {hourlyRate:hourlyRate}, function(data){	
                $('#hrRate').text(data);
                
			$('#add_hourly_form').css({"display":"none"});
		});
	}
	$('#ajaxloader').css({"display":"none"});
}
function cancelHourlyRate()
{
	$('#add_hourly_form').css({"display":"none"});
}
function show_resume(id)
{
	////$.noConflict();
	$.get("resume.php", {uid:id},	function(data){	$("#resume").html(data);	});
}
</script>

	<div class="profile-box bx-border-radius-6 clearfix">
		<div class="profile-box-lft-col">
        	<p class="txt1"><?php echo $lang[460]; ?></p>
		<p><?php echo $lang[461]; ?></p>
		</div>
		<div class="profile-box-rgt-col">
			<p class="txt1"><?php echo $lang[337]; ?>&nbsp;<?php echo profileCompleteness($row->usr_id); ?>% <?php echo $lang[338]; ?></p>
<!--			<div><img src="images/account-setup-img.jpg" alt="" /></div>-->
                  <div class="ns_progress-bar-container">
            		<div class="ns_progress-bar" style="width:<?php echo profileCompleteness($row->usr_id); ?>%"></div>
			</div>
		</div>
	</div>
		<div class="clearfix">
			<div class="freelancer-portfolio-lft-col">
				<div class="freelancer-img-col">
					<div class="img-frame-box">
					<div><img src="images/users/<?php if($row->usr_image != ''){ echo $row->usr_image; }else{ echo "unknown.png"; } ?>" class="img-frame" alt="" height="264px" width="269px" />
                                          
                                </div>
                                <?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row->usr_id)){ ?>
					<div style="position:absolute;right:10px;bottom:16px;color:#FFFFFF;padding:5px 10px;">
                                     <span class="ns_change ns_edit">
                                         <span class="ns_icon-edit-right"></span><span class="change_profile"><a onClick="changeProfilePic()" style="cursor: pointer;"><?php echo $lang[462]; ?></a></span>
                                            </span>
                                          </div>
                                           <?php } ?>
							
							</div>
                                        
                                        <?php if($row->usr_hourlyrate == '0'){ ?>
                                            <?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row->usr_id)){ ?>
                                                <div class="rate-box"><a href="javascript:void(0)" class="add_hourly_rate" onClick="showAddHourlyForm()"><?php echo $lang[463]; ?></a></div>
                                            <?php } ?>
                                        <?php } else { ?>
                                                <div class="rate-box"><?php echo $lang[464]; ?>&nbsp;<?php echo getCurrencySymbol(); ?><span id="hrRate"><?php echo $row->usr_hourlyrate; ?></span>&nbsp;<?php echo getCurrencyCode(); ?>/<?php echo $lang[437]; ?> 
    <?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row->usr_id)){ ?>
             <a style="cursor: pointer" onClick="showAddHourlyForm()">[<?php echo $lang[399]; ?>]</a>
    <?php } ?>
    </div>              
                                        <?php } ?>
                                        <div class="ns_edit ns_box" id="add_hourly_form" style="display: none;">
                                            <form class="ns_form ns_pad">
                                            <div class="ns_field">
                                            <div class="ns_col ns_last" style="width:200px">
                                            <label for="password"><?php echo $lang[465]; ?></label>
                                            <div class="ns_form-prefix"><?php echo getCurrencyCode(); ?>&nbsp;<?php echo getCurrencySymbol(); ?></div>
                                            <input id="input_hourly_rate" class="ns_short" type="text" />&nbsp;<span class="ns_right ns_form-prefix" style="font-size:16px;"> /<?php echo $lang[661]; ?></span>
                                            </div>
                                            <div class="ns_clear"></div>
                                            <img class="ns_left"src="images/ajax-loader.gif" style="display:none;" id="ajaxloader" />
                                            <p id="rate_amount_warning" class="ns_color-red ns_pad-none ns_left ns_margin-top-small" style="display: none;"></p>
                                            </div>
                                            <a href="javascript:void(0)" class="ns_btn-small ns_blue ns_left" id="save_hourly_rate" onClick="saveHourlyRate()"><?php echo $lang[106]; ?></a> <a href="javascript:void(0)" class="ns_btn-small ns_left" id="cancel_hourly_rate" onClick="cancelHourlyRate()"><?php echo $lang[398]; ?></a>
                                            <div class="ns_clear"></div>
                                            </form>
                                        </div>
                    <?php
				if(isset($_SESSION['uid']) && $row->usr_id!=$_SESSION['uid']){
                    ?>
					<div><a href="inviteUser.php?u=<?php echo md5($row->usr_id); ?>" class="hire-me-btn"><?php echo $lang[328]; ?></a></div>
                    <?php } ?>
                                          
                                          
							
			</div>
                  
			<?php include "profile-overview.php"; ?>
			</div>
			<div class="freelancer-portfolio-rgt-col">
                     <?php if($row->usr_type=="Both"){  ?> 
                        <div class="ns_right ns_margin-10" style="float: left">
      <a href="javascript:showFreelancerOverview()" id="showFreelancerOverview" btntype="seller" class="ns_toggle-btn ns_btn-left ns_left ns_selected"><?php echo $lang[64]; ?></a>
      <a href="javascript:showEmployerOverview()" id="showEmployerOverview" btntype="buyer" class="ns_toggle-btn ns_btn-right ns_left"><?php echo $lang[60]; ?></a>
      <div class="ns_clear"></div>
                        </div>
                     <?php }    ?>
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
                            
                            
				</div>
					<div class="portfolio-body-nav-section">
						<ul>                                               
							<li><a href="javascript:showOV();"><?php echo $lang[467]; ?></a></li>
							<li><a href="javascript:showFB()"><?php echo $lang[468]; ?></a></li>
							<li><a href="javascript:showPO();"><?php echo $lang[387]; ?></a></li>
							<li><a href="javascript:showRS()"><?php echo $lang[469]; ?></a></li>
                                          <li><a href="javascript:showSK()"><?php echo $lang[395]; ?></a></li>
						</ul>
						
					</div>
<div id="overview_section" >
    
<?php include "overview.php"; ?>
</div>

<div class="resume-col" id="feedback_section" style="display:none">
    <?php include "feedback.php"; ?>    
</div>

<div class="portfolio-section " id="portfolio-section" style="display:none">
    <?php  include "portfolio.php"; ?>
</div>

<div class="resume-col" id="resume" style="display:none">
    <?php //  include "resume.php"; ?>
</div>

<div class="grid_8 profile_content ns_edit-skills resume-col" id="edit-skills" style="display:none">
	<?php include "skills.php"; ?>	
    </div>

<!--js for new design starts -->
        
        <script type="text/javascript">
			window.jQuery || document.write("<script src='new_design/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='new_design/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='new_design/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="new_design/js/bootstrap.min.js"></script>
		<script src="new_design/js/typeahead-bs2.min.js"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="assets/js/excanvas.min.js"></script>
		<![endif]-->

		<script src="new_design/js/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="new_design/js/jquery.ui.touch-punch.min.js"></script>
		<script src="new_design/js/chosen.jquery.min.js"></script>
		<script src="new_design/js/fuelux/fuelux.spinner.min.js"></script>
		<script src="new_design/js/date-time/bootstrap-datepicker.min.js"></script>
		<script src="new_design/js/date-time/bootstrap-timepicker.min.js"></script>
		<script src="new_design/js/date-time/moment.min.js"></script>
		<script src="new_design/js/date-time/daterangepicker.min.js"></script>
		<script src="new_design/js/bootstrap-colorpicker.min.js"></script>
		<script src="new_design/js/jquery.knob.min.js"></script>
		<script src="new_design/js/jquery.autosize.min.js"></script>
		<script src="new_design/js/jquery.inputlimiter.1.3.1.min.js"></script>
		<script src="new_design/js/jquery.maskedinput.min.js"></script>
		<script src="new_design/js/bootstrap-tag.min.js"></script>

		<!-- ace scripts -->

		<script src="new_design/js/ace-elements.min.js"></script>
		<!--<script src="new_design/js/ace.min.js"></script>-->

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
        <!--js for new design ends-->

    <div class="pg-bottom-text">
	<?php echo get_page_content('3'); ?>
	
	</div>
</div>
</div>
<?php include "includes/footer.php"; ?>