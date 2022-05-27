<?php
ob_start();
session_start();
include "common.php";

$keyword=$_GET['keyword'];

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
	/*function fetchRecord(){
		return mysql_fetch_object($this->listview());
	}*/
	function numpage($rowPage){
		 return floor($this->totalrecord()/$rowPage);
	}
}

$p=new Pagination;
$page=$p->setpage();

$al=new listCat;

$al->limit=$p->setlimit(20);


$al->setsql("select * from project where (prj_name LIKE '%$keyword%' or prj_details LIKE '%$keyword%' or prj_id LIKE '%$keyword%') and prj_status='open'");

$totalitems=$al->totalrecord();
$limit=$al->limit;
$al->start=$p->setstart($page,$limit,$totalitems);
$adjacents=1;
$targetpage = "search-jobs.php";

$pagestring ="?sk=".$sk_id."&limit=".$limit."&page=";

$recObj=$al->listview();

$showitems=$al->start+1 ." - ";
if(($al->start+$limit)<$totalitems){
	$showitems.=$al->start+$limit;
}
else{
	$showitems.=$totalitems;
}
	$showitems.= $lang[759].$al->totalrecord().$lang[760];
	//echo $_SERVER['QUERY_STRING'];
?>

   	<?php include "includes/header.php"; ?>
<script language="javascript">

function show_desc(pid){
 $('#proj_desc'+pid).show();
 $('#main_tr'+pid).css( 'background-color' , '#edf9ff'  );

}
function hide_desc(pid){
 $('#proj_desc'+pid).hide();
 $('#main_tr'+pid).css( 'background-color' , ''  );
}
function validSearch()
{
	var keyword=document.getElementById('keyword');
	
	if(keyword.value=='' || keyword.value==null)
	{
		keyword.focus();
		return false;
	}
	else
	{
		return true;	
	}
}
</script>
	<div><h2 class="header-txt1-style align-center-txt"><?php echo $lang[567]; ?><?php echo $keyword; ?></h2></div>

<div class="row">
	<div class="col-xs-12">
    <form method="get" action="search-jobs.php" onSubmit="return validSearch();">
        
        <div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" ><?php echo $lang[276]; ?></label>
	            <div class="col-sm-8">
                 <input name="keyword" id="keyword" class="col-sm-8" type="text"/>
                 &nbsp;
                 <button type="submit" class="btn btn-sm btn-info"><i class="icon-search nav-search-icon"></i><?php echo $lang[278]; ?></button>
                 <p><span style="display: block; color: gray; font-size: 11px"><?php echo $lang[277]; ?></span></p>
           </div>
        </div>
        
        
        
   </form>
      </div>
</div>
                
   <div class="row">
	<div class="col-xs-12">
		<div class="table-responsive">
        <table width="100%" class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
                  <th width="24%" align="left"><?php echo $lang[18]; ?></th>
                  <th width="10%" align="left"><?php echo $lang[19]; ?></th>
                  <th width="8%" align="left"><?php echo $lang[20]; ?></th>
                  <th width="12%" align="left"><?php echo $lang[21]; ?> (<?php echo getCurrencyCode(); ?>)</th>
                  <th width="24%" align="left"><?php echo $lang[22]; ?></th>
                  <th width="12%" align="left"><?php echo $lang[23]; ?></th>
                  <th width="10%" align="left"><?php echo $lang[24]; ?></th>
            </tr>
        </thead>
        <tbody>

		 
<?php 
$j=1;
	   $count=mysql_num_rows($recObj);
	   if($count >0)
	   {
while($row=mysql_fetch_object($recObj)) {
	
	?>
<tr id="main_tr<?php echo $row->prj_id; ?>" onmouseover="show_desc(<?php echo $row->prj_id; ?>)" onmouseout="hide_desc(<?php echo $row->prj_id; ?>)" <?php if($j%2==0){?>class="even"<?php }else{ ?>class="odd"<?php } ?>>
	<td width="24%" align="left" valign="top" class="project-name">
        
	       		<?php
$promo_now="select * from project_promotion_option where ppo_prj_id=".$row->prj_id." and (ppo_pp_id=1 or ppo_pp_id=4)";
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
			<?php }} ?> 
<a class="c6" style="word-wrap: break-word;" href="project.php?p=<?php echo $row->prj_id; ?>"><?php echo $row->prj_name; ?></a>		</td>
<?php
$bid_now="select * from bid where bd_prj_id=".$row->prj_id;
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

?>
        <td width="10%" align="left" valign="top"><?php echo ucfirst($row->pb_type); ?></td>
        <td width="8%" align="left" valign="top"><?php echo $total_bid;?></td>
        <td width="12%" align="left" valign="top"><?php echo $ave_bid;?></td>
        <td width="24%" align="left" valign="top">
        <?php
			$sql_sk="select * from skills where sk_id in(select ps_sk_id from project_skill where ps_prj_id=".$row->prj_id.")";
			$res_sk=mysql_query($sql_sk);
			$c=0;
			while($row_sk=mysql_fetch_object($res_sk)){		?>
            <?php if($c>0){ ?>,&nbsp;<?php } ?>
		        <a class="hiddenlink" href="category.php?sk=<?php echo $row_sk->sk_id; ?>"><?php echo $row_sk->sk_name; ?></a>
		<?php	$c++;	}	?>

        </td>
        <td width="12%" align="left" valign="top"><?php echo date("M d,Y",strtotime($row->prj_updated_date)); ?></td>
        <td width="10%" align="left" valign="top">
		<?php 
		$d=dateDifference(date("Y-m-d"),$row->prj_expiry);
		if($d>=0){	echo dateDifference(date("Y-m-d"),$row->prj_expiry)." ".$lang[168];	}else{	echo $lang[169];	}
		?>        
        </td>
</tr>

	 <tr class="hover description" style="display:none;" id="proj_desc<?php echo $row->prj_id; ?>" onmouseover="show_desc(<?php echo $row->prj_id; ?>)" onmouseout="hide_desc(<?php echo $row->prj_id; ?>)">
<td colspan="7" style="word-wrap:break-word;" class="ns_project-details ns_border-top ns_align-l ns_pad-none-top" width="100%">
<?php echo substr($row->prj_details, 0, 100); ?>
</td></tr>
<?php $j++; }
	   }
else
       {
	?>
		<tr><td colspan="7>"<div class="admin-dtls" style="text-align:center; color:red; border-bottom:1px solid #ccc; padding-bottom:5px; font-weight:bold; font-size:14px;"><?php echo $lang[279]; ?></div></td></tr>
	<?php } ?>  

</tbody>
</table>
		 <table width="100%">
         <tr>
		<td  valign="top" ><?php echo $showitems; ?></td>
	  </tr>
        <tr>
	<td align="right" valign="top">
          <div class="top-pagination-col">
              <?php echo $p->getPaginationString($page, $totalitems, $limit, $adjacents, $targetpage, $pagestring); ?>
            </div>
      </td>
	  </tr>
  </table>

		</div>
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