<?php
ob_start();
session_start();
include "common.php";

if($_SESSION['uid']==''){	header("location:login.php");	}

if(!isset($_POST['confirm']))
{
	header("Location:withdraw-funds.php");
}

if(isset($_SESSION['msg'])){	$msg=$_SESSION['msg'];	unset($_SESSION['msg']);	}

$sql_usr="select * from user where usr_id=".$_SESSION['uid'];
$res_usr=mysql_query($sql_usr);
$row_usr=mysql_fetch_object($res_usr);


class addWithdraw{

	var $msg;
	var $wf_usr_id;
	var $wf_gatewayName;
	var $wf_gatewayId;
	var $min_withdraw_amt;
	var $prev_balance;
	var $wf_amount;
	var $wf_or_amount;
	function __construct($wf_usr_id,$wf_gatewayName,$wf_gatewayId,$min_withdraw_amt,$prev_balance,$wf_amount,$wf_or_amount)
	{
		$this->wf_usr_id=$wf_usr_id;
		$this->wf_gatewayName=$wf_gatewayName;
		$this->wf_gatewayId=$wf_gatewayId;
		$this->min_withdraw_amt=$min_withdraw_amt;
		$this->prev_balance=$prev_balance;
		$this->wf_amount=$wf_amount;
                $this->wf_or_amount=$wf_or_amount;
		
		$_SESSION['wf_gatewayName']=$this->wf_gatewayName;
		$_SESSION['wf_gatewayId']=$this->wf_gatewayId;
		$_SESSION['wf_amount']=$this->wf_amount;
                $_SESSION['wf_or_amount']=$this->wf_or_amount;
		
	}

	function valid()
	{
          include "language.php";
		$valid=true;
		if($this->wf_gatewayId == "")
		{
			$this->msg= '<font color="#CC0000">'.$lang[583].'</font>';
			$valid=false;
		}
		else if($this->wf_amount == "")
		{
			$this->msg= '<font color="#CC0000">'.$lang[584].'</font>';
			$valid=false;
		}
		else if($this->wf_amount < $this->min_withdraw_amt)
		{
			$this->msg= '<font color="#CC0000">'.$lang[585].getCurrencySymbol().$this->min_withdraw_amt.'. '.$lang[586].'</font>';
			$valid=false;
		}
		else if($this->prev_balance < $this->wf_amount)
		{
			$this->msg= '<font color="#CC0000">'.$lang[587].'</font> ';
			$valid=false;
		}

		return $valid;
	}
	
	function add()
	{
          include "language.php";
		$sql="insert into withdraw_funds
			set					
				wf_usr_id ='".$this->wf_usr_id."',
				wf_gatewayName ='".$this->wf_gatewayName."',
				wf_gatewayId ='".$this->wf_gatewayId."',
				wf_amount ='".$this->wf_amount."',
				wf_updated_date=now()";
				
		mysql_query($sql) or die(mysql_error());
		
		$sql_u="update user
			set
				usr_balance = '".($this->prev_balance - $this->wf_or_amount)."'
			where
				usr_id = '".$this->wf_usr_id."'";
				
		mysql_query($sql_u);

		$this->msg='<font color="#009900">'.$lang[588].'</font>';	
	}	
}


if(isset($_POST['confirm_withdraw']))
{

	$adn=new addWithdraw(addslashes(trim($_POST['wf_usr_id'])), addslashes(trim($_POST['wf_gatewayName'])), addslashes(trim($_POST['wf_gatewayId'])), addslashes($_POST['min_withdraw_amt']), addslashes(trim($_POST['prev_balance'])),addslashes($_POST['wf_amount']),addslashes($_POST['wf_or_amount']));

	if($adn->valid()){	
		$adn->add();		
	}

	$_SESSION['msg']=$adn->msg;
	
	header("location:withdraw-funds.php");
}

