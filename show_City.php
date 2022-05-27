<?php
include "common.php";
$cn=$_GET["cn"];

if (strlen($cn) > 0)
{
	$sql="select * from city where ct_cn_id=".$cn." order by ct_name";  
	$result=mysql_query($sql);
	$ct="<option value='0'>".$lang[656]."</option>";
	while($row=mysql_fetch_object($result))
	{
		$ct.="<option value=".$row->ct_id.">".$row->ct_name."</option>";
  	}
}

echo $ct;
?>
