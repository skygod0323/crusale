<?php
	ob_start();
	session_start();
    include 'common.php';
	
	$month = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
	
	$usr_id=$_GET['uid'];
	$sql_r="select * from user where md5(usr_id)='".$usr_id."' or usr_id='".$usr_id."'";
	$res_r=mysql_query($sql_r);
	$row_r=mysql_fetch_object($res_r);
?>
<script language="javascript">
function showAddExpForm()
{
	//$.noConflict();
	$('#add_experience_form').css({"display":"block"});		
	//$('#newDiv').css({"display":"none"});
}
function hideAddExpForm()
{
	//$.noConflict();
	$('#add_experience_form').css({"display":"none"});		
	//$('#newDiv').css({"display":"none"});
}
function showEditExpForm(ue_id)
{
	//$.noConflict();
	$('#edit_experience_form_'+ue_id).css({"display":"block"});		
	//$('#newDiv').css({"display":"none"});
}
function hideEditExpForm(ue_id)
{
	//$.noConflict();
	$('#edit_experience_form_'+ue_id).css({"display":"none"});		
	//$('#newDiv').css({"display":"none"});
}

$(document).ready(
	function(){		
		$('#experience_new_submit').click(function(){	
													
			ue_usr_id=$('#ue_usr_id').val(); 
			ue_title=$('#ue_title').val();
			ue_company=$('#ue_company').val();
			
			if($("input#ue_current:checked").val()=='1'){		ue_current='1';		}
			else{	ue_current='0';		}
//			ue_current=$("input#ue_current").is(':checked');
//			ue_current=$("#ue_current").val();

			ue_from_month=$('#ue_from_month :selected').val();
			ue_from_year=$('input#experience_start_date_year').val();
			ue_to_month=$('#ue_to_month :selected').val();
			ue_to_year=$('input#experience_end_date_year').val();
			ue_summary=$('textarea#ue_summary').val();

			if (ue_title == "") {
                    alert('<?php echo $lang[534]; ?>');
                    $("#ue_title").focus();
                    return false;
                    }
	        else if (ue_company == "") {
	            alert('<?php echo $lang[535]; ?>');
	            $("#ue_company").focus();
	            return false;
    	    }
			else if (ue_from_month == "-1") {
	            alert('<?php echo $lang[536]; ?>');
	            $("#ue_from_month").focus();
	            return false;
    	    }
			else if (ue_from_year == "") {
	            alert('<?php echo $lang[537]; ?>');
	            $("#ue_from_year").focus();
	            return false;
    	    }
			else if($("input#ue_current:checked").val()!='1')
			{
				if (ue_to_month == "-1") 
				{
	            	alert('<?php echo $lang[538]; ?>');
		            $("#ue_to_month").focus();
		            return false;
    	    	}	
				else if (ue_to_year == "") 
				{
	            	alert('<?php echo $lang[539]; ?>');
		            $("#ue_to_year").focus();
		            return false;
	    	    }
			}
			else if(ue_summary == '')
			{
				alert('<?php echo $lang[540]; ?>');
	            $("#ue_summary").focus();
	            return false;
			}
			$.get("ajax-file/addExperience.php", {ue_usr_id:ue_usr_id,ue_title:ue_title,ue_company:ue_company,ue_current:ue_current,ue_from_month:ue_from_month,ue_from_year:ue_from_year,ue_to_month:ue_to_month,ue_to_year:ue_to_year,ue_summary:ue_summary}, function(data){	
				
	showRS();

});
////////////////////////////////////////////////////////////////////
			
			
        // send the form via Ajax
//        event.preventDefault();
//        $.ajax({
//            type: "POST",
//            url: "processform.php",
//            data: ({subject: $("#subject").val(), email: $("#email").val(), comments: $("#comments").val()}),
//            error: function(msg) {
//                $("#errors").html(msg);
//            },
//            success: function(msg) {
//                // display the errors returned by server side validation (if any)
//                if (msg.indexOf('Congratulations') == -1) {
//                    $("#errors").html(msg);
//                }
//                // otherwise, display a confirmation message
//                else {
//                    $("form").html('<h3>' + msg + '</h3>');
//                }
//            }
//        });										
														
////////////////////////////////////////////////////////////////////////////////////////////////////	
	
	});        
});

function editExperienceSubmit(uid)
{
	ue_id=$('#ue_id_'+uid).val(); 
	ue_title=$('#ue_title_'+uid).val();
	ue_company=$('#ue_company_'+uid).val();
	if($("input#ue_current_"+uid+":checked").val()=='1'){		ue_current='1';		}
	else{	ue_current='0';		}
//	ue_current=$('input#ue_current_'+uid).is(':checked');
	ue_from_month=$('#ue_from_month_'+uid+' :selected').val();
	ue_from_year=$('input#experience_start_date_year_'+uid).val();
	ue_to_month=$('#ue_to_month_'+uid+' :selected').val();
	ue_to_year=$('input#experience_end_date_year_'+uid).val();
	ue_summary=$('textarea#ue_summary_'+uid).val();

	if (ue_title == "") {
		alert('<?php echo $lang[534]; ?>');
	    $("#ue_title_"+uid).focus();
	    return false;
    }
    else if (ue_company == "") {
        alert('<?php echo $lang[535]; ?>');
        $("#ue_company_"+uid).focus();
        return false;
    }
	else if (ue_from_month == "-1") {
        alert('<?php echo $lang[536]; ?>');
        $("#ue_from_month_"+uid).focus();
        return false;
    }
	else if (ue_from_year == "") {
        alert('<?php echo $lang[537]; ?>');
        $("#ue_from_year_"+uid).focus();
        return false;
 	}
	else if($("input#ue_current"+uid+":checked").val()!='1')
	{
		if (ue_to_month == "-1") 
		{
           	alert('<?php echo $lang[538]; ?>');
            $("#ue_to_month_"+uid).focus();
            return false;
    	}	
		else if (ue_to_year == "") 
		{
	       	alert('<?php echo $lang[539]; ?>');
	        $("#ue_to_year_"+uid).focus();
            return false;
	   }
	}
	else if(ue_summary == '')
	{
		alert('<?php echo $lang[540]; ?>');
	    $("#ue_summary_"+uid).focus();
		return false;
	}
	
	$.get("ajax-file/updExperience.php", {ue_id:ue_id,ue_title:ue_title,ue_company:ue_company,ue_current:ue_current,ue_from_month:ue_from_month,ue_from_year:ue_from_year,ue_to_month:ue_to_month,ue_to_year:ue_to_year,ue_summary:ue_summary}, function(data){	
		
		showRS();
	});
	
}

