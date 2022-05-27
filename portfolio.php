<?php
ob_start();
session_start();
include "common.php";


$usr_id=$_GET['uid'];
$sql_pf="select * from user where md5(usr_id)='".$usr_id."' or usr_id='".$usr_id."'";
$res_pf=mysql_query($sql_pf);
$row=mysql_fetch_object($res_pf);

?>
<script language="javascript">
function show_add_portfolio()
{
	//$.noConflict();
	$('#add_portfolio').css({"display":"block"});	
	$('#portfolio_overview').css({"display":"none"});	
}
function hide_add_portfolio()
{
	//$.noConflict();
	$('#add_portfolio').css({"display":"none"});	
	$('#portfolio_overview').css({"display":"block"});	
}

$(document).ready(
	function(){		
		$('#savePortfolio').click(function(){	
			$('#addNew_portfolio').submit();		
		});        
	});

function showPrFlDetail(up_id)
{
	//$.noConflict();
	$('#portfolio_details_'+up_id).css({"display":"block"});	
	$('#portfolio_overview').css({"display":"none"});	
	
}
function hidePrFlDetail(up_id)
{
	//$.noConflict();
	$('#portfolio_details_'+up_id).css({"display":"none"});	
	$('#portfolio_overview').css({"display":"block"});		
}
function editPortfolio(up_id)
{
	//$.noConflict();
	$('#edit_portfolio_'+up_id).css({"display":"block"});
	$('#portfolio_details_'+up_id).css({"display":"none"});
}
function hideeditPortfolio(up_id)
{
	//$.noConflict();
	$('#edit_portfolio_'+up_id).css({"display":"none"});
	$('#portfolio_details_'+up_id).css({"display":"block"});
}
function updatePortfolioSubmit(up_id)
{
	//$.noConflict();
	$('#update_portfolio_'+up_id).submit();
	$('#edit_portfolio_'+up_id).css({"display":"none"});
	$('#portfolio_details_'+up_id).css({"display":"block"});
}
function validPortfolio()
{
	var up_title= document.getElementById('up_title');
	var up_description=document.getElementById('up_description');
	var up_file=document.getElementById('up_file');
	
	var fileName = up_file.value;
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
	
	var msg="";
    var valid=true;
	alert(up_title.value);
	if(up_title.value=='')
	{
		alert('<?php echo $lang[730]; ?>');
        up_title.value="";
        up_title.focus();
        valid = false;
	}
	else if(up_description.value=='')
	{
		alert('<?php echo $lang[731]; ?>');
        up_description.value="";
        up_description.focus();
        valid = false;
	}
	else if(fileName != '' && (ext != "gif" && ext != "GIF" && ext != "JPEG" && ext != "jpeg" && ext != "jpg" && ext != "JPG" && ext != "png" && ext != "PNG"))
	{
		alert('<?php echo $lang[385]; ?>');
        up_file.value='';
        up_file.focus();
        valid = false;
	}
	else
    {		
        valid=true;
    }	

    return valid;
}
function validUpdatePortfolio()
{
	var up_title= document.getElementById('up_title_upd');
	var up_description=document.getElementById('up_description_upd');
	var up_file=document.getElementById('up_file_upd');
	
	var fileName = up_file.value;
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
	
	var msg="";
    var valid=true;
	if(up_title.value=='')
	{
		alert('<?php echo $lang[730]; ?>');
        up_title.value="";
        up_title.focus();
        valid = false;
	}
	else if(up_description.value=='')
	{
		alert('<?php echo $lang[731]; ?>');
        up_description.value="";
        up_description.focus();
        valid = false;
	}
	else if(fileName != '' && (ext != "gif" && ext != "GIF" && ext != "JPEG" && ext != "jpeg" && ext != "jpg" && ext != "JPG" && ext != "png" && ext != "PNG"))
	{
		alert('<?php echo $lang[385]; ?>');
        up_file.value='';
        up_file.focus();
        valid = false;
	}
	else
    {		
        valid=true;
    }	

    return valid;
}
//function upd()
//{
//document.getElementById("update_portfolio").submit();
//}
</script>

