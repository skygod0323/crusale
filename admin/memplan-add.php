<?php 
ob_start();
session_start(); 
include "../common.php";

check_user_login();

if(isset($_SESSION['mp_name'])){	$mp_name=$_SESSION['mp_name'];	unset($_SESSION['mp_name']);	}else{	$mp_name="";	}
if(isset($_SESSION['mp_rate'])){	$mp_rate=$_SESSION['mp_rate'];	unset($_SESSION['mp_rate']);	}else{	$mp_rate="";	}
if(isset($_SESSION['mp_freelancerfee'])){	$mp_freelancerfee=$_SESSION['mp_freelancerfee'];	unset($_SESSION['mp_freelancerfee']);	}else{	$mp_freelancerfee="";	}
if(isset($_SESSION['mp_employerfee'])){	$mp_employerfee=$_SESSION['mp_employerfee'];	unset($_SESSION['mp_employerfee']);	}else{	$mp_employerfee="";	}
if(isset($_SESSION['mp_bidspermonth'])){	$mp_bidspermonth=$_SESSION['mp_bidspermonth'];	unset($_SESSION['mp_bidspermonth']);	}else{	$mp_bidspermonth="";	}
if(isset($_SESSION['mp_skills'])){	$mp_skills=$_SESSION['mp_skills'];	unset($_SESSION['mp_skills']);	}else{	$mp_skills="";	}
if(isset($_SESSION['mp_portfoliosize'])){	$mp_portfoliosize=$_SESSION['mp_portfoliosize'];	unset($_SESSION['mp_portfoliosize']);	}else{	$mp_portfoliosize="";	}

class addProduct{

	var $msg;
	var $mp_name;
	var $mp_rate;
	var $mp_freelancerfee;
	var $mp_employerfee;
	var $mp_bidspermonth;
	var $mp_skills;
	var $mp_portfoliosize;
	
	function __construct( $mp_name, $mp_rate, $mp_freelancerfee, $mp_employerfee, $mp_bidspermonth, $mp_skills, $mp_portfoliosize)
	{
		$this->mp_name=$mp_name;
		$this->mp_rate=$mp_rate;
		$this->mp_freelancerfee=$mp_freelancerfee;
		$this->mp_employerfee=$mp_employerfee;
		$this->mp_bidspermonth=$mp_bidspermonth;
		$this->mp_skills=$mp_skills;
		$this->mp_portfoliosize=$mp_portfoliosize;
		
		$_SESSION['mp_name']=$this->mp_name;
		$_SESSION['mp_rate']=$this->mp_rate;
		$_SESSION['mp_freelancerfee']=$this->mp_freelancerfee;
		$_SESSION['mp_employerfee']=$this->mp_employerfee;
		$_SESSION['mp_bidspermonth']=$this->mp_bidspermonth;
		$_SESSION['mp_skills']=$this->mp_skills;
		$_SESSION['mp_portfoliosize']=$this->mp_portfoliosize;

	}

	function valid()
	{
		$valid=true;
		if($this->mp_name == "")
		{
			$this->msg= '<div class="alert alert-danger"><i class="icon-remove"></i> Please enter membership plan name</div>';
			$valid=false;
		}
		else if($this->mp_rate == "" || $this->mp_rate == " ")
		{
			$this->msg= '<div class="alert alert-danger"><i class="icon-remove"></i> Please enter plan rate</div>';
			$valid=false;
		}
		else if($this->mp_freelancerfee == "" || $this->mp_freelancerfee == " ")
		{
			$this->msg= '<div class="alert alert-danger"><i class="icon-remove"></i> Please enter freelancer fee</div>';
			$valid=false;
		}
		else if($this->mp_employerfee == "" || $this->mp_employerfee == " ")
		{
			$this->msg= '<div class="alert alert-danger"><i class="icon-remove"></i> Please enter employer fee</div>';
			$valid=false;
		}
		else if($this->mp_bidspermonth == "" || $this->mp_bidspermonth == " ")
		{
			$this->msg= '<div class="alert alert-danger"><i class="icon-remove"></i> Please enter number of bids per month</div>';
			$valid=false;
		}
		else if($this->mp_skills == "" || $this->mp_skills == " ")
		{
			$this->msg= '<div class="alert alert-danger"><i class="icon-remove"></i> Please enter number of skills</div>';
			$valid=false;
		}
		else if($this->mp_portfoliosize == "" || $this->mp_portfoliosize == " ")
		{
			$this->msg= '<div class="alert alert-danger"><i class="icon-remove"></i> Please enter portfolio size</div>';
			$valid=false;
		}
		
		
		return $valid;
	}
	
