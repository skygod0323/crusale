<?php
ob_start();
session_start();
include "common.php";


if($_SESSION['uid']=='')
{
	header("location:login.php");	
}

if(isset($_POST['choose_proj']))
{
	/*print_r($_POST);
	exit;*/
}

class addTransaction{

	var $msg;
	var $tr_to_id;
	var $tr_prj_id;
	var $tr_amount;
	var $tr_type;
	
	function __construct( $tr_to_id, $tr_prj_id, $tr_amount, $tr_type)
	{
		$this->tr_to_id=$tr_to_id;
		$this->tr_prj_id=$tr_prj_id;		
		$this->tr_amount=$tr_amount;
		$this->tr_type=$tr_type;
		/*echo "from ".$this->tr_to_id;
		echo "<br/>prj ".$this->tr_prj_id;
		echo "<br/>amt ".$this->tr_amount;
		echo "<br/>typ ".$this->tr_type;
		
		exit;*/

	}

	function valid()
	{
          include "language.php";
		$valid=true;
		if($this->tr_type == "")
		{
			$this->msg= '<font color="#CC0000">'.$lang[236].'</font>';
			$valid=false;
		}
		else if($this->tr_amount == "")
		{
			$this->msg= '<font color="#CC0000">'.$lang[237].'</font>';
			$valid=false;
		}
		else
		{
			$sql_chk1="select * from project p,bid,user,project_budget where bd_prj_id=p.prj_id and p.prj_usr_id=usr_id and p.prj_id=pb_prj_id and p.prj_usr_id='".$_SESSION['uid']."' and  bd_status=1 and p.prj_status='running' and p.prj_id='".$this->tr_prj_id."' and p.prj_id not in(select rr_prj_id from review_rating where rr_from_usr=p.prj_usr_id and (rr_completionrate='1' or rr_completionrate='0'))";
                  
			$res_chk1=mysql_query($sql_chk1);
			$row_chk1=mysql_fetch_object($res_chk1);
			
			$sql_chk2="select sum(tr_amount) from transaction where tr_prj_id='".$this->tr_prj_id."' and tr_status='1' and tr_to_id='".$row_chk1->bd_usr_id."' and tr_from_id='".$row_chk1->prj_usr_id."'";
			$res_chk2=mysql_query($sql_chk2);
			$row_chk2=mysql_fetch_array($res_chk2);
			
                  if($row_chk1->pb_type=='hourly')
                  {
                      $remain_amount=($row_chk1->pb_rate * $row_chk1->bd_amount)-$row_chk2[0];
                  }
                  else
                  {
                    $remain_amount=$row_chk1->bd_amount-$row_chk2[0];
                  }
			if($row_chk1->usr_balance < $this->tr_amount)
			{
				$this->msg= '<font color="#CC0000">'.$lang[238].'</font>';
				$valid=false;
			}
			else if($this->tr_amount > $remain_amount)
			{
				$this->msg= '<font color="#CC0000">'.$lang[239].'</font>';
				$valid=false;
			}
			
		}
				
				
		return $valid;
	}
	
