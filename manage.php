<?php 
ob_start();
session_start();
include "common.php";

$_SESSION['last_page']="manage.php";

if($_SESSION['uid']=='')
{
	header("location:login.php");	
}

$sql_ap="select * from project,bid,temp_proj_award,user where prj_id=bd_prj_id and bd_id=tpa_bd_id and prj_usr_id=usr_id and bd_usr_id=".$_SESSION['uid'];



$res_ap=mysql_query($sql_ap);

$sql_u="select * from user where usr_id=".$_SESSION['uid'];
$res_u=mysql_query($sql_u);
$row_u=mysql_fetch_object($res_u);
	
?>

<?php include "includes/header.php"; ?>
<script type="text/javascript" src="js/jquery-1.8.1.min.js"></script>
<script src="new_design/js/bootbox.min.js"></script>
<script language="javascript">
window.onload = function(){
loadWorkInProgress(1);
loadPastProjects(1);

loadCurrentWrok(1);
loadPastWork(1);

loadOpenForBidding(1);
loadActiveBids(1);
}
function loadOpenForBidding(page)
{
	//$.noConflict();
	$.post("ajax-file/loadOpenForBidding.php",{page:page},    function(data){    $('#OpenForBidding').html(data); showOpnBid();	});
}
function loadWorkInProgress(page)
{
	//$.noConflict();
	$.post("ajax-file/loadWorkInProgress.php",   {page:page}, 	  function(data){	$('#WorkInProgress').html(data); showWrkPrg();	});
}
function loadPastProjects(page)
{
	//$.noConflict();
	$.post("ajax-file/loadPastProjects.php",   {page:page}, 	  function(data)	  {	  $('#PastProjects').html(data); 	showPstPrj(); });
}

function loadActiveBids(page)
{
	//$.noConflict();
	$.post("ajax-file/loadActiveBids.php",   {page:page}, 	  function(data)	  {	  $('#ActiveBids').html(data); 	showActBid() });
}
function loadCurrentWrok(page)
{
	//$.noConflict();
	$.post("ajax-file/loadCurrentWork.php",   {page:page}, 	  function(data)	  {	  $('#CurrentWork').html(data); 	showCurWrk() });
}
function loadPastWork(page)
{
	//$.noConflict();
	$.post("ajax-file/loadPastWork.php",   {page:page}, 	  function(data)	  {	  $('#PastWork').html(data); 	showPstWrk() });
}

