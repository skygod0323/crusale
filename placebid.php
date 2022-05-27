<?php
ob_start();
session_start();
include "common.php";

$prj_id=$_GET['p'];
$_SESSION['p']=$prj_id;
//$_SESSION['last_page']="placebid.php?p=".$prj_id;

if($_SESSION['uid']=='')
{
	header("location:login.php");	
}

if(isset($_SESSION['bd_amount'])){	$bd_amount=$_SESSION['bd_amount'];	unset($_SESSION['bd_amount']); }else{ $bd_amount=""; }
if(isset($_SESSION['bd_days'])){	$bd_days=$_SESSION['bd_days'];	unset($_SESSION['bd_days']); }else{ $bd_days=""; }
if(isset($_SESSION['bd_milestone'])){	$bd_milestone=$_SESSION['bd_milestone'];	unset($_SESSION['bd_milestone']); }else{ $bd_milestone=""; }
if(isset($_SESSION['bd_details'])){	$bd_details=$_SESSION['bd_details'];	unset($_SESSION['bd_details']); }else{ $bd_details=""; }


$sql="select * from project,project_budget where prj_id=pb_prj_id and prj_id='".$prj_id."'";
//echo $sql;
$res=mysql_query($sql);
$row=mysql_fetch_object($res);
//echo $row->pb_minprice;

class addBid{

	var $msg;
	var $bd_prj_id;
	var $bd_usr_id;
	var $bd_amount;
	var $bd_days;
	var $bd_milestone;
	var $bd_details;
	var $msg_message;
	var $privatemsg;
      var $msg_to;
	var $total_bo;
	
	function __construct($bd_prj_id, $bd_usr_id, $bd_amount, $min_bid_amt, $bd_days, $bd_milestone, $bd_details, $msg_message, $privatemsg, $msg_to, $total_bo) 
	{
		$this->bd_prj_id=$bd_prj_id;
		$this->bd_usr_id=$bd_usr_id;
		$this->bd_amount=$bd_amount;
		$this->min_bid_amt=$min_bid_amt;
		$this->bd_days=$bd_days;
		$this->bd_milestone=$bd_milestone;
		$this->bd_details=$bd_details;
		$this->msg_message=$msg_message;
		$this->privatemsg=$privatemsg;
            $this->msg_to=$msg_to;
		$this->total_bo=$total_bo;
		
		$_SESSION['lst_prj']=$this->bd_prj_id;
		$_SESSION['bd_amount']=$this->bd_amount;
		$_SESSION['min_bid_amt']=$this->min_bid_amt;
		$_SESSION['bd_days']=$this->bd_days;
		$_SESSION['bd_milestone']=$this->bd_milestone;
		$_SESSION['bd_details']=$this->bd_details;
		$_SESSION['msg_message']=$this->msg_message;
		$_SESSION['privatemsg']=$this->privatemsg;
	}
	function checkPreviousBid()
	{
		$sql="select * from bid where bd_prj_id ='".$this->bd_prj_id."' and bd_usr_id ='".$this->bd_usr_id."'";
		$res=mysql_query($sql);
		if(mysql_num_rows($res)>0)
		{
			return 1;	
		}
		else
		{
			return 0;	
		}
	}

	function valid()
	{
          include "language.php";
		$valid=true;

		if($this->bd_amount == "0" || $this->bd_amount == "")
		{
			$this->msg= '<font color="#CC0000">'.$lang[173].'</font>';
			$valid=false;
		}
		else if($this->bd_amount < $this->min_bid_amt)
		{
			$this->msg= '<font color="#CC0000">'.$lang[174].$this->min_bid_amt.'.</font>';
			$valid=false;
		}
		else if($this->bd_days == "" || $this->bd_days == $lang[191])
		{
			$this->msg= '<font color="#CC0000">'.$lang[175].'</font>';
			$valid=false;
		}
		else if($this->bd_milestone == "")
		{
			$this->msg= '<font color="#CC0000">'.$lang[176].'</font>';
			$valid=false;
		}
		else if($this->bd_details == "")
		{
			$this->msg= '<font color="#CC0000">'.$lang[177].'</font>';
			$valid=false;
		}
		else if($this->privatemsg == "1" && $this->msg_message == "")
		{
			$this->msg= '<font color="#CC0000">'.$lang[178].'</font>';
			$valid=false;
		}
		else if($this->checkPreviousBid()==1)
		{
			$valid=false;	
		}
		
		return $valid;
	}
	