	function add()
	{		
		$sql="insert into membership_plan 
			set					
				mp_name ='".$this->mp_name."',
				mp_rate ='".$this->mp_rate."',
				mp_freelancerfee ='".$this->mp_freelancerfee."',								
				mp_employerfee ='".$this->mp_employerfee."',
				mp_bidspermonth ='".$this->mp_bidspermonth."',								
				mp_skills ='".$this->mp_skills."',
				mp_portfoliosize ='".$this->mp_portfoliosize."',
				mp_updated_date=now()";							
		mysql_query($sql) or die(mysql_error());
													
		$this->msg='<div class="alert alert-success"><i class="icon-ok"></i> Plan added successfully</div>';	
			
		unset($_SESSION['mp_name']);
		unset($_SESSION['mp_rate']);
		unset($_SESSION['mp_freelancerfee']);
		unset($_SESSION['mp_employerfee']);
		unset($_SESSION['mp_bidspermonth']);
		unset($_SESSION['mp_skills']);
		unset($_SESSION['mp_portfoliosize']);
		
	}	
}

if(isset($_SESSION['msg'])){
	$msg=$_SESSION['msg'];
	unset($_SESSION['msg']);
}

if(isset($_POST['btnAdd']))
{
	/*print_r($_POST);
	exit;*/
	$adn=new addProduct( addslashes(trim($_POST['mp_name'])), addslashes(trim($_POST['mp_rate'])), addslashes(trim($_POST['mp_freelancerfee'])), 
	addslashes(trim($_POST['mp_employerfee'])), addslashes(trim($_POST['mp_bidspermonth'])), addslashes(trim($_POST['mp_skills'])),	addslashes(trim($_POST['mp_portfoliosize'])));

	if($adn->valid()){	
		$adn->add();		
	}
	//echo $ecms->msg;
	$_SESSION['msg']=$adn->msg;
	
	header("location:memplan-add.php");
}

?>
<?php include "includes/admin-top.php" ?>
<div class="main-container" id="main-container">
	<script type="text/javascript">
		try{ace.settings.check('main-container' , 'fixed')}catch(e){}
	</script>

	<div class="main-container-inner">
		<a class="menu-toggler" id="menu-toggler" href="#">
			<span class="menu-text"></span>
		</a>
<script type="text/javascript">
function myvalid()
{	
	var mp_name=document.getElementById('mp_name');
	var mp_rate=document.getElementById('mp_rate');
	var mp_freelancerfee=document.getElementById('mp_freelancerfee');
	var mp_employerfee=document.getElementById('mp_employerfee');
	var mp_employerfee=document.getElementById('mp_employerfee');
	var mp_skills=document.getElementById('mp_skills');
	var mp_skills=document.getElementById('mp_skills');

	var message="";
	var valid=true;
	
	if(mp_name.value=='')
	{
		message='Please enter membership plan name';
		mp_name.focus();
		valid=false;
	}
	else if(mp_rate.value == "")
	{
		message='Please enter plan rate';
		mp_rate.focus();
		valid=false;
	}
	else if(isNaN(mp_rate.value))
	{
		message='Please enter valid plan rate';
		mp_rate.focus();
		valid=false;
	}
	else if(mp_freelancerfee.value == "")
	{
		message='Please enter freelancer fee';
		mp_freelancerfee.focus();
		valid=false;
	}
	else if(isNaN(mp_freelancerfee.value))
	{
		message='Please enter valid freelancer fee';
		mp_freelancerfee.focus();
		valid=false;
	}
	else if(mp_employerfee.value == "")
	{
		message='Please enter employer fee';
		mp_employerfee.focus();
		valid=false;
	}
	else if(isNaN(mp_employerfee.value))
	{
		message='Please enter valid employer fee';
		mp_employerfee.focus();
		valid=false;
	}
	else if(mp_bidspermonth.value == "")
	{
		message='Please enter number of bids per month';
		mp_bidspermonth.focus();
		valid=false;
	}
	else if(isNaN(mp_bidspermonth.value))
	{
		message='Please enter valid number of bids per month';
		mp_bidspermonth.focus();
		valid=false;
	}
	else if(mp_skills.value == "")
	{
		message='Please enter number of skills';
		mp_skills.focus();
		valid=false;
	}
	else if(isNaN(mp_skills.value))
	{
		message='Please enter valid number of skills';
		mp_skills.focus();
		valid=false;
	}
	else if(mp_portfoliosize.value == "")
	{
		message='Please enter portfolio size';
		mp_portfoliosize.focus();
		valid=false;
	}
	else if(isNaN(mp_portfoliosize.value))
	{
		message='Please enter valid portfolio size';
		mp_portfoliosize.focus();
		valid=false;
	}
	
	if(!valid)
	{
		document.getElementById('msg').innerHTML = "<i class='icon-remove'></i> "+message;
		document.getElementById('msg').className="alert alert-danger";
	}
	return valid;

}
</script>
	<?php include "includes/admin-left-con.php" ?>
