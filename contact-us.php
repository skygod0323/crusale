<?php
ob_start();
session_start();
include "common.php";

if(isset($_SESSION['msg'])){	$msg=$_SESSION['msg'];	unset($_SESSION['msg']);	}else{  $msg="";    }
if(isset($_SESSION['cu_fname'])){	$cu_fname=$_SESSION['cu_fname'];	unset($_SESSION['cu_fname']);	}else{ $cu_fname=""; }
if(isset($_SESSION['cu_lname'])){	$cu_lname=$_SESSION['cu_lname'];	unset($_SESSION['cu_lname']);	}else{ $cu_lname=""; }
if(isset($_SESSION['cu_email'])){	$cu_email=$_SESSION['cu_email'];	unset($_SESSION['cu_email']);	}else{ $cu_email=""; }
if(isset($_SESSION['cu_contactnumber'])){	$cu_contactnumber=$_SESSION['cu_contactnumber'];	unset($_SESSION['cu_contactnumber']);	}else{ $cu_contactnumber=""; }
if(isset($_SESSION['cu_comments'])){	$cu_comments=$_SESSION['cu_comments'];	unset($_SESSION['cu_comments']);	}else{ $cu_comments=""; }


class addContact
{
	var $msg;
	var $cu_fname;
	var $cu_lname;
	var $cu_email;	
	var $cu_contactnumber;		
	var $cu_comments;
		
	function __construct($cu_fname, $cu_lname, $cu_email, $cu_contactnumber, $cu_comments)
	{
		$this->cu_fname=$cu_fname;
		$this->cu_lname=$cu_lname;
		$this->cu_email=$cu_email;
		$this->cu_contactnumber=$cu_contactnumber;
		$this->cu_comments=$cu_comments;
		
		$_SESSION['cu_fname']=$this->cu_fname;
		$_SESSION['cu_lname']=$this->cu_lname;
		$_SESSION['cu_contactnumber']=$this->cu_contactnumber;
		$_SESSION['cu_email']=$this->cu_email;
		$_SESSION['cu_comments']=$this->cu_comments;
	}
	
	function valid()
	{	
        include "language.php";
		$valid=true;	
									
        if($this->cu_fname=="")
		{
			$this->msg='<font color="red">'.$lang[139].'</font>';
			$valid=false;
		}
		else if (!validate::is_name($this->cu_fname))
		{
			$this->msg='<font color="red">'.$lang[140].'</font>';
			$valid=false;
		}
		else if($this->cu_lname=="")
		{
			$this->msg='<font color="red">'.$lang[141].'</font>';
			$valid=false;
		}
		else if (!validate::is_name($this->cu_lname))
		{
			$this->msg='<font color="red">'.$lang[142].'</font>';
			$valid=false;
		}
		else if($this->cu_email=="")
		{
			$this->msg='<font color="red">'.$lang[261].'</font>';
			$valid=false;
		}
		else if (!validate::is_email($this->cu_email))
		{
			$this->msg='<font color="red">'.$lang[262].'</font>';
			$valid=false;
		}	
		else if($this->cu_contactnumber=="")
		{
			$this->msg='<font color="red">'.$lang[263].'</font>';
			$valid=false;
		}
		else if($this->cu_comments=="")
		{
			$this->msg='<font color="red">'.$lang[265].'</font>';
			$valid=false;
		}	
		return $valid;
	}
	
	
	function add()
	{		
		include "language.php";
		$sql="insert into contact_us 
			set 
				cu_fname='".ucwords($this->cu_fname)."',
				cu_lname='".ucwords($this->cu_lname)."',
				cu_contactnumber='".$this->cu_contactnumber."',
				cu_email='".$this->cu_email."',		
				cu_comments='".ucwords($this->cu_comments)."',					 
				cu_updated_date=now()";
					
		mysql_query($sql) or die(mysql_error());				
		
		$this->msg='<font color="#087017">'.$lang[266].'</font>';	
            
        /**** code for email sending start here ****/
		    
		$sqlemail="select * from admin_user where id='1'";
		$resemail=mysql_query($sqlemail);
		$rowemail=mysql_fetch_object($resemail);
		
		include "email/contact-us.php"; //email design with content included
		

		$from_mail=$this->cu_email;
        $to=$rowemail->email;

        $subj="Query";
        $headers  = "MIME-Version: 1.0\n";
	    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
        $headers .= 'From: '.$from_mail.'';	
		
		mail($to,$subj,$comment,$headers);
            
		/**** code for email sending end here ****/
		
		unset($_SESSION['cu_fname']);
		unset($_SESSION['cu_lname']);
		unset($_SESSION['cu_contactnumber']);
		unset($_SESSION['cu_email']);
		unset($_SESSION['cu_comments']);
		
	}
}
if(isset($_POST['submit']))
{		
	$adn=new addContact(addslashes(trim($_POST['cu_fname'])),addslashes(trim($_POST['cu_lname'])), $_POST['cu_email'], addslashes(trim($_POST['cu_contactnumber'])),addslashes(trim($_POST['cu_comments'])));
		
	if($adn->valid())
	{			
		$adn->add();			
	}
			
	$_SESSION['msg']=$adn->msg;								
	header("Location:contact-us.php");
}
?>
<?php include "includes/header.php"; ?>
<script type="text/javascript">
function validContactForm2()
{	
	var cu_fname=document.getElementById('cu_fname');
	var cu_lname=document.getElementById('cu_lname');
	var cu_email=document.getElementById('cu_email');
	var cu_contactnumber=document.getElementById('cu_contactnumber');
	var cu_comments=document.getElementById('cu_comments');
	var message="";
	var valid=true;
	var at = "@";
	var dot = ".";
	var lat = cu_email.value.indexOf(at);
	var lstr = cu_email.value.length;
	var ldot = cu_email.value.indexOf(dot);
	
	if(cu_fname.value=='')
	{
		message='<?php echo $lang[139]; ?>';
		cu_fname.focus();
		valid=false;
	}
	else if(cu_lname.value=='')
	{
		message='<?php echo $lang[141]; ?>';
		cu_lname.focus();
		valid=false;
	}
	else if(cu_email.value=='' || cu_email.value == null)
	{
		message='<?php echo $lang[261]; ?>';
		cu_email.value="";
		cu_email.focus();
		valid=false;
	}
		// check if '@' is at the first position or at last position or absent in given email 
	else if (cu_email.value.indexOf(at) == -1 || cu_email.value.indexOf(at) == 0 || cu_email.value.indexOf(at) == lstr)
	{	
		message="<?php echo $lang[262]; ?>";
		cu_email.value="";
        cu_email.focus();
        valid = false;	
			
	}
	// check if '.' is at the first position or at last position or absent in given email
	else if (cu_email.value.indexOf(dot) == -1 || cu_email.value.indexOf(dot) == 0 || cu_email.value.indexOf(dot) == lstr)
	{
	    message="<?php echo $lang[262]; ?>";
		cu_email.value="";
        cu_email.focus();
        valid = false;
		
	}
    // check if '@' is used more than one times in given email
	else if (cu_email.value.indexOf(at,(lat+1)) != -1)
	{
	    message="<?php echo $lang[262]; ?>";
		cu_email.value="";
        cu_email.focus();
        valid = false;	
	}  
    // check for the position of '.'
	else if (cu_email.value.substring(lat-1,lat) == dot || cu_email.value.substring(lat+1,lat+2) == dot)
	{
	    message="<?php echo $lang[262]; ?>";
		cu_email.value="";
        cu_email.focus();
    	valid = false;	
	}
    // check if '.' is present after two characters from location of '@'
	else if (cu_email.value.indexOf(dot,(lat+2)) == -1)
	{
	    message="<?php echo $lang[262]; ?>";
		cu_email.value="";
        cu_email.focus();
    	valid = false;	
	}	
	// check for blank spaces in given email
	else if (cu_email.value.indexOf(" ") != -1)
	{	
		message="<?php echo $lang[262]; ?>";
		cu_email.value="";
      	cu_email.focus();
       	valid = false;	
	}		

	else if(cu_contactnumber.value=='')
	{
		message='<?php echo $lang[263]; ?>';
		cu_contactnumber.focus();
		valid=false;
	}
	else if(isNaN(cu_contactnumber.value))
	{
		message='<?php echo $lang[264]; ?>';
		cu_contactnumber.value==''
		cu_contactnumber.focus();
		valid=false;
	}
	else if(cu_comments.value=='')
	{
		message='<?php echo $lang[265]; ?>';
		cu_comments.focus();
		valid=false;
	}
	if(!valid)
	{
		document.getElementById('msg').style.color = "red";
		document.getElementById('msg').innerHTML = message;	
	}
	return valid;
}
</script>