$(document).ready(
	function(){		
		$('#qualification_new_submit').click(function(){	
				
			ued_usr_id=$('#ued_usr_id').val(); 
			ued_cn_id=$('#ued_cn_id :selected').val();
			ued_institute=$('#ued_institute').val();
			ued_degree=$('#ued_degree').val();
			ued_from_year=$('#ued_from_year :selected').val();			
			ued_to_year=$('#ued_to_year :selected').val();


			if (ued_cn_id == "-1") {
	            alert('<?php echo $lang[541]; ?>');
	            $("#ued_cn_id").focus();
	            return false;
    	    }
	        else if (ued_institute == "") {
	            alert('<?php echo $lang[542]; ?>');
	            $("#ued_institute").focus();
	            return false;
    	    }
			else if (ued_degree == "") {
	            alert('<?php echo $lang[543]; ?>');
	            $("#ued_degree").focus();
	            return false;
    	    }
			else if (ued_from_year == "") {
	            alert('<?php echo $lang[537]; ?>');
	            $("#ued_from_year").focus();
	            return false;
    	    }
			else if (ued_to_year == "") {
	            alert('<?php echo $lang[539]; ?>');
	            $("#ued_to_year").focus();
	            return false;
    	    }
			
	$.get("ajax-file/addQualification.php", {ued_usr_id:ued_usr_id,ued_cn_id:ued_cn_id,ued_institute:ued_institute,ued_degree:ued_degree,ued_from_year:ued_from_year,ued_to_year:ued_to_year}, function(data){	
			showRS();
			});
		});        
});
function editQualificationSubmit(uid)
{
	ued_id=$('#ued_id_'+uid).val(); 
	ued_cn_id=$('#ued_cn_id_'+uid+' :selected').val();
	ued_institute=$('#ued_institute_'+uid).val();
	ued_degree=$('#ued_degree_'+uid).val();
	ued_from_year=$('#ued_from_year_'+uid+' :selected').val();
	ued_to_year=$('#ued_to_year_'+uid+' :selected').val();
	
	if (ued_cn_id == "-1") {
		alert('<?php echo $lang[541]; ?>');
	    $("#ued_cn_id_"+uid).focus();
	    return false;
	}
    else if (ued_institute == "") {
        alert('<?php echo $lang[542]; ?>');
        $("#ued_institute_"+uid).focus();
        return false;
    }
	else if (ued_degree == "") {
        alert('<?php echo $lang[543]; ?>');
        $("#ued_degree_"+uid).focus();
        return false;
    }
	else if (ued_from_year == "") {
	    alert('<?php echo $lang[537]; ?>');
	    $("#ued_from_year_"+uid).focus();
	    return false;
    }
	else if (ued_to_year == "") {
	     alert('<?php echo $lang[538]; ?>');
	     $("#ued_to_year_"+uid).focus();
	     return false;
    }
	
	alert(ued_institute);
//	$.get("ajax-file/updQualification.php", {ued_id:ued_id,ued_cn_id:ued_cn_id,ued_institute:ued_institute,ued_degree:ued_degree,ued_from_year:ued_from_year,ued_to_year:ued_to_year}, function(data){	
		
	//	showRS();
//	});
	
}

$(document).ready(
	function(){		
		$('#certification_new_submit').click(function(){
														   
			ucr_usr_id=$('#ucr_usr_id').val(); 
			ucr_certificate=$('#ucr_certificate').val();
			ucr_organization=$('#ucr_organization').val();
			ucr_year=$('#ucr_year :selected').val();
			ucr_description=$('textarea#ucr_description').val();
			
			
			if (ucr_certificate == "") {
	            alert('<?php echo $lang[544]; ?>');
	            $("#ucr_certificate").focus();
	            return false;
    	    }
	        else if (ucr_organization == "") {
	            alert('<?php echo $lang[545]; ?>');
	            $("#ucr_organization").focus();
	            return false;
    	    }
			else if (ucr_year == "0") {
	            alert('<?php echo $lang[546]; ?>');
	            $("#ucr_year").focus();
	            return false;
    	    }
			else if (ucr_description == "") {
	            alert('<?php echo $lang[547]; ?>');
	            $("#ucr_description").focus();
	            return false;
    	    }
			
			$.get("ajax-file/addCertification.php", {ucr_usr_id:ucr_usr_id,ucr_certificate:ucr_certificate,ucr_organization:ucr_organization,ucr_year:ucr_year,ucr_description:ucr_description}, function(data){	
		
				showRS();
			});
	});        
});