	function add()
	{
          include "language.php";
		  
		$sql="insert into bid
			set					
				bd_prj_id ='".$this->bd_prj_id."',	
				bd_usr_id ='".$this->bd_usr_id."',									
				bd_date =now(),								
				bd_amount ='".$this->bd_amount."',
				bd_days ='".$this->bd_days."',
				bd_milestone ='".$this->bd_milestone."',
				bd_details ='".$this->bd_details."'";
			
		mysql_query($sql) or die(mysql_error());
		mysql_query("update user set usr_left_bid=usr_left_bid-1 where usr_id='".$this->bd_usr_id."'");
		
		$sql_us="select * from user where usr_id='".$_SESSION['uid']."'";
		$res_us=mysql_query($sql_us);
		$row_us=mysql_fetch_object($res_us);
		
		$sql_empl="select * from user where usr_id=(select prj_usr_id from project where prj_id='".$this->bd_prj_id."')";
		$res_empl=mysql_query($sql_empl);
		$row_empl=mysql_fetch_object($res_empl);
		
		/******* Code for notification start here *********/
		$resp=mysql_query("select * from project where prj_id='".$this->bd_prj_id."'");
		$rowp=mysql_fetch_object($resp);
		
		
		$sql_un="insert into user_notification
		set
			un_usr_id='".$row_empl->usr_id."',
			un_from_usr_id='".$_SESSION['uid']."',
			un_type='bidplaced',
			un_content='".$row_us->usr_name.$lang[817].$rowp->prj_name.$lang[818].getCurrencySymbol().$this->bd_amount."',
			un_prj_id='".$this->bd_prj_id."',
			un_updated_date=now()";
			
		mysql_query($sql_un);
		
		
		/******* Code for notification end here *********/
		
		
		/**** code for email sending start here ****/
			
		$sqlemail="select * from admin_user where id='1'";
		$resemail=mysql_query($sqlemail);
		$rowemail=mysql_fetch_object($resemail);
		
        $chk_es_sql="select * from user_email_setting where ues_usr_id='".$row_us->usr_id."' and ues_es_id='1'";	//mail sending to freelancer
		
        $chk_es_res=mysql_query($chk_es_sql);
        if(mysql_num_rows($chk_es_res)>0)
        {
            
			include "email/placebid.php"; //email design with content included
	
			/*$comment1='<div style="border:1px solid #999999; width:660px;float:left; padding-bottom:0px;">
			<div style="width:650px;height:100px; padding-bottom:0;">
				'.$lang[271].$rowp->prj_name.$lang[272].'		
			</div></div>';*/

			$from_mail=$rowemail->email;
            $to=$row_us->usr_email; 	

			$subj=$lang[662];
			$headers  = "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\n";
			$headers .= 'From: '.$from_mail.'';	
		
			mail($to,$subj,$comment1,$headers);
		}
		
		/** mail sending to employer **/
		
		include "email/placebid.php"; //email design with content included
		
		/*$comment2='<div style="border:1px solid #999999; width:660px;float:left; padding-bottom:0px;">
		<div style="width:650px;height:100px; padding-bottom:0;">
			'.$row_us->usr_name.$lang[817].$rowp->prj_name.$lang[818].getCurrencySymbol().$_SESSION['bd_amount'].'		
		</div></div>';*/

		$from_mail=$rowemail->email;
        $to=$row_empl->usr_email; 	

		$subj=$lang[819];
		$headers  = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= 'From: '.$from_mail.'';	
		
		mail($to,$subj,$comment2,$headers);
		
		/**** code for email sending end here ****/
		
		
		if($this->privatemsg == "1")
		{
			if($_FILES['msg_file']["name"] != '')
			{
				if ($_FILES["msg_file"]["error"] > 0)
				{
					$this->msg = "<font color='#CC0000'>".$lang[179].$_FILES["msg_file"]["error"] . "</font><br />";
					$this->msg = "<font color='#CC0000'>s".$lang[180]."</font><br /><br />";
				}
				else
				{	
					$msg_file='msg-'.rand(0,9999).trim(addslashes($_FILES['msg_file']['name']));	
				    
					$ds = move_uploaded_file($_FILES["msg_file"]["tmp_name"], "upload/message/".$msg_file) or die('error');
				
					if($ds)
					{
						$sql="insert into message
						set	
							msg_from ='".$_SESSION['uid']."',
							msg_to ='".$this->msg_to."',
							msg_prj_id ='".$this->bd_prj_id."',
							msg_message ='".$this->msg_message."',
							msg_file ='".$msg_file."',
							msg_date =now()";
							
						mysql_query($sql) or die(mysql_error());
                                    
           /**** code for email sending start here ****/
		
            $chk_es_sql="select * from user_email_setting where ues_usr_id='".$this->msg_to."' and ues_es_id='2'";
            $chk_es_res=mysql_query($chk_es_sql);
            if(mysql_num_rows($chk_es_res)>0)
            {
            
				$sqlemail="select * from admin_user where id='1'";
				$resemail=mysql_query($sqlemail);
				$rowemail=mysql_fetch_object($resemail);
            
		        $sql_us="select * from user where usr_id='".$this->msg_to."'";
				$res_us=mysql_query($sql_us);
				$row_us=mysql_fetch_object($res_us);
		
				include "email/placebid.php"; //email design with content included
		
				/*$comment3='<div style="border:1px solid #999999; width:660px;float:left; padding-bottom:0px;">
				<div style="width:650px;height:100px; padding-bottom:0;">'.$lang[664].'</div></div>';*/


				$from_mail=$rowemail->email;
        		$to=$row_us->usr_email; 	

		        $subj=$lang[663];
        		$headers  = "MIME-Version: 1.0\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\n";
				$headers .= 'From: '.$from_mail.'';	
		
				mail($to,$subj,$comment3,$headers);
            }
		/**** code for email sending end here ****/
						
					}
				}
			}
			else
			{
                     
				$sql_m="insert into message
					set	
					msg_from ='".$_SESSION['uid']."',
					msg_to ='".$this->msg_to."',
					msg_prj_id ='".$this->bd_prj_id."',
					msg_message ='".$this->msg_message."',
					msg_date =now()";
				mysql_query($sql_m);
                        
                        /**** code for email sending start here ****/
		
            $chk_es_sql="select * from user_email_setting where ues_usr_id='".$this->msg_to."' and ues_es_id='2'";
            $chk_es_res=mysql_query($chk_es_sql);
            if(mysql_num_rows($chk_es_res))
            {
            
		$sqlemail="select * from admin_user where id='1'";
		$resemail=mysql_query($sqlemail);
		$rowemail=mysql_fetch_object($resemail);
            
            $sql_us="select * from user where usr_id='".$this->msg_to."'";
		$res_us=mysql_query($sql_us);
		$row_us=mysql_fetch_object($res_us);
		
		include "email/placebid.php"; //email design with content included
		
		/*$comment4='<div style="border:1px solid #999999; width:660px;float:left; padding-bottom:0px;">
		<div style="width:650px;height:100px; padding-bottom:0;">'.$lang[664].'</div></div>';*/


		$from_mail=$rowemail->email;
            $to=$row_us->usr_email; 	

           $subj=$lang[663];
           $headers  = "MIME-Version: 1.0\n";
	       $headers .= "Content-type: text/html; charset=iso-8859-1\n";
           $headers .= 'From: '.$from_mail.'';	
		
		mail($to,$subj,$comment4,$headers);
            }
		/**** code for email sending end here ****/
				

			}
		}
		
		$res_bd=mysql_query("select max(bd_id) from bid where bd_prj_id='".$this->bd_prj_id."'");
		$row_bd=mysql_fetch_array($res_bd);
		
		$total=0;
		$j=-1;
		$bo=array();
		for($i=1; $i<=$this->total_bo; $i++)
		{
			if(isset($_POST['bo_id_'.$i]))
			{
				$j++;
				$bo[$j]=$i;
				$total=$total+$_POST['bo_amount_'.$i];
				
				/*if($i=='1'){
					$sql_upd="update bid set bd_uplift='1' where bd_id='".$row_bd[0]."'";
					mysql_query($sql_upd);
				}
				else if($i=='2')
				{
					$sql_upd="update bid set bd_highlight='1' where bd_id='".$row_bd[0]."'";
					mysql_query($sql_upd);
				}*/
			}
		}
		if($j>=0)
		{
			$_SESSION['bd_amount']=$this->bd_amount;
			$_SESSION['bo']=$bo;
			$_SESSION['tot_bo_amt']=$total;
			$_SESSION['lst_bd']=$row_bd[0];
			
		}
													
		$this->msg='<font color="#009900">'.$lang[181].'</font>';		
		
		unset($_SESSION['bd_amount']);
		unset($_SESSION['bd_days']);
		unset($_SESSION['bd_milestone']);
		unset($_SESSION['bd_details']);
		unset($_SESSION['msg_message']);
		unset($_SESSION['privatemsg']);
	}	
}

