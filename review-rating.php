<?php
ob_start();
session_start();
include "common.php";

$_SESSION['last_page']="review-rating.php?b=".$_GET['b'];

if($_SESSION['uid']=='')
{
	header("location:login.php");	
}

$bd_id=$_GET['b'];

$sql_bid="select * from bid,project where bd_id='".$bd_id."' and bd_prj_id=prj_id";

$res_bid=mysql_query($sql_bid);
$row_bid=mysql_fetch_object($res_bid);

$from_user_id=$_SESSION['uid'];
$to_user_id="";
if($row_bid->bd_usr_id == $_SESSION['uid'])
{
	$to_user_id=$row_bid->prj_usr_id;
}
else if($row_bid->prj_usr_id == $_SESSION['uid'])
{
	$to_user_id=$row_bid->bd_usr_id;
}

$sql_chk="select * from review_rating where rr_prj_id='".$row_bid->prj_id."' and rr_from_usr='".$_SESSION['uid']."' and rr_to_usr='".$to_user_id."'";

$res_chk=mysql_query($sql_chk);
$upd_rating=mysql_num_rows($res_chk);


/*$sql_from_user="select * from user where usr_id='".$from_user_id."'";
$res_from_user=mysql_query($sql_from_user);
$row_from_user=mysql_fetch_object($res_from_user);

$sql_to_user="select * from user where usr_id='".$to_user_id."'";
$res_to_user=mysql_query($sql_to_user);
$row_to_user=mysql_fetch_object($res_to_user);*/




/*if(isset($_POST['updatePortfolio']))
{
    include "language.php";
	$skills="";
	foreach($_POST['up_skills'] as $val)
	{
		$skills.=$val.",";
	}
	$up_id=addslashes(trim($_POST['up_id']));
	$up_title=addslashes(trim($_POST['up_title']));
	$up_description=addslashes(trim($_POST['up_description']));

	
	$sql="update user_portfolio
		set	
			up_title ='".$up_title."',
			up_description ='".$up_description."',								
			up_skills='".$skills."'
		where
			up_id = '".$up_id."'";
					
	mysql_query($sql) or die(mysql_error());
														
	$msg='<font color="#009900">Portfolio updated successfully</font>';	

}*/

?>
   	<?php include "includes/header.php"; ?>