function editCertificationSubmit(uid)
{
	ucr_id=$('#ucr_id_'+uid).val(); 
	ucr_certificate=$('#ucr_certificate_'+uid).val();
	ucr_organization=$('#ucr_organization_'+uid).val();
	ucr_year=$('#ucr_year_'+uid+' :selected').val();
	ucr_description=$('textarea#ucr_description_'+uid).val();

	if (ucr_certificate == "") {
		alert('<?php echo $lang[544]; ?>');
        $("#ucr_certificate_"+uid).focus();
        return false;
	}
	else if (ucr_organization == "") {
		alert('<?php echo $lang[545]; ?>');
	    $("#ucr_organization_"+uid).focus();
	    return false;
	}
	else if (ucr_year == "0") {
        alert('<?php echo $lang[546]; ?>');
        $("#ucr_year_"+uid).focus();
        return false;
    }
	else if (ucr_description == "") {
	    alert('<?php echo $lang[547]; ?>');
	    $("#ucr_description_"+uid).focus();
	    return false;
 	}
	
	$.get("ajax-file/updCertification.php", {ucr_id:ucr_id,ucr_certificate:ucr_certificate,ucr_organization:ucr_organization,ucr_year:ucr_year,ucr_description:ucr_description}, function(data){	
		
		showRS();
	});		
}


function showAdd_qualification_form()
{
	//$.noConflict();
	$('#add_qualification_form').css({"display":"block"});
}
function hideAdd_qualification_form()
{
	//$.noConflict();
	$('#add_qualification_form').css({"display":"none"});
}
function showEdit_qualification_form(ued_id)
{
	//$.noConflict();
	$('#edit_qualification_form_'+ued_id).css({"display":"block"});
}
function hideEdit_qualification_form(ued_id)
{
	//$.noConflict();
	$('#edit_qualification_form_'+ued_id).css({"display":"none"});
}
function showAdd_certification_form()
{
	//$.noConflict();
	$('#add_certification_form').css({"display":"block"});
	
}
function hideAdd_certification_form()
{
	//$.noConflict();
	$('#add_certification_form').css({"display":"none"});
	
}
function showEdit_certification_form(ucr_id)
{
	//$.noConflict();
	$('#edit_certification_form_'+ucr_id).css({"display":"block"});
}
function hideEdit_certification_form(ucr_id)
{
	//$.noConflict();
	$('#edit_certification_form_'+ucr_id).css({"display":"none"});
}
//$(document).ready(
//	function(){		
//		$('#del_experience').click(function(){
//												 alert('OK');
//			var ue_id = $('#del_exp_id').val();								 
//			$.get("ajax-file/delExperience.php", {ue_id:ue_id});		
//			location.reload();
//		});        
//	});

function delExperience(ue_id)
{
	//bootbox.confirm("<?php echo $lang[727]; ?>", function(result) {
		if(confirm("<?php echo $lang[727]; ?>")) {
			$.get("ajax-file/delExperience.php", {ue_id:ue_id},	function(data){	showRS();   });
		}
	//});
	
//	$.get("ajax-file/delExperience.php", {ue_id:ue_id},	function(data){	showRS();   });
}
function delEducation(ued_id)
{
	//bootbox.confirm("<?php echo $lang[728]; ?>", function(result) {
		if(confirm("<?php echo $lang[728]; ?>")) {
			$.get("ajax-file/delEducation.php", {ued_id:ued_id},	function(data){	
				showRS();
			});
		}
	//});
}
function delCertification(ucr_id)
{
	//bootbox.confirm("<?php echo $lang[729]; ?>", function(result) {
		if(confirm("<?php echo $lang[729]; ?>")) {
			$.get("ajax-file/delCertification.php", {ucr_id:ucr_id},	function(data){	
				showRS();
			});
		}
	//});
	
}
</script>
<hr class="invis">
		<h4><?php echo $row_r->usr_name; ?> Resume</h4>

