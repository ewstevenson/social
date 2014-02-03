<?php

include_once('twitteroauth/twitteroauth/twitteroauth.php');

function twitter_login() {


    $access_token = '';
    $access_token_secret = '';
    $consumer_key = '';
    $consumer_secret = '';
    $connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
    return $connection;

}





?>
