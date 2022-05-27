<?php 

$_SESSION['uid']=$userdata['usr_id'];
$_SESSION['usr']=$userdata['usr_name'];
$_SESSION['psw']=$userdata['usr_password'];
$_SESSION['eml']=$userdata['usr_email'];
$_SESSION['img']=$userdata['usr_image'];
$_SESSION['type']=$userdata['usr_type'];

//$_SESSION['login_pint'] = 'true';
header("Location:../../index.php"); 

?>