<div class="main-content">
	<div class="breadcrumbs" id="breadcrumbs">
		<script type="text/javascript">
			try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
		</script>

		<ul class="breadcrumb">
			<li>
				<i class="icon-home home-icon"></i>
				<a href="welcome.php">Home</a>
			</li>
			<li>
				<a href="memplan-view.php">Manage Membership Plan</a>
			</li>
			<li class="active">Add Plan</li>
		</ul><!-- .breadcrumb -->
		<!-- #nav-search -->
	</div>
				
<div class="page-content">
	<div class="page-header">
		<h1>
			Membership Plan Management
			<small>
				<i class="icon-double-angle-right"></i>
				Add Plan
			</small>
		</h1>
	</div>
	<div class="row">
		<div class="col-xs-12">
<form class="form-horizontal" action="" id="test_add" name="test_add" method="post" enctype="multipart/form-data" onsubmit="return myvalid();">
	<em style="display:block;margin:5px;">Fields with <span style="color:#F00">*</span> are required.</em>
    <div id="msg"><?php echo $msg; ?></div>

	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-2">Plan Name <span style="color:#CC0000">*</span></label>
		<div class="col-sm-9">
			<input name="mp_name" id="mp_name" class="col-xs-10 col-sm-5" type="text" value="<?php echo $mp_name; ?>" />
		</div>
	</div>
    
    <div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-2">Rate per month <span style="color:#CC0000">*</span></label>
		<div class="col-sm-9">
			<input name="mp_rate" id="mp_rate" class="col-xs-10 col-sm-5" type="text" value="<?php echo $mp_rate; ?>" />
		</div>
	</div>
    
    <div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-2">Freelancer Fee(in Percentage) <span style="color:#CC0000">*</span></label>
		<div class="col-sm-9">
			<input name="mp_freelancerfee" id="mp_freelancerfee" class="col-xs-10 col-sm-5" type="text" value="<?php echo $mp_freelancerfee; ?>" />
		</div>
	</div>
    
    <div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-2">Employer Fee(in Percentage) <span style="color:#CC0000">*</span></label>
		<div class="col-sm-9">
			<input name="mp_employerfee" id="mp_employerfee" class="col-xs-10 col-sm-5" type="text" value="<?php echo $mp_employerfee; ?>" />
		</div>
	</div>
    
    <div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-2">Bids per month <span style="color:#CC0000">*</span></label>
		<div class="col-sm-9">
			<input name="mp_bidspermonth" id="mp_bidspermonth" class="col-xs-10 col-sm-5" type="text" value="<?php echo $mp_bidspermonth; ?>" />
		</div>
	</div>
    
    <div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-2">Skills <span style="color:#CC0000">*</span></label>
		<div class="col-sm-9">
			<input name="mp_skills" id="mp_skills" class="col-xs-10 col-sm-5" type="text" value="<?php echo $mp_skills; ?>" />
		</div>
	</div>
    
    <div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-2">Portfolio Size <span style="color:#CC0000">*</span></label>
		<div class="col-sm-9">
			<input name="mp_portfoliosize" id="mp_portfoliosize" class="col-xs-10 col-sm-5" type="text" value="<?php echo $mp_portfoliosize; ?>" />
		</div>
	</div>
    
    <div class="clearfix form-actions">
		<div class="col-md-offset-3 col-md-9">
			<button class="btn btn-info" type="submit" name="btnAdd" id="btnAdd"><i class="icon-ok bigger-110"></i>Add</button>
			<button class="btn" type="reset"><i class="icon-undo bigger-110"></i>Reset</button>
		</div>
	</div>

</form>
 			</div>
		</div>
			
	</div>
	<br clear="all" />	
</div>
<?php include "includes/footer.php" ?>
</body>
		<script type="text/javascript">
			window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/typeahead-bs2.min.js"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="assets/js/excanvas.min.js"></script>
		<![endif]-->

		<script src="assets/js/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="assets/js/chosen.jquery.min.js"></script>
		<script src="assets/js/fuelux/fuelux.spinner.min.js"></script>
		<script src="assets/js/date-time/bootstrap-datepicker.min.js"></script>
		<script src="assets/js/date-time/bootstrap-timepicker.min.js"></script>
		<script src="assets/js/date-time/moment.min.js"></script>
		<script src="assets/js/date-time/daterangepicker.min.js"></script>
		<script src="assets/js/bootstrap-colorpicker.min.js"></script>
		<script src="assets/js/jquery.knob.min.js"></script>
		<script src="assets/js/jquery.autosize.min.js"></script>
		<script src="assets/js/jquery.inputlimiter.1.3.1.min.js"></script>
		<script src="assets/js/jquery.maskedinput.min.js"></script>
		<script src="assets/js/bootstrap-tag.min.js"></script>

		<!-- ace scripts -->

		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

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
</html>