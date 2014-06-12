<?php

require_once('../oauth/twitteroauth.php');
require_once('../conf/twitter-info.php');

function send_direct_message($uID, $text, $access_token, $access_token_secret, $api_key, $api_secret) {
    $connection = new TwitterOAuth($api_key, $api_secret, $access_token, $access_token_secret);
    $dm = $connection->post('direct_messages/new', array('text' => "$text", 'user_id' => "$uID"));
    return $dm;
}



?>
