<?php
include "../common.php";

$ued_id = addslashes(trim($_GET['ued_id']));

$sql_ued="delete from user_education where ued_id = '".$ued_id."'";
mysql_query($sql_ued);

?>