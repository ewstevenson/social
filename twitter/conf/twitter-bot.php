<?php

/**
# Authenticates to twitter and returns a bot object.
#
# twitter-info.php needs to be populated with your twitter application information
#
# Author: ericwilliamstevenson@gmail.com
#
**/


function twitter_login() {
	include_once('../oauth/twitteroauth.php');
	include_once('twitter-info.php');
    	$connection = new TwitterOAuth($api_key, $api_secret, $access_token, $access_token_secret);
    	return $connection;

}

?>
