<?php
ob_start();
session_start();
include "common.php";


$prj_id=$_GET['p'];

$_SESSION['last_page']="project-edit.php?p=".$prj_id;

$sql="select * from project,subcategory,category where prj_scat_id=scat_id and scat_cat_id=cat_id and prj_id='".$prj_id."'";
$res=mysql_query($sql);
$row=mysql_fetch_object($res);


class editProject{

	var $msg;
	var $prj_id;
	var $cat_id;
	var $prj_scat_id;
	var $skills;
	var $currentDescr;
	var $prj_details;
		
	
/*	function __construct( $prj_id, $cat_id, $prj_scat_id, $skills, $currentDescr, $prj_details)
	{
		$this->prj_id=$prj_id;
		$this->cat_id=$cat_id;
		$this->prj_scat_id=$prj_scat_id;
		$this->skills=$skills;
		$this->currentDescr=$currentDescr;
		$this->prj_details=$prj_details;
	}*/
	
	function valid()
	{
		$valid=true;
		
		//$ext = substr($this->prj_file, strpos($this->prj_file,'.'), strlen($this->prj_file)-1);

		if($this->cat_id == "0")
		{
			$this->msg= '<font color="#CC0000">Please select category.</font>';
			$valid=false;
		}
		else if($this->prj_scat_id == "")
		{
			$this->msg= '<font color="#CC0000">Please select sub category.</font>';
			$valid=false;
		}
		else if($this->skills == "")
		{
			$this->msg= '<font color="#CC0000">Please select atleast one skill.</font>';
			$valid=false;
		}
		return $valid;
	}
	
	function add()
	{	
		$validity=get_page_settings(6);

		$sql="update project
					set	
						prj_scat_id ='".$this->prj_scat_id."',								
						prj_details ='".$this->currentDescr.$this->prj_details."',
						prj_status ='open',
						prj_updated_date=now()
					where
						prj_id ='".$this->prj_id."'";
					
		mysql_query($sql) or die(mysql_error());
		
		$sk_id_arr=array();
		$sk_id_arr=explode(",",$this->skills);

		mysql_query("delete from project_skill where ps_prj_id='".$prj_id."'");
		
		foreach($sk_id_arr as $sk_id)
		{
			if($sk_id != '')
			{
				$sql_ps="insert into project_skill
				set					
					ps_prj_id ='".$this->prj_id."',									
					ps_sk_id ='".$sk_id."'";
				mysql_query($sql_ps);
			}
		}
				
															
		$this->msg='<font color="#009900">Project upadated successfully</font>';	

		unset($_SESSION['cat_id']);
		unset($_SESSION['prj_scat_id']);
				
		unset($_SESSION['prj_details']);
		
		$total=0;
		$j=-1;
		$pp=array();
		
		for($i=1; $i<=$this->total_pp; $i++)
		{
			if(isset($_POST['chkbx_pp_'.$i]))
			{
				$j++;
				$pp[$j]=$i;
				$total=$total+$_POST['pp_amount_'.$i];
			}
		}
		if($j>=0)
		{
			$_SESSION['pp']=$pp;
			$_SESSION['tot_pp_amt']=$total;
			$_SESSION['lst_prj']=$prj_id;
		}

	}	
}

if(isset($_POST['updProject']))
{
	
	$skills="";
	foreach($_POST['prj_skills'] as $val)
	{
		$skills.=$val.",";
	}
	

	$adn=new editProject();
	$adn->prj_id=addslashes(trim($_POST['prj_id']));
	$adn->cat_id=addslashes(trim($_POST['cat_id']));
	$adn->prj_scat_id=addslashes(trim($_POST['prj_scat_id']));
	$adn->skills=$skills;
	$adn->currentDescr=addslashes(trim($_POST['currentDescr']));
	$adn->prj_details=addslashes(trim($_POST['prj_details']));
	$adn->total_pp=addslashes(trim($_POST['total_pp']));
	
	$_SESSION['cat_id']=$adn->cat_id;
	$_SESSION['prj_scat_id']=$adn->prj_scat_id;
	$_SESSION['prj_details']=$adn->prj_details;

	if($adn->valid())
	{
		$adn->add();		
		$_SESSION['msg']=$adn->msg;
		header("location:post-project-res.php?p=".$adn->prj_id);
	}
	else
	{
		$_SESSION['msg']=$adn->msg;
		header("location:project-edit.php?p=".$adn->prj_id);
	}
	//echo $ecms->msg;
//	$_SESSION['msg']=$adn->msg;

}