<hr>
<div id="div_experience_id">
	<h4 class=""><?php echo $lang[548]; ?>&nbsp;&nbsp;<?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row_r->usr_id)){ ?><a style="cursor:pointer;text-decoration:none;" id="addOne" href="javascript:showAddExpForm()"><i class="fa fa-pencil" aria-hidden="true"></i></a><?php } ?></h4>
	<div id="experiences_div"></div>
	<div class="ns_clear"></div>
	<div class="ns_edit ns_box" id="add_experience_form" style="display:none;">
		<div id="new_experience">
    		<form class="ns_form ns_pad" id="addExperience" name="addExperience" method="post" action="">
		        <input type="hidden" name="ue_usr_id" id="ue_usr_id" value="<?php echo $_SESSION['uid']; ?>" />
        		<div class="ns_field">
					<label for="password"><?php echo $lang[389]; ?></label>	
                	<div class="ns_col">
                    		
			            <input class="ns_half form-control" id="ue_title" type="text" name="ue_title">
            		</div>
					<label for="password"><?php echo $lang[549]; ?></label>	
		            <div class="ns_col">
                    	
			            <input class="ns_half form-control" id="ue_company" type="text" name="ue_company">
					</div>
                    <div class="ns_clear"></div>
				</div>
                <div class="ns_field">
					<label for="password" style="display:inline"><?php echo $lang[550]; ?></label>
                	<div class="ns_col">
                    	
						<input id="ue_current" style="margin-left: 1px;" type="checkbox" name="ue_current" value="1"><?php echo $lang[551]; ?>
                        <div>
                        	<span id="experience_new_start_date_month_dropdown" style="margin-right:10px">
					            <select style="vertical-align:middle;width:104px;" name="ue_from_month" id="ue_from_month">
					            	<option selected="selected" value="-1"><?php echo $lang[553]; ?></option>
					                <?php for($m1=0;$m1<12;$m1++){ ?>
					                <option value="<?php echo $m1; ?>"><?php echo $month[$m1]; ?></option>
					                <?php } ?>
					             </select>
				             </span>
                             <span style="position:absolute">
             <input class="ns_half experience-year" placeholder="<?php echo $lang[554]; ?>" id="experience_start_date_year" name="ue_from_year" maxlength="4" style="width: 40px; color: grey;" type="text"></span>
             <span class="relative" style="margin-left:60px"> to </span><span id="experience_new_end_date_month_dropdown" style="margin-left:10px;margin-right:10px;">
            <select style="vertical-align:middle;width:104px;" name="ue_to_month" id="ue_to_month">
             	<option selected="selected" value="-1"><?php echo $lang[553]; ?></option>
                <?php for($m2=0;$m2<12;$m2++){ ?>
                <option value="<?php echo $m2; ?>"><?php echo $month[$m2]; ?></option>
                <?php } ?>

			</select></span><span style="position:absolute">
            <input class="ns_half experience-year " placeholder="<?php echo $lang[554]; ?>" id="experience_end_date_year" maxlength="4" style="width: 40px; color: grey;" type="text" name="ue_to_year">
            </span></div></div></div><div class="ns_field"><div class="ns_field"><label for="password"><?php echo $lang[457]; ?></label><div class="ns_col"><textarea class="form-control ns_full" style="height: 100px;" id="ue_summary" name="ue_summary"></textarea>
             <input type="hidden" name="expSubmit" value="1" />
             </div></div><div class="ns_clear"></div>
             <a href="javascript:void(0)" class="btn btn-info btn-sm" id="experience_new_submit"><i class="icon-ok"></i><?php echo $lang[106]; ?></a>
             <a href="javascript:hideAddExpForm()" class="btn btn-white" id="experience_new_cancel"><?php echo $lang[398]; ?></a>
             <div class="ns_clear"></div>
             </div>
             
    	</form>
	</div>