function showOpnBid()
{
	//$.noConflict();

//	$('#OpnBid').css({"display":"block"});
	$('#OpenForBidding').css({"display":"block"});
//	$("#OB").addClass("tabber-nav-normal");

//	$('#WrkPrg').css({"display":"none"});
	$('#WorkInProgress').css({"display":"none"});
	
//	$("#WP").removeClass("tabber-nav-normal");
	
//	$('#PstPrj').css({"display":"none"});
	$('#PastProjects').css({"display":"none"});
	
//	$("#PsP").removeClass("tabber-nav-normal");
	
	
	$('#PrzAwr').css({"display":"none"});
//	$("#PrAw").removeClass("tabber-nav-normal");
}
function showWrkPrg()
{
	//$.noConflict();
//	$('#OpnBid').css({"display":"none"});
	$('#OpenForBidding').css({"display":"none"});
//	$("#OB").removeClass("tabber-nav-normal");

//	$('#WrkPrg').css({"display":"none"});
	$('#WorkInProgress').css({"display":"block"});
//	$("#WP").addClass("tabber-nav-normal");
	
//	$('#PstPrj').css({"display":"none"});
	$('#PastProjects').css({"display":"none"});
//	$("#PsP").removeClass("tabber-nav-normal");
	
	
	$('#PrzAwr').css({"display":"none"});
//	$("#PrAw").removeClass("tabber-nav-normal");
}
function showPstPrj()
{
	//$.noConflict();

//	$('#OpnBid').css({"display":"none"});
	$('#OpenForBidding').css({"display":"none"});
//	$("#OB").removeClass("tabber-nav-normal");

//	$('#WrkPrg').css({"display":"none"});
	$('#WorkInProgress').css({"display":"none"});
//	$("#WP").removeClass("tabber-nav-normal");
	
//	$('#PstPrj').css({"display":"block"});
	$('#PastProjects').css({"display":"block"});	
//	$("#PsP").addClass("tabber-nav-normal");
	
	
	$('#PrzAwr').css({"display":"none"});
//	$("#PrAw").removeClass("tabber-nav-normal");
}
function showPrzAwr()
{
	//$.noConflict();

//	$('#OpnBid').css({"display":"none"});
	$('#OpenForBidding').css({"display":"none"});
//	$("#OB").removeClass("tabber-nav-normal");

//	$('#WrkPrg').css({"display":"none"});
	$('#WorkInProgress').css({"display":"none"});
//	$("#WP").removeClass("tabber-nav-normal");
	
//	$('#PstPrj').css({"display":"block"});
	$('#PastProjects').css({"display":"block"});
//	$("#PsP").removeClass("tabber-nav-normal");

	
//	$('#AwrPrj').css({"display":"none"});
	$('#AwardedPrj').css({"display":"none"});
//	$("#AwP").removeClass("tabber-nav-normal");
	
	$('#PrzAwr').css({"display":"block"});
//	$("#PrAw").addClass("tabber-nav-normal");
}
//---------------//
function showActBid()
{
	//$.noConflict();

//	$('#ActBid').css({"display":"block"});
	$('#ActiveBids').css({"display":"block"});
//	$("#AB").addClass("tabber-nav-normal");

//	$('#CurWrk').css({"display":"none"});
	$('#CurrentWork').css({"display":"none"});
	
//	$("#CW").removeClass("tabber-nav-normal");
	
//	$('#PstWrk').css({"display":"none"});
	$('#PastWork').css({"display":"none"});
//	$("#PsW").removeClass("tabber-nav-normal");
	
//	$('#AwrPrj').css({"display":"none"});
	$('#AwardedPrj').css({"display":"none"});
//	$("#AwP").removeClass("tabber-nav-normal");
	
	$('#PrzWon').css({"display":"none"});
//	$("#PrW").removeClass("tabber-nav-normal");
}
function showCurWrk()
{
	//$.noConflict();
	
//	$('#ActBid').css({"display":"none"});
	$('#ActiveBids').css({"display":"none"});
//	$("#AB").removeClass("tabber-nav-normal");
	
//	$('#CurWrk').css({"display":"block"});
	$('#CurrentWork').css({"display":"block"});
//	$("#CW").addClass("tabber-nav-normal");
	
//	$('#PstWrk').css({"display":"none"});
	$('#PastWork').css({"display":"none"});
//	$("#PsW").removeClass("tabber-nav-normal");
	
//	$('#AwrPrj').css({"display":"none"});
	$('#AwardedPrj').css({"display":"none"});
//	$("#AwP").removeClass("tabber-nav-normal");
	
	$('#PrzWon').css({"display":"none"});
//	$("#PrW").removeClass("tabber-nav-normal");
}

function showPstWrk()
{
	//$.noConflict();
	
//	$('#ActBid').css({"display":"none"});
	$('#ActiveBids').css({"display":"none"});
//	$("#AB").removeClass("tabber-nav-normal");
	
//	$('#CurWrk').css({"display":"none"});
	$('#CurrentWork').css({"display":"none"});
//	$("#CW").removeClass("tabber-nav-normal");
	
//	$('#PstWrk').css({"display":"block"});
	$('#PastWork').css({"display":"block"});
//	$("#PsW").addClass("tabber-nav-normal");
	
//	$('#AwrPrj').css({"display":"none"});
	$('#AwardedPrj').css({"display":"none"});
//	$("#AwP").removeClass("tabber-nav-normal");
	
	$('#PrzWon').css({"display":"none"});
//	$("#PrW").removeClass("tabber-nav-normal");
}
function showAwrPrj()
{
	//$.noConflict();

//	$('#ActBid').css({"display":"none"});
	$('#ActiveBids').css({"display":"none"});	
//	$("#AB").removeClass("tabber-nav-normal");
	
//	$('#CurWrk').css({"display":"none"});
	$('#CurrentWork').css({"display":"none"});
//	$("#CW").removeClass("tabber-nav-normal");
	
//	$('#PstWrk').css({"display":"none"});
	$('#PastWork').css({"display":"none"});
//	$("#PsW").removeClass("tabber-nav-normal");
	
//	$('#AwrPrj').css({"display":"block"});
	$('#AwardedPrj').css({"display":"block"});
//	$("#AwP").addClass("tabber-nav-normal");
	
	$('#PrzWon').css({"display":"none"});
//	$("#PrW").removeClass("tabber-nav-normal");

}

