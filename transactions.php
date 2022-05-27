<?php
ob_start();
session_start();
include "common.php";

if($_SESSION['uid']==''){	header("Location:login.php");	}

?>

<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<script type="text/javascript">
$( document ).ready(function() {

	loadAllDepositTrans(1);
	loadAllWithdrawTrans(1);
	showTransIn(1);
	showTransOut(1);
});
function showTransOut(page)
{
	$.post("ajax-file/loadOutgoingTrans.php",{page:page},    function(data){    
											
	$('#trans-outgoing').html(data);
	
	$('#trans-outgoing').css({"display":"block"});
	$("#TransOut").addClass("ns_selected");

	$('#trans-incoming').css({"display":"none"});
	$("#TransIn").removeClass("ns_selected");
	
	});
}
function showTransIn(page)
{
	//$.noConflict();

	$.post("ajax-file/loadIncomingTrans.php",{page:page},    function(data){    
											
		$('#trans-incoming').html(data);
		
		$('#trans-outgoing').css({"display":"none"});
		$("#TransOut").removeClass("ns_selected");

		$('#trans-incoming').css({"display":"block"});
		$("#TransIn").addClass("ns_selected");
	});
	
	
}

function loadAllDepositTrans(page)
{
	$.post("ajax-file/loadAllDepositTrans.php",{page:page},    function(data){    $('#deposit').html(data);	});
}
function loadAllWithdrawTrans(page)
{
	$.post("ajax-file/loadAllWithdrawTrans.php",{page:page},    function(data){    $('#withdraw').html(data);	});
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
                        <div class="sidebar col-md-3">
                            <div class="post-padding clearfix">
                                <ul class="nav nav-pills nav-stacked">
									<li ><a href="financial-dash.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[133]; ?></a></li>
                                    <li ><a href="payment-deposit.php"><span class="glyphicon glyphicon-user"></span>  <?php echo $lang[134]; ?></a></li>
									<li ><a href="transfer-funds.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[135]; ?></a></li>
									<li ><a href="withdraw-funds.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[136]; ?></a></li>
									<li ><a href="release-funds.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[137]; ?></a></li>
									<li ><a href="invoice.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[796]; ?></a></li>
									<li class="active"><a href="transactions.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[138]; ?></a></li>
                                    </ul>
                            </div><!-- end widget -->
                        </div><!-- end col -->

                        <div class="content col-md-9">
                            <div class="post-padding">
                                <div class="job-title nocover hidden-sm hidden-xs"><h5><?php echo $lang[138]; ?></h5></div>
                                
                                    
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">   
                                            
											
											
											<div class="clearfix">
												
												<div class="pg-header-rgt-col" style="float:right;"><a href="payment-deposit.php" class="btn btn-success"><?php echo $lang[53]; ?></a></div>
											</div>
											<div class="tabbable">
												
													<ul class="nav nav-tabs padding-12 tab-color-blue background-blue">
														<li class="active"><a data-toggle="tab" href="#trans"><?php echo $lang[54]; ?></a></li>
														<li><a data-toggle="tab" href="#deposit"><?php echo $lang[55]; ?></a></li>
														<li><a data-toggle="tab" href="#withdraw"><?php echo $lang[56]; ?></a></li>
													</ul>
												
												<div class="transaction-history-box tab-content">
													
														<div class="tab-pane in active" id="trans">
															<div style="padding-bottom:20px;"><!--<a href="#" class="export-transation-txt">+ Export Transactions</a>--></div>
															<div class="clearfix" style="padding-bottom:30px;">
																<div class="show-tran-col">
																		<a onClick="javascript:showTransOut(1)" id="TransOut" class="btn btn-primary milestone-toggle-outgoing ns_toggle-btn ns_btn-right ns_right" style="cursor:pointer;"><?php echo $lang[57]; ?></a>
																		<a onClick="javascript:showTransIn(1)" id="TransIn" class="btn btn-primary milestone-toggle-incoming ns_toggle-btn ns_btn-left ns_right ns_selected" style="cursor:pointer;"><?php echo $lang[58]; ?></a>
																</div>
																<div class="top-pagination-col"><!--<img src="images/pagination.jpg" alt="" />--></div>
															</div>
															<div class="tran-history-detail-box" id="trans-incoming" style="display:block;"></div>
															<div class="tran-history-detail-box" id="trans-outgoing" style="display:none;"></div>
															<div style="text-align:right; padding:20px 0 0 0;"><!--<img src="images/pagination.jpg" alt="" />--></div>
														</div>
																
																<!--- All Deposit -->
																<div class="tab-pane" id="deposit">

																
																	
<?php 

$page =1;
$cur_page = $page;
$page -= 1;
$per_page = 10; // Per page records
$previous_btn = true;
$next_btn = true;
//$first_btn = false;
//$last_btn = false;
$start = $page * $per_page;


$sql_dp="select * from deposit_fund where df_usr_id='".$_SESSION['uid']."' order by df_paydate desc LIMIT $start, $per_page";
$res_dp=mysql_query($sql_dp) or die('MySql Error' . mysql_error());
?>
<div style="padding-bottom:20px;"><!--<a href="#" class="export-transation-txt">+ Export Transaction</a>--></div>
<div class="clearfix" style="padding-bottom:30px;">
	<div class="show-tran-col"><!--Show&nbsp;&nbsp;<img src="images/tran-list-img.jpg" alt="" />--></div>
	<div class="top-pagination-col"><!--<img src="images/pagination.jpg" alt="" />--></div>
</div>
<div class="tran-history-detail-box">
	<table class="table table-striped table-bordered table-hover">
		<thead>
    		<tr>
				<th><?php echo $lang[59]; ?></th>
				<th><?php echo $lang[66]; ?></th>
				<th><?php echo $lang[62]; ?> (<?php echo getCurrencyCode(); ?>)</th>
			</tr>
		</thead>
		<tbody>
        <?php
			if(mysql_num_rows($res_dp)>0)	{
				$c=1;
				while($row_dp=mysql_fetch_object($res_dp)){	
		?>
			<tr>
				<td width="15%" align="left" valign="top"><?php echo date("d-F-Y",strtotime($row_dp->df_paydate)); ?></td>
				<td width="65%" align="left" valign="top"><?php echo strtoupper($row_dp->df_method); ?></td>
				<td width="20%" align="left" valign="top" ><?php echo getCurrencySymbol()."&nbsp;".strtoupper($row_dp->df_amount); ?></td>
			</tr>
		<?php } 
		}else{	?>
			<tr>
		       	<td width="100%" colspan="3" valign="top"><?php echo $lang[67]; ?></td>
			</tr>
			<?php } ?>
		<style>select { font-size:13px; }</style>
	</tbody>
	</table>
    
<!------------------------- pagination start here ----------->
<?php
/* -----Total count--- */
$query_pag_num = "select count(*) AS count from deposit_fund where df_usr_id='".$_SESSION['uid']."'"; // Total records
$result_pag_num = mysql_query($query_pag_num);
$row = mysql_fetch_array($result_pag_num);
$count = $row['count'];
$no_of_paginations = ceil($count / $per_page);

if ($cur_page >= 7) {
    $start_loop = $cur_page - 3;
    if ($no_of_paginations > $cur_page + 3)
        $end_loop = $cur_page + 3;
    else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
        $start_loop = $no_of_paginations - 6;
        $end_loop = $no_of_paginations;
    } else {
        $end_loop = $no_of_paginations;
    }
} else {
    $start_loop = 1;
    if ($no_of_paginations > 7)
        $end_loop = 7;
    else
        $end_loop = $no_of_paginations;
}
?>

