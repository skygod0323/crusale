<?php
ob_start();
session_start();
include "../common.php";


if(isset($_GET['usr_summary']))
{
	mysql_query("update user set usr_summary='".$_GET['usr_summary']."' where usr_id='".$_SESSION['uid']."'");
}

echo $_GET['usr_summary'];

?>