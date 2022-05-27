<?php
include "common.php";
$q=$_GET["q"];

//lookup all hints from array if length of q>0
if (strlen($q) > 0)
{
	$sql="select * from subcategory where scat_cat_id=".$q." and scat_status=1 order by scat_name";  

	$result=mysql_query($sql);
	$ct="<option value='0'>".$lang[427]."</option>";
	while($row=mysql_fetch_object($result))
	{
  		$ct.="<option value=".$row->scat_id.">".$row->scat_name."</option>";
  	}
}

echo $ct;
?>
