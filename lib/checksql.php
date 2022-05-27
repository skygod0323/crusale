<?php
if($key = array_keys($_GET)) {
foreach ($key as $keys){
if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', "$_GET[$keys]")){
header("Location: index.php");
}
}}

if($key = array_keys($_REQUEST)) {
foreach ($key as $keys){
if(preg_match("/0x3a/i", "$_REQUEST[$keys]")){
$_REQUEST[$keys] = str_replace("0x3a", "0", "$_REQUEST[$keys]");
}
if(preg_match("/concat/i", "$_REQUEST[$keys]")){
$_REQUEST[$keys] = str_replace("concat", "", "$_REQUEST[$keys]");
}
if(preg_match("/union/i", "$_REQUEST[$keys]")){
$_REQUEST[$keys] = str_replace("union", "", "$_REQUEST[$keys]");
}
}}

if($key = array_keys($_POST)) {
foreach ($key as $keys){
if(preg_match("/0x3a/i", "$_POST[$keys]")){
$_POST[$keys] = str_replace("0x3a", "0", "$_POST[$keys]");
}
if(preg_match("/concat/i", "$_POST[$keys]")){
$_POST[$keys] = str_replace("concat", "", "$_POST[$keys]");
}
if(preg_match("/union/i", "$_POST[$keys]")){
$_POST[$keys] = str_replace("union", "", "$_POST[$keys]");
}
}}
?>
