<?php
ob_start();
session_start();

unset($_SESSION['uid']);
unset($_SESSION['usr']);
unset($_SESSION['psw']);
unset($_SESSION['eml']);
unset($_SESSION['img']);
unset($_SESSION['type']);
unset($_SESSION['last_page']);
unset($_SESSION['promotion_msg']);
unset($_SESSION['token']);

unset($_SESSION['temp_proj']);

header("Location:index.php");
?>