<?php if($count>$per_page){	?>
<ul class="pagination pull-right no-margin">
<?php
// FOR ENABLING THE PREVIOUS BUTTON
if ($previous_btn && $cur_page > 1) {
    $pre = $cur_page - 1;
	?>
    <li class="prev"><a href="javascript:loadAllDepositTrans('<?php echo $pre; ?>')"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
<?php	} else if ($previous_btn) {	?>
	<li class="prev disabled"><a><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
<?php	}	?>
	<!--<li class="prev disabled">
		<a href="#"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
	</li>-->
    
    <?php
for ($i = $start_loop; $i <= $end_loop; $i++) {
    if ($cur_page == $i){	?>
        <li class="active"><a><?php echo $i; ?></a></li>
	<?php	}else{	?>
        <li><a href="javascript:loadAllDepositTrans('<?php echo $i; ?>')"><?php echo $i; ?></a></li>
	<?php	}
}
	 ?>
	<!--<li class="active">
		<a href="#">1</a>
	</li>
	<li>
		<a href="#">2</a>
	</li>
	<li>
		<a href="#">3</a>
	</li>-->
<?php
// TO ENABLE THE NEXT BUTTON
if ($next_btn && $cur_page < $no_of_paginations) {
    $nex = $cur_page + 1;	?>
    <li class="next"><a href="javascript:loadAllDepositTrans('<?php echo $nex; ?>')"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
<?php	} else if ($next_btn) {	?>
    <li class="next disabled"><a><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
<?php	}	?>
	<!--<li class="next">
		<a href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
	</li>-->
</ul>
<div style="text-align:right; padding-bottom:50px;"><!--<img src="images/pagination.jpg" alt="" />--></div>
<?php	}	?>
<!------------------------- pagination end here ----------->
		</div>
	

	

																 
																</div>
																
																<!--- All Withdrawals -->
																<div class="tab-pane" id="withdraw">
<?php 																

$page = 1;
$cur_page = $page;
$page -= 1;
$per_page = 10; // Per page records
$previous_btn = true;
$next_btn = true;
//$first_btn = false;
//$last_btn = false;
$start = $page * $per_page;