<?php
	$sql_tot_pfolio="select count(*) from user_portfolio where up_usr_id='".$row->usr_id."'";
	$res_tot_pfolio=mysql_query($sql_tot_pfolio);
	$row_tot_pfolio=mysql_fetch_array($res_tot_pfolio);
			
	$sql_avl_pfolio="select * from membership_plan where mp_id=(select usr_mp_id from user where usr_id='".$row->usr_id."')";
	$res_avl_pfolio=mysql_query($sql_avl_pfolio);
	$row_avl_pfolio=mysql_fetch_object($res_avl_pfolio);
?>
<hr class="invis">
<h4><?php echo $row->usr_name; ?>&nbsp;<?php echo $lang[387]; ?>
	<?php			
		if($row_avl_pfolio->mp_portfoliosize > $row_tot_pfolio[0] && ($_SESSION['uid']==$row->usr_id)){
	?>
   		<a href="javascript:show_add_portfolio()" style="cursor:pointer;text-decoration:none;">
           	<i class="fa fa-pencil" aria-hidden="true" ></i>
			<?php /*echo $lang[403];*/ ?>
        </a>
    <?php } ?></h4>

<hr class="invis">

<div class="grid_8 profile_content" id="add_portfolio" style="display:none">

<!--<link href="css/jquery-ui-1_002.css" rel="stylesheet" type="text/css">
<link href="css/jquery.css" rel="stylesheet" type="text/css">-->
		  
<form class="ns_form form-horizontal" id="addNew_portfolio" method="post" action="" enctype="multipart/form-data" onsubmit="return validPortfolio();">
<!--<h4><?php echo $lang[387]; ?></h4>-->
    
    
    
    
<!--<div class="ns_right ns_align-r">
		<div class="ns_bold">Added:</div>
		<div class="ns_largest"><span id="addedItemCount"></span>
					 /5</div>
			</div>-->
			<hr>
     		<div class="ns_form ns_box">
				
     			<h4 id="editTitle"  isfeature="N"><?php echo $lang[388]; ?></h4>
     			<div class="ns_clear"></div>
     			<!--<div class="ns_field ns_pad-none ns_margin-20 non-feature">
     				<label class="ns_pad-5">Content Type:</label>
     				<ul class="ns_field ns_inline">
     					<li><input name="content_type" id="content_new_pic" value="new_pic" checked="checked" type="radio"> Image</li>
     					<li><input name="content_type" id="content_new_article" value="new_article" type="radio"> Article</li>
     					<li><input name="content_type" id="content_new_code" value="new_code" type="radio"> Code</li>
     					<li><input name="content_type" id="content_new_vid" value="new_vid" type="radio"> Video</li>
						<li><input name="content_type" id="content_new_aud" value="new_aud" type="radio"> Audio</li>
						<li><input name="content_type" id="content_new_other" value="new_other" type="radio"> Others</li>
     				</ul>
     			</div>-->
     			<input type="hidden" name="up_usr_id" value="<?php echo $_SESSION['uid']; ?>"/>
				<label class=" control-label no-padding-right"><?php echo $lang[389]; ?></label>
     			<div class="ns_field  non-feature">
					
     				
					<input class="ns_full inline-error form-control" id="up_title" maxlength="60" type="text" name="up_title">
					<!--<div class="ns_note-right"><span id="title_count">60</span> <?php /*echo $lang[390];*/ ?></div>-->
     			</div>
     			<label id="descr_head"><?php echo $lang[391]; ?></label>
     			<div class="ns_field">
     				
					<textarea class="ns_full inline-error form-control" name="up_description" id="up_description" rows="10" maxlength="1000"></textarea>
					<!--<div class="ns_note-right"><span id="descr_count">1000</span> <?php /*echo $lang[390];*/ ?></div>-->
     			</div>
                
                <!--<div class="ace-file-input">
                	<input id="id-input-file-2" type="file">
                    <label class="file-label" data-title="Choose">
                    	<span class="file-name" data-title="No File ..."><i class="icon-upload-alt"></i></span>
                    </label>
                    <a class="remove" href="#"><i class="icon-remove"></i></a>
				</div>-->
     			<label id="uploadItemLable" class="ns_left"><?php echo $lang[392]; ?> <span id="uploadExtTxt"></span></label>
				<div class="ns_field ns_upload ns_margin-30">

     				
						<div class="ns_field ns_left " style="width:521px; margin-top:10px">
                            <div id="uploadContainer" class="">
                                <input id="up_file" name="up_file" type="file">
                                
                            </div>
                        </div>

     			</div>
     			<label class="ns_margin-10"><?php echo $lang[395]; ?></label>
				<div class="ns_field ns_upload ns_margin-30">
					
					<div>
		        		<!--<input class="input-skill ns_half ns_clear ns_border-bottom ns_round-none" name="skill" value="Enter a skill ..." type="text">-->
                        <?php
					$sql_skp="select * from skills where sk_id in(select usk_sk_id from user_skills where usk_usr_id='".$_SESSION['uid']."')";
					$res_skp=mysql_query($sql_skp);
				?>
                
					<select class="form-control" id="up_skills" name="up_skills[]" data-placeholder="<?php echo $lang[703]; ?>"  class="ns_half ns_clear ns_round-none" multiple="multiple">
                        <?php while($row_skp=mysql_fetch_object($res_skp)) { ?>
                        <option value="<?php echo $row_skp->sk_id; ?>"><?php echo $row_skp->sk_name; ?></option>
                        <?php } ?>
                        </select>
					</div>
					<div class="ns_col ns_last ns_half">
						<label class="ns_margin-10 inline-error" id="selectSkillsLabel"><?php /*echo $lang[396];*/ ?> <!--<span>(<?php /*echo $lang[397];*/ ?> <span id="jobsLeft" class="ns_color-red">5</span>)</span>--></label>
						<ul id="skills_selected" class="ns_skills-bubble">
						</ul>
					</div>
				</div>
				
