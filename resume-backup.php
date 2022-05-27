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

			$.get("ajax-file/addExperience.php", {ue_usr_id:ue_usr_id,ue_title:ue_title,ue_company:ue_company,ue_current:ue_current,ue_from_month:ue_from_month,ue_from_year:ue_from_year,ue_to_month:ue_to_month,ue_to_year:ue_to_year,ue_summary:ue_summary}, function(data){	
				
			showRS();

			});
			
	
		});        
	});

function editExperienceSubmit(uid)
{
	ue_id=$('#ue_id_'+uid).val(); 
	ue_title=$('#ue_title_'+uid).val();
	ue_company=$('#ue_company_'+uid).val();
	ue_current=$('input#ue_current_'+uid).is(':checked');
	ue_from_month=$('#ue_from_month_'+uid+' :selected').val();
	ue_from_year=$('input#experience_start_date_year_'+uid).val();
	ue_to_month=$('#ue_to_month_'+uid+' :selected').val();
	ue_to_year=$('input#experience_end_date_year_'+uid).val();
	ue_summary=$('textarea#ue_summary_'+uid).val();
	
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
	
	
	$.get("ajax-file/updQualification.php", {ued_id:ued_id,ued_cn_id:ued_cn_id,ued_institute:ued_institute,ued_degree:ued_degree,ued_from_year:ued_from_year,ued_to_year:ued_to_year}, function(data){	
		
		showRS();
	});
	
}

