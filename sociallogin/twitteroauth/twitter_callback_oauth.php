<?php
include '../../common.php';
include '../function.php';
require_once('twitteroauth.php');

$CONSUMER_KEY = social_login_settings(16);
$CONSUMER_SECRET= social_login_settings(17);
$OAUTH_CALLBACK= social_login_settings(18);

/*$CONSUMER_KEY = 'N5y8bHU6CJPIjF4jXfe47w';
$CONSUMER_SECRET= 'o8EgfQiSSVP3K0NbLNwFHnKLU6JDZbT4muVS1pOZJM';
$OAUTH_CALLBACK= 'http://fb.demonstrationserver.com/freelancer_gundus/sociallogin/twitteroauth/twitter_callback_oauth.php';*/

if(isset($_GET['oauth_token']))
{

	$connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET, $_SESSION['request_token'], $_SESSION['request_token_secret']);
	$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
	
	if($access_token)
	{
			$connection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
			$params =array();
//			$params['include_entities']='false';
//			$content = $connection->get('account/verify_credentials',$params);

			$content = $connection->get('account/verify_credentials');
	
			if($content && isset($content->screen_name) && isset($content->name))
			{
				$_SESSION['name']=$content->name;
				$_SESSION['image']=$content->profile_image_url;
				$_SESSION['twitter_id']=$content->screen_name;
				
				include '../twit_sql_session.php';
			}
			else
			{
				echo "<h4> Login Error </h4>";
			}
	}

else
{

	echo "<h4> Login Error </h4>";
}

}
else //Error. redirect to Login Page.
{
	header('Location: ../login.php'); 

}

?>