</div>
          
          
            
		<div class="newDiv row">
        <?php
			$sql_ex="select * from user_experience where ue_usr_id='".$row_r->usr_id."' order by ue_from_year desc,ue_from_month";
			$res_ex=mysql_query($sql_ex);
			while($row_ex=mysql_fetch_object($res_ex)) {
				$from_month=$row_ex->ue_from_month;
				$to_month=$row_ex->ue_to_month;

		?>
       <div class="col-xs-12 col-sm-6 widget-container-span ui-sortable">
			<div class="widget-box" >
				<div class="widget-header widget-header-small header-color-orange">
					
                    <?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row_r->usr_id)){	?>
					<div class="widget-toolbar" style="background:#eee; border-radius: 5px 5px 0 0;">
						<span style="padding-left:10px;"><?php echo $row_ex->ue_title; ?></span>
						<span style="padding-right:10px;float:right;">
						<a href="javascript:showEditExpForm(<?php echo $row_ex->ue_id; ?>)">
                        	<i class="fa fa-pencil-square-o" aria-hidden="true" style="vertical-align:middle;"></i>
						</a>
						<a id="del_experience" href="javascript:delExperience(<?php echo $row_ex->ue_id; ?>)">
							<i class="fa fa-times" aria-hidden="true"></i>
						</a>
						</span>
					</div>
                    <?php	}	?>
				</div>
				<div class="widget-body alert alert-info">
                	<div class="widget-toolbox">
						<div class="btn-toolbar" style="padding-left:10px;">
	                        <?php echo $row_ex->ue_company; ?>&nbsp;&nbsp;[
							<?php 
							if($row_ex->ue_current == 1) { 
								$diff_y=date("Y")-$row_ex->ue_from_year;
						 		echo $month[$from_month]; ?>&nbsp;<?php echo $row_ex->ue_from_year; ?> - <?php echo $lang[555];
								if($diff_y>0){ ?>
                                	(<?php echo $diff_y; ?>&nbsp;<?php echo $lang[556]; ?>)
								<?php } ?>
							<?php } else { 
								$dif_y=$row_ex->ue_to_year - $row_ex->ue_from_year;
								echo $month[$from_month]; ?>&nbsp;<?php echo $row_ex->ue_from_year; ?> - <?php echo $month[$to_month]; ?>&nbsp;<?php echo $row_ex->ue_to_year; ?> (<?php echo $dif_y; ?>&nbsp;<?php echo $lang[556]; ?>)
							<?php } ?>]
						</div>
					</div>
                	<div style="display: block;" class="widget-body-inner">
						<div class="widget-main">
							<p class="alert alert-info">
   								<?php echo $row_ex->ue_summary; ?>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
       
       <!---->
            
            <div class="ns_edit ns_box" id="edit_experience_form_<?php echo $row_ex->ue_id; ?>" style="display:none;">
	<div id="edit_experience">
    	<form class="ns_form ns_pad" id="editExperience<?php echo $row_ex->ue_id; ?>" name="editExperience<?php echo $row_ex->ue_id; ?>" method="post" action="">
	        <input type="hidden" name="ue_id" id="ue_id_<?php echo $row_ex->ue_id; ?>" value="<?php echo $row_ex->ue_id; ?>" />
        	<div class="ns_field">
				<label for="password"><?php echo $lang[389]; ?></label>	
            	<div class="ns_col">	
            	<input class="form-control ns_half" id="ue_title_<?php echo $row_ex->ue_id; ?>" type="text" name="ue_title" value="<?php echo $row_ex->ue_title; ?>">
	            </div>
				<label for="password"><?php echo $lang[549]; ?></label>	
    	        <div class="ns_col">	
        		    <input class="form-control ns_half" id="ue_company_<?php echo $row_ex->ue_id; ?>" type="text" name="ue_company" value="<?php echo $row_ex->ue_company; ?>">
				</div>
                <div class="ns_clear"></div>
			</div>
          
			<div class="ns_field">
				<label for="password" style="display:inline"><?php echo $lang[550]; ?></label>
            	<div class="ns_col">
                	
					<input id="ue_current_<?php echo $row_ex->ue_id; ?>" style="margin-left: 1px;" type="checkbox" name="ue_current" value="1"><?php echo $lang[551]; ?><div>
                    <span id="experience_new_start_date_month_dropdown" style="margin-right:10px">
                        <select style="vertical-align:middle;width:104px;" name="ue_from_month" id="ue_from_month_<?php echo $row_ex->ue_id; ?>">
                        <option selected="selected" value="-1"><?php echo $lang[553]; ?></option>
                        <?php for($m3=0;$m3<12;$m3++){ ?>
                            <option value="<?php echo $m3; ?>" <?php if($from_month == $m3){ ?> selected="selected"<?php } ?>><?php echo $month[$m3]; ?></option>
                        <?php } ?>
                         </select>
	            	 </span>
                     <span style="position:absolute">
			             <input class="ns_half experience-year" placeholder="<?php echo $lang[554]; ?>" id="experience_start_date_year_<?php echo $row_ex->ue_id; ?>" name="ue_from_year" maxlength="4" style="width: 40px; color: grey;" type="text" value="<?php echo $row_ex->ue_from_year; ?>">
                     </span>
		             <span class="relative" style="margin-left:60px"> to </span>
                     <span id="experience_new_end_date_month_dropdown" style="margin-left:10px;margin-right:10px;">
             
			            <select style="vertical-align:middle;width:104px;" name="ue_to_month" id="ue_to_month_<?php echo $row_ex->ue_id; ?>">
            			 	<option selected="selected" value="-1"><?php echo $lang[553]; ?></option>
			                <?php for($m4=0;$m4<12;$m4++){ ?>
			                <option value="<?php echo $m4; ?>" <?php if($m4 == $to_month){ ?> selected="selected"<?php } ?>><?php echo $month[$m4]; ?></option>
			                <?php } ?>
						</select></span><span style="position:absolute">
			            <input class="ns_half experience-year" placeholder="<?php echo $lang[554]; ?>" id="experience_end_date_year_<?php echo $row_ex->ue_id; ?>" maxlength="4" style="width: 40px; color: grey;" type="text" name="ue_to_year" value="<?php echo $row_ex->ue_to_year; ?>">
	            	</span>
               	</div>
               </div>
           </div>
            <div class="ns_field"><div class="ns_field"><label for="password"><?php echo $lang[457]; ?></label><div class="ns_col"><textarea class="form-control ns_full" style="height: 100px;" id="ue_summary_<?php echo $row_ex->ue_id; ?>" name="ue_summary"><?php echo $row_ex->ue_summary; ?></textarea>
             <input type="hidden" name="expEditSubmit" value="1" />
             </div></div><div class="ns_clear"></div>
             <a onClick="editExperienceSubmit(<?php echo $row_ex->ue_id; ?>)" class="btn btn-info btn-sm" id="experience_edit_submit"><i class="icon-ok"></i><?php echo $lang[106]; ?></a>
             <a onClick="hideEditExpForm(<?php echo $row_ex->ue_id; ?>)" class="btn btn-white" id="experience_new_cancel"><?php echo $lang[398]; ?></a>
             <div class="ns_clear"></div>
             </div>
             
    	</form>
	</div>
</div>
            
        <?php } ?>
		</div>
    
</div>

<div class="hr dotted"></div>

<div class="ns_qualifications ns_margin-10" id="div_qualification_id">
    <h4 class="ns_edit"><?php echo $lang[810]; ?>&nbsp;&nbsp;
