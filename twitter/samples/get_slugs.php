<?php

include_once('../conf/twitter-bot.php'); // INCLUDE THE BOT AND AUTH
include_once('../friends_and_followers/friends_and_followers.php'); // INCLUDE THE FUNCTIONS

$twitter_bot = twitter_login(); // CREATE THE BOT
#$get_slugs = get_slugs($twitter_bot);
$get_suggested_users = get_suggested($twitter_bot);
#print_r($get_slugs);

foreach ($get_suggested_users as $slug) {
	print_r($slug);
	
}


?>