?>
   	<?php include "includes/header.php"; ?>
    <script language="javascript">
function showSubcat(str)
{
	//$.noConflict();

	$.get("showSubcat.php",  {q:str},    function(data){     $('#prj_scat_id').html(data);  });
	$('#prj_scat_id').show();
}
</script>
	<div class="ns_clear"></div>
	<div class="grid">
	<div class="clear"></div>
<div class="c9d-space"></div>
 
<ul class="c9d-tab">
<!--
<li><a class="hover" href="">Open</a></li>
<li><a href="">Active</a></li>
<li><a href="">Closed</a></li>
<li><a href="">Rate Freelancers</a></li>
	<div class="c9d-pros">-->

</ul>
<div class="c9d-tabcnt">

<table cellpadding="10" cellspacing="20">

        
          <tbody><tr><td valign="top">
            <table width="850" border="0" cellpadding="0" cellspacing="5">
              <tbody><tr>
                <td>
                <!-- hide post a project button on top -->


<link rel="stylesheet" href="css/jquery.css" type="text/css">
<link rel="stylesheet" href="css/postproject_style.css" type="text/css">
<link rel="stylesheet" href="css/gaf_style_new.css" type="text/css">

<a name="projectNameSec"></a>
<div class="clear"></div>
<div class="c9d-space"></div>


    <h1>Edit Project</h1>
	<br>
    
    <form id="createform" name="createform" action="" method="post" enctype="multipart/form-data">
    
	
<div id="divProjectName">
	<input type="hidden" id="prj_id" name="prj_id" value="<?php echo $prj_id; ?>"/>
	<label for="projectName">Project Name:</label>&nbsp;<span id="proj-name-err" class="err-msg">Please input a project name (at least 10 characters)</span><br>
	<input value="<?php echo $row->prj_name; ?>" size="45" maxlength="60" name="prj_name" class="projectFormTextField big-textbox" disabled="disabled" type="text">&nbsp;
	<span id="proj-name-hint" class="hint">Your project name is important as it is what attracts freelancers to bid on your project. You should clearly describe what you need in as few words as possible.<span class="hint-pointer">&nbsp;</span></span>
</div>
<div class="clear"></div>
<br>
<br>
<a name="skillsSec"></a>

	<label for="category">What work do you require? </label><i style="font-size:14px">(Select at least 1 skill) </i>
	
	<div style="clear:both"></div>
<div style="margin-top: 10px" class="projectUserLeftColumn">
	<!--<select class="select_menu" style="width: 381px;padding: 4px; margin: 4px 4px 4px 0px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border: 2px solid rgb(217, 217, 217); font-size: 14px; " id="skill_category"><option value="1">Websites IT &amp; Software</option><option value="2">Mobile</option><option value="3">Writing</option><option value="4">Design</option><option value="5">Data Entry</option><option value="6">Product Sourcing &amp; Manufacturing</option><option value="7">Sales &amp; Marketing</option><option value="8">Business, Accounting &amp; Legal</option><option value="-1">Customized (Select skills manually)</option><option selected="selected" value="-1">Select a category of work (Optional)</option></select>-->
    <?php
		$sql_cat="select * from category where cat_status=1 order by cat_name";
		$res_cat=mysql_query($sql_cat);
	?>
    <select id="cat_id" class="span6" name="cat_id" onChange="showSubcat(this.value)">
		<option value="0">Select Category</option>
	<?php while($row_cat=mysql_fetch_object($res_cat)) { ?>
        <option value="<?php echo $row_cat->cat_id; ?>" <?php if($row_cat->cat_id == $row->cat_id){ ?> selected="selected" <?php } ?> ><?php echo ucfirst($row_cat->cat_name); ?></option>
    <?php } ?>
    </select>
    <select id="prj_scat_id" class="span6" name="prj_scat_id">
		<option value="0">Select Sub-Category</option>
        <?php
        	$sql_scat="select * from subcategory where scat_cat_id='".$row->prj_scat_id."'"; 
			$res_scat=mysql_query($sql_scat);
			while($row_scat=mysql_fetch_object($res_scat)){
		?>
        <option value="<?php echo $row_scat->scat_id; ?>" <?php if($row_scat->scat_id == $row->prj_scat_id){ ?> selected="selected" <?php } ?> ><?php echo ucfirst($row_scat->scat_name); ?></option>
        <?php	}	?>
	</select>