function showActCon()
{
	//$.noConflict();
	
//	$('#ActBid').css({"display":"none"});
	$('#ActiveBids').css({"display":"none"});
//	$("#AB").removeClass("tabber-nav-normal");
	
//	$('#CurWrk').css({"display":"none"});
	$('#CurrentWork').css({"display":"none"});
//	$("#CW").removeClass("tabber-nav-normal");
	
//	$('#PstWrk').css({"display":"none"});
	$('#PastWork').css({"display":"none"});
//	$("#PsW").removeClass("tabber-nav-normal");
	
	$('#ActCon').css({"display":"block"});
//	$("#AC").addClass("tabber-nav-normal");
	
	$('#PrzWon').css({"display":"none"});
//	$("#PrW").removeClass("tabber-nav-normal");
}
function showPrzWon()
{
	//$.noConflict();
	
//	$('#ActBid').css({"display":"none"});
	$('#ActiveBids').css({"display":"none"});
	
//	$("#AB").removeClass("tabber-nav-normal");
	
//	$('#CurWrk').css({"display":"none"});
	$('#CurrentWork').css({"display":"none"});
//	$("#CW").removeClass("tabber-nav-normal");
	
	$('#PstWrk').css({"display":"none"});
//	$("#PsW").removeClass("tabber-nav-normal");
	
	$('#ActCon').css({"display":"none"});
//	$("#AC").removeClass("tabber-nav-normal");
	
	$('#PrzWon').css({"display":"block"});
//	$("#PrW").addClass("tabber-nav-normal");
}


