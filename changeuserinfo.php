<?php
ob_start();
session_start();
include "common.php";

$_SESSION['last_page']="changeuserinfo.php";

if($_SESSION['uid']=='')
{
	header("Location:login.php");
}

class editUser{

	var $msg;	
	var $usr_id;
	var $usr_image;
	var $usr_fname;
	var $usr_lname;
	var $usr_address;
	var $usr_cn_id;
	var $usr_city;
	var $usr_state;
	var $usr_postalcode;
	var $usr_phone;
	
	
	function __construct($usr_id){
		$this->usr_id=$usr_id;
	}
	function detailsObj(){
		$sql="select * from user where usr_id='".$this->usr_id."'";
		$res=mysql_query($sql);
		return mysql_fetch_object($res);
	}
	function valid()
      {
		include "language.php";
		$valid=true;
			
		if($this->usr_fname == "")
		{
			$this->msg= '<div class="alert alert-danger"><i class="icon-remove"></i> '.$lang[139].'</div>';
			$valid=false;
		}
		else if(!validate::is_name($this->usr_fname))
		{
			$this->msg= '<div class="alert alert-danger"><i class="icon-remove"></i> '.$lang[140].'</div>';
			$valid=false;
		}
		else if($this->usr_lname == "")
		{
			$this->msg= '<div class="alert alert-danger"><i class="icon-remove"></i> '.$lang[141].'</div>';
			$valid=false;
		}
		else if(!validate::is_name($this->usr_lname))
		{
			$this->msg= '<div class="alert alert-danger"><i class="icon-remove"></i> '.$lang[142].'</div>';
			$valid=false;
		}
		else if($this->usr_address == "")
		{
			$this->msg= '<div class="alert alert-danger"><i class="icon-remove"></i> '.$lang[143].'</div>';
			$valid=false;
		}
		else if($this->usr_cn_id == "" || $this->usr_cn_id == "0")
		{
			$this->msg= '<div class="alert alert-danger"><i class="icon-remove"></i> '.$lang[144].'</div>';
			$valid=false;
		}
		else if($this->usr_city == "")
		{
			$this->msg= '<div class="alert alert-danger"><i class="icon-remove"></i> '.$lang[145].'</div>';
			$valid=false;
		}
		else if($this->usr_state == "" || $this->usr_state == NULL)
		{
			$this->msg= '<div class="alert alert-danger"><i class="icon-remove"></i> '.$lang[146].'</div>';
			$valid=false;
		}
		else if($this->usr_postalcode == "" || $this->usr_postalcode == NULL)
		{
			$this->msg= '<div class="alert alert-danger"><i class="icon-remove"></i> '.$lang[147].'</div>';
			$valid=false;
		}
		else if($this->usr_phone == "" || $this->usr_phone == NULL)
		{
			$this->msg= '<div class="alert alert-danger"><i class="icon-remove"></i> '.$lang[150].'</div>';
			$valid=false;
		}
		
		return $valid;
	}
	
