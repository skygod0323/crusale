<?php
ob_start();
session_start();
include "common.php";

unset($_SESSION['last_page']);

class listCat{
	/*var $start="";
	var $limit="";*/
	var $sqlList="";
	var $start="";
	var $limit="";
	
	function setsql($sql){
		$this->sqlList=$sql;
	}
	function totalrecord(){
		return mysql_num_rows(mysql_query($this->sqlList));
	}
	function listview(){
		$sql=$this->sqlList." limit ".$this->start.",".$this->limit;
		$res=mysql_query($sql);
		return $res;
	}
	function numpage($rowPage){
		 return floor($this->totalrecord()/$rowPage);
	}
}

$p=new Pagination;
$page=$p->setpage();

$al=new listCat;

$al->limit=$p->setlimit(10);

if(!isset($_SESSION['uid']) && $_SESSION['uid']==''){
$al->setsql("select * from project, project_budget,user where prj_id=pb_prj_id and prj_usr_id=usr_id and prj_status = 'open' and prj_expiry>'".date("Y-m-d H:i:s")."' and prj_id not in(select ppo_prj_id from project_promotion_option where ppo_status='1' and ppo_pp_id=(select pp_id from project_promotion where pp_name='private' and pp_status='1')) order by prj_updated_date desc");

}
else
{
$al->setsql("select * from project, project_budget,user where prj_id=pb_prj_id and prj_usr_id=usr_id and prj_status = 'open' and prj_expiry>'".date("Y-m-d H:i:s")."' order by prj_updated_date desc");	
}

$totalitems=$al->totalrecord();
$limit=$al->limit;
$al->start=$p->setstart($page,$limit,$totalitems);
$adjacents=1;
$targetpage = "index.php";
$pagestring ="?limit=".$limit."&page=";

$recObj=$al->listview();

$showitems=$al->start+1 ." - ";
if(($al->start+$limit)<$totalitems){
	$showitems.=$al->start+$limit;
}
else{
	$showitems.=$totalitems;
}
	$showitems.= $lang[759].$al->totalrecord().$lang[760];
	
?>
<?php include "includes/header.php"; ?>

<div class="top-banner-str">
	<div id="wrapper-container">
		<div class="top-banner">
			<div class="top-heart"></div>
			<script type="text/javascript">
			function home_text()
			{
				$('#1').toggle();
				$('#2').toggle();
				setTimeout("home_text()",4000);
			}
			home_text();
			</script>

			<div class="" style=" float:right; width:50%; padding-top:50px">
				<span id="1"><h1><?php echo $lang[632]; ?></h1></span>
				<span id="2" style="display:none;"><h1><?php echo $lang[633]; ?></h1></span>
				<h6><?php echo $lang[2]; ?></h6>
				<div><a class="btn btn-warning btn-lg" style="cursor:pointer" onClick="firstProj()"><?php echo $lang[3]; ?></a></div>
			</div>
		</div>
	</div>
</div>
<div class="row">
        <div class="project-steps span12">
            <h3><?php echo $lang[634];?></h3>
            <ul>
                <li>
                    <div class="step step-one">
                        <div class="icon-post-project"></div>
                    </div>
                    <div class="icon-chevron-right"></div>
                    <p><?php echo $lang[635];?></p>
                </li>
                <li>
                    <div class="step step-two">
                        <div class="icon-bidders"></div>
                    </div>
                    <div class="icon-chevron-right"></div>
                    <p><?php echo $lang[636];?></p>
                </li>
                <li>
                    <div class="step step-three">
                        <div class="icon-create-payment"></div>
                    </div>
                    <div class="icon-chevron-right"></div>
                    <p><?php echo $lang[637];?></p>
                </li>
                <li>
                    <div class="step step-four">
                        <div class="icon-approve-project"></div>
                    </div>
                    <div class="icon-chevron-right"></div>
                    <p><?php echo $lang[638];?></p>
                </li>
                <li>
                    <div class="step step-five">
                        <div class="icon-release-payment"></div>
                    </div>
                    <div class="icon-chevron-right"></div>
                    <p><?php echo $lang[639];?></p>
                </li>
            </ul>
        </div>
    </div>
	<div>
		<div id="page-container">
        <script type="text/javascript">