<div><h2 class="header-txt1-style align-center-txt"><?php echo $lang[267]; ?></h2></div>
<div class="row">
	<div class="col-xs-12">
    	<form name="changeuserinfoform" id="changeuserinfoform" method="post" action="" class="form-horizontal" enctype="multipart/form-data" onSubmit="return validContactForm();">
		
        <div class="form-group">
        <label class="col-sm-4 control-label no-padding-right"></label>
			<div class="col-sm-6" id="msg" align="left"><?php echo $msg; ?></div>
        </div>                         
            <div class="form-group">
				<label class="col-sm-4 control-label no-padding-right" for="cu_fname"><?php echo $lang[156]; ?></label>
					<div class="col-sm-6">
						<input name="cu_fname" id="cu_fname" type="text" value="<?php echo $cu_fname; ?>" class="form-control"/>
					</div>
				</div>
								
                <div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="cu_lname"><?php echo $lang[157]; ?></label>
					<div class="col-sm-6">
						<input name="cu_lname" id="cu_lname" type="text" value="<?php echo $cu_lname; ?>" class="form-control"/>
                    </div>
				</div>
                                
                <div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="cu_email"><?php echo $lang[253]; ?></label>
					<div class="col-sm-6">
						<input name="cu_email" id="cu_email" type="text" value="<?php echo $cu_email; ?>" class="form-control"/>
					</div>
				</div>
                <div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="cu_contactnumber"><?php echo $lang[268]; ?></label>
                    <div class="col-sm-6">
						<input name="cu_contactnumber" id="cu_contactnumber" type="text" value="<?php echo $cu_contactnumber; ?>" class="form-control"/>
                    </div>
				</div>
                                
                <div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="cu_comments"><?php echo $lang[269]; ?></label>
					<div class="col-sm-6">
						<textarea name="cu_comments" id="cu_comments" class="form-control"><?php echo $cu_comments; ?></textarea>
                    </div>
				</div>
                                
	            <div class="form-group">
					<div class="col-md-12" align="center">
						<input type="submit" id="submit" name="submit" class="btn btn-info" value="<?php echo $lang[270]; ?>">
					</div>
				</div>
    		</form>
	</div>
</div>
<!-- basic scripts -->

		<!--[if !IE]> -->

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
		  <script src="new_design/js/excanvas.min.js"></script>
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
		<script src="new_design/js/ace.min.js"></script>

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