	function update()
	{	
          
          include "language.php";
		if($_FILES["usr_image"]["name"] != '')
		{
			if ($_FILES["usr_image"]["error"] > 0)
			{
				$msg = "Return Code: " . $_FILES["usr_image"]["error"] . "<br />";
			}
			else
			{	
				$sqlImg="select * from user where usr_id='".$this->usr_id."'";
				$resImg=mysql_query($sqlImg);
				$rowImg=mysql_fetch_object($resImg);
				
//				$pathS="../upload/logo/small/".$rowImg->al_logo;	
				$pathB="images/users/".$rowImg->usr_image;
	
				if(is_file($pathS))
				{
					unlink($pathS);
				}
				
				if(is_file($pathB))
				{
					unlink($pathB);
				}	
				
				//$imgSImage = new SimpleImage();			
				//$imgSImage->load($_FILES['ar_profile_img']['tmp_name']);			
//				$imgSImage->resize(119,70);

				$this->usr_image='usr-'.rand(0,9999).trim(addslashes($_FILES['usr_image']['name']));	
//				$imgSImage->save("../upload/logo/small/".$this->al_logo);
				
				$ds = move_uploaded_file($_FILES["usr_image"]["tmp_name"], "images/users/".$this->usr_image) or die('error');	
						
				if($ds)
				{
					$sql="update user
						set				
							usr_image ='".$this->usr_image."',
							usr_fname ='".$this->usr_fname."',
							usr_lname ='".$this->usr_lname."',
							usr_address ='".$this->usr_address."',
							usr_city ='".$this->usr_city."',
							usr_cn_id ='".$this->usr_cn_id."',
							usr_state='".$this->usr_state."',
							usr_postalcode='".$this->usr_postalcode."',
							usr_phone='".$this->usr_phone."',
							usr_updated_date = now()
						where usr_id='".$this->usr_id."'";
					mysql_query($sql) or die(mysql_error());
					
					$_SESSION['img']=$this->usr_image;
					
					$this->msg='<div class="alert alert-success"><i class="icon-ok"></i> '.$lang[152].'</font>';	
				}
				else
				{
					$this->msg='<div class="alert alert-danger"><i class="icon-remove"></i> '.$lang[153].'</div>';
				}
			}		
		}
		else
		{
			$sql="update user
			set					
				usr_fname ='".$this->usr_fname."',
				usr_lname ='".$this->usr_lname."',						
				usr_address ='".$this->usr_address."',
				usr_city ='".$this->usr_city."',
				usr_cn_id ='".$this->usr_cn_id."',
				usr_state='".$this->usr_state."',
				usr_postalcode='".$this->usr_postalcode."',
				usr_phone='".$this->usr_phone."',
				usr_updated_date = now()
			where
				usr_id='".$this->usr_id."'";
	
			mysql_query($sql) or die(mysql_error());
															
			$this->msg='<div class="alert alert-success"><i class="icon-ok"></i> '.$lang[152].'</div>';
		}						
	}	
}

if(isset($_SESSION['msg'])){	$msg=$_SESSION['msg'];	unset($_SESSION['msg']);	}

$ob=new editUser($_SESSION['uid']);
$row=$ob->detailsObj();