	function add()
	{	
          include "language.php";
		$sql="insert into transaction
			set					
				tr_to_id ='".$this->tr_to_id."',
				tr_from_id ='".$_SESSION['uid']."',
				tr_prj_id ='".$this->tr_prj_id."',
				tr_amount ='".$this->tr_amount."',	
				tr_type ='".$this->tr_type."',	
				tr_updated_date=now(),
				tr_status=1";
		mysql_query($sql) or die(mysql_error());
		
		$sql_us22="select * from user where usr_id='".$_SESSION['uid']."'";
		$res_us22=mysql_query($sql_us22);
		$row_us22=mysql_fetch_object($res_us22);
		
		$new_bal=$row_us22->usr_balance - $this->tr_amount;
		
		$sql_upd="update user
			set
				usr_balance=".$new_bal."
			where
				usr_id='".$_SESSION['uid']."'";
				
		mysql_query($sql_upd);

		if(strcmp($this->tr_type,'escrow')==0)
		{
			$res_tr=mysql_query("select max(tr_id) from transaction");
			$row_tr=mysql_fetch_array($res_tr);
			
			
			$sql_es="insert into escrow
				set
					es_tr_id='".$row_tr[0]."',
					es_to_id ='".$this->tr_to_id."',
					es_from_id='".$_SESSION['uid']."',
					es_prj_id ='".$this->tr_prj_id."',
					es_amount ='".$this->tr_amount."',
					es_updated_date =now()";

			mysql_query($sql_es);
			
			
			/******* Code for notification start here *********/
		
			$sql_un="insert into user_notification
			set
				un_usr_id='".$this->tr_to_id."',
				un_from_usr_id='".$_SESSION['uid']."',
				un_type='".$this->tr_type."',
				un_content='".$_SESSION['usr'].$lang[577].getCurrencySymbol().$this->tr_amount." ".getCurrencyCode().$lang[578]."',
				un_prj_id='".$this->tr_prj_id."',
				un_updated_date=now()";
				
			mysql_query($sql_un);
		
			/******* Code for notification end here *********/
		
		}
		else
		{
			$sql_us="select * from user where usr_id='".$this->tr_to_id."'";
			$res_us=mysql_query($sql_us);
			$row_us=mysql_fetch_object($res_us);
			
			$sql_usr="update user
				set
					usr_balance=".($row_us->usr_balance + $this->tr_amount)."
				where
					usr_id='".$row_us->usr_id."'";
			
			mysql_query($sql_usr);
			
			/******* Code for notification start here *********/
		
			$sql_un="insert into user_notification
			set
				un_usr_id='".$this->tr_to_id."',
				un_from_usr_id='".$_SESSION['uid']."',
				un_type='".$this->tr_type."',
				un_content='".$_SESSION['usr'].$lang[579].getCurrencySymbol().$this->tr_amount." ".getCurrencyCode().$lang[580]."',
				un_prj_id='".$this->tr_prj_id."',
				un_updated_date=now()";
				
			mysql_query($sql_un);
		
			/******* Code for notification end here *********/
			
		}
		
		/**** code for email sending start here ****/
		
		$sqlemail="select * from admin_user where id='1'";
		$resemail=mysql_query($sqlemail);
		$rowemail=mysql_fetch_object($resemail);
				
		$sql_prj="select * from project where prj_id='".$this->tr_prj_id."'";
		$res_prj=mysql_query($sql_prj);
		$row_prj=mysql_fetch_object($res_prj);
				
		$sql_usr_to="select * from user where usr_id='".$this->tr_to_id."'";
		$res_usr_to=mysql_query($sql_usr_to);
		$row_usr_to=mysql_fetch_object($res_usr_to);
				
		$sql_usr_from="select * from user where usr_id='".$_SESSION['uid']."'";
		$res_usr_from=mysql_query($sql_usr_from);
		$row_usr_from=mysql_fetch_object($res_usr_from);

		$mail_msg1="";
		if(strcmp($this->tr_type,'escrow')==0)
		{
			$mail_msg1=$row_usr_from->usr_name.$lang[812].getCurrencySymbol().$this->tr_amount.$lang[815].$row_prj->prj_name.$lang[813];
		}
		else
		{
			$mail_msg1=$row_usr_from->usr_name.$lang[812].getCurrencySymbol().$this->tr_amount.$lang[808].$row_prj->prj_name.$lang[813];
		}
		
		include "email/transfer-funds.php"; //email design with content included
		
		/*$comment1='<div style="border:1px solid #999999; width:660px;float:left; padding-bottom:0px;">
		<div style="width:650px;height:100px; padding-bottom:0;">'.$mail_msg1.'</div></div>';*/

		$from_mail=$rowemail->email;
   	    $to=$row_usr_to->usr_email; 	

        $subj=$lang[827];
		$headers  = "MIME-Version: 1.0\n";
	    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
	    $headers .= 'From: '.$from_mail.'';	
		
		mail($to,$subj,$comment1,$headers);
				
		/****************************************/
		
		$mail_msg2="";
		
		if(strcmp($this->tr_type,'escrow')==0)
		{
			$mail_msg2=getCurrencySymbol().$this->tr_amount.$lang[814].$row_usr_to->usr_name.$lang[815].$row_prj->prj_name.$lang[813];
		}
		else
		{
			$mail_msg2=getCurrencySymbol().$this->tr_amount.$lang[814].$row_usr_to->usr_name.$lang[808].$row_prj->prj_name.$lang[813];
		}
		
		include "email/transfer-funds.php"; //email design with content included
		
		
		/*$comment2='<div style="border:1px solid #999999; width:660px;float:left; padding-bottom:0px;">
		<div style="width:650px;height:100px; padding-bottom:0;">'.$mail_msg2.'</div></div>';*/

		$from_mail=$rowemail->email;
   	    $to=$row_usr_from->usr_email; 	

        $subj=$lang[827];
		$headers  = "MIME-Version: 1.0\n";
	    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
	    $headers .= 'From: '.$from_mail.'';	
		
		mail($to,$subj,$comment2,$headers);
            
            
		/**** code for email sending end here ****/
												
		$this->msg='<font color="#009900">'.$lang[240].'</font>';	
	}	
}

