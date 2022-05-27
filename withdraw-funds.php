<?php
ob_start();
session_start();
include "common.php";

if($_SESSION['uid']==''){	header("location:login.php");	}

if(isset($_SESSION['msg'])){	$msg=$_SESSION['msg'];	unset($_SESSION['msg']);	}
if(isset($_SESSION['wf_gatewayName'])){	$wf_gatewayName=$_SESSION['wf_gatewayName'];	unset($_SESSION['wf_gatewayName']);	}else{ $wf_gatewayName=""; }
if(isset($_SESSION['wf_gatewayId'])){	$wf_gatewayId=$_SESSION['wf_gatewayId'];	unset($_SESSION['wf_gatewayId']);	}else{ $wf_gatewayId=""; }
if(isset($_SESSION['wf_amount'])){	$wf_amount=$_SESSION['wf_amount'];	unset($_SESSION['wf_amount']);	}else{ $wf_amount=""; }

$sql_usr="select * from user where usr_id=".$_SESSION['uid'];
$res_usr=mysql_query($sql_usr);
$row_usr=mysql_fetch_object($res_usr);


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
                        <div class="sidebar col-md-3">
                            <div class="post-padding clearfix">
                                <ul class="nav nav-pills nav-stacked">
									<li ><a href="financial-dash.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[133]; ?></a></li>
                                    <li ><a href="payment-deposit.php"><span class="glyphicon glyphicon-user"></span>  <?php echo $lang[134]; ?></a></li>
									<li ><a href="transfer-funds.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[135]; ?></a></li>
									<li class="active"><a href="withdraw-funds.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[136]; ?></a></li>
									<li ><a href="release-funds.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[137]; ?></a></li>
									<li ><a href="invoice.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[796]; ?></a></li>
									<li ><a href="transactions.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[138]; ?></a></li>
                                    </ul>
                            </div><!-- end widget -->
                        </div><!-- end col -->

                        <div class="content col-md-9">
                            <div class="post-padding">
                                <div class="job-title nocover hidden-sm hidden-xs"><h5><?php echo $lang[226]; ?></h5></div>
                                
                                    
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">   
                                            
                                            <form action="withdraw-funds-confirm.php" class="form-horizontal" method="post" onsubmit="return validWithdraw()">
												<input type="hidden" name="wf_usr_id" value="<?php echo $_SESSION['uid']; ?>"/>
												<div class="signup-form-str" id="msg"><?php echo $msg; ?></div>
													<h4><?php echo $lang[227]; ?><?php echo getCurrencySymbol() ?><?php echo $row_usr->usr_balance; ?>&nbsp;<?php echo getCurrencyCode() ?></h4>
														<label class="control-label"><?php echo $lang[228]; ?> </label>
														<?php
														$al=mysql_query("select * from payment_gateway where pg_status='1'");
														while($row_al=mysql_fetch_array($al)){
														?>
												 
														<input id="deposit.paypal.referenceRadio" name="wf_method" methodname="deposit.paypal.reference" value="<?php echo $row_al['id'];?>" type="radio" checked="checked" class="ace"/><span class="lbl">&nbsp;<?php echo ucfirst($row_al['pg_name']);?>( <?php echo $lang[229]; ?> <?php if($row_al['pg_withdraw_fee_type']=="fixed"){ echo get_page_settings(8); echo $row_al['pg_withdraw_fee']; } if($row_al['pg_withdraw_fee_type']=="percent"){ echo $row_al['pg_withdraw_fee']."%"; } ?> )</span>
														<?php } ?>
														<br>
														<label class="col-sm-6 control-label no-padding-right" for="df_amount"><?php echo $lang[230]; ?></label>
														<div class="col-sm-5">
															<input type="text" name="wf_gatewayId" id="wf_gatewayId" class="form-control" value="<?php echo $wf_gatewayId; ?>"/>
														</div>
														<br><br>
														<label class="col-sm-6 control-label no-padding-right" for="df_amount"><?php echo $lang[231]; ?><?php echo $lang[232]; ?>&nbsp;<?php echo getCurrencySymbol().getMinWithdrawAmt(); ?>&nbsp;<?php echo getCurrencyCode(); ?><?php echo $lang[233]; ?></label>
														<div class="col-sm-4">
															<input type="hidden" id="min_withdraw_amt" name="min_withdraw_amt" value="<?php echo getMinWithdrawAmt(); ?>"/>
															<input type="hidden" id="prev_balance" name="prev_balance" value="<?php echo $row_usr->usr_balance; ?>"/>
															 <input type="text" name="wf_amount" id="wf_amount" class="form-control" value="<?php echo $wf_amount; ?>" />
														</div>
														<br><br>
														<div class="form-group">
															<div class="col-md-12">
																	<input type="hidden" name="confirm" value="1"/>
															<input type="submit" id="btn_next_id" name="withdraw_fund" class="btn btn-info" value="<?php echo $lang[234]; ?>">
															</div>
														</div>
																
															
											</form>
										</div>	
									</div>
                            </div><!-- end row -->
                                <hr class="invis">
									
								
                            </div><!-- end post-padding -->
                        </div><!-- end col -->
                    </div><!-- end row -->  
                </div><!-- end container -->
            </div><!-- end section -->