</div>

<div class="clear"></div>

<div id="divSkillsCategory" style="margin-top: 5px;">
	Select skills:
	<br>
	<?php
		$sql_sk="select * from skills where sk_status=1";
		$res_sk=mysql_query($sql_sk);
		
		$sql_psk="select * from project_skill where ps_prj_id='".$row->prj_id."'";
		$res_psk=mysql_query($sql_psk);
		
		$p_sk=array();
		$x=-1;
		while($row_psk=mysql_fetch_object($res_psk))
		{
			$x++;
			$p_sk[$x]=$row_psk->ps_sk_id;
		}

		function actSkill($a)
		{
			for($x=0;$x<count($p_sk);$x++)
			{
				if($a == $p_sk[$x])
				{
					return true;	
				}
			}
			return false;
		}

	?>
	<select multiple="multiple" id="prj_skills" name="prj_skills[]" placeholder="Start typing to see list..." style="width: 440px;">
    <?php while($row_sk=mysql_fetch_object($res_sk)) { ?>
    	<option value="<?php echo $row_sk->sk_id; ?>" <?php if(actSkill($row_sk->sk_id)==true){?> selected="selected" <?php } ?> ><?php echo $row_sk->sk_name; ?></option>                            
	<?php } ?>
    </select>
                            
	
 </div>



<div class="clear"></div>
<br><br>


<label for="projectDetails">Existing Description:</label>
<br><br>
<textarea name="currentDescr" rows="10" style="width: 764px; background-color: rgb(217, 217, 217);" class="projectFormTextField" readonly="readonly">
<?php echo $row->prj_details; ?>
</textarea>
<br>

<br>
<br>
This information will be displayed under your original description with the date and time you submitted it.
Freelancers who have bid on your project will be notified of the change by e-mail.
<br><br>

<a name="descriptionSec"></a>
<div id="divProjectDescription">
	<table width="767" border="0">
		<tbody><tr>
			<td width="460"><label for="projectDetails">Add to Existing Description:</label>
			
			</td><td align="right"></td>
		</tr>
		
		<tr>
			<td colspan="2">
			<div style="width:790px;margin-bottom:15px;">
			<textarea style="width: 764px;" name="prj_details" id="prj_details" rows="13" class="projectFormTextField"></textarea>&nbsp;
			<span style="display: none;" id="proj-descr-hint" class="hintRC">The more detail you provide, the better chance you have in getting exactly what you are after in the shortest possible time period.<span class="hint-pointerRC">&nbsp;</span></span>
			</div>
			</td>
		</tr>
        <tr>
			<td colspan="2" class="projectDescriptionWarning" height="20"><strong>IMPORTANT!</strong> You're not allowed to post any contact information on <?php echo get_page_settings(4);?>.</td>
		</tr>
		
        </tbody></table>
        <div class="horizontalLine"></div>
        <table width="767" border="0">
	<tbody><tr>
                        <td width="215">
                            
                            <div class="divProjectUploadBox">

	<div style="display: none;" id="upload_ProgressBar" class="ProgressBar"><div>&nbsp;</div></div>
	<div style="display: none;" id="upload_uploading"><span>Uploading... <span id="upload_percentage"></span></span><input style="vertical-align: middle; margin: 0pt 0pt 0pt 15px; width: 60px; height: 25px;" value="Cancel" type="button"></div>
	<select class="uploadFileSelectList" id="project_files" name="project_files[]" multiple="multiple" size="5" style="display:none;">
	
	</select>
</div>
<div class="clear"></div>
<ul id="upload_completedMessagePool">
	
</ul>
<div class="clear"></div>
                        </td>
		</tr>
	</tbody></table>
</div>

<div class="horizontalLine"></div>


<br>
	<!--<link rel="stylesheet" href="//cdn2.f-cdn.com/css/postproject_style.css?9&v=d07f6b3c46d475b561e06da452ecb387" type="text/css" />-->

