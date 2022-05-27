<?php
function check_user_login()
{
	$sql="select id from admin_user where username='".$_SESSION['username']."'";
	$res=mysql_num_rows(mysql_query($sql));
	if($res==0)
	{
		header("location:index.php");
	}
}	

?>
<?php 
function dateDifference($start_dt,$end_dt) //pranab
{

	$start_ts = strtotime($start_dt);
  	$end_ts = strtotime($end_dt);
  	$diff = $end_ts - $start_ts;
  	
	return round($diff / 86400);	
}

function dateRange( $first, $last, $step = '+1 day', $format = 'Y/m/d' ) //pranab
{
	$dates = array();
	$current = strtotime( $first );
	$last = strtotime( $last );

	while( $current < $last ) {

		$dates[] = date( $format, $current );
		$current = strtotime( $step, $current );
	}

	return $dates;
}
function checkActive($op) //pranab
{
	$sql="select so_value from site_option where so_id='".$op."'";
	$qry=mysql_query($sql);
	$obj=mysql_fetch_object($qry);
	if($obj->so_value=='1')
	{
		return true;	
	}
	else
	{
		return false;	
	}
}

function getSiteTitle()	//pranab
{
	$sql="select st_value from site_settings where st_id=4 and st_status=1";
	$query=mysql_query($sql);
	if($tit=mysql_fetch_object($query))
	{
		return ucfirst($tit->st_value);
	}
	
	return "No Title";
}
function getWebSiteName()	//pranab
{
	$sql="select st_value from site_settings where st_id=4 and st_status=1";
	$query=mysql_query($sql);
	if($tit=mysql_fetch_object($query))
	{
		return ucfirst($tit->st_value);
	}
	
	return "No Title";
}

function getWebSiteTitle()	//pranab
{
	$sql="select st_value from site_settings where st_id=1 and st_status=1";
	$query=mysql_query($sql);
	if($tit=mysql_fetch_object($query))
	{
		return ucfirst($tit->st_value);
	}
	
	return "No Title";
}
function getMinWithdrawAmt()	//pranab
{
	$sql="select st_value from site_settings where st_id=9 and st_status=1";
	$query=mysql_query($sql);
	if($tit=mysql_fetch_object($query))
	{
		return ucfirst($tit->st_value);
	}
}

function get_page_settings($x)
{
	$sql = "select * from site_settings where st_id='".$x."'";
	$qry = mysql_query($sql);
	$arr = mysql_fetch_array($qry);	
	return $arr['st_value'];
}
function getCurrencyCode()
{
	$sql = "select * from site_settings where st_id='7'";
	$qry = mysql_query($sql);
	$arr = mysql_fetch_array($qry);	
	return stripslashes($arr['st_value']);
}
function getCurrencySymbol()
{
	$sql = "select * from site_settings where st_id='8'";
	$qry = mysql_query($sql);
	$arr = mysql_fetch_array($qry);	
	return stripslashes($arr['st_value']);
}
function get_page_content($x)
{
	$sql = "select * from cms where cms_id='".$x."'";
	$qry = mysql_query($sql);
	$arr = mysql_fetch_array($qry);	
	return stripslashes($arr['cms_content']);
}
/*function strip_content($content,$length){
	$str='';
	if(strlen($content)>$length){
		$str.=substr($content,0,$length)."...";
	}
	else{
		$str.=$content;
	}
	return $str;
}*/


function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

function datetimeDifference($startDt,$endDt)
{
	$expDate = strtotime($endDt);
	$curDate = strtotime($startDt);
	$second=$expDate - $curDate;
	
	$min=floor($second/60);
	$sec=$second%60;

	$hr=floor($min/60);
	$min=$min%60;
	$dy=floor($hr/24);
	$hr=$hr%24;
	
	$str="";
	
	if($dy>=1)
	{
		if($hr!=0)
		{
			$str = $dy." days ".$hr." hours";
		}
		else
		{
			$str = $dy." days";
		}
	}
	else if($hr>=1){
		$str = $hr." hours ".$min." mins";
	}
	else if($min>=1){
		$str = $min." mins ".$sec." sec";
	}
	else{
		$str = $sec." sec";
	}
	return $str;
}

function profileCompleteness($uid)
{
	$per=0;
	
	$sql_photo="select * from user where usr_id='".$uid."'";
	$res_photo=mysql_query($sql_photo);
	$row_photo=mysql_fetch_object($res_photo);
	if($row_photo->usr_image != '')
	{
		$per=20;
	}
	
	$sql_pfol="select * from user_portfolio where up_usr_id='".$uid."'";
	$res_pfol=mysql_query($sql_pfol);
	if(mysql_num_rows($res_pfol)>0)
	{
		$per=$per+20;	
	}
	
	$sql_exp="select * from user_experience where ue_usr_id='".$uid."'";
	$res_exp=mysql_query($sql_exp);
	if(mysql_num_rows($res_exp)>0)
	{
		$per=$per+20;	
	}
	
	$sql_edu="select * from user_education where ued_usr_id='".$uid."'";
	$res_edu=mysql_query($sql_edu);
	if(mysql_num_rows($res_edu)>0)
	{
		$per=$per+10;	
	}
	
	$sql_cert="select * from user_certification where ucr_usr_id='".$uid."'";
	$res_cert=mysql_query($sql_cert);
	if(mysql_num_rows($res_cert)>0)
	{
		$per=$per+10;	
	}

	$sql_skl="select * from user_skills where usk_usr_id='".$uid."'";
	$res_skl=mysql_query($sql_skl);
	if(mysql_num_rows($res_skl)>0)
	{
		$per=$per+20;	
	}


	return $per;
}
function table_data($id,$data,$table)
{
$sql="select $data from $table where $id";
$res=mysql_query($sql);
$row=mysql_fetch_array($res);
$return=$row[$data];
echo "$return";
}

function createRandomPassword($t) {
if($t==1){
    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
}
if($t==2){
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ023456789";
}
if($t==3){
    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
}
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '' ;
 while ($i <= 7) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }
    return $pass;
}
?>