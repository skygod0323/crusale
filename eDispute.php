<?php
ob_start();
session_start();
include "common.php";

if(!isset($_GET['b']))
{
    header("Location:manage.php");
}

$bd_id=$_GET['b'];

//$sql_es="select * from escrow,project,transaction where es_prj_id=prj_id and es_tr_id=tr_id and es_status='1' and tr_release='0' and tr_type='escrow' and tr_status='1' and prj_id=(select bd_prj_id from bid where bd_id='".$bd_id."')";
$sql_es="select * from escrow,transaction where es_tr_id=tr_id and es_status='1' and tr_release='0' and tr_type='escrow' and tr_status='1' and es_prj_id=(select bd_prj_id from bid where bd_id='".$bd_id."')";

//$sql_es="select * from bid,escrow,project,transaction where bd_id='".$bd_id."' and bd_prj_id='prj_id' and es_prj_id=prj_id and es_tr_id=tr_id and es_status='1' and tr_release='0' and tr_type='escrow' and tr_status='1'";
$res_es=  mysql_query($sql_es);

$tot_escrow=0;

while($row_es=mysql_fetch_object($res_es))
{
    $tot_escrow=$tot_escrow+$row_es->es_amount;
}
$row_prj=mysql_fetch_object(mysql_query("select * from project,bid where bd_prj_id=prj_id and bd_id='".$bd_id."'"));


if(isset($_SESSION['msg'])){	$msg=$_SESSION['msg'];	unset($_SESSION['msg']);	}else{ $msg=""; }
if(isset($_SESSION['pds_reason'])){	$pds_reason=$_SESSION['pds_reason']; unset($_SESSION['pds_reason']); }else{ $pds_reason=""; }
if(isset($_SESSION['pds_releaseAmount'])){	$pds_releaseAmount=$_SESSION['pds_releaseAmount'];	unset($_SESSION['pds_releaseAmount']);	}else{ $pds_releaseAmount=""; }


class addDispute
{
	var $msg;
	var $pds_prj_id;
    var $pds_bd_id;
    var $bd_usr_id;
	var $pds_reason;
	var $pds_releaseAmount;
    var $max_release_amt;
		
	function __construct($pds_prj_id, $pds_bd_id, $bd_usr_id, $pds_reason, $pds_releaseAmount, $max_release_amt)
	{
		$this->pds_prj_id=$pds_prj_id;
        $this->pds_bd_id=$pds_bd_id;
        $this->bd_usr_id=$bd_usr_id;
		$this->pds_reason=$pds_reason;
		$this->pds_releaseAmount=$pds_releaseAmount;
		$this->max_release_amt=$max_release_amt;
		
		$this->set_session();
	}
	
	function valid()
	{	
        include "language.php";
		$valid=true;	
		
        if($this->pds_reason=="")
		{
			$this->msg='<font color="red">'.$lang[643].'</font>';
			$valid=false;
                  
		}
		else if($this->pds_releaseAmount=="")
		{
			$this->msg='<font color="red">'.$lang[644].'</font>';
			$valid=false;
		}
        else if($this->pds_releaseAmount > $this->max_release_amt)
        {
            $this->msg='<font color="red">'.$lang[646].' '.getCurrencySymbol().$thid->max_release_amt.'</font>';
            $valid=false;
        }
		return $valid;
	}
	
	function set_session()
	{
	//	$_SESSION['pds_prj_id']=$this->pds_prj_id;
		$_SESSION['pds_reason']=$this->pds_reason;
            $_SESSION['pds_releaseAmount']=$this->pds_releaseAmount;            
	}
	