$sql_wf="select * from withdraw_funds where wf_usr_id='".$_SESSION['uid']."' order by wf_updated_date desc LIMIT $start, $per_page";
$res_wf=mysql_query($sql_wf) or die('MySql Error' . mysql_error());
?>
<div style="padding-bottom:20px;"></div>
<div class="clearfix" style="padding-bottom:30px;">
	<div class="show-tran-col"></div>
	<div class="top-pagination-col"></div>
</div>
<div class="tran-history-detail-box">
	<table class="table table-striped table-bordered table-hover">
		<thead>
    		<tr>
				<th><?php echo $lang[59]; ?></th>
				<th><?php echo $lang[62]; ?> (<?php echo getCurrencyCode(); ?>)</th>
				<th><?php echo $lang[68]; ?></th>
				<th><?php echo $lang[61]; ?></th>
			</tr>
		</thead>
        <tbody>
       	<?php
			if(mysql_num_rows($res_wf)>0){
				$c=1;
				while($row_wf=mysql_fetch_object($res_wf)){	
		?>
			<tr>
				<td width="25%" align="left" valign="top"><?php echo date("d-F-Y",strtotime($row_wf->wf_updated_date)); ?></td>
				<td width="25%" align="left" valign="top"><?php echo getCurrencySymbol()." ".strtoupper($row_wf->wf_amount); ?></td>
				<td width="35%" align="left" valign="top"><?php echo ucfirst($row_wf->wf_gatewayName)." ( ".$lang[71]." ".$row_wf->wf_gatewayId." )"; ?></td>
                <td width="15%" align="left" valign="top"><?php if($row_wf->wf_status=='0'){	echo $lang[69]; }else{ echo $lang[70]; } ?></td>
			</tr>
		<?php } 
			}else{	?>
			<tr>
				<td colspan="4" valign="top"><?php echo $lang[72]; ?></td>
			</tr>
		<?php } ?>
			<style>select { font-size:13px; }</style>
		</tbody>
	</table>
	
				<!------------------------- pagination start here ----------->
<?php
/* -----Total count--- */
$query_pag_num = "select count(*) AS count from withdraw_funds where wf_usr_id='".$_SESSION['uid']."'"; // Total records
$result_pag_num = mysql_query($query_pag_num);
$row = mysql_fetch_array($result_pag_num);
$count = $row['count'];
$no_of_paginations = ceil($count / $per_page);

if ($cur_page >= 7) {
    $start_loop = $cur_page - 3;
    if ($no_of_paginations > $cur_page + 3)
        $end_loop = $cur_page + 3;
    else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
        $start_loop = $no_of_paginations - 6;
        $end_loop = $no_of_paginations;
    } else {
        $end_loop = $no_of_paginations;
    }
} else {
    $start_loop = 1;
    if ($no_of_paginations > 7)
        $end_loop = 7;
    else
        $end_loop = $no_of_paginations;
}
?>

<?php if($count>$per_page){	?>
<ul class="pagination pull-right no-margin">
<?php
// FOR ENABLING THE PREVIOUS BUTTON
if ($previous_btn && $cur_page > 1) {
    $pre = $cur_page - 1;
	?>
    <li class="prev"><a href="javascript:loadAllWithdrawTrans('<?php echo $pre; ?>')"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
<?php	} else if ($previous_btn) {	?>
	<li class="prev disabled"><a><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>
<?php	}	?>
	<!--<li class="prev disabled">
		<a href="#"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>
	</li>-->
    
    <?php
for ($i = $start_loop; $i <= $end_loop; $i++) {
    if ($cur_page == $i){	?>
        <li class="active"><a><?php echo $i; ?></a></li>
	<?php	}else{	?>
        <li><a href="javascript:loadAllWithdrawTrans('<?php echo $i; ?>')"><?php echo $i; ?></a></li>
	<?php	}
}
	 ?>
	<!--<li class="active">
		<a href="#">1</a>
	</li>
	<li>
		<a href="#">2</a>
	</li>
	<li>
		<a href="#">3</a>
	</li>-->
<?php
// TO ENABLE THE NEXT BUTTON
if ($next_btn && $cur_page < $no_of_paginations) {
    $nex = $cur_page + 1;	?>
    <li class="next"><a href="javascript:loadAllWithdrawTrans('<?php echo $nex; ?>')"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
<?php	} else if ($next_btn) {	?>
    <li class="next disabled"><a><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>
<?php	}	?>
	<!--<li class="next">
		<a href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
	</li>-->
</ul>
<div style="text-align:right; padding-bottom:50px;"><!--<img src="images/pagination.jpg" alt="" />--></div>
<?php	}	?>
<!------------------------- pagination end here ----------->
		</div>

																
																</div>

														
												</div>
											</div>
												
											
											
										</div>
                                    </div><!-- end row -->
                                    <hr class="invis">
									
								
                            </div><!-- end post-padding -->
                        </div><!-- end col -->
                    </div><!-- end row -->  
                </div><!-- end container -->
            </div><!-- end section -->



					
			
<?php include "includes/footer.php"; ?>>>