if(isset($_SESSION['msg'])){	$msg=$_SESSION['msg'];	unset($_SESSION['msg']);	}

if(isset($_POST['transfer_fund']))
{
	$adn=new addTransaction(addslashes(trim($_POST['tr_to_id'])), addslashes(trim($_POST['tr_prj_id'])), addslashes(trim($_POST['tr_amount'])), addslashes(trim($_POST['tr_type'])));

	if($adn->valid()){
		$adn->add();		
	}

	$_SESSION['msg']=$adn->msg;
	
	header("location:transfer-funds.php");
}

?>
	<?php include "includes/header.php"; ?>


	
	<<div class="section db" style="background-image:url('upload/parallax_02.jpg');">
                <div class="container">
                    <div class="page-title text-center">
                        <div class="heading-holder">
                            <h1><?php echo $lang[132]; ?></h1>
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
									<li ><a href="financial-dash.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[133]; ?></a></li>
                                    <li ><a href="payment-deposit.php"><span class="glyphicon glyphicon-user"></span>  <?php echo $lang[134]; ?></a></li>
									<li class="active"><a href="transfer-funds.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[135]; ?></a></li>
									<li ><a href="withdraw-funds.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[136]; ?></a></li>
									<li ><a href="release-funds.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[137]; ?></a></li>
									<li ><a href="invoice.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[796]; ?></a></li>
									<li ><a href="transactions.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[138]; ?></a></li>
                                    </ul>
                            </div><!-- end widget -->
                        </div><!-- end col -->

                        <div class="content col-md-9">
                            <div class="post-padding">
                                <div class="job-title nocover hidden-sm hidden-xs"><h5><?php echo $lang[245]; ?></h5></div>
                                
                                    
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12"> 
											<div id="transfer-form1" <?php if(isset($_POST['prj_id'])){ ?> style="display:none;" <?php } ?>>
                                            <div class="signup-form-str" id="msg"><?php echo $msg; ?></div>
											<?php
											$sql_tf="select * from project p,bid,user where bd_prj_id=p.prj_id and bd_usr_id=usr_id and p.prj_usr_id='".$_SESSION['uid']."' and bd_status=1 and p.prj_status='running' and p.prj_id not in(select rr_prj_id from review_rating where rr_from_usr=p.prj_usr_id and (rr_completionrate='1' or rr_completionrate='0'))";
											$res_tf=mysql_query($sql_tf);
											if(mysql_num_rows($res_tf)>0){	?>
											<form action="" method="post" class="form-horizontal" onSubmit="return validForm();">
											<div class="panel-group">
											
												<div class="panel panel-default">
															
															<div class="panel-body">
																	<?php	
																	$i=0;
																	while($row_tf=mysql_fetch_object($res_tf))	{	?>
															
																<label>
																	<input type="radio" name="prj_id" id="prj_id" value="<?php echo $row_tf->prj_id; ?>" <?php if($i==0){ ?>checked="checked" <?php } ?> class="ace" />&nbsp;<span class="lbl"><?php echo $row_tf->prj_name; ?></span>
																</label>
															
														   
																<?php $i++; }	?>
															
																
																<div class="form-group">
																	<div class="col-md-offset-5 col-md-6">
																		<input type="hidden" name="confirm" value="1"/>
																		<input type="submit" id="btn_next_id" name="choose_proj" class="btn btn-info" value="<?php echo $lang[245]; ?>">
																	</div>
																</div>
																
															</div>
												</div>
											
											</div>
											<?php	}else{	?>
											 <h3><font color="#FF0000"><?php echo $lang[244]; ?></font></h3>
											 <?php } ?>
											<div class="clearfix"></div>
											</form>
												
											
												
											
											
											
                                            
											</div>
											<div id="transfer-form2" <?php if(isset($_POST['prj_id'])){ ?> style="display:block;" <?php } else {?> style="display:none;"<?php } ?>> 
											
											<form action="" method="post" class="form-horizontal" onSubmit="return validTransferType();">
                
							
												<div class="signup-form-str" id="msg"><?php echo $msg; ?></div>
																
															<div class="signup-form-str">
													<label class="form-label"><?php echo $lang[248]; ?></label>
											<?php
										//	$sql_to="select * from project,bid,user where bd_prj_id=prj_id and bd_usr_id=usr_id and prj_usr_id='".$_SESSION['uid']."' and now()<prj_expiry and  bd_status=1 and prj_status='running' and prj_id=".$_POST['prj_id'];
											$sql_to="select * from project,bid where bd_prj_id=prj_id and prj_usr_id='".$_SESSION['uid']."' and bd_status=1 and prj_status='running' and prj_id=".$_POST['prj_id'];

											$res_to=mysql_query($sql_to);
											$row_to=mysql_fetch_object($res_to);
													?>
													<input type="hidden" name="tr_to_id" value="<?php echo $row_to->bd_usr_id; ?>" />
													<input type="hidden" name="tr_prj_id" value="<?php echo $_POST['prj_id']; ?>"/>
													<div class="radio" style="padding-top:8px;">
													<label>
													<input type="radio" value="direct" id="tr_type_dir" name="tr_type" class="ace" />&nbsp;<span class="lbl"><?php echo $lang[246]; ?></span>
													</label>
													 </div>
													<div class="radio" style="padding-top:8px;">
													<label>
													<input type="radio" value="escrow" id="tr_type_esc" name="tr_type" class="ace"/>&nbsp;<span class="lbl"><?php echo $lang[247]; ?></span>
													</label>
													</div>
																
												</div>
																
												<div class="form-group">
													<label class="col-sm-5 control-label no-padding-right" for="tr_amount"><?php echo $lang[249]; ?> (<?php echo getCurrencyCode(); ?>):</label>
													<div class="col-sm-4">
														<input type="text" name="tr_amount" id="tr_amount" class="form-control"/>
													</div>
												</div>
																
																
												<div class="form-group">
													<div class="col-md-offset-6 col-md-9">
														<input type="hidden" name="confirm" value="1"/>
														<input type="submit" id="btn_next_id" name="transfer_fund" class="btn btn-info" value="<?php echo $lang[245]; ?>">
													</div>
												</div>
														
											</form>
											
											</div>
											<?php include "dashboard.php"; ?>
										</div>
                                    </div><!-- end row -->
                                    <hr class="invis">
									
								
                            </div><!-- end post-padding -->
                        </div><!-- end col -->
                    </div><!-- end row -->  
                </div><!-- end container -->
            </div><!-- end section -->
	
	
	
	
	
	
	
	

<script type="text/javascript">
function validForm()
{
      //if(!$("input.prj_id:checked").val())
      //{
	if(!document.getElementByName('prj_id').checked)
	{
		alert('<?php echo $lang[241]; ?>');
		return false;
	}
	else
	{
		return true;	
	}
}
function validTransferType()
{
	if(!document.getElementById('tr_type_dir').checked && !document.getElementById('tr_type_esc').checked)
	{
		alert('<?php echo $lang[236]; ?>');
		return false;
	}
	else if(document.getElementById('tr_amount').value=='')
	{
		alert('<?php echo $lang[237]; ?>');
		return false;
	}
	else if(isNaN(document.getElementById('tr_amount').value))
	{
		alert('<?php echo $lang[242]; ?>');
		document.getElementById('tr_amount').value="";
		return false;
	}
	else
	{
		return true;	
	}
}
</script>


			<?php include "includes/footer.php"; ?>