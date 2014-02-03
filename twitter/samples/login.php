<?php

function twitter_connection(){
    // Connect to Twitter
    $connection = new TwitterOAuth($twitter_consumer_key, $twitter_consumer_secret, $twitter_access_token, $twitter_access_token_secret);    $content = $connection->post('statuses/update', array('status' => "$tweet"));
    return $connection;
}

?>
