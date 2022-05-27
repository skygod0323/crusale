<?php



/*if(isset($_GET['usr_summary']))
{
	ob_start();
	session_start();
	include "common.php";
	
	$sql_sm="update user set usr_summary='".$_GET['usr_summary']."' where usr_id='".$_SESSION['uid']."'";
	mysql_query($sql_sm);
}*/
$sql_po="select * from user where usr_id='".$row->usr_id."'";
$res_po=mysql_query($sql_po);
$row_po=mysql_fetch_object($res_po);
?>

<!--<script type="text/javascript" src="js/profile-overview.js"></script> -->

<script language="javascript">//for Profile Overview Section
function showeditNameBlock()
{
	//$.noConflict();
	$('#edit_displayname_div').show();
	$('#display_name_id').parent().hide();	
}
function saveUserName()
{
	//$.noConflict();
	var uname = $("#value_edit").val();
	
	//$('#edit_displayname_div').hide();
	//$('#display_name_id').parent().show();	
	$.get("ajax-file/updUsername.php", {usr_name:uname}, function(data){	
		$('#display_name_id').html(data);	
		$('#usrnameoverview').html(data); 
            $("#userName").text(data);
		$("#value_edit").val(data);
	});
	
	$('#edit_displayname_div').hide();
	$('#display_name_id').parent().show();	
}
function hideeditNameBlock()
{
	//$.noConflict();
	$('#edit_displayname_div').hide();
	$('#display_name_id').parent().show();	
}



function showSummaryEdit()
{
	//$.noConflict();
	$('#add_summary_div').css({"display":"none"});
	$('#summary_text_p').css({"display":"none"});
	$('#summary_div').css({"display":"block"});
}
function saveUserSummary()
{
	//$.noConflict();
	var summary = $("#summary_edit_text").val();

	$.get("ajax-file/updUsersummary.php", {usr_summary:summary}, function(data){	
		$('#summary_short').html(data);	
		$('#summary_text_p').css({"display":"block"});
		$('#summary_div').css({"display":"none"});
	});
	
}
function hideSummaryEdit()
{
	//$.noConflict();
	$('#add_summary_div').css({"display":"block"});
	$('#summary_text_p').css({"display":"block"});
	
	$('#summary_div').css({"display":"none"});
	
}