<!--				<a id="saveBtn" href="../fake.php" class="ns_btn ns_blue ns_left">Save</a> <a href="#" class="ns_btn">Cancel</a>-->
				<!--<input type="submit" class="ns_btn ns_blue ns_left" value="Save" />-->
				<a id="savePortfolio" class="btn btn-info btn-sm"><i class="icon-ok"></i><?php echo $lang[106]; ?></a> 
				<a id="cancelBtn" href="javascript:hide_add_portfolio()" class="btn btn-white"><?php echo $lang[398]; ?></a>
				<img id="portfolioSaveLoading" style="display: none; padding-left: 75px;" src="images/ajax-loader_002.gif">
     			
	    	</div>
            <input type="hidden" name="addPortfolio" value="1" >
			</form>
			
	</div>
    
    <div class="row">
    <?php
		$sql_pdet="select * from user_portfolio where up_usr_id='".$row->usr_id."'";
		$res_pdet=mysql_query($sql_pdet);
		while($row_pdet=mysql_fetch_object($res_pdet)) {
	?>
    <div class="col-xs-12 col-sm-6 widget-container-span ui-sortable">
		<div class="widget-box">
			<div class="widget-header widget-header-small header-color-orange">
			<h6><?php echo $row_pdet->up_title; ?></h6>
            <?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row->usr_id)){ ?>
				<div class="widget-toolbar">
              		<!--<a href="#" data-action="collapse">
						<i class="icon-chevron-up"></i>
					</a>-->
					<a href="javascript:editPortfolio(<?php echo $row_pdet->up_id; ?>);">
						<i class="icon-edit green bigger-120" style="vertical-align:middle;"></i>
					</a>
					<a href="javascript:delPortfolio(<?php echo $row_pdet->up_id; ?>)" >
						<i class="icon-remove"></i>
					</a>
				</div>
             <?php	}	?>
			</div>
			<div class="widget-body">
        	    <div class="widget-toolbox">
            	<?php	if($row_pdet->up_skills!='' && $row_pdet->up_skills!=','){	?>
					<div class="btn-toolbar" style="padding-left:10px;">
					<?php
						$cc=0;
						$sk_arr=explode(",",$row_pdet->up_skills);
						foreach($sk_arr as $sk_id)
    					{
							if($sk_id != '')
							{
								if($cc>0){	echo ", ";	}
								$sql_sk="select * from skills where sk_id='".$sk_id."'";
								$res_sk=mysql_query($sql_sk);
								$row_sk=mysql_fetch_object($res_sk);
								echo $row_sk->sk_name;
								$cc++;
							}
	    				}
					?>
					</div>
    			<?php	}	?>
				</div>
    	        <div style="display: block;" class="widget-body-inner">
					<div class="widget-main">
						<p class="alert alert-info">
                	        <?php if($row_pdet->up_file != ''){ ?>
							<img src="images/users/portfolio/<?php echo $row_pdet->up_file; ?>" width="80" height="79" />
							<?php } ?>
							<?php echo $row_pdet->up_description; ?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
    
    
    
    <div class="grid_8 profile_content" id="edit_portfolio_<?php echo $row_pdet->up_id; ?>" style="display:none">

		<link href="css/jquery-ui-1_002.css" rel="stylesheet" type="text/css">
		<link href="css/jquery.css" rel="stylesheet" type="text/css">
	
		  
	<form class="ns_form" id="update_portfolio_<?php echo $row_pdet->up_id; ?>" method="post" action="" enctype="multipart/form-data" onsubmit="return validUpdatePortfolio()">
     		<h1><?php echo $lang[387]; ?></h1>
