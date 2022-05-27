<?php
include "common.php";
$cat_id=$_GET["cat"];

if (strlen($cat_id) > 0)
{
	$sql="select * from skills where sk_cat_id=".$cat_id." and sk_status=1 order by sk_name";  

	$result=mysql_query($sql);
	$ct="<option value='0'>".$lang[321]."</option>";
	while($row=mysql_fetch_object($result))
	{
  		$ct.="<option value=".$row->sk_id.">".ucfirst($row->sk_name)."</option>";
  	}
}

echo $ct;
?>