	function add()
	{		
		include "language.php";
		$sql="insert into project_dispute 
			set 
				pds_prj_id='".$this->pds_prj_id."',
                pds_bd_id='".$this->pds_bd_id."',
				pds_reason='".$this->pds_reason."',
				pds_releaseAmount='".$this->pds_releaseAmount."',
				pds_disputeDate=now()";
             
		mysql_query($sql) or die(mysql_error());
            $id=mysql_insert_id();
            /******* Code for notification start here *********/
		
		$sql_un="insert into user_notification
		set
			un_usr_id='".$this->bd_usr_id."',
			un_from_usr_id='".$_SESSION['uid']."',
			un_type='dispute',
			un_content='".$_SESSION['usr'].$lang[647].getCurrencySymbol().$this->pds_releaseAmount." ".getCurrencyCode()."|".$id."',
			un_prj_id='".$this->pds_prj_id."',
			un_updated_date=now()";
			
		mysql_query($sql_un);
		
		/******* Code for notification end here *********/
		
		$this->msg='<font color="#087017">'.$lang[645].'</font>';	
		
		unset($_SESSION['pds_reason']);
		unset($_SESSION['pds_releaseAmount']);
	}
}
if(isset($_POST['submit']))
{
	$adn=new addDispute(addslashes(trim($_POST['pds_prj_id'])),addslashes(trim($_POST['pds_bd_id'])),addslashes(trim($_POST['bd_usr_id'])), addslashes(trim($_POST['pds_reason'])), addslashes(trim($_POST['pds_releaseAmount'])), addslashes(trim($_POST['max_release_amt'])));
		
	if($adn->valid())
	{			
		$adn->add();			
	}
	else
	{ 			
		$adn->set_session();			
	}		
	$_SESSION['msg']=$adn->msg;								
	header("Location:eDispute.php?".$_SERVER['QUERY_STRING']);
}
?>
<?php include "includes/header.php"; ?>
<script type="text/javascript">
function validDisputeForm()
{	
	var pds_reason=document.getElementById('pds_reason');
	var pds_releaseAmount=document.getElementById('pds_releaseAmount');
      var max_release_amt=document.getElementById('max_release_amt');
	
	var message="";
	var valid=true;
	
	if(pds_reason.value=='')
	{
		message='<?php echo $lang[643]; ?>';
		pds_reason.focus();
		valid=false;
	}
	else if(pds_releaseAmount.value=='')
	{
		message='<?php echo $lang[644]; ?>';
		pds_releaseAmount.focus();
		valid=false;
	}
      else if(parseFloat(pds_releaseAmount.value) > parseFloat(max_release_amt.value))
	{
		message='<?php echo $lang[646]; ?>'+'<?php echo " ".getCurrencySymbol(); ?>'+max_release_amt.value;
		pds_releaseAmount.focus();
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

	<div><h2 class="header-txt1-style align-center-txt"><?php echo $lang[642]; ?></h2></div>
    <div class="row">
		<div class="col-xs-12">
        <form name="changeuserinfoform" id="changeuserinfoform" class="form-horizontal" method="post" action="" enctype="multipart/form-data" onSubmit="return validDisputeForm();">
									
                <div class="signup-form-str">
                    <?php echo $lang[652]; ?>
                </div>
                
                <div class="signup-form-str" id="msg"><?php echo $msg; ?></div>
                
                <input type="hidden" id="pds_bd_id" name="pds_bd_id" value="<?php echo $bd_id; ?>"/>
                
                <div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="pds_reason"><?php echo $lang[640]; ?></label>
					<div class="col-sm-5">
						<textarea class="form-control" name="pds_reason" id="pds_reason"><?php echo $pds_reason; ?></textarea>
                    </div>
                </div>
                
                <div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="pds_releaseAmount"><?php echo $lang[223]; ?></label>
                    <div class="col-sm-5">
                        <input type="hidden" id="pds_prj_id" name="pds_prj_id" value="<?php echo $row_prj->prj_id; ?>" />
                        <input type="hidden" id="bd_usr_id" name="bd_usr_id" value="<?php echo $row_prj->bd_usr_id; ?>" />
                        <input type="hidden" id="max_release_amt" name="max_release_amt" value="<?php echo $tot_escrow; ?>"/>
                        <input type="text" name="pds_releaseAmount" id="pds_releaseAmount" class="form-control" value="<?php echo $pds_releaseAmount; ?>"/>
                    </div>
                </div>
                
                <div class="form-group">
					<div class="col-md-12">
                        <input type="submit" id="submit" name="submit" class="btn btn-info" value="<?php echo $lang[270]; ?>">
                    </div>
                </div>
           
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