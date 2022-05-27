<?php
include "../common.php";

$prj_id=$_GET['prj_id'];

$validity=get_page_settings(6);

$sql="update project
		set
			prj_expiry=date_add(NOW(),INTERVAL ".$validity." DAY),
			prj_updated_date=now(),
			prj_status='close'
where prj_id='".$prj_id."'";

mysql_query($sql);

?>