function firstProj()
{
	window.location.href = "post-project.php";
}
function show_desc(pid){
	$('#proj_desc'+pid).show();
	$('#main_tr'+pid).css( 'background-color' , '#edf9ff'  );
}
function hide_desc(pid)
{
	$('#proj_desc'+pid).hide();
	$('#main_tr'+pid).css( 'background-color' , ''  );
}
</script>

<?php if(!isset($_SESSION['uid'])){ ?>	
<div class="clearfix"><div><a href="login.php" class="btn btn-warning btn-lg"><?php echo $lang[9]; ?></a></div></div>
<?php } ?>
					
	<div class="row" style="margin-top:25px;">
		<div class="col-xs-12">
			<div class="table-header"><?php echo $lang[17]; ?></div>
			<div class="table-responsive">
				<table id="sample-table-2" class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th><?php echo $lang[18]; ?></th>
							<th><?php echo $lang[19]; ?></th>
							<th style="text-align:center"><?php echo $lang[20]; ?></th>
							<th><?php echo $lang[21]; ?> (<?php echo getCurrencyCode(); ?>)</th>
							<th><?php echo $lang[22]; ?></th>
							<th><?php echo $lang[23]; ?></th>
							<th><?php echo $lang[24]; ?></th>
						</tr>
					</thead>
					<tbody>
													
<?php 
	$i=0;
	while($row=mysql_fetch_object($recObj)) { 
	$i++;
	?>													
		<tr id="main_tr<?php echo $row->prj_id; ?>" onMouseOver="show_desc(<?php echo $row->prj_id; ?>)" onMouseOut="hide_desc(<?php echo $row->prj_id; ?>)">
			<td class="center">
			<?php
                $promo_now="select * from project_promotion_option where ppo_prj_id=".$row->prj_id;
				$promo_now2=mysql_query($promo_now);
				$total_promo=mysql_num_rows($promo_now2);
				if($total_promo>0){
                
                	while($promo_row=mysql_fetch_object($promo_now2)) { 
                    	$promo_name="select pp_name from project_promotion where pp_id=".$promo_row->ppo_pp_id;
	                    $promo_name2=mysql_query($promo_name);
    	                $promo_name_row=mysql_fetch_object($promo_name2);
        	            $pp_name=$promo_name_row->pp_name;
            ?>
                 <div class="ns_<?php echo $pp_name;?>-icon"></div>
      <?php  }} ?>
                <a href="project.php?p=<?php echo $row->prj_id; ?>"><?php echo $row->prj_name; ?></a>
			</td>
			<td><?php echo ucfirst($row->pb_type); ?></td>
			<td style="text-align:center">
            <?php
				/*$bid_now="select * from bid where bd_prj_id=".$row->prj_id;
				$bid_now2=mysql_query($bid_now);
				$total_bid=mysql_num_rows($bid_now2);
				if($total_bid==0){
					$total_bid=$lang[659];
				}

				$ave_now="select AVG(bd_amount) from bid where bd_prj_id=".$row->prj_id;
				$ave_now2=mysql_query($ave_now);
				$ave_bid_row=mysql_fetch_array($ave_now2);
				$ave_bid=round($ave_bid_row['AVG(bd_amount)'], 2);
				if($total_bid==0){
					$ave_bid="-";
				}
				echo $total_bid;*/
				
			$expDate = strtotime($row->prj_expiry);
			$curDate = strtotime(date("Y-m-d H:i:s"));
			$second=$expDate - $curDate;
			
			$tot_bid=mysql_fetch_array(mysql_query("select count(*) from bid where bd_prj_id='".$row->prj_id."'"));
			
	if(isset($_SESSION['uid']) && $_SESSION['uid']!=''){
		
		$sql_mem="select * from membership_plan,user where usr_mp_id=mp_id and usr_id='".$_SESSION['uid']."'";
		$res_mem=mysql_query($sql_mem);
		$row_mem=mysql_fetch_object($res_mem);

		$remaining_bid=$row_mem->usr_left_bid;

		$today = date("Y-m-d", strtotime("now"));
		$expiry = date("Y-m-d", strtotime($row->prj_expiry));
		
		
		$chk_bid_sql="select * from bid where bd_usr_id='".$_SESSION['uid']."' and bd_prj_id='".$row->prj_id."'";
		$chk_bid_res=mysql_query($chk_bid_sql);
			
		$chk_bid_sql2="select * from temp_proj_award,bid where tpa_bd_id=bd_id and bd_prj_id='".$row->prj_id."'";
		$chk_bid_res2=mysql_query($chk_bid_sql2);

		if(mysql_num_rows($chk_bid_res)==0 && mysql_num_rows($chk_bid_res2)==0)
		{
			
			if($row->prj_usr_id != $_SESSION['uid'] && ($row->prj_status=="open" && $expDate>$curDate)){
				if($remaining_bid>0 && $today<=$expiry){
					if($second>0) { ?>
                    <?php	if(profileCompleteness($_SESSION['uid'])>=40){	?>
                    	<a href="placebid.php?p=<?php echo $row->prj_id; ?>" class="btn btn-success btn-minier"><?php echo $lang[659]; ?></a>
                   <?php	}else{	?>
                            <a href="profile.php" class="btn btn-success btn-minier"><?php echo $lang[724]; ?></a>
                   <?php	}	?>
                    
                    <?php } ?>
                    
				<?php } else { ?>
    	            <a href="membership.php" class="btn btn-success btn-minier"><?php echo $lang[487]; ?></a>
                <?php 	} 
				}
				else
				{
					echo $tot_bid[0];
				}
			}
			else
			{
				echo $tot_bid[0];
			}
		}
		else
		{
			echo $tot_bid[0];
		}
		
		?>
			
            </td>
			<td class="hidden-480"><?php echo $ave_bid; ?></td>
			<td>
            <?php
				$sql_sk="select * from skills where sk_id in(select ps_sk_id from project_skill where ps_prj_id=".$row->prj_id.")";
				$res_sk=mysql_query($sql_sk);
				$c=0;
				while($row_sk=mysql_fetch_object($res_sk)){	?>
		    <?php if($c>0){ ?>,&nbsp;<?php } ?>
				<a class="hiddenlink" href="category.php?sk=<?php echo $row_sk->sk_id; ?>"><?php echo $row_sk->sk_name; ?></a>
			<?php	$c++;	}	?>
            </td>
			<td class="hidden-480"><?php echo date("M d,Y",strtotime($row->prj_updated_date)); ?></td>
			<td>
				<?php if(dateDifference(date("Y-m-d"),$row->prj_expiry)>=0){	echo dateDifference(date("Y-m-d"),$row->prj_expiry).$lang[715]; }else{ echo $lang[169];	}	?>
            </td>
		</tr>
        <tr style="display:none;" id="proj_desc<?php echo $row->prj_id; ?>" onMouseOver="show_desc(<?php echo $row->prj_id; ?>)" onMouseOut="hide_desc(<?php echo $row->prj_id; ?>)">
    <td colspan="7" align="left"><?php echo substr($row->prj_details, 0, 100); ?></td>
    </tr>
                                                    
      <?php } ?>
		</tbody>
	</table>
	</div>
	</div>
