<?php
ob_start();
session_start();
include "../common.php";


if(isset($_GET['usr_name']))
{
	mysql_query("update user set usr_name='".trim($_GET['usr_name'])."' where usr_id='".$_SESSION['uid']."'");
}

echo $_GET['usr_name'];

?>