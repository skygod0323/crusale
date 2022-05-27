<?php
ob_start();
session_start();
include "common.php";

if($_SESSION['uid']=='')
{
	header("location:login.php");	
}
$sql="select * from user where usr_id=".$_SESSION['uid'];
$res=mysql_query($sql);
$row=mysql_fetch_object($res);

if(isset($_SESSION['msg'])){	$msg=$_SESSION['msg'];	unset($_SESSION['msg']);	}
if(isset($_SESSION['oldpasswd'])){ 	$oldpasswd=$_SESSION['oldpasswd'];	unset($_SESSION['oldpasswd']); }else{ $oldpasswd=""; }
if(isset($_SESSION['passwd'])){ 	$passwd=$_SESSION['passwd'];	unset($_SESSION['passwd']); }else{ $passwd=""; }
if(isset($_SESSION['passwd2'])){ 	$passwd2=$_SESSION['passwd2'];	unset($_SESSION['passwd2']); }else{ $passwd2=""; }

class updPassword
{
	var $msg;
	var $oldpasswd;
	var $passwd;
	var $passwd2;
	
	function __construct($oldpasswd, $passwd, $passwd2)
	{
		$this->oldpasswd=$oldpasswd;
		$this->passwd=$passwd;
		$this->passwd2=$passwd2;
		
		$_SESSION['oldpasswd']=$this->oldpasswd;
		$_SESSION['passwd']=$this->passwd;
		$_SESSION['passwd2']=$this->passwd2;
	}
	function valid()
	{
          include "language.php";
		$valid=true;
		
		if($this->oldpasswd == "")
		{
			$this->msg= '<font color="#CC0000">'.$lang[95].'</font>';
			$valid=false;
		}
		else if(substr($_SESSION['psw'],2) != md5($this->oldpasswd))
		{
			$this->msg='<font color="#CC0000">'.$lang[96].'</font>';
			$valid=false;
		}
		else if($this->passwd == '')
		{
			$this->msg='<font color="#CC0000">'.$lang[97].'</font>';
			$valid=false;
		}
		else if(strlen($this->passwd)<6)
		{
			$this->msg='<font color="#CC0000">'.$lang[98].'</font>';
			$valid=false;
		}
		else if($this->passwd2 == '')
		{
			$this->msg='<font color="#CC0000">'.$lang[99].'</font>';
			$valid=false;
		}
		else if($this->passwd != $this->passwd2)
		{
			$this->msg='<font color="#CC0000">'.$lang[100].'</font>';
			$valid=false;
		}
		else
		{
			$valid=true;	
		}
		return $valid;
	}
	function update()
	{
          include "language.php";
		$password=rand(10,99).md5($this->passwd);
		$sql_ps="update user
			set
				usr_password = '".$password."'
			where
				usr_id=".$_SESSION['uid'];
		mysql_query($sql_ps);
		
		$this->msg='<font color="#009900">'.$lang[101].'</font>';
		
		unset($_SESSION['oldpasswd']);
		unset($_SESSION['passwd']);
		unset($_SESSION['passwd2']);
		
		$_SESSION['psw']=$password;

	}
}
if(isset($_POST['settingSave']))
{
	$adu=new updPassword( addslashes(trim($_POST['oldpasswd'])), addslashes(trim($_POST['passwd'])), addslashes(trim($_POST['passwd2'])));
	
	if($adu->valid())
	{	
		$adu->update();
	}
		
	$_SESSION['msg']=$adu->msg;
	
	header("location:change-password.php");
}
?>
		<?php include "includes/header.php"; ?>
        
		
		<<div class="section db" style="background-image:url('upload/parallax_02.jpg');">
                <div class="container">
                    <div class="page-title text-center">
                        <div class="heading-holder">
                            <h1>Profile</h1>
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
                                    <li class="active"><a href="change-password.php"><span class="glyphicon glyphicon-briefcase"></span>  <?php echo $lang[127]; ?></a></li>
                                    <li><a href="membership.php"><span class="glyphicon glyphicon-refresh"></span>  <?php echo $lang[128]; ?></a></li>
                                </ul>
                            </div><!-- end widget -->
                        </div><!-- end col -->

                        <div class="content col-md-9">
                            <div class="post-padding">
                                <div class="job-title nocover hidden-sm hidden-xs"><h5><?php echo $lang[127]; ?></h5></div>
                                <form method="post" action="" id="" class="form-horizontal" onSubmit="return validChangePassword()">
                                    
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">   
											<div class="signup-form-str" id="msg"><?php echo $msg; ?></div>
                                            <input type="hidden" id="po" value="<?php echo substr($_SESSION['psw'],2); ?>"/>
											<label class="control-label"><?php echo $lang[103]; ?> </label>
                                            <input type="password" name="oldpasswd" id="oldpasswd" class="form-control" value="<?php echo $oldpasswd; ?>"/>
                                            <br>
											<label class="control-label"><?php echo $lang[104]; ?> </label>
                                            <input type="password" name="passwd" id="passwd" class="form-control" value="<?php echo $passwd; ?>"/>
                                            <br>
											<label class="control-label"><?php echo $lang[105];?> </label>
                                            <input type="password" name="passwd2" id="passwd2" class="form-control" value="<?php echo $passwd2; ?>"/>
										</div>
                                    </div><!-- end row -->
                                    <hr class="invis">
									<input type="submit" id="submitbtn" class="btn btn-info" name="settingSave" value="<?php echo $lang[106]; ?>">
                                </form>
								
                            </div><!-- end post-padding -->
                        </div><!-- end col -->
                    </div><!-- end row -->  
                </div><!-- end container -->
            </div><!-- end section -->
		
		
		
		
		
		
		
		
<script type="text/javascript">
function validChangePassword()
{

    var oldpasswd = document.getElementById('oldpasswd');
	var po=document.getElementById('po');
    var passwd = document.getElementById('passwd');
    var passwd2 = document.getElementById('passwd2');

	var msg="";
	var valid=true;	
	
	if (oldpasswd.value == "" || oldpasswd.value == null)
    {
		msg='<?php echo $lang[95]; ?>';
		oldpasswd.value="";
        oldpasswd.focus();
        valid = false;		
    }
	
	else if (passwd.value == "" || passwd.value == null)
    {
		msg='<?php echo $lang[97]; ?>';
		passwd.value="";
        passwd.focus();
        valid = false;		
    }  
	else if ((passwd.value).length<6)
    {
		msg='<?php echo $lang[98]; ?>';
		passwd.value="";
        passwd.focus();
        valid = false;		
    }
	else if (passwd2.value == "" || passwd2.value == null)
    {
		msg='<?php echo $lang[99]; ?>';
		passwd2.value="";
        passwd2.focus();
        valid = false;		
    }
	else if (passwd.value != passwd2.value)
    {
		msg='<?php echo $lang[100]; ?>';
		passwd2.value="";
        passwd2.focus();
        valid = false;		
    }
	else
	{		
		valid=true;
	}	
	
	if(!valid)
	{
		document.getElementById("msg").style.color = "red";
		document.getElementById('msg').innerHTML = msg;			 				
	}
    return valid;
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