</div>
<script type="text/javascript">
			jQuery(function($) {
				var oTable1 = $('#sample-table-2').dataTable( {
				"aoColumns": [
			      { "bSortable": false },
			      null, null,null, null, null,
				  { "bSortable": false }
				] } );
				
				
				$('table th input:checkbox').on('click' , function(){
					var that = this;
					$(this).closest('table').find('tr > td:first-child input:checkbox')
					.each(function(){
						this.checked = that.checked;
						$(this).closest('tr').toggleClass('selected');
					});
						
				});
			
			
				$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('table')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
			})
		</script>
                                <!-- new table design ends -->
                                
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
            <div class="clearfix" style="margin-top:30px;">
				<div class="recent-project-btn-lft"><a href="post-project.php" class="btn btn-purple btn-lg"><?php echo $lang[25]; ?></a></div>
			
<?php if(!isset($_SESSION['uid'])){ ?>	
<div class="recent-project-btn-rgt"><a href="login.php" class="btn btn-purple btn-lg"><?php echo $lang[26]; ?></a></div>
<?php } ?>
				</div>
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
    <!-- <script src="new_design/js/jquery.dataTables.min.js"></script>-->
	<!--<script src="new_design/js/jquery.dataTables.bootstrap.js"></script>-->
	<?php include "includes/footer.php"; ?>
