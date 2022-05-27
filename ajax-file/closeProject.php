<?php
include "../common.php";

$prj_id=$_GET['prj_id'];
$sql="update project
		set
			prj_expiry =now(),
			prj_status='close'
where prj_id='".$prj_id."'";

mysql_query($sql);

?>