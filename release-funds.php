<?php
ob_start();
session_start();
include "common.php";

if($_SESSION['uid']==''){	header("location:login.php");	}


if(isset($_SESSION['msg'])){	$msg=$_SESSION['msg'];	unset($_SESSION['msg']);	}

if(isset($_POST['release_fund']))
{
    include "language.php";

	if(isset($_POST['es_id']))
	{
		$es_id=addslashes(trim($_POST['es_id']));
		
		$sql_us="select * from user,escrow where usr_id=es_to_id and es_id='".$es_id."'";
		$res_us=mysql_query($sql_us);
		$row_us=mysql_fetch_object($res_us);
		
		$new_bal = $row_us->usr_balance + $row_us->es_amount;
		
		$sql_upd="update user
			set
				usr_balance=".$new_bal."
			where
				usr_id='".$row_us->es_to_id."'";
			
		mysql_query($sql_upd);	
		
		$sql_rel="update transaction
			set
				tr_release = '1'
			where
				tr_id = '".$row_us->es_tr_id."'";
		
		mysql_query($sql_rel);	//OK
		
		$sql_esc="update escrow 
			set
				es_status = '0'
		where 
			es_id='".$es_id."'";
		
		mysql_query($sql_esc);	//OK
		
		
		/******** Code for notification start here *********/
		
		$sql_un="insert into user_notification
		set
			un_usr_id='".$row_us->es_to_id."',
			un_from_usr_id='".$_SESSION['uid']."',
			un_type='release',
			un_content='".$_SESSION['usr'].$lang[479].getCurrencySymbol().$row_us->es_amount." ".getCurrencyCode().$lang[480]."',
			un_prj_id='".$row_us->es_prj_id."',
			un_updated_date=now()";

		mysql_query($sql_un);	//OK
		
		/******* Code for notification end here *********/
		
		/**** code for email sending start here ****/
		
		$sqlemail="select * from admin_user where id='1'";
		$resemail=mysql_query($sqlemail);
		$rowemail=mysql_fetch_object($resemail);
				
		$sql_prj="select * from project where prj_id='".$row_us->es_prj_id."'";
		$res_prj=mysql_query($sql_prj);
		$row_prj=mysql_fetch_object($res_prj);
				
		$sql_usr_to="select * from user where usr_id='".$row_us->es_to_id."'";
		$res_usr_to=mysql_query($sql_usr_to);
		$row_usr_to=mysql_fetch_object($res_usr_to);
				
		$sql_usr_from="select * from user where usr_id='".$_SESSION['uid']."'";
		$res_usr_from=mysql_query($sql_usr_from);
		$row_usr_from=mysql_fetch_object($res_usr_from);
				
		


		include "email/release-funds.php"; //email design with content included
		
       	/*$comment1='<div style="border:1px solid #999999; width:660px;float:left; padding-bottom:0px;">
		<div style="width:650px;height:100px; padding-bottom:0;">'.getCurrencySymbol().$this->tr_amount.$lang[807].$row_usr_from->usr_name.$lang[808].$row_prj->prj_name.'.</div></div>';*/
		

		$from_mail=$rowemail->email;
   	    $to=$row_usr_to->usr_email; 	

        $subj=$lang[828];
		$headers  = "MIME-Version: 1.0\n";
	    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
	    $headers .= 'From: '.$from_mail.'';	
		
		
		mail($to,$subj,$comment1,$headers);
				
		/****************************************/
		
		include "email/release-funds.php"; //email design with content included
		
		/*$comment2='<div style="border:1px solid #999999; width:660px;float:left; padding-bottom:0px;">
		<div style="width:650px;height:100px; padding-bottom:0;">'.getCurrencySymbol().$this->tr_amount.$lang[809].$row_prj->prj_name.'.</div></div>';*/
		

		$from_mail=$rowemail->email;
   	    $to=$row_usr_from->usr_email; 	

        $subj=$lang[828];
		$headers  = "MIME-Version: 1.0\n";
	    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
	    $headers .= 'From: '.$from_mail.'';	
		
		mail($to,$subj,$comment2,$headers);
            
            
		/**** code for email sending end here ****/
			
		$_SESSION['msg']='<font color="#009900">'.$lang[481].'</font>';		
	}
	else
	{
		
		$_SESSION['msg']='<font color="#CC0000">'.$lang[482].'</font>';
	}
	
	header("location:release-funds.php");
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
									<li ><a href="transfer-funds.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[135]; ?></a></li>
									<li ><a href="withdraw-funds.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[136]; ?></a></li>
									<li class="active"><a href="release-funds.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[137]; ?></a></li>
									<li ><a href="invoice.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[796]; ?></a></li>
									<li ><a href="transactions.php"><span class="glyphicon glyphicon-off"></span>  <?php echo $lang[138]; ?></a></li>
                                    </ul>
                            </div><!-- end widget -->
                        </div><!-- end col -->

                        <div class="content col-md-9">
                            <div class="post-padding">
                                <div class="job-title nocover hidden-sm hidden-xs"><h5><?php echo $lang[135]; ?></h5></div>
                                
                                    
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">   
                                            <div><?php echo $msg; ?></div>
											<?php 
											$sql_es="select * from escrow,user,project,transaction where es_to_id=usr_id and es_prj_id=prj_id and es_tr_id=tr_id and es_from_id='".$_SESSION['uid']."' and es_status='1' and tr_release='0' and tr_type='escrow' and tr_status='1'";
											$res_es=mysql_query($sql_es);
											if(mysql_num_rows($res_es)>0)	{?>
													
											<form action="" method="post" class="form-horizontal">
											<div class="panel-group">
											
												<div class="panel panel-default">
															<div class="panel-heading">
																<?php echo $lang[483]; ?>
															</div>
															<div class="panel-body">
																	<?php 
																while($row_es=mysql_fetch_object($res_es)) {
																?>
															
																<label>
																	<input type="radio" name="es_id" value="<?php echo $row_es->es_id; ?>" class="ace"/>
																	<span class="lbl">&nbsp;<?php echo $row_es->prj_name; ?>&nbsp;(<?php echo getCurrencySymbol().$row_es->es_amount; ?>&nbsp;<?php echo getCurrencyCode(); ?>)</span>
																</label>
															
														   
																<?php } ?>
															
																
																<div style="margin-top:20px;">
																	<div class="control-group response-info span5">
																	<button type="submit" id="btn_next_id" class="btn btn-info" name="release_fund"><?php echo $lang[484]; ?></button>
																	</div>
																</div>
															</div>
												</div>
											
											</div>
											<div class="clearfix"></div>
											</form>
												
											<?php	}	else	{		?>
												<div class="control-group">
												<h3><font color="#FF0000"><?php echo $lang[485]; ?></font></h3>
												</div>
														
											<?php 	}	?>
												
											
											
											
                                            <?php include "dashboard.php"; ?>
											
										</div>
                                    </div><!-- end row -->
                                    <hr class="invis">
									
								
                            </div><!-- end post-padding -->
                        </div><!-- end col -->
                    </div><!-- end row -->  
                </div><!-- end container -->
            </div><!-- end section -->
	  
	  
	  
	  
      
<script language="javascript">

function showempStat()
{
	//$.noConflict();
	$('#employer-stats').css({"display":"block"});
	$('#freelancer-stats').css({"display":"none"});
	$("#btnEmp").addClass("active");
	$("#btn-quick-stat-freelancer").removeClass("active");
}
function showfreelStat()
{
	//$.noConflict();
	$('#employer-stats').css({"display":"none"});
	$('#freelancer-stats').css({"display":"block"});
	$("#btn-quick-stat-freelancer").addClass("active");
	$("#btnEmp").removeClass("active");
}

</script>
  
    
    <div><?php echo $msg; ?></div>
    
  <?php include "includes/footer.php"; ?>