if(isset($_POST['submit_id']))
{
	//print_r($_POST);
	//exit;

	$ob->usr_image=trim($_FILES['usr_image']['name']);
	$ob->usr_fname=addslashes(trim($_POST['usr_fname']));	
	$ob->usr_lname=addslashes(trim($_POST['usr_lname']));	
	$ob->usr_address=addslashes(trim($_POST['usr_address']));	
	$ob->usr_cn_id=addslashes(trim($_POST['cn_id']));	
	$ob->usr_city=addslashes(trim($_POST['usr_city']));	
	$ob->usr_state=addslashes(trim($_POST['usr_state']));	
	$ob->usr_postalcode=addslashes(trim($_POST['usr_postalcode']));	
	$ob->usr_phone=addslashes(trim($_POST['usr_phone']));	

	
	if($ob->valid()){
		$ob->update();
	}
	$_SESSION['msg']=$ob->msg;

	header("Location:changeuserinfo.php");
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
									<li class="active"><a href="changeuserinfo.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[124]; ?></a></li>
                                    <li><a href="change-email.php"><span class="glyphicon glyphicon-user"></span>  <?php echo $lang[125]; ?></a></li>
                                    <li><a href="profile.php"><span class="glyphicon glyphicon-briefcase"></span>  <?php echo $lang[126]; ?></a></li>
                                    <li><a href="change-password.php"><span class="glyphicon glyphicon-briefcase"></span>  <?php echo $lang[127]; ?></a></li>
                                    <li><a href="membership.php"><span class="glyphicon glyphicon-refresh"></span>  <?php echo $lang[128]; ?></a></li>
                                </ul>
                            </div><!-- end widget -->
                        </div><!-- end col -->

                        <div class="content col-md-9">
                            <div class="post-padding">
                                <div class="job-title nocover hidden-sm hidden-xs"><h5><?php echo $lang[154]; ?></h5></div>
                                <form name="changeuserinfoform" id="changeuserinfoform" class="form-horizontal" method="post" action="" enctype="multipart/form-data" onSubmit="return validUserInfo();">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">    
											<div class="signup-form-str" id="msg"><?php if (isset($msg)) { echo $msg; }?></div>               
                                            <label class="control-label"><?php echo $lang[155]; ?></label>
                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                <div class="fileupload-preview thumbnail">
													<?php if($row->usr_image == ''){ ?>
														<img id="unknow_img_id" class="" style="border: 1px solid rgb(204, 204, 204);" src="images/unknown.png" width="280px" height="280px"/>
													<?php } else { ?>
														<img id="unknow_img_id" class="" style="border: 1px solid rgb(204, 204, 204);" src="images/users/<?php echo $row->usr_image; ?>" width="280px" height="280px"/>
													<?php } ?>
												</div>
												
                                                <br>
                                                <span class="btn btn-default btn-file">
                                                    <span class="fileupload-new">Select Photo</span>
                                                    <span class="fileupload-exists">Change</span>
                                                    <input multiple="" type="file" id="id-input-file-3" name="usr_image"/>
                                                </span>
                                                
                                            </div>
                                        </div>
                                    </div><!-- end row -->
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">   
                                            <label class="control-label"><?php echo $lang[156]; ?> <span style="color:#F00;">*</span> </label>
                                            <input name="usr_fname" id="usr_fname" type="text" class="form-control" value="<?php echo $row->usr_fname; ?>"/>
                                            <br>
                                            <label class="control-label"><?php echo $lang[157]; ?> <span style="color:#F00;">*</span> </label>
                                            <input name="usr_lname" id="usr_lname" type="text" class="form-control" value="<?php echo $row->usr_lname; ?>"/>
											<label class="control-label"><?php echo $lang[158]; ?> <span style="color:#F00;">*</span> </label>
                                            <input name="usr_address" id="usr_address" type="text" class="form-control" value="<?php echo $row->usr_address; ?>"/>
											<br>
											<label class="control-label"><?php echo $lang[159]; ?> <span style="color:#F00;">*</span> </label>
                                            <?php
												$sql_cn="select * from country where cn_status=1 order by cn_name";
												$res_cn=mysql_query($sql_cn);
											?>
											<select name="cn_id" id="cn_id" class="form-control"> 
												<option value="0">(<?php echo $lang[160]; ?>)</option> 
												<?php	while($row_cn=mysql_fetch_object($res_cn)){ ?>
													<option value="<?php echo $row_cn->cn_id; ?>" <?php if($row_cn->cn_id == $row->usr_cn_id) { ?> selected="selected" <?php }  ?>><?php echo ucfirst($row_cn->cn_name); ?></option>
												<?php } ?>
											</select>
											<br>
											<label class="control-label"><?php echo $lang[161]; ?> <span style="color:#F00;">*</span> </label>
                                            <input name="usr_city" id="usr_city" type="text" class="form-control" value="<?php echo $row->usr_city; ?>"/>
											<br>
											<label class="control-label"><?php echo $lang[163]; ?> <span style="color:#F00;">*</span> </label>
                                            <input name="usr_state" id="usr_state" type="text" class="form-control" value="<?php echo $row->usr_state; ?>"/>
											<br>
											<label class="control-label"><?php echo $lang[164]; ?> <span style="color:#F00;">*</span> </label>
                                            <input name="usr_postalcode" id="usr_postalcode" type="text" class="form-control" value="<?php echo $row->usr_postalcode; ?>"/>
											<br>
											<label class="control-label"><?php echo $lang[165]; ?> <span style="color:#F00;">*</span> </label>
                                            <input id="usr_phone" name="usr_phone" type="text" class="form-control" value="<?php echo $row->usr_phone; ?>"/>
											
                                            
                                        </div>
                                    </div><!-- end row -->
                                    <hr class="invis">
									<input type="submit" id="btnSave" name="submit_id" class="btn btn-info" value="<?php echo $lang[106]; ?>">
                                </form>
								
                            </div><!-- end post-padding -->
                        </div><!-- end col -->
                    </div><!-- end row -->  
                </div><!-- end container -->
            </div><!-- end section -->
		
		
		
		
		
        
        
<script type="text/javascript">
function validUserInfo()
{

    var usr_fname = document.getElementById('usr_fname');
    var usr_lname = document.getElementById('usr_lname');
    var usr_address = document.getElementById('usr_address');
    var cn_id = document.getElementById('cn_id');
    var usr_ct_id = document.getElementById('usr_ct_id');
    var usr_state = document.getElementById('usr_state');			
    var usr_postalcode = document.getElementById('usr_postalcode');
	var usr_phone = document.getElementById('usr_phone');

	var msgContact="";
	var valid=false;	

	if (usr_fname.value == "" || usr_fname.value == null)
    {
		
		msgContact='<?php echo $lang[139]; ?>';
		usr_fname.value="";
        usr_fname.focus();
        valid = false;
    }  
	else if(!isNaN(usr_fname.value))
	{
		msgContact='<?php echo $lang[140]; ?>';
		usr_fname.value="";
        usr_fname.focus();
        valid = false;		
	}
	else if (usr_lname.value == "" || usr_lname.value == null)
    {
		msgContact='<?php echo $lang[141]; ?>';
		usr_lname.value="";
        usr_lname.focus();
        valid = false;		
    }  
	else if(!isNaN(usr_lname.value))
	{
		msgContact='<?php echo $lang[142]; ?>';
		usr_lname.value="";
        usr_lname.focus();
        valid = false;		
	}
	else if (usr_address.value == "" || usr_address.value == null)
    {
		msgContact='<?php echo $lang[143]; ?>';
		usr_address.value="";
        usr_address.focus();
        valid = false;		
    }
	else if(cn_id.value == "" || cn_id.value == null || cn_id.value == "0")
	{
		msgContact='<?php echo $lang[144]; ?>';
        cn_id.focus();
        valid = false;		
	}
	else if(usr_ct_id.value == "" || usr_ct_id.value == null || usr_ct_id.value == "0")
	{
		msgContact='<?php echo $lang[145]; ?>';
		usr_ct_id.focus();
        valid = false;	
	}
	else if(usr_state.value == "" || usr_state.value == null)
	{
		msgContact='<?php echo $lang[146]; ?>';
		usr_state.value="";
        usr_state.focus();
        valid = false;		
	}
	else if(!isNaN(usr_state.value))
	{
		msgContact='<?php echo $lang[148]; ?>';
		usr_state.value="";
        usr_state.focus();
        valid = false;		
	}
	else if(usr_postalcode.value == "" || usr_postalcode.value == null)
	{
		msgContact='<?php echo $lang[147]; ?>';
		usr_postalcode.value="";
        usr_postalcode.focus();
        valid = false;
	}
	else if(isNaN(usr_postalcode.value))
	{
		msgContact='<?php echo $lang[149]; ?>';
		usr_postalcode.value="";
        usr_postalcode.focus();
        valid = false;
	}
	else if(usr_phone.value == "" || usr_phone.value == null)
	{
		msgContact='<?php echo $lang[150]; ?>';
		usr_phone.value="";
        usr_phone.focus();
        valid = false;
	}
	else
	{		
		valid=true;
	}	
	
	if(!valid)
	{
		document.getElementById('msg').innerHTML = "<i class='icon-remove'></i> "+msgContact;
		document.getElementById('msg').className="alert alert-danger";
	}

    return valid;
}
</script>
<script language="javascript">
function showCity(str)
{
	$.get("showCity.php", {q:str},	function(data){	$('#usr_ct_id').html(data);	 });
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