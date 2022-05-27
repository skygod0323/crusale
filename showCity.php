<?php
include "common.php";
$q=$_GET["q"];

if (strlen($q) > 0)
{
	$sql="select * from city where ct_cn_id=".$q." order by ct_name";  
	$result=mysql_query($sql);
	$ct="<option value='0'>".$lang[526]."</option>";
	while($row=mysql_fetch_object($result))
	{
		$ct.="<option value=".$row->ct_id.">".$row->ct_name."</option>";
  	}
}

echo $ct;
?>