</script>

    <div class="freelancer-detail-col">
        <h2><span id="userName"><?php echo $row_po->usr_name; ?></span>
                 <?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row->usr_id)){ ?>
                     <a id="edit_display_name_id" href="javascript:showeditNameBlock()" desc="display_name" shownname="Display Name" class="ns_edit profile_info_edit">[<span class="ns_icon-edit"></span> <?php echo $lang[399]; ?>]</a>
                 <?php } ?>
        </h2>
        <div class="ns_edit ns_box" style="display:none;" id="edit_displayname_div">
                        <form class="ns_form ns_pad">
                            <div>
                                <div class="ns_field">
                                    <label for="password"><span id="displayname_div_title" style="color:#333;font-weight:bold;font-style:normal;!important;"><?php echo $lang[456]; ?></span></label>
                                    <input id="usr_id" class="ns_third-2" type="hidden" value="<?php echo $row->usr_id; ?>">
                                    <input id="value_edit" class="ns_third-2" type="text" value="<?php echo $row_po->usr_name; ?>">
                                </div>
                            <a href="javascript:saveUserName()" id="displayname_save" class="ns_btn-small ns_blue ns_left"><span><?php echo $lang[106]; ?></span></a> <a href="javascript:hideeditNameBlock(0)" id="edit_displayname_cancel" class="ns_btn-small ns_left"><span><?php echo $lang[398]; ?></span></a>
                            <div class="ns_clear"></div>
                            <span class="ns_icon-16 ns_icon-error ns_left ns_margin-r5 ns_margin-top-small" style="display: none;"></span>
                            <p id="error-msg-box" class="ns_color-red ns_pad-none ns_left ns_margin-top-small" style="display: none;"></p>
                            </div>
                            <img src="images/ajax-loader_002.gif" style="display: none;">
        			</form>
                    </div>
                            
                    <p><strong><?php echo $lang[42]; ?></strong> <span id="usrnameoverview"><?php echo $row_po->usr_name; ?></span></p>
                    <?php
                        $sql_ct_cn="select * from city,country where ct_cn_id=cn_id and ct_id='".$row->usr_ct_id."'";
                        $res_ct_cn=  mysql_query($sql_ct_cn);
                        $row_ct_cn=  mysql_fetch_object($res_ct_cn);
                    ?>
                            <p><span class="user-location"><strong><?php echo $lang[668]; ?>:</strong> <?php echo $row_ct_cn->ct_name; ?>, <?php echo $row_ct_cn->cn_name; ?></span><?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row->usr_id)){ ?><a href="changeuserinfo.php" class="ns_edit ns_margin-l10" id="country_edit">[<span class="ns_icon-edit"></span> <?php echo $lang[399]; ?>]</a><?php } ?></p>
                            
                            <p><strong><?php echo $lang[458]; ?></strong> <?php echo date("F, Y",  strtotime($row->usr_creation_date)); ?></p>

        <div class="ns_bg-hover">
                	<?php if($row_po->usr_summary != '') { ?>
                    <p style="display:block;" class="ns_profile-desc" id="summary_text_p">
                        <!-- This must be on a single line and not be formatted.  Otherwise summary_text is not detected as an empty string due to the new lines. -->
                        <span id="summary_text" itemprop="description">
                        	<span id="summary_short"><?php echo $row_po->usr_summary; ?></span>
                            <span style="display:inline;" id="summary_text_autoset"></span>
                        </span>
                        <br />
                        <?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row->usr_id)){ ?>
                            <a style="" href="javascript:showSummaryEdit()" id="summary_edit_button" desc="title" class="ns_edit ns_margin-l10 summary_edit">[<span class="ns_icon-edit"></span> <?php echo $lang[399]; ?>]</a>
                        <?php } ?>
                    </p>
					<?php } else { ?>
                    	<?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row->usr_id)){ ?>
                        <div class="ns_empty ns_box ns_hr-rate ns_add ns_margin-10 ns_edit" id="add_summary_div" style="display:block;">
                            <span id="span_summary_edit" class="ns_label ns_edit">
                                <a href="javascript:showSummaryEdit()" class="ns_edit summary_edit"><?php echo $lang[459]; ?></a>
                            </span>
                        </div>
                     	<?php } ?>
                     <?php } ?>
                    
                </div>
        <div class="ns_edit ns_box" style="display:none;" id="summary_div">
            <form class="ns_form ns_pad">
                <div>
                    <div class="ns_field">
                        <label for="password"><span id="summary_div_title" style="color:#333;font-weight:bold;font-style:normal;!important;"><?php echo $lang[457]; ?></span></label>
                        <textarea id="summary_edit_text" class="ns_third-2" style="height: 100px;"><?php echo $row_po->usr_summary; ?></textarea>
                    </div>
                    <a href="javascript:saveUserSummary()" id="summary_save" class="ns_btn-small ns_blue ns_left"><span><?php echo $lang[106]; ?></span></a> <a href="javascript:hideSummaryEdit()" id="summary_cancel" class="ns_btn-small ns_left"><span><?php echo $lang[398]; ?></span></a>
                    <div class="ns_clear"></div>
                    <span class="ns_icon-16 ns_icon-error ns_left ns_margin-r5 ns_margin-top-small" style="display: none;"></span>
                    <img src="images/ajax-loader_002.gif" style="display: none;">
                    <p class="ns_color-red ns_pad-none ns_left ns_margin-top-small" style="display: none;"></p>
                    </div>
        	</form>
        </div>
   </div>