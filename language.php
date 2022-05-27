<?php
$lng_sql="select * from site_settings where st_id='10' and st_status='1'";
$res_sql=mysql_query($lng_sql);
$row_sql=mysql_fetch_object($res_sql);
include 'lang/'.strtolower($row_sql->st_value).'.php';
?>