<?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row_r->usr_id)){	?>
<a href="javascript:showAdd_qualification_form()" style="text-decoration:none;cursor:pointer;" id="addOne"><i class="fa fa-pencil" aria-hidden="true"></i></a>
<?php } ?>
</h4>
<div id="qualifications_div"></div><div class="ns_clear"></div>
<div class="ns_edit ns_box" id="add_qualification_form"  style="display:none;">
	<div id="new_qualification">
    	<form class="ns_form ns_pad" id="qualification_form" method="post">
        	<input type="hidden" id="ued_usr_id" name="ued_usr_id" value="<?php echo $_SESSION['uid']; ?>" />
        	<div class="ns_field">
				<label for="password"><?php echo $lang[557]; ?></label>
            	<div class="ns_col">
                	
                    <div id="qualification_country_list">
                    <?php 
					$sql_cn="select * from country where cn_status=1 order by cn_name";
					$res_cn=mysql_query($sql_cn);
					
					?>
                    	<select id="ued_cn_id" name="ued_cn_id" class="form-control">
							<option value="-1">(<?php echo $lang[552]; ?>)</option>
                        <?php	while($row_cn=mysql_fetch_object($res_cn))	{	?>
							<option value="<?php echo $row_cn->cn_id; ?>"><?php echo $row_cn->cn_name; ?></option>
                        <?php } ?>
                           
						</select>
                    </div>
            	</div>
			</div>
            <div class="ns_field">
				<label for="password"><?php echo $lang[558]; ?></label>
            	<div class="ns_col">
					<input class="form-control ns_half" type="text" id="ued_institute" name="ued_institute" value="">
				</div>
			</div>
            <div class="ns_field">
				<label for="password"><?php echo $lang[559]; ?></label>
            	<div class="ns_col">
                	<input class="form-control ns_half" type="text" id="ued_degree" name="ued_degree" value="">
               	</div>
            </div>
			<div class="ns_field">
			<label for="password"><?php echo $lang[560]; ?></label>
            	<div class="ns_col">
                	
                    <span id="qualification_add_start_date_dropdown" style="margin-right:10px">
                    
                        <select style="vertical-align:middle;width:104px;" name="ued_from_year" id="ued_from_year">
                        	<option value="0">-</option>
                        <?php
					for($ys=date("Y");$ys>=(date("Y")-80);$ys--){
				?>
                        <option value="<?php echo $ys; ?>"><?php echo $ys; ?></option>
                        <?php } ?>
                        </select>
                    </span> to <span id="qualification_add_end_date_dropdown" style="margin-left:10px">
                        <select style="vertical-align:middle;width:104px;" name="ued_to_year" id="ued_to_year">
                        	<option value="0">-</option>
                        <?php
					for($ye=date("Y");$ye>=(date("Y")-80);$ye--){
				?>
                        <option value="<?php echo $ye; ?>"><?php echo $ye; ?></option>
                        <?php } ?>
                        </select>
                    </span>
                </div>
				<div class="ns_clear"></div>
			</div>
            <div class="ns_clear"></div>
            <a class="btn btn-info btn-sm" id="qualification_new_submit"><i class="icon-ok"></i><?php echo $lang[106]; ?></a>
            <a class="btn btn-white" id="qualification_cancel" href="javascript:hideAdd_qualification_form()"><?php echo $lang[398]; ?></a>
            <div class="ns_clear"></div>

         </form>
                        </div></div>
                        
	<div class="newDiv row">
		
    	<?php
			$sql_ed="select * from user_education where ued_usr_id='".$row_r->usr_id."' order by ued_to_year desc";
			$res_ed=mysql_query($sql_ed);
			while($row_ed=mysql_fetch_object($res_ed)) {
		?>
        <div class="col-xs-12 col-sm-4 widget-container-span ui-sortable">
			<div class="widget-box">
				<div class="widget-header widget-header-small header-color-orange">
					

					<?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row_r->usr_id)){	?>
                    <div class="widget-toolbar" style="background:#eee; border-radius: 5px 5px 0 0;">
					<span style="padding-left:10px;"><?php echo $row_ed->ued_degree; ?></span>
					<span style="padding-right:10px;float:right;">
					<a href="javascript:showEdit_qualification_form(<?php echo $row_ed->ued_id; ?>)" ><i class="fa fa-pencil-square-o" aria-hidden="true" style="vertical-align:middle;"></i></a>
					<a class="ns_edit qualification_delete"  href="javascript:delEducation(<?php echo $row_ed->ued_id; ?>)"><i class="fa fa-times" aria-hidden="true"></i></a>
					</span>
                	</div>
					<?php } ?>
				</div>
				<div class="widget-body alert alert-info">
	                <?php	if($row_ed->ued_from_year && $row_ed->ued_to_year != 0){	?>
                	<div class="widget-toolbox">
						<div class="btn-toolbar" style="padding-left:10px;">
	                        <?php
								$dur=$row_ed->ued_to_year-$row_ed->ued_from_year;
							?>
                            <?php echo $row_ed->ued_from_year; ?>&nbsp;-&nbsp;<?php echo $row_ed->ued_to_year; ?>&nbsp;<?php if($dur>0){ ?>(<?php echo $dur; ?>&nbsp;<?php echo $lang[556]; ?>)<?php } ?>
						</div>
					</div>
                    <?php	}	?>                    
                	<div style="display: block;" class="widget-body-inner">
						<div class="widget-main">
							<p class="alert alert-info">
								<?php echo $row_ed->ued_institute;	?>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
                        
        <div class="ns_edit ns_box" id="edit_qualification_form_<?php echo $row_ed->ued_id; ?>"  style="display:none;">
	<div id="new_qualification">
    	<form class="ns_form ns_pad" id="qualification_form_edit<?php echo $row_ed->ued_id; ?>" method="post">
			<br><br><br><br><br><br><br>
			<input type="hidden" id="ued_id_<?php echo $row_ed->ued_id; ?>" value="<?php echo $row_ed->ued_id; ?>" />
        	<div class="ns_field">
				<label for="password"><?php echo $lang[557]; ?></label>
            	<div class="ns_col">
                	
                    <div id="qualification_country_list">
                    <?php 
					$sql_cn="select * from country where cn_status=1 order by cn_name";
					$res_cn=mysql_query($sql_cn);
					
					?>
                    	<select class="form-control" name="ued_cn_id" id="ued_cn_id_<?php echo $row_ed->ued_id; ?>">
					<option value="-1">(<?php echo $lang[552]; ?>)</option>
                        <?php	while($row_cn=mysql_fetch_object($res_cn))	{	?>
					<option value="<?php echo $row_cn->cn_id; ?>" <?php if($row_cn->cn_id==$row_ed->ued_cn_id){ ?> selected="selected"<?php } ?>><?php echo $row_cn->cn_name; ?></option>
                        <?php } ?>
                           
				</select>
                    </div>
            	</div>
			</div>
            <div class="ns_field">
				<label for="password"><?php echo $lang[558]; ?></label>
            	<div class="ns_col">
					<input class="form-control ns_half" type="text" id="ued_institute_<?php echo $row_ed->ued_id; ?>" name="ued_institute" value="<?php echo $row_ed->ued_institute; ?>">
				</div>
			</div>
            <div class="ns_field">
				<label for="password"><?php echo $lang[559]; ?></label>
            	<div class="ns_col">
                	<input class="form-control ns_half" type="text" id="ued_degree_<?php echo $row_ed->ued_id; ?>" name="ued_degree" value="<?php echo $row_ed->ued_degree; ?>">
               	</div>
            </div>
			<div class="ns_field">
				<label for="password"><?php echo $lang[560]; ?></label>
            	<div class="ns_col">
                	
                    <span id="qualification_add_start_date_dropdown" style="margin-right:10px">
                    
                        <select style="vertical-align:middle;width:104px;" name="ued_from_year" id="ued_from_year_<?php echo $row_ed->ued_id; ?>">
                        	<option value="0">-</option>
                        <?php
					for($ys=date("Y");$ys>=(date("Y")-80);$ys--){
				?>
                        <option value="<?php echo $ys; ?>" <?php if($ys == $row_ed->ued_from_year){ ?> selected="selected"<?php } ?>><?php echo $ys; ?></option>
                        <?php } ?>
                        </select>
                    </span> to <span id="qualification_add_end_date_dropdown" style="margin-left:10px">
                        <select style="vertical-align:middle;width:104px;" name="ued_to_year" id="ued_to_year_<?php echo $row_ed->ued_id; ?>">
                        	<option value="0">-</option>
                        <?php
							for($ye=date("Y");$ye>=(date("Y")-80);$ye--){
						?>
                        <option value="<?php echo $ye; ?>" <?php if($ye == $row_ed->ued_to_year){ ?> selected="selected"<?php } ?>><?php echo $ye; ?></option>
                        <?php } ?>
                        </select>
                    </span>
                </div>
				<div class="ns_clear"></div>
			</div>
            <div class="ns_clear"></div>
            <a class="btn btn-info btn-sm" id="qualification_edit_submit" href="javascript:editQualificationSubmit(<?php echo $row_ed->ued_id; ?>)"><i class="icon-ok"></i><?php echo $lang[106]; ?></a>
            <a class="btn btn-white" id="qualification_cancel" href="javascript:hideEdit_qualification_form(<?php echo $row_ed->ued_id; ?>)"><?php echo $lang[398]; ?></a>
            <div class="ns_clear"></div>
            <input type="hidden" name="editQualification" value="1" />
         </form>
                        </div></div>
        <?php } ?>
	</div>
     <div class="ns_empty ns_box ns_add ns_edit" id="addOneA" style="display: none; "><p><a><?php echo $lang[561]; ?></a></p></div>