$(document).ready(
	function(){		
		$('#certification_new_submit').click(function(){
														   
			ucr_usr_id=$('#ucr_usr_id').val(); 
			ucr_certificate=$('#ucr_certificate').val();
			ucr_organization=$('#ucr_organization').val();
			ucr_year=$('#ucr_year :selected').val();
			ucr_description=$('textarea#ucr_description').val();
			
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
	//$.noConflict();
	$.get("ajax-file/delExperience.php", {ue_id:ue_id},	function(data){	
		
				showRS();
	});
}
function delEducation(ued_id)
{
	//$.noConflict();
	$.get("ajax-file/delEducation.php", {ued_id:ued_id},	function(data){	
		
				showRS();
	});
}
function delCertification(ucr_id)
{
	//$.noConflict();
	$.get("ajax-file/delCertification.php", {ucr_id:ucr_id},	function(data){	
		showRS();
	});
}
</script>
		<h2 class="ns_large"><?php echo $row_r->usr_name; ?> Resume</h2>


<div id="div_experience_id">
<h2 class="">Experience<span class="ns_right ns_edit"></span><?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row_r->usr_id)){ ?><a class="ns_add ns_edit ns_right ns_margin-r15 ns_edit" id="addOne" href="javascript:showAddExpForm()">+ Add item</a><?php } ?></h2>
<div id="experiences_div"></div>
<div class="ns_clear"></div>
<div class="ns_edit ns_box" id="add_experience_form" style="display:none;">
	<div id="new_experience">
    	<form class="ns_form ns_pad" id="addExperience" name="addExperience" method="post" action="">
        <input type="hidden" name="ue_usr_id" id="ue_usr_id" value="<?php echo $_SESSION['uid']; ?>" />
        	<div class="ns_field"><div class="ns_col">	<label for="password">Title:</label>	
            <input class="ns_half" id="ue_title" type="text" name="ue_title">
            </div>
            <div class="ns_col">	<label for="password">Company:</label>	
            <input class="ns_half" id="ue_company" type="text" name="ue_company">
</div><div class="ns_clear"></div></div><div class="ns_field"><div class="ns_col"><label for="password" style="display:inline">Time Period:</label>
<input id="ue_current" style="margin-left: 1px;" type="checkbox" name="ue_current" value="1">I currently work here<div><span id="experience_new_start_date_month_dropdown" style="margin-right:10px">
            <select style="vertical-align:middle;width:104px;" name="ue_from_month" id="ue_from_month">
            	<option selected="selected" value="-1">Choose</option>
                <?php for($m1=0;$m1<12;$m1++){ ?>
                <option value="<?php echo $m1; ?>"><?php echo $month[$m1]; ?></option>
                <?php } ?>
             </select>
             </span><span style="position:absolute">
             <input class="ns_half experience-year" placeholder="Year" id="experience_start_date_year" name="ue_from_year" maxlength="4" style="width: 40px; color: grey;" type="text"></span>
             <span class="relative" style="margin-left:60px"> to </span><span id="experience_new_end_date_month_dropdown" style="margin-left:10px;margin-right:10px;">
            <select style="vertical-align:middle;width:104px;" name="ue_to_month" id="ue_to_month">
             	<option selected="selected" value="-1">Choose</option>
                <?php for($m2=0;$m2<12;$m2++){ ?>
                <option value="<?php echo $m2; ?>"><?php echo $month[$m2]; ?></option>
                <?php } ?>

			</select></span><span style="position:absolute">
            <input class="ns_half experience-year" placeholder="Year" id="experience_end_date_year" maxlength="4" style="width: 40px; color: grey;" type="text" name="ue_to_year">
            </span></div></div></div><div class="ns_field"><div class="ns_field"><div class="ns_col"><label for="password">Summary:</label><textarea class="ns_full" style="height: 100px;" id="ue_summary" name="ue_summary"></textarea>
             <input type="hidden" name="expSubmit" value="1" />
             </div></div><div class="ns_clear"></div>
             <a href="javascript:void(0)" class="ns_btn-small ns_blue ns_left" id="experience_new_submit">Save</a>
             <a href="javascript:hideAddExpForm()" class="ns_btn-small ns_left" id="experience_new_cancel">Cancel</a>
             <div class="ns_clear"></div>
             </div>
             
    	</form>
	</div>
</div>
            
		<div class="newDiv">
        <?php
			$sql_ex="select * from user_experience where ue_usr_id='".$row_r->usr_id."' order by ue_from_year desc,ue_from_month";
			$res_ex=mysql_query($sql_ex);
			while($row_ex=mysql_fetch_object($res_ex)) {
				$from_month=$row_ex->ue_from_month;
				$to_month=$row_ex->ue_to_month;

		?>
       
        	<div>
            	<div class="experience_bg ns_bg-hover">
                	<div class="ns_experience-con">
                    	<h3 class="ns_left"><?php echo $row_ex->ue_title; ?>
                        <?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row_r->usr_id)){	?>
                        <a class="ns_edit ns_margin-l10 experience_edit" href="javascript:showEditExpForm(<?php echo $row_ex->ue_id; ?>)">[<span class="ns_icon-edit"></span> edit]</a><a class="ns_edit experience_delete" id="del_experience" href="javascript:delExperience(<?php echo $row_ex->ue_id; ?>)"><span>[delete]</span></a>
						<?php } ?>
						</h3>
                        <span class="ns_right">
						<?php if($row_ex->ue_current == 1) { 
						$diff_y=date("Y")-$row_ex->ue_from_year;
						?>
                        
                        <?php echo $month[$from_month]; ?>&nbsp;<?php echo $row_ex->ue_from_year; ?> - Present <?php if($diff_y>0){ ?>(<?php echo $dif_y; ?> years)<?php } ?>
						<?php } else { 
						$dif_y=$row_ex->ue_to_year - $row_ex->ue_from_year;
						?>
						<?php echo $month[$from_month]; ?>&nbsp;<?php echo $row_ex->ue_from_year; ?> - <?php echo $month[$to_month]; ?>&nbsp;<?php echo $row_ex->ue_to_year; ?> (<?php echo $dif_y; ?> years) 
						<?php } ?>
                       
                        </span>
                        <div class="ns_clear"></div>
                        <p class="ns_italic ns_pad-10"><?php echo $row_ex->ue_company; ?></p>
                        <p class="ns_small"></p>
					</div>
				</div>
			</div>
            
            <div class="ns_edit ns_box" id="edit_experience_form_<?php echo $row_ex->ue_id; ?>" style="display:none;">
	<div id="edit_experience">
    	<form class="ns_form ns_pad" id="editExperience<?php echo $row_ex->ue_id; ?>" name="editExperience<?php echo $row_ex->ue_id; ?>" method="post" action="">
	        <input type="hidden" name="ue_id" id="ue_id_<?php echo $row_ex->ue_id; ?>" value="<?php echo $row_ex->ue_id; ?>" />
        	<div class="ns_field">
            	<div class="ns_col">	<label for="password">Title:</label>	
            	<input class="ns_half" id="ue_title_<?php echo $row_ex->ue_id; ?>" type="text" name="ue_title" value="<?php echo $row_ex->ue_title; ?>">
	            </div>
    	        <div class="ns_col">	<label for="password">Company:</label>	
        		    <input class="ns_half" id="ue_company_<?php echo $row_ex->ue_id; ?>" type="text" name="ue_company" value="<?php echo $row_ex->ue_company; ?>">
				</div>
                <div class="ns_clear"></div>
			</div>
          
			<div class="ns_field">
            	<div class="ns_col">
                	<label for="password" style="display:inline">Time Period:</label>
					<input id="ue_current_<?php echo $row_ex->ue_id; ?>" style="margin-left: 1px;" type="checkbox" name="ue_current" value="1">I currently work here<div>
                    <span id="experience_new_start_date_month_dropdown" style="margin-right:10px">
                        <select style="vertical-align:middle;width:104px;" name="ue_from_month" id="ue_from_month_<?php echo $row_ex->ue_id; ?>">
                        <option selected="selected" value="-1">Choose</option>
                        <?php for($m3=0;$m3<12;$m3++){ ?>
                            <option value="<?php echo $m3; ?>" <?php if($from_month == $m3){ ?> selected="selected"<?php } ?>><?php echo $month[$m3]; ?></option>
                        <?php } ?>
                         </select>
	            	 </span>
                     <span style="position:absolute">
			             <input class="ns_half experience-year" placeholder="Year" id="experience_start_date_year_<?php echo $row_ex->ue_id; ?>" name="ue_from_year" maxlength="4" style="width: 40px; color: grey;" type="text" value="<?php echo $row_ex->ue_from_year; ?>">
                     </span>
		             <span class="relative" style="margin-left:60px"> to </span>
                     <span id="experience_new_end_date_month_dropdown" style="margin-left:10px;margin-right:10px;">
             
			            <select style="vertical-align:middle;width:104px;" name="ue_to_month" id="ue_to_month_<?php echo $row_ex->ue_id; ?>">
            			 	<option selected="selected" value="-1">Choose</option>
			                <?php for($m4=0;$m4<12;$m4++){ ?>
			                <option value="<?php echo $m4; ?>" <?php if($m4 == $to_month){ ?> selected="selected"<?php } ?>><?php echo $month[$m4]; ?></option>
			                <?php } ?>
						</select></span><span style="position:absolute">
			            <input class="ns_half experience-year" placeholder="Year" id="experience_end_date_year_<?php echo $row_ex->ue_id; ?>" maxlength="4" style="width: 40px; color: grey;" type="text" name="ue_to_year" value="<?php echo $row_ex->ue_to_year; ?>">
	            	</span>
               	</div>
               </div>
           </div>
            <div class="ns_field"><div class="ns_field"><div class="ns_col"><label for="password">Summary:</label><textarea class="ns_full" style="height: 100px;" id="ue_summary_<?php echo $row_ex->ue_id; ?>" name="ue_summary"><?php echo $row_ex->ue_summary; ?></textarea>
             <input type="hidden" name="expEditSubmit" value="1" />
             </div></div><div class="ns_clear"></div>
             <a href="javascript:editExperienceSubmit(<?php echo $row_ex->ue_id; ?>)" class="ns_btn-small ns_blue ns_left" id="experience_edit_submit">Save</a>
             <a href="javascript:hideEditExpForm(<?php echo $row_ex->ue_id; ?>)" class="ns_btn-small ns_left" id="experience_new_cancel">Cancel</a>
             <div class="ns_clear"></div>
             </div>
             
    	</form>
	</div>
