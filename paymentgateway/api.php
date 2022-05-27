<?php
if(empty($_SERVER['REQUEST_URI'])) {
    $_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'];
}

// Strip off query string so dirname() doesn't get confused
$url = preg_replace('/\?.*$/', '', $_SERVER['REQUEST_URI']);
if($url=''){
$url = 'http://'.$_SERVER['HTTP_HOST'].'/'.ltrim(dirname($url), '/').'';
}
if($url==''){
$url = 'http://'.$_SERVER['HTTP_HOST'].'/'.ltrim(dirname($url), '').'';
}
if($gateway==1)
{
$al=mysql_query("select * from payment_gateway where id='".$gateway."'");
$row_al=mysql_fetch_array($al);
?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
<input type=hidden name="cmd" value=_xclick>
<input type=hidden name="business" value="<?php echo $row_al['pg_id'];?>">
<input type=hidden name="item_name" value="<?php echo get_page_settings(4);?> Deposit">
<input type=hidden name="amount" value="<?php echo $tot_amount; ?>">
<input type=hidden name="no_note" value=1>
<input type=hidden name="currency_code" value="<?php echo get_page_settings(7);?>">
<input type=hidden name="rm" value=2>
<input type=hidden name="custom" value="<?php echo $_SESSION['uid'];?>||<?php echo $amount; ?>">
<input type=hidden name="return" value="<?php echo $_SESSION['last_page'];?>">
<input type=hidden name="cancel_return" value="<?php echo $url;?>">
<input type=hidden name="notify_url" value="<?php echo $url;?>paymentgateway/paypal.php">
<input class="btn btn-primary" type=image src="<?php echo $url;?>/paymentgateway/paypal.jpg">
</form>
<?php
}
?>