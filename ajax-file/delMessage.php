<?php
include "../common.php";

$msg_id=$_GET['msg_id'];
$fld=$_GET['fld'];
if($fld=='to')
{
$sql="update message set msg_to_status='0' where msg_id='".$msg_id."'";
mysql_query($sql);
}
else if($fld=='from')
{
    $sql="update message set msg_from_status='0' where msg_id='".$msg_id."'";
    mysql_query($sql);
}
?>
