

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
        
<script type="text/javascript">
function showTransFreelancer()
{
	//$.noConflict();

	$('#trans-freelancer').css({"display":"table"});
	$("#Freel").addClass("ns_selected");

	$('#trans-employer').css({"display":"none"});
	$("#Empl").removeClass("ns_selected");
}
function showTransEmployer()
{
	//$.noConflict();

	$('#trans-freelancer').css({"display":"none"});
	$("#Freel").removeClass("ns_selected");

	$('#trans-employer').css({"display":"table"});
	$("#Empl").addClass("ns_selected");
}
</script>
<div class="panel-group">
	<div class="panel panel-primary">
			<div class="panel-heading">
				<?php echo $lang[284]; ?>
			
				<?php  if($_SESSION['type']=="Both"){  ?>
				<div class="show-tran-col" style="float:right;">
					<a onClick="javascript:showTransFreelancer()" id="Freel"  class="btn btn-primary milestone-toggle-outgoing ns_toggle-btn ns_btn-right ns_right" style="cursor:pointer;"><?php echo $lang[64]; ?></a>
					<a onClick="javascript:showTransEmployer()" id="Empl"  class="btn btn-primary milestone-toggle-incoming ns_toggle-btn ns_btn-left ns_right ns_selected" style="cursor:pointer;"><?php echo $lang[60]; ?></a>
				</div>
				<?php  } ?>
			</div>
			<div class="panel-body">
				
				<table class="table table-striped table-bordered table-hover" id="trans-employer" <?php if($_SESSION['type']=="Freelancer"){ ?>style="display: none;" <?php } ?>>
					<tbody align="center">
					<tr>
						<td>
							<h6 class="q-start-header-txt"><?php echo $lang[285]; ?></h6>
							<div class="clearfix">
							<?php
								$sql_pd="select count(*) from project where subdate(now(), INTERVAL 30 DAY) < prj_updated_date and prj_usr_id=".$_SESSION['uid'];
								$res_pd=mysql_query($sql_pd);
								$row_pd=mysql_fetch_array($res_pd);
							?>
								<div class="project-post-lft-col">
									<span class="number-txt"><?php echo $row_pd[0]; ?></span>
									<span class="only-txt"><?php echo $lang[286]; ?></span>
								</div>
							<?php 
								$sql_lp="select count(*) from project where prj_usr_id=".$_SESSION['uid'];
								$res_lp=mysql_query($sql_lp);
								$row_lp=mysql_fetch_array($res_lp);
							?>
								<div class="project-post-rgt-col">
									<span class="number-txt"><?php echo $row_lp[0]; ?></span>
									<span class="only-txt"><?php echo $lang[287]; ?></span>
								</div>
							</div>
						</td>
						
						<td>
							<h6 class="q-start-header-txt"><?php echo $lang[288]; ?></h6>
							<div class="clearfix">
							<?php
							$sql_wp="select sum(bd_amount),count(*) from project,bid,user where bd_prj_id=prj_id and bd_usr_id=usr_id and prj_usr_id='".$_SESSION['uid']."' and now()<prj_expiry and  bd_status=1 and prj_status='running'";
							$res_wp=mysql_query($sql_wp);
							$row_wp=mysql_fetch_array($res_wp);
							?>
								<div class="q-start-header-txt" align="center">
									<span class="number-txt_1" style="width:360px;"><?php echo getCurrencySymbol(); ?>&nbsp;<?php if($row_wp[0]>0){ echo number_format($row_wp[0],2); } else { echo "0.00"; } ?></span>
									<span class="only-txt_1" style="width:360px;"><?php if($row_wp[1]>0){ echo $row_wp[1]; } else { echo "0"; } ?><?php echo $lang[289]; ?></span>
								</div>
								<!--<div class="work-prog-rgt_col">
									<span class="number-txt_1">$3235.00</span>
									<span class="only-txt_1">55 outstanding projects</span>
								</div>-->
							</div>
						</td>
						<td>
						<?php
						
						
							$sql_fh="select count(*) from project,bid,user where prj_id=bd_prj_id and prj_usr_id=usr_id and prj_usr_id='".$_SESSION['uid']."' and bd_status='1'";
							$res_fh=mysql_query($sql_fh);
							$row_fh=mysql_fetch_array($res_fh);
						?>
							<h6 class="q-start-header-txt"><?php echo $lang[290]; ?></h6>
							<h3 class="q-start-body-txt"><?php echo $row_fh[0]; ?></h3>
							<h7 class="q-start-header-txt"><strong><?php echo $lang[287]; ?></strong></h7>
							
						</td>
						</tr>
						</tbody>
				</table>
				
				
				
				<table class="table table-striped table-bordered table-hover" id="trans-freelancer" <?php if($_SESSION['type']=="Freelancer"){ ?>style="display:table;" <?php }else{ ?>style="display:none;" <?php } ?>>
					<tbody>
					<tr>
						<td>
							<h6 class="q-start-header-txt"><?php echo $lang[291]; ?></h6>
							<div class="clearfix">
							<?php
							$sql_pa="select count(*) from project,bid,user where bd_prj_id=prj_id and prj_usr_id=usr_id and bd_usr_id='".$_SESSION['uid']."' and bd_status=1 and ( prj_status='running' or prj_status='complete') and (subdate(now(), INTERVAL 30 DAY) < subdate(bd_deadline, INTERVAL bd_days DAY))";
							$res_pa=mysql_query($sql_pa);
							$row_pa=mysql_fetch_array($res_pa);
							
							?>
								<div class="project-post-lft-col">
									<span class="number-txt"><?php echo $row_pa[0]; ?></span>
									<span class="only-txt"><?php echo $lang[286]; ?></span>
								</div>
							<?php
							$sql_lt="select count(*) from project,bid,user where bd_prj_id=prj_id and prj_usr_id=usr_id and bd_usr_id='".$_SESSION['uid']."' and bd_status=1 and ( prj_status='running' or prj_status='complete')";
							$res_lt=mysql_query($sql_lt);
							$num_lt=mysql_num_rows($res_lt);
							$row_lt=mysql_fetch_array($res_lt);
							
							?>
								<div class="project-post-rgt-col">
									<span class="number-txt"><?php if($num_lt>0){ echo $row_lt[0]; } else { ?>0<?php } ?></span>
									<span class="only-txt"><?php echo $lang[287]; ?></span>
								</div>
							</div>
						</td>
						<td>
							<h6 class="q-start-header-txt"><?php echo $lang[288]; ?></h6>
							<div class="clearfix">
							<?php
							$sql_wrp="select sum(bd_amount),count(*) from project,bid,user where bd_prj_id=prj_id and prj_usr_id=usr_id and bd_usr_id='".$_SESSION['uid']."' and now()<prj_expiry and bd_status=1 and prj_status='running'";
						$res_wrp=mysql_query($sql_wrp);
						$row_wrp=mysql_fetch_array($res_wrp);
							?>
								<div class="q-start-header-txt" align="center">
									<span class="number-txt_1" style="width:360px;"><?php echo getCurrencySymbol(); ?>&nbsp;<?php if($row_wrp[0]>0){ echo number_format($row_wrp[0],2); } else { echo "0.00"; } ?></span>
									<span class="only-txt_1" style="width:360px;"><?php echo $row_wrp[1]; ?><?php echo $lang[718]; ?></span>
								</div>
								<!--<div class="work-prog-rgt_col">
									<span class="number-txt_1">$3235.00</span>
									<span class="only-txt_1">55 outstanding projects</span>
								</div>-->
							</div>
						</td>
						<td>
						<?php
						$sql_cr="select count(*),sum(rr_completionrate) from review_rating where rr_to_usr='".$_SESSION['uid']."' and rr_prj_id not in(select prj_id from project where prj_usr_id='".$_SESSION['uid']."')";
						$res_cr=mysql_query($sql_cr);
						$row_cr=mysql_fetch_array($res_cr);
						?>
							<h6 class="q-start-header-txt"><?php echo $lang[292]; ?></h6>
							<h3 class="q-start-body-txt"><?php if($row_cr[0]==0){ echo "0"; } else { echo ($row_cr[1]/$row_cr[0])*100; } ?>%</h3>
							<!--<h7 class="q-start-header-txt"><strong>Lifetime</strong></h7>-->
							
						</td>	
						</tr>
						</tbody>
				</table>
				
				
				
			</div>
	</div>
	
    <div class="panel panel-primary">
		<div class="panel-heading">
			<?php echo $lang[293]; ?>
		</div>
		<div class="panel-body">
    
			<div class="table-responsive">
				<table class="table table-bordered table-striped table-hover" style="text-align:center">
				<thead >
					<tr>
						<th style="text-align:center"><?php echo $lang[294]; ?></th>
						<th style="text-align:center"><?php echo getCurrencySymbol(); ?>&nbsp;<?php echo getCurrencyCode(); ?></th>
					</tr>
				</thead>
				<tbody>
				<tr>
					<td><?php echo $lang[295]; ?></td>
					<td><?php echo $row_bl->usr_balance; ?></td>
				</tr>
				<tr>
					<td><?php echo $lang[296]; ?></td>
					<td>
					<?php
						$sql_escr="select sum(es_amount) from escrow where es_to_id=".$_SESSION['uid']." and es_status=1";
						$res_escr=mysql_query($sql_escr);
						$row_escr=mysql_fetch_array($res_escr);
						echo number_format($row_escr[0],2); /*ESCROW Receivable*/
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $lang[297]; ?></td>
					<td>
					<?php
						$sql_escr2="select sum(es_amount) from escrow where es_from_id=".$_SESSION['uid']." and es_status=1";
						$res_escr2=mysql_query($sql_escr2);
						$row_escr2=mysql_fetch_array($res_escr2);
						echo number_format($row_escr2[0],2);/*ESCROW Payable*/
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $lang[298]; ?></td>
					<td>
					<?php
						$sql_er="select sum(bd_amount) from bid where bd_usr_id=".$_SESSION['uid']." and bd_status=1";
						$res_er=mysql_query($sql_er);
						$row_er=mysql_fetch_array($res_er);
						echo number_format($row_er[0],2);/*Project Earnings*/
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $lang[299]; ?></td>
					<td>
					<?php
						$sql_pp="select sum(bd_amount) from bid where bd_status=1 and bd_prj_id in(select prj_id from project where prj_usr_id='".$_SESSION['uid']."' and  (prj_status='running' or prj_status='complete'))";
						$res_pp=mysql_query($sql_pp);
						$row_pp=mysql_fetch_array($res_pp);
						echo number_format($row_pp[0],2);/*Project Payments*/
					?>
					</td>
				</tr>
				<tr>
					<td><?php echo $lang[300]; ?></td>
					<td>
					<?php
						$sql_cst="select sum(tr_amount) from transaction where tr_from_id=".$_SESSION['uid']." and tr_status=1 and tr_type in('promotion','bid promotion','upgrade membership','freelancer fee','employer fee')";
						$res_cst=mysql_query($sql_cst);
						$row_cst=mysql_fetch_array($res_cst);
						echo number_format($row_cst[0],2);/*Other Cost*/
					?>
					</td>
				</tr>
				</tbody>
				</table>
			</div>
    
		</div>
    </div>
</div>
    
    
    
    
            
            
            