<div class="control-group">
	<label class="control-label" for="project_upgrades">Promote your listing (Optional):</label>
    	<div class="controls">
	    	<ul class="upgrades">
	        <?php
				$sql_ppo="select * from project_promotion_option where ppo_prj_id='".$prj_id."'";
				$res_ppo=mysql_query($sql_ppo);
				$act_ppo=array();
				$x=-1;
				while($row_ppo=mysql_fetch_object($res_ppo))
				{
					$x++;
					$act_ppo[$x]=$row_ppo->ppo_pp_id;
				}
				
			
				$sql_pp="select * from project_promotion where pp_status='1' order by pp_id";
				$res_pp=mysql_query($sql_pp);
				$pp=0;
				while($row_pp=mysql_fetch_object($res_pp)){
			?>
           		<li class="project_upgrades">
           			<div class="pad">
                    <?php	if(in_array($row_pp->pp_id,$act_ppo)){	?>
                    
               			<input id="nonpublic" class="project_upgrades" type="checkbox" checked="checked" disabled="disabled"/>
                        <span class="upgrade"><strong><?php echo stripslashes(strtoupper($row_pp->pp_name)); ?></strong></span> 
                        <p><?php echo $row_pp->pp_dispText; ?></p>
                        <span id="nonpublic_price" class="price nonpublic_price"><?php echo getCurrencySymbol(); ?>&nbsp;<?php echo number_format($row_pp->pp_amount,2); ?></span>
                        <div class="clear"></div>
                    
							
					<?php	}else{	
							
					?>
               			<input id="nonpublic" class="project_upgrades" name="chkbx_pp_<?php echo $row_pp->pp_id; ?>" type="checkbox"/>
                        <span class="upgrade"><strong><?php echo stripslashes(strtoupper($row_pp->pp_name)); ?></strong></span> 
                        <p><?php echo $row_pp->pp_dispText; ?></p>
                        <span id="nonpublic_price" class="price nonpublic_price"><?php echo getCurrencySymbol(); ?>&nbsp;<?php echo number_format($row_pp->pp_amount,2); ?></span>
                        <input type="hidden" name="pp_amount_<?php echo $row_pp->pp_id; ?>" value="<?php echo $row_pp->pp_amount; ?>"/>
                        <div class="clear"></div>
                     <?php		}		 ?>
           			</div>                    			
           		</li> 
       		<?php 
					$pp++;
				} ?>
                <input type="hidden" name="total_pp" id="total_pp" value="<?php echo $pp; ?>"/>
           	</ul>
		</div>
</div>

<style>
	.btn_submit {background-image: url("/img/buttons/btn_submit.png");width:156px; height: 38px;	display: block;	cursor: pointer;}
	.btn_submit:hover {		background-image: url("/img/buttons/btn_submit.png");		background-position:right top;	}
</style>

<!--<br>
<div id="no_upgrade" style="padding-left:5px;">
<br><p><strong>Your project will be reviewed by staff before it goes live.</strong></p>
</div>-->

<div class="clear"></div>
<br>
<br>

<!--<a class="ns_btn ns_blue" id="btn-preview-project" style="text-decoration: none;"><span>Update my Project �</span></a>-->
<input type="submit" name="updProject" value="Update my Project �" class="ns_btn ns_blue" id="btn-preview-project"/>
<div class="clear"></div>
        
    </form>

<div id="mask"></div>
<div class="modal-dialog ui-draggable">
	<img id="btn-modal-dialog-close" src="images/icon_close.png">
	<div id="modal-dialog-content">
		<div class="modal-dialog-head">
	<h4>All Skills</h4>
</div>
<div class="modal-dialog-body">
<h5 style="font-family:Helvetica, Arial, sans-serif;">Click to expand</h5>
<ul id="all-data-list">
<li class="data-item" id="5-data-item"><div class="icon-skill-chosen"></div></li>
</ul>
</div>


	</div>
</div>


<div class="clear"></div>
<div class="clear"></div>
<script src="images/postproject-event-sk.js" type="text/javascript"></script>

                </td>
              </tr>
            </tbody></table>
          </td>
        </tr>
      </tbody></table>

</div>

	</div>
	<div class="pg-bottom-text">
	<?php echo get_page_content('3'); ?>
	
</div>
</div>
</div>
<?php include "includes/footer.php"; ?>
	