</div>
            
        <?php } ?>
		</div>
    
 </div>
            
            
<div class="ns_qualifications ns_margin-10" id="div_qualification_id"><h2 class="ns_edit">Education<span class="ns_right ns_edit"></span>
<?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row_r->usr_id)){	?>
<a href="javascript:showAdd_qualification_form()" class="ns_add ns_edit ns_right ns_margin-r15 ns_edit" id="addOne">+ Add item</a>
<?php } ?>
</h2><div id="qualifications_div"></div><div class="ns_clear"></div>
<div class="ns_edit ns_box" id="add_qualification_form"  style="display:none;">
	<div id="new_qualification">
    	<form class="ns_form ns_pad" id="qualification_form" method="post">
        	<input type="hidden" id="ued_usr_id" name="ued_usr_id" value="<?php echo $_SESSION['uid']; ?>" />
        	<div class="ns_field">
            	<div class="ns_col">
                	<label for="password">Country</label>
                    <div id="qualification_country_list">
                    <?php 
					$sql_cn="select * from country where cn_status=1 order by cn_name";
					$res_cn=mysql_query($sql_cn);
					
					?>
                    	<select id="ued_cn_id" name="ued_cn_id">
							<option value="-1">(Choose a Country)</option>
                        <?php	while($row_cn=mysql_fetch_object($res_cn))	{	?>
							<option value="<?php echo $row_cn->cn_id; ?>"><?php echo $row_cn->cn_name; ?></option>
                        <?php } ?>
                           
						</select>
                    </div>
            	</div>
			</div>
            <div class="ns_field">
            	<div class="ns_col"><label for="password">University / College:</label>
					<input class="ns_half" type="text" id="ued_institute" name="ued_institute" value="">
				</div>
			</div>
            <div class="ns_field">
            	<div class="ns_col">
                	<label for="password">Degree</label><input class="ns_half" type="text" id="ued_degree" name="ued_degree" value="">
               	</div>
            </div>
			<div class="ns_field">
            	<div class="ns_col">
                	<label for="password">Dates Attended:</label>
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
            <a class="ns_btn-small ns_blue ns_left" id="qualification_new_submit">Save</a>
            <a class="ns_btn-small ns_left" id="qualification_cancel" href="javascript:hideAdd_qualification_form()">Cancel</a>
            <div class="ns_clear"></div>

         </form>
                        </div></div>
                        
	<div class="newDiv">
    	<?php
			$sql_ed="select * from user_education where ued_usr_id='".$row_r->usr_id."' order by ued_to_year desc";
			$res_ed=mysql_query($sql_ed);
			while($row_ed=mysql_fetch_object($res_ed)) {
		?>
    	<div>
        	<div class="qualification_bg ns_bg-hover">
            	<p class="ns_left ns_bold  ns_pad-5"><?php echo $row_ed->ued_degree; ?>
                <?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row_r->usr_id)){	?>
                <a class="ns_edit ns_margin-l10 qualification_edit" href="javascript:showEdit_qualification_form(<?php echo $row_ed->ued_id; ?>)">[<span class="ns_icon-edit"></span> edit]</a><a class="ns_edit qualification_delete"  href="javascript:delEducation(<?php echo $row_ed->ued_id; ?>)"><span>[delete]</span></a>
                <?php } ?>
                </p>
                <div class="ns_clear"></div>
                <p class="ns_pad-5"></p>
                <?php
				$dur=$row_ed->ued_to_year-$row_ed->ued_from_year;
				?>
                <p class="ns_margin-25"><?php echo $row_ed->ued_from_year; ?>&nbsp;-&nbsp;<?php echo $row_ed->ued_to_year; ?>&nbsp;<?php if($dur>0){ ?>(<?php echo $dur; ?> years)<?php } ?></p>
			</div>
		</div>
        <div class="ns_edit ns_box" id="edit_qualification_form_<?php echo $row_ed->ued_id; ?>"  style="display:none;">
	<div id="new_qualification">
    	<form class="ns_form ns_pad" id="qualification_form_edit<?php echo $row_ed->ued_id; ?>" method="post">
			<input type="hidden" id="ued_id_<?php echo $row_ed->ued_id; ?>" value="<?php echo $row_ed->ued_id; ?>" />
        	<div class="ns_field">
            	<div class="ns_col">
                	<label for="password">Country</label>
                    <div id="qualification_country_list">
                    <?php 
					$sql_cn="select * from country where cn_status=1 order by cn_name";
					$res_cn=mysql_query($sql_cn);
					
					?>
                    	<select name="ued_cn_id" id="ued_cn_id_<?php echo $row_ed->ued_id; ?>">
							<option value="-1">(Choose a Country)</option>
                        <?php	while($row_cn=mysql_fetch_object($res_cn))	{	?>
							<option value="<?php echo $row_cn->cn_id; ?>" <?php if($row_cn->cn_id==$row_ed->ued_cn_id){ ?> selected="selected"<?php } ?>><?php echo $row_cn->cn_name; ?></option>
                        <?php } ?>
                           
						</select>
                    </div>
            	</div>
			</div>
            <div class="ns_field">
            	<div class="ns_col"><label for="password">University / College:</label>
					<input class="ns_half" type="text" id="ued_institute_<?php echo $row_ed->ued_id; ?>" name="ued_institute" value="<?php echo $row_ed->ued_institute; ?>">
				</div>
			</div>
            <div class="ns_field">
            	<div class="ns_col">
                	<label for="password">Degree</label><input class="ns_half" type="text" id="ued_degree_<?php echo $row_ed->ued_id; ?>" name="ued_degree" value="<?php echo $row_ed->ued_degree; ?>">
               	</div>
            </div>
			<div class="ns_field">
            	<div class="ns_col">
                	<label for="password">Dates Attended:</label>
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
            <a class="ns_btn-small ns_blue ns_left" id="qualification_edit_submit" href="javascript:editQualificationSubmit(<?php echo $row_ed->ued_id; ?>)">Save</a>
            <a class="ns_btn-small ns_left" id="qualification_cancel" href="javascript:hideEdit_qualification_form(<?php echo $row_ed->ued_id; ?>)">Cancel</a>
            <div class="ns_clear"></div>
            <input type="hidden" name="editQualification" value="1" />
         </form>
                        </div></div>
        <?php } ?>
	</div>
     <div class="ns_empty ns_box ns_add ns_edit" id="addOneA" style="display: none; "><p><a>+ Add qualification to your resume.</a></p></div>
