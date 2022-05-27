<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'free_lancer');
define('DB_PASSWORD', '24Password987@');
define('DB_DATABASE', 'free_lancer');

//define('USERS_TABLE_NAME', 'users_table_name');

$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
$database = mysql_select_db(DB_DATABASE) or die(mysql_error());
?>