function takeAction(id,act,md5_id)
{

	if(act=='retract')
	{
		
        bootbox.confirm("<?php echo $lang[690]; ?>", function(result) {
			if(result)
			{
				$.get("ajax-file/retractBid.php", {bd_id:id}, function(data){	//window.location.reload();	showActBid();	
				loadActiveBids(1);	
			});
				
         	}
		 });
	}
	else if(act=='edit_bid')
	{
//		$('#edit_bid_'+id).css({"display":"table"});
		$('#edit_bid_'+id).show();
	}
	else if(act=='dispute')
	{
		window.location.href="eDispute.php?b="+id;
	}
      else if(act=='send_message')
	{
		window.open("private.php?b="+id,'','width=640, height=540, resizable=yes, left=100,top=100,menu=no, toolbar=no,scrollbars=yes');
	}
	else if(act=='review_rating')
	{
		window.location.href="review-rating.php?b="+id;
	}
	else if(act=='delproj')
	{
		//$.noConflict();
		$.get("ajax-file/delProject.php", {prj_id:id}, function(data){	window.location.reload();	});
	}
	else if(act=='awardproj')
	{
		window.location = "project.php?p="+id;	
	}
	else if(act=='editproj')
	{
		window.location = "project-edit.php?p="+md5_id;
	}
	else if(act=='closeProj')
	{
		//$.noConflict();
		$.get("ajax-file/closeProject.php", {prj_id:id}, function(data){	window.location.reload();	});
	}
	else if(act=='repostProj')
	{
		//$.noConflict();
		$.get("ajax-file/repostProject.php", {prj_id:id}, function(data){	window.location.reload();	});
	}
	else if(act=='feedback')
	{
		window.location = "review-rating.php?bd="+id;
	}
      else if(act=='complete_by_webmstr')
	{
            //$.noConflict();
            $.get("ajax-file/projComplete.php", {b:id}, function(data){	window.location.reload();	});
      }
}
function editBidSubmit(bd_id)
{
	//$.noConflict();
	new_bid_amt = $("#new_bid_amt").val();
	if(new_bid_amt =='' || new_bid_amt=='0')
	{
		alert('<?php echo $lang[332]; ?>');
		$("#new_bid_amt").focus();
		return false;
	}
	$.get("ajax-file/updBid.php", {bd_id:bd_id,bd_amount:new_bid_amt}, function(data){	window.location.reload();	showActBid();	});
}
function editBidCancel(bd_id)
{
	//$.noConflict();
	$('#edit_bid_'+bd_id).css({"display":"none"});
}
function changepage(newPage)
{
    
	if (newPage == 'sellerview') 
	{
		//$.noConflict();
		$('#employerView_id').css({"display":"none"});
		$('#freelancerView_id').css({"display":"block"});
		$("#fo").addClass("ns_selected");
		$("#eo").removeClass("ns_selected");
		
	}
	else
	{
		//$.noConflict();
		$('#employerView_id').css({"display":"block"});
		$('#freelancerView_id').css({"display":"none"});
		$("#fo").removeClass("ns_selected");
		$("#eo").addClass("ns_selected");
	}
}
function actdecProj(tpa_id,stat)
{
	//$.noConflict();
	$.get("projAward.php", {tpa_id:tpa_id,stat:stat}, function(data){	window.location.reload();	});
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
		
        <!--js for new design ends-->
		
		<<div class="section db" style="background-image:url('upload/parallax_02.jpg');">
                <div class="container">
                    <div class="page-title text-center">
                        <div class="heading-holder">
                            <h1>Dashboard</h1>
                        </div>
						<div class="row">
                            <div class="col-md-12 col-sm-12">                   
                                <div class="col-md-12 col-sm-12">
									
									
								</div>
								
                            </div>
                        </div><!-- end row -->
							
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
                                    <li  class="active"><a href="manage.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[120]; ?></a></li>
									<li ><a href="mymessage.php"><span class="glyphicon glyphicon-user"></span>  <?php echo $lang[122]; ?></a></li>
                                    </ul>
                            </div><!-- end widget -->
                        </div><!-- end col -->

                        <div class="content col-md-9">
                            <div class="post-padding">
                                <div class="job-title nocover hidden-sm hidden-xs"><h5><?php echo $lang[120]; ?></h5></div>
                                <form id="submit" class="submit-form">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">                   
                                            <div class="col-md-2 col-sm-4">
												<?php if($row_u->usr_image=='' || $row_u->usr_image==NULL){ ?>
												<img src="images/users/unknown.png" alt="<?php echo $row_u->usr_name; ?>" style="margin-right: 20px;" border="0" width="80" height="80">
												<?php } else { ?>
															<img src="images/users/<?php echo $row_u->usr_image; ?>" alt="<?php echo $row_u->usr_name; ?>" style="margin-right: 20px;" border="0" width="80" height="80">
												<?php } ?>
											</div>
											<div class="col-md-4 col-sm-8">
												<p class="lead" style="text-align:left;padding-top:10px;"><?php echo $lang[333]; ?>&nbsp;<?php echo $_SESSION['usr']; ?> </p>
												<?php
													$sql_uld="select * from user usr, user_login_details uld where usr.usr_id='".$_SESSION['uid']."' and usr.usr_id=uld.uld_usr_id and uld.uld_id != (select max(uld.uld_id) from user usr, user_login_details uld where usr.usr_id=uld.uld_usr_id) order by uld_last_login desc";
													$res_uld=mysql_query($sql_uld);
													if(mysql_num_rows($res_uld)>0){
													$row_uld=mysql_fetch_object($res_uld);
												?>
												<p class="lead" style="font-size:10px;text-align:left;line-height:15px;font-style:italic;"><?php echo $lang[334]; ?> <?php echo date("M d,Y",strtotime($row_uld->uld_last_login)); ?> <?php echo $lang[335]; ?> <?php echo date("H:i",strtotime($row_uld->uld_last_login)); ?> <?php echo $lang[336]; ?> <?php echo $row_uld->uld_ip; ?></p>
												<?php } ?>
											</div>
											<div class="col-md-4 col-sm-8">
												<p style="padding-top:10px;"><?php echo $lang[337]; ?>&nbsp;<?php echo profileCompleteness($row_u->usr_id); ?>%&nbsp;<?php echo $lang[338]; ?></p>
												<div class="progress progress-striped active">
													<div class="progress-bar progress-bar-success" style="width: <?php echo profileCompleteness($row_u->usr_id); ?>%"></div>
												</div>
											</div>
											<div class="col-md-2 col-sm-4">
												<?php
												$sql_tot_bid="select count(*) from bid,user where bd_usr_id=usr_id and bd_usr_id='".$_SESSION['uid']."' and bd_date between DATE_SUB(usr_mem_expiry,INTERVAL 1 MONTH) and usr_mem_expiry and (now() between DATE_SUB(usr_mem_expiry,INTERVAL 1 MONTH) and usr_mem_expiry)";
												$res_tot_bid=mysql_query($sql_tot_bid);
												$row_tot_bid=mysql_fetch_array($res_tot_bid);

												$sql_mem="select * from membership_plan,user where usr_mp_id=mp_id and usr_id='".$_SESSION['uid']."'";
												$res_mem=mysql_query($sql_mem);
												$row_mem=mysql_fetch_object($res_mem);

												$remaining_bid=$row_mem->usr_left_bid;
										
												?>
												<p style="padding-top:10px;"><span><?php echo $remaining_bid; ?>/<?php echo $row_mem->usr_total_bid; ?></span></p>
												<p><?php echo $lang[339]; ?></p>
											</div>
                                        </div>
                                    </div><!-- end row -->
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">                   
											<h3 class="row  smaller lighter blue">
												<span class="col-xs-12"> &nbsp;<?php echo $lang[340]; ?> </span><!-- /span -->
											</h3>

											<div id="accordion" class="accordion-style1 panel-group">
											
												<?php
												$sql_ntc="select * from notice where ntc_status=1 order by ntc_updated_date desc limit 4";
												$res_ntc=mysql_query($sql_ntc);
												$c=0;
												while($row_ntc=mysql_fetch_object($res_ntc))
												{	?>
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
															<a class="accordion-toggle <?php	if($c!=0){	?>collapsed<?php	}	?>" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php	echo $c; ?>">
																<i class="icon-angle-down bigger-110" data-icon-hide="icon-angle-down" data-icon-show="icon-angle-right"></i>
																&nbsp;<?php echo $row_ntc->ntc_heading; ?>&nbsp;&nbsp;(<?php echo date("M d, Y", strtotime($row_ntc->ntc_updated_date)); ?>)
															</a>
														</h4>
													</div>

													<div class="panel-collapse collapse <?php	if($c==0){	?>in<?php	}	?>" id="collapse<?php	echo $c; ?>">
														<div class="panel-body"><?php echo $row_ntc->ntc_description; ?></div>
													</div>
												</div>
												<?php	
												$c++;
												}	?>
											</div>
                                        </div>
                                    </div><!-- end row -->
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">   
                                           <h2><?php echo $lang[341]; ?></h2>

										   <?php if($row_u->usr_type=="Both"){  ?> 
											<div class="control-group" align="left">
												
												
													<label>
														<input id="employerView_option" onClick="changepage('buyerview')" value="employer" name="usertype_option" type="radio" class="ace" />
														<span class="lbl"> <?php echo $lang[342]; ?></span>
													</label>
													&nbsp;
													<label>
														<input id="freelancerView_option" onClick="changepage('sellerview')" value="freelancer" name="usertype_option" type="radio" checked="checked" class="ace" />
														<span class="lbl"> <?php echo $lang[343]; ?></span>
													</label>
												
										
											</div>
										   <?php } ?>
										   
										   <div id="employerView_id" style="display:none;" >
												<div class="tabbable">
													<ul class="nav nav-tabs padding-12 tab-color-blue background-blue">
														<li class="active"><a data-toggle="tab" onClick="showOpnBid()" style="cursor:pointer"><?php echo $lang[344]; ?></a></li>
														<li><a data-toggle="tab" onClick="showWrkPrg()" style="cursor:pointer"><?php echo $lang[345]; ?></a></li>
														<li><a data-toggle="tab" onClick="showPstPrj()" style="cursor:pointer"><?php echo $lang[346]; ?></a></li>
													</ul>
													<div class="tab-content">
														<div id="OpenForBidding" style="display:none;"></div>
														<div id="WorkInProgress" style="display:none;"></div>
														<div id="PastProjects" style="display:none;"></div>
													</div>
												</div>
											</div>
											
											
											
											
											
											<div id="freelancerView_id" style="display:block;">
												<div class="tabbable">
													<ul class="nav nav-tabs padding-12 tab-color-blue background-blue">
														<li class="active"><a data-toggle="tab" onClick="showActBid()" style="cursor:pointer"><?php echo $lang[347]; ?></a></li>
														<li><a data-toggle="tab" onClick="showCurWrk()" style="cursor:pointer"><?php echo $lang[348]; ?></a></li>
														<li><a data-toggle="tab" onClick="showPstWrk()" style="cursor:pointer"><?php echo $lang[349]; ?></a></li>
														<?php if(mysql_num_rows($res_ap)>0) { ?>
														<li><a data-toggle="tab" onClick="showAwrPrj()" style="cursor:pointer"><?php echo $lang[675]; ?></a></li>
														<?php } ?>
													</ul>
												
												<div class="tab-content">
													<div id="ActiveBids" style="display:none;"></div>
													<div id="CurrentWork" style="display:none;"></div>
													<div id="PastWork" style="display:none;"></div>
													
													<div id="AwardedPrj" style="display:none;">
													<div class="row" id="AwrPrj">
														<div class="col-xs-12">
														<div class="table-responsive">
														<table class="table table-striped table-bordered table-hover">
														<thead>
															<tr>
																<th><?php echo $lang[18]; ?></th>
																<th><?php echo $lang[60]; ?></th>
																<th><?php echo $lang[606]; ?></th>
																<th><?php echo $lang[600]; ?></th>
																<th><?php echo $lang[598]; ?></th>
															</tr>
														</thead>
														<tbody>

														<?php
														//$sql_ap="select * from project where prj_id in(select bd_prj_id from bid where bd_id in(select tpa_bd_id from temp_proj_award) and bd_usr_id=".$_SESSION['uid'].")";
														while($row_ap=mysql_fetch_object($res_ap)){?>

															<tr>
																<td width="25%" align="left" valign="top"><a href="project.php?p=<?php echo $row_ap->prj_id; ?>"><?php echo stripslashes($row_ap->prj_name); ?></a></td>
																<td width="18%" align="left" valign="top">
																	<a href="profile.php?u=<?php echo md5($row_ap->usr_id); ?>"><?php echo $row_ap->usr_name; ?></a>
																</td>
																<td width="18%" align="left" valign="top"><?php echo $row_ap->bd_amount; ?>&nbsp;
																		<?php  if($row_ap->usr_balance<$row_ap->bd_amount){	?>
																		<img style="vertical-align: bottom;" title="<?php echo $lang[602]; ?>" src="images/cross.png" border="0">
																		<?php }   ?>

																</td>
															
																<td width="21%" align="left" valign="top">
																	<?php
																		$sql_m="select count(*) from message where msg_prj_id='".$row_ap->prj_id."' and msg_to='".$_SESSION['uid']."'";
																		$res_m=mysql_query($sql_m);
																		$row_m=mysql_fetch_array($res_m);
																				
																		$sql_ur="select count(*) from message where msg_prj_id='".$row_ap->prj_id."' and msg_to='".$_SESSION['uid']."' and msg_read='0'";
																		$res_ur=mysql_query($sql_ur);
																		$row_ur=mysql_fetch_array($res_ur);
																	?>
																	<a href="mymessage.php"><?php echo $row_m[0]; ?></a><?php if($row_ur[0]>0){ ?><sup style="color:green; font-weight: bold"> +<?php echo $row_ur[0]; ?> unread</sup><?php } ?>
																</td>
															
																<td width="18%" align="left" valign="top">
																	<select class="sellerview-action-on-proj" name="actdec" id="actdec" onChange="actdecProj(<?php echo $row_ap->tpa_id; ?>,this.value)">
																		<option value="0"><?php echo $lang[526]; ?></option>
																		<option value="accept"><?php echo $lang[514]; ?></option>
																		<option value="decline"><?php echo $lang[515]; ?></option>
																	</select>
																</td>
															
															</tr>
														<?php } ?>

														<style>
														select {
														 font-size:13px; 
														}
														</style>
														</tbody>
														</table>
														</div>
														</div>
													</div>
													</div>
													
													
												</div>
												</div>
											</div>
											
                                        </div>
                                    </div><!-- end row -->
                                    
                                </form>
                            </div><!-- end post-padding -->
                        </div><!-- end col -->
                    </div><!-- end row -->  
                </div><!-- end container -->
            </div><!-- end section -->

	
        
        
        
	



<?php include "includes/footer.php"; ?>
<?php if($row_u->usr_type=="Employer"){ ?>
<script type="text/javascript"> changepage('buyerview'); </script>
<?php }else if($row_u->usr_type=="Freelancer"){    ?>
<script type="text/javascript"> changepage('sellerview'); </script>
<?php } ?>