</div>

<div class="hr dotted"></div>

<div class="ns_margin-10" id="div_certification_id">
	<h4 class="ns_edit"><?php echo $lang[811]; ?>&nbsp;&nbsp;
    <?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row_r->usr_id)){ ?>
    <a style="text-decoration:none;cursor:pointer;" id="addOne" href="javascript:showAdd_certification_form()"><i class="fa fa-pencil" aria-hidden="true"></i></a>
    <?php } ?>
    </h4>
    <div id="certifications_div"></div>
    <div class="ns_clear"></div>
	<div class="ns_edit ns_box" id="add_certification_form" style="display: none; ">
    	<div id="new_certification">
        	<form class="ns_form ns_pad" id="certification_form" method="post">
            	<input type="hidden" id="ucr_usr_id" value="<?php echo $_SESSION['uid']; ?>" />
            	<div class="ns_field">
					<label for="password"><?php echo $lang[562]; ?></label>
                	<div class="ns_col">
                        <input class="form-control ns_half" type="text" id="ucr_certificate" value="" name="ucr_certificate"/>
                    </div>
					<label for="password"><?php echo $lang[563]; ?></label>
                    <div class="ns_col">
                        
                        <input class="form-control ns_half" type="text" id="ucr_organization" value="" name="ucr_organization">
                    </div>
	                <div class="ns_clear"></div>
				</div>
                <div class="ns_field">
					<label for="password"><?php echo $lang[564]; ?></label>
                	<div class="ns_col">
                    	
                        <span id="certification_add_award_date_dropdown">
                        	<select style="vertical-align:middle;width:104px;" name="ucr_year" id="ucr_year">
                            	<option value="0">-</option>
                                <?php
									for($yc=date("Y");$yc>=(date("Y")-80);$yc--){
								?>
                                <option value="<?php echo $yc; ?>"><?php echo $yc; ?></option>
                                <?php	}	?>
							</select>
						</span>
					</div>
				</div>
                <div class="ns_field">
					<label for="password"><?php echo $lang[565]; ?></label>
                	<div class="ns_col">
                    	
                        <textarea class="form-control ns_full" style="height:100px;" id="ucr_description" name="ucr_description"></textarea>
					</div>
				</div>
                <div class="ns_clear"></div>
                <a class="btn btn-info btn-sm" id="certification_new_submit"><i class="icon-ok"></i><?php echo $lang[106]; ?></a>
                <a class="btn btn-white" id="certification_cancel" href="javascript:hideAdd_certification_form()"><?php echo $lang[398]; ?></a>
                <div class="ns_clear"></div>

			</form>
		</div></div>
        
        <div class="newDiv row">
        <?php
			$sql_crt="select * from user_certification where ucr_usr_id='".$row_r->usr_id."' order by ucr_year desc";
			$res_crt=mysql_query($sql_crt);
			while($row_crt=mysql_fetch_object($res_crt)) {
		?>
        
        <div class="col-xs-12 col-sm-4 widget-container-span ui-sortable">
			<div class="widget-box">
				<div class="widget-header widget-header-small header-color-orange">
					<h6></h6>
                    <?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row_r->usr_id)){ ?>
					<div class="widget-toolbar" style="background:#eee; border-radius: 5px 5px 0 0;">
					<span style="padding-left:10px;"><?php echo $row_crt->ucr_certificate; ?>&nbsp;&nbsp;[ <?php echo $row_crt->ucr_year; ?> ]</span>
					<span style="padding-right:10px;float:right;">
						<a href="javascript:showEdit_certification_form(<?php echo $row_crt->ucr_id; ?>)" >
                        	<i class="fa fa-pencil-square-o" aria-hidden="true" style="vertical-align:middle;"></i>
						</a>
						<a id="del_experience" href="javascript:delCertification(<?php echo $row_crt->ucr_id; ?>)">
							<i class="fa fa-times" aria-hidden="true"></i>
						</a>
					</span>
					</div>
                    <?php	}	?>
				</div>
				<div class="widget-body alert alert-info">
                	<div class="widget-toolbox">
						<div class="btn-toolbar" style="padding-left:10px;">
	                        <?php echo $row_crt->ucr_organization; ?>
						</div>
					</div>
                	<div style="display: block;" class="widget-body-inner">
						<div class="widget-main">
							<p class="alert alert-info"><?php echo $row_crt->ucr_description; ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
        
            
            <div class="ns_edit ns_box" id="edit_certification_form_<?php echo $row_crt->ucr_id; ?>" style="display: none; ">
    	<div id="new_certification">
        	<form class="ns_form ns_pad" id="edit_certification_form<?php echo $row_crt->ucr_id; ?>" method="post">
			<br><br><br><br><br><br><br><br>
            	<input type="hidden" name="ucr_id" id="ucr_id_<?php echo $row_crt->ucr_id; ?>" value="<?php echo $row_crt->ucr_id; ?>" />
            	<div class="ns_field">
					<label for="password"><?php echo $lang[562]; ?></label>
                	<div class="ns_col">
                        
                        <input class="form-control ns_half" type="text" id="ucr_certificate_<?php echo $row_crt->ucr_id; ?>" name="ucr_certificate" value="<?php echo $row_crt->ucr_certificate; ?>" />
                    </div>
					<label for="password"><?php echo $lang[563]; ?></label>
                    <div class="ns_col">
                        
                        <input class="form-control ns_half" type="text" id="ucr_organization_<?php echo $row_crt->ucr_id; ?>" name="ucr_organization" value="<?php echo $row_crt->ucr_organization; ?>" >
                    </div>
	                <div class="ns_clear"></div>
				</div>
                <div class="ns_field">
					<label for="password"><?php echo $lang[564]; ?></label>
                	<div class="ns_col">
                    	
                        <span id="certification_add_award_date_dropdown">
                        	<select style="vertical-align:middle;width:104px;" name="ucr_year" id="ucr_year_<?php echo $row_crt->ucr_id; ?>">
                            	<option value="0">-</option>
                                <?php
						for($yc=date("Y");$yc>=(date("Y")-80);$yc--){
					?>
                                <option value="<?php echo $yc; ?>" <?php if($row_crt->ucr_year == $yc){ ?> selected="selected"<?php } ?>><?php echo $yc; ?></option>
                                <?php	}	?>
							</select>
						</span>
					</div>
				</div>
                <div class="ns_field">
					<label for="password"><?php echo $lang[565]; ?></label>
                	<div class="ns_col">
                    	
                        <textarea class="form-control ns_full" style="height:100px;" id="ucr_description_<?php echo $row_crt->ucr_id; ?>" name="ucr_description"><?php echo $row_crt->ucr_description; ?></textarea>
					</div>
				</div>
                <div class="ns_clear"></div>
                <a class="btn btn-info btn-sm" id="certification_edit_submit" href="javascript:editCertificationSubmit(<?php echo $row_crt->ucr_id; ?>)"><i class="icon-ok"></i><?php echo $lang[106]; ?></a>
                <a class="btn btn-white" id="certification_cancel" href="javascript:hideEdit_certification_form(<?php echo $row_crt->ucr_id; ?>)"><?php echo $lang[398]; ?></a>
                <div class="ns_clear"></div>
                <input type="hidden" name="editCertification" value="1" />
			</form>
		</div></div>
            
            
            <?php } ?>

        </div>
   
        <div class="ns_empty ns_box ns_add ns_edit" id="addOneA" style="display:none;"><p><a><?php echo $lang[566]; ?></a></p></div>
</div>

<!--<link href="css/$.css" rel="stylesheet" type="text/css">
<link href="css/$-ui-1_002.css" rel="stylesheet" type="text/css">-->