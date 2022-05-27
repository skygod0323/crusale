<?php

$ip=$_SERVER['REMOTE_ADDR'];
echo $ip;
$addr_details = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=".$ip));
$city = stripslashes(ucfirst($addr_details[geoplugin_city]));
$countrycode = stripslashes(ucfirst($addr_details[geoplugin_countryCode]));
$country = stripslashes(ucfirst($addr_details[geoplugin_countryName]));
echo $city;
echo $countrycode;
echo $country;


/*function get_client_ip()
{
     $ipaddress = '';
     if (getenv('HTTP_CLIENT_IP'))
         $ipaddress = getenv('HTTP_CLIENT_IP');
     else if(getenv('HTTP_X_FORWARDED_FOR'))
         $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
     else if(getenv('HTTP_X_FORWARDED'))
         $ipaddress = getenv('HTTP_X_FORWARDED');
     else if(getenv('HTTP_FORWARDED_FOR'))
         $ipaddress = getenv('HTTP_FORWARDED_FOR');
     else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
     else if(getenv('REMOTE_ADDR'))
         $ipaddress = getenv('REMOTE_ADDR');
     else
         $ipaddress = 'UNKNOWN';

     return $ipaddress; 
}

echo get_client_ip();*/

?>