<script type="text/javascript">
function saveReviewRating()
{
//      $('#btn').css({"display":"none"});
	$('#ajaxloader').css({"display":"block"});
//	$('#saveBut').css({"display":"none"});
	
	rr_prj_id=$('#rr_prj_id').val();
	rr_to_usr=$('#rr_to_usr').val();
	rr_from_usr=$('#rr_from_usr').val();
	rr_work_quality=$('#rr_work_quality').val();
	rr_communication=$('#rr_communication').val();
	rr_expertise=$('#rr_expertise').val();
	rr_work_hire_again=$('#rr_work_hire_again').val();
	rr_professionalism=$('#rr_professionalism').val();
	rr_completionrate=$('#rr_completionrate').val();
	rr_review=$('textarea#rr_review').val();

	if(rr_review == '')
	{
		alert('<?php echo $lang[519]; ?>');
		$("#rr_review").focus();
            //return false;
	}
	else
	{
		$.get("ajax-file/addReviewRating.php", {rr_prj_id:rr_prj_id,rr_to_usr:rr_to_usr,rr_from_usr:rr_from_usr,rr_work_quality:rr_work_quality,rr_communication:rr_communication,rr_expertise:rr_expertise,rr_work_hire_again:rr_work_hire_again,rr_professionalism:rr_professionalism,rr_completionrate:rr_completionrate,rr_review:rr_review}, function(data){
		$('#ajaxloader').css({"display":"none"});
		$('#res').css({"display":"block"});
            $('#btn').css({"display":"none"});
		});
	}
	
}
function updReviewRating()
{
//      $('#btn_upd').css({"display":"none"});
//	$('#ajaxloader_upd').css({"display":"block"});
//	$('#saveBut_upd').css({"display":"none"});
	
	rr_id=$('#rr_id').val();
	rr_work_quality=$('#rr_work_quality :selected').val();
	rr_communication=$('#rr_communication :selected').val();
	rr_expertise=$('#rr_expertise :selected').val();
	rr_work_hire_again=$('#rr_work_hire_again :selected').val();
	rr_professionalism=$('#rr_professionalism :selected').val();
	rr_review=$('textarea#rr_review').val();
	

	if(rr_review == '')
	{
		alert('<?php echo $lang[519]; ?>');
		$("#rr_review").focus();
            //return false;
	}
	else
	{
		$.get("ajax-file/updReviewRating.php", {rr_id:rr_id,rr_work_quality:rr_work_quality,rr_communication:rr_communication,rr_expertise:rr_expertise,rr_work_hire_again:rr_work_hire_again,rr_professionalism:rr_professionalism,rr_review:rr_review}, function(data){
		$('#ajaxloader_upd').css({"display":"none"});
		$('#res_upd').css({"display":"block"});
            $('#btn_btn').css({"display":"none"});
		});
	}
	
}
</script>


	<div class="page-header"><h1><?php echo $lang[468]; ?></h1></div>
    <div class="row">
		<div class="col-xs-12">
	<form method="post" action="" class="form-horizontal" id="changenotificationsform" >
                    
		<input type="hidden" name="rr_prj_id" id="rr_prj_id" value="<?php echo $row_bid->prj_id; ?>"/>
		<input type="hidden" name="rr_to_usr" id="rr_to_usr" value="<?php echo $to_user_id; ?>"/>
		<input type="hidden" name="rr_from_usr" id="rr_from_usr" value="<?php echo $from_user_id; ?>"/>
                  
			
						
		<div class="signup-form-str" id="msg"><?php echo $msg; ?></div>
                                
		<div class="form-group">
			<label class="col-sm-4 control-label no-padding-right" for="rr_work_quality"><?php echo $lang[312]; ?></label>
			<div class="col-sm-6">
	    		<input type="text" class="input-mini" id="rr_work_quality" name="rr_work_quality" readonly="readonly" />
			</div>
		</div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="rr_work_quality"><?php echo $lang[313]; ?></label>
						<div class="col-sm-6">
	                        <input type="text" class="input-mini" id="rr_communication" name="rr_communication" readonly="readonly" />
						</div>
					</div>
                    <div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="rr_expertise"><?php echo $lang[314]; ?></label>
						<div class="col-sm-6">
							<input type="text" class="input-mini" id="rr_expertise" name="rr_expertise" readonly="readonly" />
						</div>
					</div>
                   <div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="rr_work_hire_again"><?php echo $lang[315]; ?></label>
						<div class="col-sm-6">
	                        <input type="text" class="input-mini" id="rr_work_hire_again" name="rr_work_hire_again" readonly="readonly" />
						</div>
					</div>
                    <div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="rr_professionalism"><?php echo $lang[316]; ?></label>
						<div class="col-sm-6">
	                        <input type="text" class="input-mini" id="rr_professionalism" name="rr_professionalism" readonly="readonly" />
						</div>
					</div>
                        <?php if($upd_rating<1){ ?>
                    <div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="rr_work_quality"><?php echo $lang[521]; ?></label>
					<div class="col-sm-6">
						<select name="rr_completionrate" id="rr_completionrate" class="spinner3">
        <!--         <option value="" selected="selected"><?php /*echo $lang[526];*/ ?></option>-->
                                           <option value="1" selected="selected"><?php echo $lang[522]; ?></option>
                                           <option value="0"><?php echo $lang[523]; ?></option>
                                    </select>
					</div>
				</div>
                        <?php } ?>
						<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="rr_professionalism"><?php echo $lang[524]; ?></label>
                    <div class="col-sm-6">
								<textarea class="form-control" name="rr_review" id="rr_review" rows="10"></textarea>
	                        </div>
						</div>
								

                        <?php if($upd_rating<1){ ?>        		
				<div class="form-group" id="btn">
       				<div class="col-md-12">
						<input type="button" id="subm" name="btnSave" value="<?php echo $lang[270]; ?>" class="btn btn-info" onClick="saveReviewRating()">
					</div>
				</div>
                        <div class="signup-form-str" id="res" style="display:none">
                            <div style="color:#063; font-size:10px;"><?php echo $lang[525]; ?></div>
                        </div>
                        <div class="signup-form-str" id="ajaxloader">
                            <div  style="display:none;"><img style="left: 200px; top: 200px;" src="images/ajax-loader_002.gif"></div>
                        </div>
                        <?php   }else{   
                        $row_chk=mysql_fetch_object($res_chk);
                        ?>
                        <input type="hidden" id="rr_id" name="rr_id" value="<?php echo $row_chk->rr_id; ?>"/>
                        
                        <div class="form-group" id="btn_upd">
        				<div class="col-md-12">
						<input type="button" id="subm" name="btnSave" class="btn btn-info" value="<?php echo $lang[270]; ?>" onClick="updReviewRating()">
					</div>
				</div>
               
               	<div class="signup-form-str" id="res_upd" style="display:none">
               		<div style="color:#063; font-size:10px;"><?php echo $lang[666]; ?></div>
                </div>
                        <div class="signup-form-str" id="ajaxloader_upd">
                            <div  style="display:none;"><img style="left: 200px; top: 200px;" src="images/ajax-loader_002.gif"></div>
                        </div>
                        <?php } ?>
				
            </form>
        	</div>
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
				
				$('#rr_work_quality').ace_spinner({value:0,min:0,max:10,step:1, on_sides: true, icon_up:'icon-plus smaller-75', icon_down:'icon-minus smaller-75', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
				$('#rr_communication').ace_spinner({value:0,min:0,max:10,step:1, on_sides: true, icon_up:'icon-plus smaller-75', icon_down:'icon-minus smaller-75', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
				$('#rr_expertise').ace_spinner({value:0,min:0,max:10,step:1, on_sides: true, icon_up:'icon-plus smaller-75', icon_down:'icon-minus smaller-75', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
				$('#rr_work_hire_again').ace_spinner({value:0,min:0,max:10,step:1, on_sides: true, icon_up:'icon-plus smaller-75', icon_down:'icon-minus smaller-75', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
				$('#rr_professionalism').ace_spinner({value:0,min:0,max:10,step:1, on_sides: true, icon_up:'icon-plus smaller-75', icon_down:'icon-minus smaller-75', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
				
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
        
        <div class="pg-bottom-text">
            <?php echo get_page_content('3'); ?>
		<?php
                      $sql_adv="select * from advertisement where adv_status='1' order by rand() limit 1";
                      $res_adv=mysql_query($sql_adv);
                      if(mysql_num_rows($res_adv)>0){
                      ?>
				<ul>
					<li>
                              <?php
                              
                              $row_adv=mysql_fetch_object($res_adv);
                              
                              ?>
                                  <a href="<?php echo $row_adv->adv_link; ?>" target="blank"><img src="upload/advertisement/<?php echo $row_adv->adv_img; ?>" height="<?php echo $row_adv->adv_imageheight; ?>" width="<?php echo $row_adv->adv_imagewidth; ?>"/></a>
                               
                                  </li>
					
				</ul>
                      <?php } ?>
       </div>
	</div>
</div>
<?php include "includes/footer.php"; ?>