<!--     		<div class="ns_right ns_align-r">
				<div class="ns_bold">Added:</div>
				<div class="ns_largest"><span id="addedItemCount"></span>
					 /5</div>
			</div>-->
     		<div class="ns_form ns_box">
     			<h2 id="editTitle" isfeature="N"><?php echo $lang[658]; ?></h2>
     			<div class="ns_clear"></div>
     			
     			<input type="hidden" id="up_id" name="up_id" value="<?php echo $row_pdet->up_id; ?>"/>
     			<div class="ns_field  non-feature">
     				<label><?php echo $lang[389]; ?></label>
					<input class="ns_full inline-error" id="up_title_upd" maxlength="60" type="text" name="up_title_upd" value="<?php echo $row_pdet->up_title; ?>"/>
					<!--<div class="ns_note-right"><span id="title_count">60</span> <?php /*echo $lang[390];*/ ?></div>-->
     			</div>
     			
     			<div class="ns_field">
     				<label id="descr_head"><?php echo $lang[391]; ?></label>
					<textarea class="ns_full inline-error" name="up_description_upd" id="up_description_upd" rows="10" maxlength="1000"><?php echo $row_pdet->up_description; ?></textarea>
					<!--<div class="ns_note-right"><span id="descr_count">1000</span> <?php /*echo $lang[390];*/ ?></div>-->
     			</div>
     			
                <?php if($row_pdet->up_file!=''){	?>
				<div class="ns_field ns_upload ns_dotted-bottom ns_margin-30">
                <label id="uploadItemLable" class="ns_left"><?php echo $lang[825]; ?> <span id="uploadExtTxt"></span></label>
					<div class="ns_field ns_left " style="width:521px; margin-top:10px">
                		<img src="images/users/portfolio/<?php echo $row_pdet->up_file; ?>" style="max-width:250px;"/>
                    </div>
                </div>
                <?php } ?>
				<div class="ns_field ns_upload ns_dotted-bottom ns_margin-30">
     				<label id="uploadItemLable" class="ns_left"><?php echo $lang[826]; ?> <span id="uploadExtTxt"></span></label>
						<div class="ns_field ns_left " style="width:521px; margin-top:10px">
                            <div id="uploadContainer" class="inline-error dropzone dropzone-ui" style="height:15px; width:103px">
                                <input id="up_file_upd" name="up_file_upd" type="file">
                                
                            </div>
                            <div id="files-bucket" class="files-bucket">

								<ul class="ns_added-items" id="added_items"></ul>
								
                            </div>
                        </div>
						

     				<div class="ns_clear"></div>
					

     			</div>
     			
				<div class="ns_field ns_margin-30  non-feature">
					<label class="ns_margin-10"><?php echo $lang[395]; ?></label>
                    <?php

					$skills=explode(",",substr($row_pdet->up_skills,0,strlen($row_pdet->up_skills)-1));
					
					?>
					<div class="ns_col">
                        <?php
						$sql_skp="select * from skills where sk_id in(select usk_sk_id from user_skills where usk_usr_id='".$_SESSION['uid']."')";
						$res_skp=mysql_query($sql_skp);
						?>
						<select id="up_skills_upd" name="up_skills_upd[]" size="10" class="ns_half ns_clear ns_round-none" multiple="multiple">
                        <?php while($row_skp=mysql_fetch_object($res_skp)) { 
                        $sel=0;
                        	foreach($skills as $val){
								if($row_skp->sk_id == $val){
									$sel=1;
								}
							}
							?>
                        <option value="<?php echo $row_skp->sk_id; ?>" <?php if($sel==1){ ?> selected="selected"<?php } ?>><?php echo $row_skp->sk_name; ?></option>
                        <?php } ?>
                        </select>
					</div>
					
					
				</div>
				<a id="saveeditPortfolio" class="btn btn-info btn-sm" href="javascript:updatePortfolioSubmit(<?php echo $row_pdet->up_id; ?>)"><i class="icon-ok"></i><?php echo $lang[106]; ?></a> 
				<a id="cancelBtn" href="javascript:hideeditPortfolio(<?php echo $row_pdet->up_id; ?>)"  class="btn btn-white"><?php echo $lang[398]; ?></a>
				<img id="portfolioSaveLoading" style="display: none; padding-left: 75px;" src="images/ajax-loader_002.gif">
     			
	    	</div>
            <input type="hidden" name="updatePortfolio" value="1" >
			</form>
			
	</div>
    <?php } ?>
    </div>
    
    <div class="grid_8 profile_content " id="portfolio_overview" style="display:block">
            
			<div class="ns_clear"></div>
		
			
		<div id="limitWarningDiv" class="ns_notify ns_warning ns_edit" <?php	if($row_avl_pfolio->mp_portfoliosize==$row_tot_pfolio[0] && ($_SESSION['uid']==$row->usr_id)){	?>style="display:block"<?php	}else{	?>style="display:none"<?php	}	?>>
<!--	           	<a href="#" class="ns_close">x</a>-->
	            <div class="ns_icon"></div>
	            <div class="ns_pad">
					<h3><?php echo $lang[404]; ?></h3>
					<p><?php echo $lang[405]; ?></p> 	
					<p class="ns_block ns_margin-tops"><a href="membership.php" class="ns_right ns_margin-r"><?php echo $lang[406]; ?></a></p>
				</div>
		</div>
		
		
       
<!--<div class="ns_pagination ns_right ns_margin-top"><span class="current prev">« Prev</span><span class="current">1</span><a>2</a><a>3</a><a class="next">Next »</a></div>-->
           	
	</div>
    <script src="new_design/js/ace-elements.min.js"></script>
		<script src="new_design/js/ace.min.js"></script>
<script type="text/javascript">
jQuery(function($) {
	$('#id-input-file-1 , #id-input-file-2').ace_file_input({
		no_file:'No File ...',
		btn_choose:'Choose',
		btn_change:'Change',
		droppable:true,
		onchange:null,
		thumbnail:false //| true | large
		//whitelist:'gif|png|jpg|jpeg'
		//blacklist:'exe|php'
		//onchange:''
		//
	});
});
</script>