if(isset($_SESSION['msg'])){
	$msg=$_SESSION['msg'];
	unset($_SESSION['msg']);
}

if(isset($_POST['submitBid']))
{
    
    if(isset($_POST['privatemsg']))
    {
        $p_msg="1";
    }
    else
    {
        $p_msg="0";
    }

	$adn=new addBid($_POST['bd_prj_id'], addslashes(trim($_POST['bd_usr_id'])), addslashes(trim($_POST['bd_amount'])), addslashes(trim($_POST['min_bid_amt'])), addslashes(trim($_POST['bd_days'])), addslashes(trim($_POST['bd_milestone'])), addslashes(trim($_POST['bd_details'])), addslashes(trim($_POST['msg_message'])), $p_msg, addslashes(trim($_POST['msg_to'])), addslashes(trim($_POST['total_bo'])));

	if($adn->valid())
	{	
		$adn->add();
		header("location:bidplaced.php");
	}
	else
	{
		//echo $ecms->msg;
		$_SESSION['msg']=$adn->msg;
		header("location:placebid.php?p=".$prj_id);
	}
}

?>
		<?php include "includes/header.php"; ?>

<script language="javascript">
function togglePrivateMsg() {
    if ($('#privatemsg').is(':checked')) {
        $('#privatemsgForm').slideDown('slow');
    } else {
        $('#privatemsgForm').slideUp('slow');
    }
}
</script>
<script type="text/javascript">
function validPlacebid()
{
    var bd_amount = document.getElementById('bd_amount');
	var min_bid_amt = document.getElementById('min_bid_amt');
	var bd_days = document.getElementById('bd_days');	
	var bd_milestone = document.getElementById('bd_milestone');	
	var bd_details = document.getElementById('bd_details');	
	var privatemsg = document.getElementById('privatemsg');	
	var msg_message = document.getElementById('msg_message');	

	
	var msg="";
	var valid=true;	
	
	if (bd_amount.value == "" || bd_amount.value == null)
    {
		msg='<?php echo $lang[173]; ?>';
		bd_amount.value="";
        bd_amount.focus();
        valid = false;		
    }  
    else if (isNaN(bd_amount.value))
    {
		msg='<?php echo $lang[242]; ?>';
		bd_amount.value="";
            bd_amount.focus();
            valid = false;		
    }  
	else if (parseInt(bd_amount.value) < parseInt(min_bid_amt.value))
    {
		msg='<?php echo $lang[174]; ?>'+min_bid_amt.value+'.';
		bd_amount.value="";
        bd_amount.focus();
        valid = false;		
    }
	else if (bd_days.value == "" || bd_days.value == null || bd_days.value == '<?php echo $lang[191]; ?>')
    {
		msg='<?php echo $lang[175]; ?>';
		bd_days.value="";
        bd_days.focus();
        valid = false;		
    }
	else if (isNaN(bd_days.value))
    {
		msg='<?php echo $lang[183]; ?>';
		bd_days.value="";
        bd_days.focus();
        valid = false;		
    }
	else if(bd_milestone.value == "" || bd_milestone.value == null)
	{
		msg='<?php echo $lang[176]; ?>';
		bd_milestone.value="";
        bd_milestone.focus();
        valid = false;
	}
      else if(isNaN(bd_milestone.value))
	{
		msg='<?php echo $lang[676]; ?>';
		bd_milestone.value="";
        bd_milestone.focus();
        valid = false;
	}
	else if(bd_details.value == "" || bd_details.value == null)
	{
		msg='<?php echo $lang[177]; ?>';
		bd_details.value="";
        bd_details.focus();
        valid = false;
	}
//	document.getElementById(custId).checked == true
	else if((privatemsg.checked == true) && (msg_message.value == ""))
	{
		msg='<?php echo $lang[184]; ?>';
		msg_message.value="";
        msg_message.focus();
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
            <div class="section wb">
                <div class="container">
	<div><h2 class="header-txt1-style align-center-txt"><?php echo $lang[185]; ?><?php echo $row->prj_name; ?></h2></div>
    
    <div class="row">
		<div class="col-xs-12">
		<form id="frm_place_bid" action="" method="post" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal" onSubmit="return validPlacebid();">
		
        
			<div class="signup-form-str">
            	<div style="float:right;background-color:#9ED3FE;border: 1px solid #adadad;	border-radius:3px;	-webkit-border-radius:3px;	-moz-border-radius:3px;	color: #fff;   filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#fba904, endColorstr=#e2e2e2);width:150px;height:60px;color:#000;"><strong>
                       <?php
					$sql_tot_bid="select count(*) from bid,user where bd_usr_id=usr_id and bd_usr_id='".$_SESSION['uid']."' and bd_date between DATE_SUB(usr_mem_expiry,INTERVAL 1 MONTH) and usr_mem_expiry and (now() between DATE_SUB(usr_mem_expiry,INTERVAL 1 MONTH) and usr_mem_expiry)";
					$res_tot_bid=mysql_query($sql_tot_bid);
					$row_tot_bid=mysql_fetch_array($res_tot_bid);
	
					$sql_mem="select * from membership_plan,user where usr_mp_id=mp_id and usr_id='".$_SESSION['uid']."'";
					$res_mem=mysql_query($sql_mem);
					$row_mem=mysql_fetch_object($res_mem);

					$remaining_bid=$row_mem->usr_left_bid;
				?>
                                	<div style="padding-top:5px;margin-bottom:0px;" align="center"><?php echo $remaining_bid; ?>/<?php echo $row_mem->usr_total_bid; ?></div>
					<div style="padding-top:5px;margin-bottom:0px;" align="center"><?php echo $lang[187]; ?></div>
                                </strong>
								</div>
				</div>
			<div class="signup-form-str" id="msg"><?php echo $msg; ?></div>
                                
                    <input type="hidden" name="bd_prj_id" value="<?php echo $row->prj_id; ?>"/>
                    <input type="hidden" name="bd_usr_id" value="<?php echo $_SESSION['uid']; ?>"/>
                                
                    <div class="signup-form-str">
					<label class="form-label" style="color:#999"><?php echo $lang[186]; ?>
                                <?php if($row->pb_type == 'fixed'){ ?>
					<?php echo getCurrencySymbol().$row->pb_minprice." - ".getCurrencySymbol().$row->pb_maxprice; ?>&nbsp;<?php echo getCurrencyCode(); ?>
					<?php } else if($row->pb_type == 'hourly'){	?>
					<?php echo getCurrencySymbol().$row->pb_rate; ?>&nbsp;<?php echo getCurrencyCode(); ?><?php echo $lang[801]; ?>
				<?php }  ?>
                </label>
								
            </div>
                                
                  
                <div class="form-group">
					<label class="col-sm-5 control-label no-padding-right" for="bd_amount"><?php echo $lang[188]; ?>(<?php echo getCurrencyCode(); ?>):</label>
                    <div class="col-sm-5">
						<input name="bd_amount" id="bd_amount" type="text" class="form-control" value="<?php echo $bd_amount; ?>"/>
                        <input type="hidden" name="min_bid_amt" id="min_bid_amt" value="<?php echo $row->pb_minprice; ?>"/>
					</div>
				</div>
                                
                 <div class="form-group">
					<label class="col-sm-5 control-label no-padding-right" for="bd_days"><?php echo $lang[189]; ?></label>
					<div class="col-sm-2">
						<input name="bd_days" id="bd_days" type="text" value="<?php if($bd_days==''){ echo $lang[191]; }else{ echo $bd_days; } ?>" onfocus="if(this.value=='<?php echo $lang[191]; ?>')this.value='';" onblur="if(this.value==''){this.value='<?php echo $lang[191]; ?>'}" class="form-control"/>
					</div>
				</div>
                                
                 <div class="form-group">
					<label class="col-sm-5 control-label no-padding-right" for="bd_days"><?php echo $lang[190]; ?></label>
					<div class="col-sm-2">
						<input id="bd_milestone" name="bd_milestone" maxlength="3" type="text" value="<?php if($bd_milestone==''){ echo "50"; }else{ echo $bd_milestone; } ?>" class="form-control"/>
					</div>
				</div>
				<hr>
                <?php
                	$sql_bo="select * from bidding_option where bo_status='1' order by bo_id";
                    $res_bo=mysql_query($sql_bo);
                    if(mysql_num_rows($res_bo)>0){
				?>
                    	<div class="signup-form-str" align="left">
							<label class="form-label"><?php echo $lang[192]; ?></label>
								
                                <?php
					$bo=0;
					while($row_bo=mysql_fetch_object($res_bo)){	?>
							
					<div style="padding-top:8px;">
						<input name="bo_id_<?php echo $row_bo->bo_id; ?>" type="checkbox" style="vertical-align:middle">&nbsp;<?php echo $row_bo->bo_option; ?>&nbsp;<span style="color:#00F"><?php echo getCurrencySymbol(); ?><?php echo number_format($row_bo->bo_amount,2); ?>&nbsp;<?php echo getCurrencyCode(); ?></span>
                                        <input type="hidden" name="bo_amount_<?php echo $row_bo->bo_id; ?>" id="bo_amount_<?php echo $row_bo->bo_id; ?>" value="<?php echo $row_bo->bo_amount; ?>"/>
                                        <div><?php echo stripslashes($row_bo->bo_description);?></div>
					</div>
				<?php 
					$bo++;
				} ?>
				</div>
                                <?php } ?>
					<input type="hidden" name="total_bo" id="total_bo" value="<?php echo $bo; ?>"/>
                                
                    <div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="bd_days"><?php echo $lang[193]; ?></label>
    	                <div class="col-sm-9" align="left">
                              <p><?php echo $lang[194]; ?></p>
                              <p><?php echo $lang[195]; ?></p>
                              <p><?php echo stripslashes($lang[196]); ?><?php echo get_page_settings(4);?><?php echo $lang[197]; ?></p>
                        </div>
                    </div>
                              
                              
<div>
				<div style="background-color:#edeced;border: 1px solid #adadad;	border-radius:3px;	-webkit-border-radius:3px;	-moz-border-radius:3px;	color: #fff;   filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#fba904, endColorstr=#e2e2e2);width:280px;height:165px;">
				<textarea style="width:260px;height:155px;margin:4px auto 0 auto;background:none;border:none;display:block;font:normal 14px/18px Arial, Helvetica, sans-serif;
	color:#7e7d7d;padding:0;" name="bd_details" id="bd_details" rows="10"><?php echo $bd_details; ?></textarea>
				</div>
                     	</div>
                            
                      <div class="signup-form-str">
				<label class="form-label"></label>
				<div style="padding-top:8px;">
					<!--<input name="notifylowerbids" type="checkbox" style="vertical-align:middle"/>&nbsp;--><?php /*echo $lang[205];*/ ?>
                                     </div>
				<div style="padding-top:8px;">
                               <input name="privatemsg" id="privatemsg" onClick="javascript:togglePrivateMsg()" type="checkbox" value="1" <?php if($privatemsg == '1'){ ?> checked="checked" <?php } ?> style="vertical-align:middle"/>&nbsp;<?php echo $lang[206]; ?>
                               
				</div>
				</div>
                                
                                <div id="privatemsgForm" style="display:none;">
                                <div class="signup-form-str">
					<label class="form-label"><?php echo $lang[207]; ?><?php echo $row->usr_name; ?></label>
					<div style="background-color:#edeced;border: 1px solid #adadad;	border-radius:3px;	-webkit-border-radius:3px;	-moz-border-radius:3px;	color: #fff;   filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#fba904, endColorstr=#e2e2e2);width:280px;height:160px;">
					<textarea style="width:260px;height:150px;margin:4px auto 0 auto;background:none;border:none;display:block;font:normal 14px/18px Arial, Helvetica, sans-serif;color:#7e7d7d;padding:0;" name="msg_message" id="msg_message" rows="10"><?php echo $msg_message; ?></textarea>
                                    </div>
				</div>
                                <!---->
                                <div class="signup-form-str">
					<label class="form-label"><?php echo $lang[208]; ?></label>
                                <p style="margin-bottom:-1px;"><?php echo $lang[209]; ?></p>
                                <p style="color:#F00;margin-top:-1px;margin-bottom:-1px;"><?php echo $lang[210]; ?></p>

				<input name="msg_file" type="file"> <?php echo $lang[211]; ?>
			</div>
                                </div>
                                <!---->
                                
                                
                     <p><strong><font color="red"><?php echo $lang[212]; ?></font></strong> <?php echo $lang[213]; ?><?php echo get_page_settings(4);?><?php echo $lang[214]; ?><a target="_blank" href="terms.php"><?php echo $lang[215]; ?></a>.</p>
                      
                      
                               
					<div class="form-group">
						<div class="col-md-12">
                             <input type="hidden" name="msg_to" value="<?php echo $row->prj_usr_id ?>" />
                             <input type="submit" id="submitBid" name="submitBid" class="btn btn-info" value="<?php echo $lang[216]; ?>">
						</div>
                    </div>
                        
                    </form>
                </div>
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

	
                    </div><!-- end row -->
                </div><!-- end container -->
<?php include "includes/footer.php"; ?>