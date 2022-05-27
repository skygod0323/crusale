<?php
ob_start();
session_start();
include "common.php";
$df_method=trim($_GET[df_method]);
$df_amount=trim($_GET[df_amount]);
?>

<?php
	if(!is_numeric($df_amount))
	{
		$but_enable="No";
		?>
        <div class="form-group">
			<label class="col-sm-8 control-label no-padding-right"><font color="#CC0000"><b><?php echo $lang[688]; ?>.</b></font></label>
        </div>
<?php } else 
	{	
		if($df_amount<get_page_settings(13))
		{
			$but_enable="No";
			?>
			<div class="form-group">
			<label class="control-label" style="width:100%;text-align:center"><font color="#CC0000"><b><?php echo $lang[686]; ?><?php echo get_page_settings(8); ?><?php echo get_page_settings(13); ?></b></font></label>
            </div>
<?php 	} 
		if($df_amount>=get_page_settings(13))
		{
			$but_enable="Yes";
			$al1=mysql_query("select * from payment_gateway where id='".$df_method."'");
			$row_al1=mysql_fetch_array($al1);
			if($row_al1['pg_deposit_fee_type']=="fixed")
			{ 
				$fee_amm = $row_al1['pg_deposit_fee'];
			}
			if($row_al1['pg_deposit_fee_type']=="percent")
			{
				$fee_amm = $df_amount * $row_al1['pg_deposit_fee']/100;
			}
			$tot_amount = $df_amount+$fee_amm;
			?>
            <div class="form-group">
			<label class="col-sm-6 control-label no-padding-right"><?php echo $lang[684]; ?></label>
			<div class="col-sm-6" align="left"><font style="font-size:22px; font-weight:bold;"><?php echo get_page_settings(8); ?><?php echo $tot_amount; ?></font></div>
            </div>
            <div class="form-group">
			<label class="form-label">(<?php echo $lang[685]; ?>: <font color="#009900"><?php echo get_page_settings(8); ?><?php echo $df_amount; ?></font>)</label>
            </div>
<?php 	}
	} ?>||||<?php echo $but_enable; ?>