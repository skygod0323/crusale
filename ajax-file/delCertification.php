<?php
ob_start();
session_start();
include "../common.php";

$ucr_id = addslashes(trim($_GET['ucr_id']));

$sql_cert="delete from user_certification where ucr_id = '".$ucr_id."'";

mysql_query($sql_cert);

?>