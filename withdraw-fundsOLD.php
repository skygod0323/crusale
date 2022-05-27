<?php
ob_start();
session_start();
include "common.php";

if($_SESSION['uid']==''){	header("location:login.php");	}

if(isset($_SESSION['msg'])){	$msg=$_SESSION['msg'];	unset($_SESSION['msg']);	}
if(isset($_SESSION['wf_gatewayName'])){	$wf_gatewayName=$_SESSION['wf_gatewayName'];	unset($_SESSION['wf_gatewayName']);	}else{ $wf_gatewayName=""; }
if(isset($_SESSION['wf_gatewayId'])){	$wf_gatewayId=$_SESSION['wf_gatewayId'];	unset($_SESSION['wf_gatewayId']);	}else{ $wf_gatewayId=""; }
if(isset($_SESSION['wf_amount'])){	$wf_amount=$_SESSION['wf_amount'];	unset($_SESSION['wf_amount']);	}else{ $wf_amount=""; }

$sql_usr="select * from user where usr_id=".$_SESSION['uid'];
$res_usr=mysql_query($sql_usr);
$row_usr=mysql_fetch_object($res_usr);


?>
	<?php include "includes/header.php"; ?>

	<div><h2 class="header-txt1-style align-center-txt"><?php echo $lang[226]; ?></h2></div>
        <form action="withdraw-funds-confirm.php" method="post">
                <input type="hidden" name="wf_usr_id" value="<?php echo $_SESSION['uid']; ?>"/>

			<div class="clearfix">
                    
				<div style="width:785px;float:left;margin:0 0 0 100px;">
							
				<div class="signup-form-str" id="msg"><?php echo $msg; ?></div>
                                
                                <div class="signup-form-str">
					<label class="form-label"><?php echo $lang[227]; ?><?php echo getCurrencySymbol() ?><?php echo $row_usr->usr_balance; ?>&nbsp;<?php echo getCurrencyCode() ?></label>
				</div>
                                
                                <div class="signup-form-str">
					<label class="form-label"><?php echo $lang[228]; ?></label>
								
					<?php
                               $al=mysql_query("select * from payment_gateway where pg_status='1'");
					while($row_al=mysql_fetch_array($al)){
					?>
					<div style="padding-top:8px;">
					<input id="deposit.paypal.referenceRadio" name="wf_method" methodname="deposit.paypal.reference" value="<?php echo $row_al['id'];?>" type="radio" checked="checked"/>&nbsp;<?php echo ucfirst($row_al['pg_name']);?>
                                        <p style="margin-top:0px;">( <?php echo $lang[229]; ?> <?php if($row_al['pg_deposit_fee_type']=="fixed"){ echo get_page_settings(8); echo $row_al['pg_deposit_fee']; } if($row_al['pg_deposit_fee_type']=="percent"){ echo $row_al['pg_deposit_fee']."%"; } ?> )</p>
					</div>
                                    
								<?php } ?>
								</div>
                                
                                <div class="signup-form-str">
					<label class="form-label"><?php echo $lang[230]; ?></label>
					<div class="signup-input-field">
					<input type="text" name="wf_gatewayId" id="wf_gatewayId" value="<?php echo $wf_gatewayId; ?>"/>
					</div>
				</div>
                                
                                <div class="signup-form-str">
					<label class="form-label"><?php echo $lang[231]; ?><?php echo $lang[232]; ?>&nbsp;<?php echo getCurrencySymbol().getMinWithdrawAmt(); ?>&nbsp;<?php echo getCurrencyCode(); ?><?php echo $lang[233]; ?></label>
					<div class="signup-input-field">
					<input type="hidden" id="min_withdraw_amt" name="min_withdraw_amt" value="<?php echo getMinWithdrawAmt(); ?>"/>
					<input type="hidden" id="prev_balance" name="prev_balance" value="<?php echo $row_usr->usr_balance; ?>"/>
                                    <input type="text" name="wf_amount" id="wf_amount" value="<?php echo $wf_amount; ?>" />
				</div>
				</div>
								
		                       
					<div class="signup-form-str">
					<div class="create-acc-btn">
                                	<input type="hidden" name="confirm" value="1"/>
					<input type="submit" id="btn_next_id" name="withdraw_fund" value="<?php echo $lang[234]; ?>">
					</div>
					</div>
							
				</div>
						
			</div>
                    </form>
					
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