<?php
ob_start();
session_start();
include "common.php";

if($_SESSION['uid']==''){	header("location:login.php");	}

if($_GET['u']==''){	header("location:".$_SESSION['last_page']);	}

$sql="select * from user where md5(usr_id)='".$_GET['u']."'";
$res=mysql_query($sql);
$row=mysql_fetch_object($res);

if(isset($_SESSION['msg'])){	$msg=$_SESSION['msg'];	unset($_SESSION['msg']);	}

class InviteUser
{
	var $msg;
	var $iu_usr_id;
	var $iu_prj_id;
	
	function __construct($iu_usr_id,$iu_prj_id)
	{
		$this->iu_usr_id=$iu_usr_id;
		$this->iu_prj_id=$iu_prj_id;
	}
	
	function valid()
	{
          include "language.php";
		$valid=true;
		if($this->iu_prj_id == "")
		{
			$this->msg= '<font color="#CC0000">'.$lang[325].'</font>';
			$valid=false;
		}
		return $valid;
	}
	
	function add()
	{
        include "language.php";   
		$sql="insert into invited_user
	  	set		
			iu_usr_id ='".$this->iu_usr_id."',
			iu_prj_id ='".$this->iu_prj_id."',
			iu_updated_date=now()";
		mysql_query($sql) or die(mysql_error());
		
		
		/******* Code for notification start here *********/
		
		$sql_proj="select * from project where prj_id='".$this->iu_prj_id."'";
		$res_proj=mysql_query($sql_proj);
		$row_proj=mysql_fetch_object($res_proj);
		
		$sql_un="insert into user_notification
		set
			un_usr_id='".$this->iu_usr_id."',
			un_from_usr_id='".$_SESSION['uid']."',
			un_type='invite',
			un_content='".$_SESSION['usr']." ".$lang[326]." <span style=\"color:#309\">".$row_proj->prj_name."</span>.',
			un_prj_id='".$this->iu_prj_id."',
			un_updated_date=now()";
			
		mysql_query($sql_un);
		
		/******* Code for notification end here *********/
		
		
		$this->msg='<font color="#009900">'.$lang[327].'</font>';
	}
}
if(isset($_POST['invite_user']))
{
	$adn=new InviteUser(addslashes(trim($_POST['iu_usr_id'])),addslashes(trim($_POST['iu_prj_id'])));

	if($adn->valid())
	{	
		$adn->add();		
	}
	//echo $ecms->msg;
	$_SESSION['msg']=$adn->msg;
	header("location:inviteUser.php?u=".md5($row->usr_id));
}
?>
    <?php include "includes/header.php"; ?>
  
<<div class="section db" style="background-image:url('upload/parallax_02.jpg');">
                <div class="container">
                    <div class="page-title text-center">
                        <div class="heading-holder">
                            <h1><?php echo $lang[132]; ?></h1>
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
                                
                                    
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">   
										
										 

											<div id="transfer-form1" class="col-xs-12">
												<legend><h3><?php echo $lang[328]; ?></h3></legend>
												
												<div><?php echo $msg; ?></div>
												
												<?php 
													$sql_pr="select * from project where prj_usr_id='".$_SESSION['uid']."' and now()<prj_expiry and prj_id not in(select bd_prj_id from bid where bd_status=1) and prj_status='open' and prj_id not in(select iu_prj_id from invited_user where iu_usr_id='".$row->usr_id."') and prj_id not in(select bd_prj_id from bid where bd_usr_id='".$row->usr_id."') order by prj_updated_date desc";
													$res_pr=mysql_query($sql_pr);
													if(mysql_num_rows($res_pr)>0)	{?>
													
													<form action="" method="post" class="form-horizontal">
												<div class="control-group search-bar-group">
													
													<div class="control-group"><h3><?php echo $lang[329]; ?></h3></div>
													
													<?php 
													while($row_pr=mysql_fetch_object($res_pr)) {

												?>
												
											   
													<label>
														<input type="radio" name="iu_prj_id" id="iu_prj_id" value="<?php echo $row_pr->prj_id; ?>" class="ace"/><span class="lbl">&nbsp;<?php echo $row_pr->prj_name; ?></span>
														 <input type="hidden" name="iu_usr_id" id="iu_usr_id" value="<?php echo $row->usr_id; ?>"/>
													</label>
												
												
												<?php } ?>
												
												</div>
												<div class="space-6"></div>
												<div class="form-group">
													<div class="col-md-12">
													<button type="submit" id="btn_next_id" class="btn btn-info" name="invite_user"><?php echo $lang[330]; ?></button>
													</div>
												</div>
												</form>
												
												<?php	}	else	{	?>
												<div class="control-group">
													<h3><font color="#FF0000"><?php echo $lang[331]; ?></font></h3>
												</div>
														
												<?php 	}	?>
												  
											</div>

												 <?php /*include "dashboard.php";*/ ?>
												 
												 
											 
										
										
										
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