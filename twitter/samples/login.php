<?php

include_once('hehy.conf.php');


print_r(twitter_connection());


function twitter_connection(){
    // Connect to Twitter
    $connection = new TwitterOAuth($twitter_consumer_key, $twitter_consumer_secret, $twitter_access_token, $twitter_access_token_secret);
    return $connection;
}

?>
