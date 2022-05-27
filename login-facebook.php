<?php
error_reporting(0);
include 'includes/facebook.php';
include 'includes/fbfunctions.php';
$APP_ID=get_page_settings(11);
$APP_SECRET=get_page_settings(12);

define('APP_ID', $APP_ID);
define('APP_SECRET', $APP_SECRET);

$facebook = new Facebook(array(
            'appId' => APP_ID,
            'secret' => APP_SECRET
        ));

    $user1 = $facebook->getUser();

if ($user1) 
{
    # Active session, let's try getting the user id (getUser()) and user info (api->('/me')) 
try {
        $uid = $facebook->getUser();
        $user = $facebook->api('/me');
    } 
    catch (FacebookApiException $e) {
        error_log($e);
        $user1 = null;

    }

    if (!empty($user)) 
    {

        $username = $user['name'];
        $email = $user['email'];
        $user = new User();
       $userdata = $user->checkUser($uid, 'facebook', $username, $email);
        
        if(!empty($userdata))
        {
          //  session_start();
            $_SESSION['uid'] = $userdata['usr_id'];
	      $_SESSION['oauth_id'] = $uid;
		$_SESSION['eml']=$userdata['usr_email'];
		$_SESSION['psw']=$userdata['usr_password'];
            $_SESSION['usr'] = $userdata['usr_name'];
            $_SESSION['oauth_provider'] = $userdata['oauth_provider'];
            
            header("Location: index.php"); //header("Location: home.php");
        }
    } 
    else
    {

        # For testing purposes, if there was an error, let's kill the script
//        die("There was an error.");
    }
}
 else 
 {
    # There's no active session, let's generate one
   $login_url = $facebook->getLoginUrl(array(
    'scope' => 'email'
));
     header("Location: " . $login_url);
//echo "ff";
}
?>