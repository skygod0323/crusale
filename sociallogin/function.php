<?php 


function social_login_settings($x)
{
	$sql = "select * from social_media_login_info where smli_id='".$x."'";
	$qry = mysql_query($sql);
	$arr = mysql_fetch_array($qry);	
	return stripslashes($arr['smli_value']);
}
?>