</div>



<div class="ns_margin-10" id="div_certification_id">
	<h2 class="ns_edit">Certifications<span class="ns_right ns_edit"></span>
    <?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row_r->usr_id)){ ?>
    <a class="ns_add ns_edit ns_right ns_margin-r15 ns_edit" id="addOne" href="javascript:showAdd_certification_form()">+ Add item</a>
    <?php } ?>
    </h2>
    <div id="certifications_div"></div>
    <div class="ns_clear"></div>
	<div class="ns_edit ns_box" id="add_certification_form" style="display: none; ">
    	<div id="new_certification">
        	<form class="ns_form ns_pad" id="certification_form" method="post">
            	<input type="hidden" id="ucr_usr_id" value="<?php echo $_SESSION['uid']; ?>" />
            	<div class="ns_field">
                	<div class="ns_col">
                        <label for="password">Professional Certificate or Award</label>
                        <input class="ns_half" type="text" id="ucr_certificate" value="" name="ucr_certificate"/>
                    </div>
                    <div class="ns_col">
                        <label for="password">Conferring Organization:</label>
                        <input class="ns_half" type="text" id="ucr_organization" value="" name="ucr_organization">
                    </div>
	                <div class="ns_clear"></div>
				</div>
                <div class="ns_field">
                	<div class="ns_col">
                    	<label for="password">Year Awarded/Received</label>
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
                	<div class="ns_col">
                    	<label for="password">Describe Certification:</label>
                        <textarea class="ns_full" style="height:100px;" id="ucr_description" name="ucr_description"></textarea>
					</div>
				</div>
                <div class="ns_clear"></div>
                <a class="ns_btn-small ns_blue ns_left" id="certification_new_submit">Save</a>
                <a class="ns_btn-small ns_left" id="certification_cancel" href="javascript:hideAdd_certification_form()">Cancel</a>
                <div class="ns_clear"></div>

			</form>
		</div></div>
        
        <div class="newDiv">
        <?php
			$sql_crt="select * from user_certification where ucr_usr_id='".$row_r->usr_id."' order by ucr_year desc";
			$res_crt=mysql_query($sql_crt);
			while($row_crt=mysql_fetch_object($res_crt)) {
		?>
        	<div>
            	<div class="certification_bg ns_bg-hover">
                	<p class="ns_left ns_bold  ns_pad-5"><?php echo $row_crt->ucr_certificate; ?>
                    <?php if(isset($_SESSION['uid']) && ($_SESSION['uid']==$row_r->usr_id)){ ?>
                    <a class="ns_edit ns_margin-l10 certification_edit" href="javascript:showEdit_certification_form(<?php echo $row_crt->ucr_id; ?>)">[<span class="ns_icon-edit"></span> edit]</a><a class="ns_edit certification_delete" href="javascript:delCertification(<?php echo $row_crt->ucr_id; ?>)"><span>[delete]</span></a>
                    <?php } ?>
                    </p>
                    <div class="ns_clear"></div>
                  	<p class="ns_pad-5"><?php echo $row_crt->ucr_organization; ?>&nbsp;<?php echo $row_crt->ucr_year; ?></p>
                    <p class="ns_margin-25 ns_small"><?php echo $row_crt->ucr_description; ?></p>
                 </div>
			</div>
            
            <div class="ns_edit ns_box" id="edit_certification_form_<?php echo $row_crt->ucr_id; ?>" style="display: none; ">
    	<div id="new_certification">
        	<form class="ns_form ns_pad" id="edit_certification_form<?php echo $row_crt->ucr_id; ?>" method="post">
            	<input type="hidden" name="ucr_id" id="ucr_id_<?php echo $row_crt->ucr_id; ?>" value="<?php echo $row_crt->ucr_id; ?>" />
            	<div class="ns_field">
                	<div class="ns_col">
                        <label for="password">Professional Certificate or Award</label>
                        <input class="ns_half" type="text" id="ucr_certificate_<?php echo $row_crt->ucr_id; ?>" name="ucr_certificate" value="<?php echo $row_crt->ucr_certificate; ?>" />
                    </div>
                    <div class="ns_col">
                        <label for="password">Conferring Organization:</label>
                        <input class="ns_half" type="text" id="ucr_organization_<?php echo $row_crt->ucr_id; ?>" name="ucr_organization" value="<?php echo $row_crt->ucr_organization; ?>" >
                    </div>
	                <div class="ns_clear"></div>
				</div>
                <div class="ns_field">
                	<div class="ns_col">
                    	<label for="password">Year Awarded/Received</label>
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
                	<div class="ns_col">
                    	<label for="password">Describe Certification:</label>
                        <textarea class="ns_full" style="height:100px;" id="ucr_description_<?php echo $row_crt->ucr_id; ?>" name="ucr_description"><?php echo $row_crt->ucr_description; ?></textarea>
					</div>
				</div>
                <div class="ns_clear"></div>
                <a class="ns_btn-small ns_blue ns_left" id="certification_edit_submit" href="javascript:editCertificationSubmit(<?php echo $row_crt->ucr_id; ?>)">Save</a>
                <a class="ns_btn-small ns_left" id="certification_cancel" href="javascript:hideEdit_certification_form(<?php echo $row_crt->ucr_id; ?>)">Cancel</a>
                <div class="ns_clear"></div>
                <input type="hidden" name="editCertification" value="1" />
			</form>
		</div></div>
            
            
            <?php } ?>

        </div>
   
        <div class="ns_empty ns_box ns_add ns_edit" id="addOneA" style="display:none;"><p><a>+ Add certification to your resume.</a></p></div>
</div>

<link href="css/jquery.css" rel="stylesheet" type="text/css">
<link href="css/jquery-ui-1_002.css" rel="stylesheet" type="text/css">