<script type="text/javascript">
    function validWithdraw()
{

	var wf_gatewayId = document.getElementById('wf_gatewayId');	
	var min_withdraw_amt = document.getElementById('min_withdraw_amt');	
	var prev_balance = document.getElementById('prev_balance');	
	var wf_amount = document.getElementById('wf_amount');	

	var msg="";
	var valid=true;
	
	if (wf_gatewayId.value == "" || wf_gatewayId.value == null)
    {
		msg='<?php echo $lang[670]; ?>';
		wf_gatewayId.value="";
            wf_gatewayId.focus();
            valid = false;		
    }  
	else if (wf_amount.value == "" || wf_amount.value == null)
    {
		msg='<?php echo $lang[671]; ?>';
		wf_amount.value="";
        wf_amount.focus();
        valid = false;		
    }  
	else if (parseInt(wf_amount.value) < parseInt(min_withdraw_amt.value))
    {
		msg='<?php echo $lang[672]; ?>'+min_withdraw_amt.value+'<?php echo $lang[673]; ?>';
		wf_amount.value="";
        wf_amount.focus();
		
        valid = false;		
    }
	else if (prev_balance.value < wf_amount.value)
    {
		msg='<?php echo $lang[587]; ?>';
		wf_amount.value="";
        wf_amount.focus();
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




	<div><h2 class="header-txt1-style align-center-txt"><?php echo $lang[226]; ?></h2></div>
    <div class="row">
		<div class="col-xs-12">
      <form action="withdraw-funds-confirm.php" class="form-horizontal" method="post" onsubmit="return validWithdraw()">
                <input type="hidden" name="wf_usr_id" value="<?php echo $_SESSION['uid']; ?>"/>

			
							
				<div class="signup-form-str" id="msg"><?php echo $msg; ?></div>
                                
                                <div class="signup-form-str">
					<label class="form-label"><?php echo $lang[227]; ?><?php echo getCurrencySymbol() ?><?php echo $row_usr->usr_balance; ?>&nbsp;<?php echo getCurrencyCode() ?></label>
				</div>
                                
                <div class="form-group">
	                <label class="col-sm-5 control-label no-padding-right" for="wf_method"><?php echo $lang[228]; ?></label>
					<div class="control-group" align="left">
					<div class="radio">
					<?php
                               $al=mysql_query("select * from payment_gateway where pg_status='1'");
					while($row_al=mysql_fetch_array($al)){
					?>
					 
					<input id="deposit.paypal.referenceRadio" name="wf_method" methodname="deposit.paypal.reference" value="<?php echo $row_al['id'];?>" type="radio" checked="checked" class="ace"/><span class="lbl">&nbsp;<?php echo ucfirst($row_al['pg_name']);?>( <?php echo $lang[229]; ?> <?php if($row_al['pg_withdraw_fee_type']=="fixed"){ echo get_page_settings(8); echo $row_al['pg_withdraw_fee']; } if($row_al['pg_withdraw_fee_type']=="percent"){ echo $row_al['pg_withdraw_fee']."%"; } ?> )</span>
					
                                    
								<?php } ?>
					</div></div>
								</div>
                                
               <div class="form-group">
	                   <label class="col-sm-5 control-label no-padding-right" for="wf_gatewayId"><?php echo $lang[230]; ?></label>
					<div class="col-sm-5">
					<input type="text" name="wf_gatewayId" id="wf_gatewayId" class="form-control" value="<?php echo $wf_gatewayId; ?>"/>
					</div>
				</div>
                <div class="form-group">
	                  <label class="col-sm-5 control-label no-padding-right" for="wf_amount"><?php echo $lang[231]; ?><?php echo $lang[232]; ?>&nbsp;<?php echo getCurrencySymbol().getMinWithdrawAmt(); ?>&nbsp;<?php echo getCurrencyCode(); ?><?php echo $lang[233]; ?></label>
					<div class="col-sm-4">
					<input type="hidden" id="min_withdraw_amt" name="min_withdraw_amt" value="<?php echo getMinWithdrawAmt(); ?>"/>
					<input type="hidden" id="prev_balance" name="prev_balance" value="<?php echo $row_usr->usr_balance; ?>"/>
                     <input type="text" name="wf_amount" id="wf_amount" class="form-control" value="<?php echo $wf_amount; ?>" />
				</div>
				</div>
								
		                       
				<div class="form-group">
					<div class="col-md-12">
                        	<input type="hidden" name="confirm" value="1"/>
					<input type="submit" id="btn_next_id" name="withdraw_fund" class="btn btn-info" value="<?php echo $lang[234]; ?>">
					</div>
				</div>
				
          </form>
        </div>
    </div>

	

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

			
	<?php include "includes/footer.php"; ?>