?>
		<?php include "includes/header.php"; ?>

	<div><h2 class="header-txt1-style align-center-txt"><?php echo $lang[589]; ?></h2></div>
    <div class="row">
		<div class="col-xs-10">            
			<form action="withdraw-funds-confirm.php" method="post" onSubmit="return validDeposit()">
                <input type="hidden" name="df_usr_id" value="<?php echo $_SESSION['uid']; ?>"/>
						
				<div class="signup-form-str" id="msg"><?php echo $msg; ?></div>
                                
               <div class="form-group">
	            	<label class="col-sm-10 control-label no-padding-right" for="df_method" style="color:#666"><?php echo $lang[590]; ?>&nbsp;<?php echo getCurrencySymbol() ?><?php echo $row_usr->usr_balance; ?>&nbsp;<?php echo getCurrencyCode() ?></label>
				</div>
                                
                <div class="form-group">
	            	<label class="col-sm-10 control-label no-padding-right"><?php echo $lang[222]; ?></label>
				</div>
                <div>
                            <?php
					echo $al1=mysql_query("select * from payment_gateway where id='".$_POST['wf_method']."'");
					$row_al1=mysql_fetch_array($al1);
					$wf_gatewayName =$row_al1['pg_name'];

					$amount=$_POST['wf_amount'];
					if($row_al1['pg_withdraw_fee_type']=="fixed"){ 
						$fee_amm = $row_al1['pg_withdraw_fee'];
					}
					if($row_al1['pg_withdraw_fee_type']=="percent"){
						$fee_amm = $amount * $row_al1['pg_withdraw_fee']/100;
					}
					$tot_amount = $amount-$fee_amm;

            			?>
								
						<div style="signup-input-field">
							<?php echo $lang[591]; ?>&nbsp;<?php echo ucfirst($wf_gatewayName); ?>
                                	</div>
                                    <div style="signup-input-field">
							<?php echo $lang[592]; ?>&nbsp;<?php echo $_POST['wf_gatewayId']; ?>
                                	</div>
                                    <div style="signup-input-field">
							<?php echo $lang[593]; ?>&nbsp;<?php echo getCurrencySymbol() ?><?php echo $amount; ?>&nbsp;<?php echo getCurrencyCode() ?>
                                	</div>
                                    <div style="signup-input-field">
							<?php echo $lang[594]; ?>&nbsp;<?php echo getCurrencySymbol() ?><?php echo $fee_amm; ?>&nbsp;<?php echo getCurrencyCode() ?>
                                	</div>
                                    <div style="signup-input-field">
							<?php echo $lang[595]; ?>&nbsp;<?php echo getCurrencySymbol() ?><?php echo $tot_amount; ?>&nbsp;<?php echo getCurrencyCode() ?>
                                	</div>
								
								</div>
                                
                                <input type="hidden" name="wf_usr_id" value="<?php echo $_SESSION['uid']; ?>"/>
								<input type="hidden" id="wf_gatewayName" name="wf_gatewayName" value="<?php echo ucfirst($wf_gatewayName); ?>" />
						        <input type="hidden" id="wf_gatewayId" name="wf_gatewayId" value="<?php echo $_POST['wf_gatewayId']; ?>" />
						        <input type="hidden" id="min_withdraw_amt" name="min_withdraw_amt" value="<?php echo getMinWithdrawAmt(); ?>"/>
						        <input type="hidden" id="prev_balance" name="prev_balance" value="<?php echo $_POST['prev_balance']; ?>"/>
						        <input type="hidden" id="wf_amount" name="wf_amount" value="<?php echo $tot_amount; ?>"/>
<input type="hidden" id="wf_or_amount" name="wf_or_amount" value="<?php echo $amount; ?>"/>
                                
								<div class="signup-form-str">
								<div class="create-acc-btn">
                                <input type="submit" id="btn_next_id" name="confirm_withdraw" value="<?php echo $lang[596]; ?>">
								</div>
                                <div align="center">(<?php echo $lang[597]; ?>)</div>
								</div>
        	</form>
    	</div>
	</div>
					
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