<?
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value)
{
	$value = urlencode(stripslashes($value));
	$req .= '&' . $key . '=' . $value;
}
$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
// If testing on Sandbox use: 
//$header .= "Host: www.sandbox.paypal.com:443\r\n";
$header .= "Host: www.paypal.com:443\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
$payment_status = $_POST['payment_status'];
$amount = $_POST['mc_gross'];
$pay_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$scustom = explode('||',$_POST['custom']);

$uid=$scustom[0];
$net_amount=$scustom[1];

if (!$fp)
{
$checkpay="no";
	$error_output = $errstr . ' (' . $errno . ')';
}
else
{
	fputs ($fp, $header . $req);
	while (!feof($fp))
	{
		$res = fgets ($fp, 1024);
		if (strcmp ($res, "VERIFIED") == 0)
		{
$checkpay="yes";

		}
	}
	fclose ($fp);
}





if($checkpay=="yes")
{
require '../common.php';

$sql="insert into deposit_fund
			set			
				df_method ='Paypal',
				df_usr_id ='".$uid."',
				df_amount ='".$net_amount."',
				df_paydate =now()";
			

		mysql_query($sql) or die(mysql_error());
		
		
		$sql_upd="update user
			set
				usr_balance = usr_balance+'".$net_amount."'
			where
				usr_id='".$uid."'";
		mysql_query($sql_upd);
}
?>