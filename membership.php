<?php
ob_start();
session_start();
include "common.php";


$sql_pchk="select * from user where usr_id='".$_SESSION['uid']."'";
$res_pchk=mysql_query($sql_pchk);
$row_pchk=mysql_fetch_object($res_pchk);

?>

   	<?php include "includes/header.php"; ?>
	
	<<div class="section db" style="background-image:url('upload/parallax_02.jpg');">
                <div class="container">
                    <div class="page-title text-center">
                        <div class="heading-holder">
                            <h1>Membership</h1>
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
                                    <li><a href="profile.php"><span class="glyphicon glyphicon-briefcase"></span>  <?php echo $lang[126]; ?></a></li>
                                    <li><a href="change-password.php"><span class="glyphicon glyphicon-briefcase"></span>  <?php echo $lang[127]; ?></a></li>
                                    <li class="active"><a href="membership.php"><span class="glyphicon glyphicon-refresh"></span>  <?php echo $lang[128]; ?></a></li>
                                </ul>
                            </div><!-- end widget -->
                        </div><!-- end col -->

                        <div class="content col-md-9">
                            <div class="post-padding">
                                <div class="job-title nocover hidden-sm hidden-xs"><h5><?php echo $lang[128]; ?></h5></div>
                                
                                    
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">   
                                            <h4><?php echo $lang[769]; ?></h4>
											<hr>
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
												<div class="col-md-3 col-sm-4 col-xs-12" style="padding-bottom:10px;padding-top:10px;">
													<div class="pricing-box">
														
														<div class="pricing-price" >
															<p style="padding:20px 0;font-size:20px;background:<?php echo $back_color[$col]; ?>;color:#fff;"><?php echo stripslashes(ucfirst($row_mp->mp_name)); ?></p>
														</div>
														<!-- end price -->
														
														<div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">
															<div class="panel panel-default">
																<div class="panel-heading" role="tab" id="headingOne">
																	<h4 class="panel-title" style="padding:5px 0;">
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
																		<p style="color:#000;margin:0 0 0px;"><?php echo $lang[766]; ?>  <?php echo stripslashes(ucfirst($row_mp->mp_portfoliosize)); ?><?php echo $lang[800]; ?></p>
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
														<form id="plan-<?php echo $row_mp->mp_id; ?>" method="post" action="membership-res.php">
															<input class="btn btn-primary btn-block" type="hidden" name="mp_id" id="mp_id" value="<?php echo $row_mp->mp_id; ?>"/>
														</form>
															<?php
																$today = date("Y-m-d", strtotime("now"));
																$expiry = date("Y-m-d", strtotime($row_pchk->usr_mem_expiry));
																if($row_mp->mp_id != 1){
																	if($row_pchk->usr_mp_id == $row_mp->mp_id && $today<=$expiry){	?>
																		<a class="btn btn-block btn-sm btn-<?php echo $btn_color[$col]; ?>" style="pointer-events: none;"><?php echo $lang[767]; ?></a>
																		<br/>
																		<?php echo $lang[381]; ?>&nbsp;<?php echo date("d-M-Y", strtotime($row_pchk->usr_mem_expiry)); ?>
																	<?php }else{	?>
													
																		<a class="btn btn-block btn-sm btn-<?php echo $btn_color[$col]; ?>" onClick="choosePlan(<?php echo $row_mp->mp_id; ?>)">
																	<span><?php echo $lang[771]; ?></span>
																	</a>
													
																<?php	}	?>
															<?php	}	?>
														</div>
														<!-- end desc -->
													</div>
													<!-- end pricing-box -->
												</div>
												<!-- end col -->
												<?php $col++; } ?>
												
											</div>
                                            
                                            
											
                                            
                                        </div>
                                    </div><!-- end row -->
                                    
								
                            </div><!-- end post-padding -->
                        </div><!-- end col -->
                    </div><!-- end row -->  
                </div><!-- end container -->
            </div><!-- end section -->
	
	
    <script>
function choosePlan(mpid)
{
	//$.noConflict();
	//$.ajax({
//       type: "POST",
//       contentType: "application/json; charset=utf-8",
//       url: "payment-deposit.php",
//       dataType: "json",
//            data: {mp_id:mpid},
//            complete:
//            function () {
//                window.location = "payment-deposit.php";
//            }
//    });
		
		
	document.getElementById("plan-"+mpid).submit();
}
</script>
	<div class="ns_clear"></div>
	<div class="grid">
	<link href="css/jquery-ui-1.css" rel="stylesheet" type="text/css">


<style>
.ns_features .generic_hover, .membership-bottom-note .generic_hover {width:170px; font-weight:normal; font-size:12px;}
</style>


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
	
	<div class="ns_clear"></div>
<div id="alert-dialog" title="Alert"></div>
<?php include "includes/footer.php"; ?>