<?php
ob_start();
session_start();
include "common.php";

$sql_catg="select * from category where cat_status=1 order by cat_id limit 1";
$res_catg=mysql_query($sql_catg);
$row_catg=mysql_fetch_object($res_catg);

if(isset($_GET['cat']))
{
	$cat_id=$_GET['cat'];
}
else
{
	$cat_id=$row_catg->cat_id;
}

if(isset($_GET['sk']))
{
	$sk_id=$_GET['sk'];
}
else
{
	$sk_id=0;
}
//$sk_id=$_GET['sk'];

class ProductList{
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

$al=new ProductList;
$al->limit=$p->setlimit(10);

if(isset($_GET['sk']))
{
	if($_GET['sk']=='0')
	{
		$al->setsql("select * from user where usr_status=1 and usr_emailVerified='1' and usr_type!='Employer' and usr_id in(select prj_usr_id from project where prj_scat_id in(select scat_id from subcategory where scat_cat_id=".$cat_id.")) order by usr_name");	
	}
	else
	{
		$sk_id=$_GET['sk'];
		$al->setsql("select * from user where usr_status=1 and usr_emailVerified='1' and usr_type!='Employer' and usr_id in(select distinct prj_usr_id from project where prj_id in(select distinct ps_prj_id from project_skill where ps_sk_id=".$sk_id.")) order by usr_name");
	}
}
else
{
	$al->setsql("select * from user where usr_status=1 and usr_emailVerified='1' and usr_type!='Employer' and usr_id in(select prj_usr_id from project where prj_scat_id in(select scat_id from subcategory where scat_cat_id=".$cat_id.")) order by usr_name");
}
$totalitems=$al->totalrecord();
$limit=$al->limit;
$al->start=$p->setstart($page,$limit,$totalitems);
$adjacents=1;
$targetpage = "find-freelancer.php";

$pagestring ="?cat=".$cat_id."&sk=".$sk_id."&limit=".$limit."&page=";

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

	<<div class="section db" style="background-image:url('upload/parallax_02.jpg');">
                <div class="container">
                    <div class="page-title text-center">
                        <div class="heading-holder">
                            <h1><?php echo $lang[129]; ?></h1>
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
									<li ><a href="employer-following.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[130]; ?></a></li>
                                    <li class="active"><a href="find-freelancer.php"><span class="glyphicon glyphicon-user"></span>  <?php echo $lang[131]; ?></a></li>
                                    </ul>
                            </div><!-- end widget -->
                        </div><!-- end col -->

                        <div class="content col-md-9">
                            <div class="post-padding">
                                <div class="job-title nocover hidden-sm hidden-xs"><h5><?php echo $lang[318]; ?></h5></div>
                                
                                    
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">   
                                            
                                            
											<div class="panel-group">
													
												<div class="col-md-12 col-sm-12">
													<div class="panel panel-primary">
														<div class="panel-heading">
															<?php echo $lang[319]; ?>
														</div>
														<div class="panel-body">
															<div class="col-md-12 col-sm-12">
																<form class="form-horizontal">
																<div class="col-md-8 col-sm-12">
																	<label class="control-label no-padding-right" for="cat_id"><?php echo $lang[320]; ?></label>
																	<div class="">
																	<?php
																		$sql_cat="select * from category where cat_status=1 order by cat_id";
																		$res_cat=mysql_query($sql_cat);
																	?>
																		<select id="cat_id" name="cat_id" onChange="show_skills(1)" class="form-control">
																			<?php	while($row_cat=mysql_fetch_object($res_cat)) {	?>
																			<option value="<?php echo $row_cat->cat_id; ?>"><?php echo ucfirst($row_cat->cat_name); ?></option>
																			<?php } ?>
																		</select>
																	</div>
																</div>		
																<div class="col-md-4 col-sm-12"  style="padding-left:10px;padding-right:10px;">
																	<label class="control-label" for="sk_id"><?php echo $lang[322]; ?></label>
																	<div class="">
																		<select name="sk_id" id="sk_id" onChange="show_result(1);" class="form-control">
																			<option value="0" selected="selected"><?php echo $lang[321]; ?></option>
																		</select>
																	</div>
																</div>
																<div class="col-md-6 col-sm-12" style="text-align:left;">
																	<label class="control-label no-padding-right" for=""><?php echo $lang[720]; ?></label>
																	<div class="">
																		<input type="text" id="freelancer_name" name="freelancer_name" class="form-control"/>
																	</div>
																</div>
																<div class="col-md-6 col-sm-12" style="text-align:left;">
																	<label class="control-label no-padding-right" for=""></label>
																	<div class="">
																		<input type="button" class="btn btn-info" value="<?php echo $lang[721]; ?>" onClick="show_result(1);"/>
																	</div>
																</div>
																<!--<div class="freelancer-filter-input-box-col_3"><div class="search-now-btn"><input type="submit" value="Search Now"></div></div>-->
																</form>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-12 col-sm-12" id="result">
													
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


<script language="javascript">
$(document).ready(function() {
fillSkill();
show_result(1);
});
/*function show_data(page)
{
	var cat = $('select#cat_id').val();
	$.get("show-freelancer.php", {page:page,cat:cat},	function(data){	$('#result').html(data);	});
	
	show_skills(cat);
}*/
function show_result(page)
{
	var cat = $('select#cat_id').val();
	var sk = $('select#sk_id').val();
	var u = $('#freelancer_name').val();
	$.get("show-freelancer.php", {page:page,cat:cat,sk:sk,u:u},	function(data){	$('#result').html(data);	 });
}

function show_skills(page)
{

//	$.get("show-freelancer.php", {cat:val},	function(data){	$('#result').html(data);	 });
	
//	$.get("showSkill.php", {cat:val},
//		function(data){
//		$('#sk_id').html(data);
//	 });
	fillSkill();
	show_result(page);
}
function fillSkill()
{
	var cat = $('select#cat_id').val();
	$.get("showSkill.php", {cat:cat},	function(data){	$('#sk_id').html(data);	 });
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