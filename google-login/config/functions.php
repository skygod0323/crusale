<?php

require 'dbconfig.php';

class User {

    function checkUserGoogle($uid, $oauth_provider, $username, $email)
	{
        //$userstable = USERS_TABLE_NAME;
        $query = mysql_query("SELECT * FROM user WHERE usr_email = '$email' and oauth_provider = '$oauth_provider'") or die(mysql_error());
        $result = mysql_fetch_array($query);
        if (!empty($result)) {
            # User is already present
        } else {
            #user not present. Insert a new Record
            echo "INSERT INTO user (oauth_provider, oauth_id, usr_name, usr_email) VALUES ('$oauth_provider', '$uid', '$username', '$email')";
            echo "<br/>INSERT INTO user (oauth_provider, oauth_id, usr_name, usr_email) VALUES ('$oauth_provider', $uid, '$username', '$email')";
            $query = mysql_query("INSERT INTO user (oauth_provider, oauth_id, usr_name, usr_email) VALUES ('$oauth_provider', '$uid', '$username', '$email')") or die(mysql_error());
            $query = mysql_query("SELECT * FROM user WHERE usr_email = '$email' and oauth_provider = '$oauth_provider'");
            $result = mysql_fetch_array($query);
            return $result;
        }
        return $result;
    }

    

}

?>
