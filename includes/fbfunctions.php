<?php
include "lib/connect.php";
function get_page_settings($x)
{
	$sql = "select * from site_settings where st_id='".$x."'";
	$qry = mysql_query($sql);
	$arr = mysql_fetch_array($qry);	
	return $arr['st_value'];
}
function createRandomPassword($t) {
if($t==1){
    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
}
if($t==2){
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ023456789";
}
if($t==3){
    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
}
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '' ;
 while ($i <= 7) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }
    return $pass;
}
class User {

    function checkUser($uid, $oauth_provider, $username, $email) 
	{
        $query = mysql_query("SELECT * FROM `user` WHERE usr_email = '$email'") or die(mysql_error());
        $result = mysql_fetch_array($query);
        if (!empty($result)) {
        $query_f = mysql_query("update `user` set oauth_id = '$uid', oauth_provider = '$oauth_provider' WHERE usr_email = '$email'") or die(mysql_error());
  //      $result_f = mysql_fetch_array($query_f);
        } else {
            #user not present. Insert a new Record
	$usr_password=createRandomPassword('1');
 	$usr_password=md5($usr_password);
$parts = explode("@", $email);
$usr_name = $parts[0];
$query = mysql_query("INSERT INTO `user` (usr_name, usr_password, oauth_provider, oauth_id, usr_email, usr_type, usr_verify) VALUES ('$usr_name', '$usr_password', '$oauth_provider', $uid, '$email','individual','1')") or die(mysql_error());
            $query = mysql_query("SELECT * FROM `user` WHERE oauth_id = '$uid' and oauth_provider = '$oauth_provider'") or die(mysql_error());
            $result = mysql_fetch_array($query);
            return $result;
        }
        return $result;
    }

}

?>
