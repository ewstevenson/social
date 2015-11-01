<?php

/**
# A sample script that follows 'RANDOM' users in a loop.
#
# A sample script that unfollows friends in a loop
# 
# Author: ericwilliamstevenson@gmail.com
**/

include_once('../conf/twitter-bot.php'); // INCLUDE THE BOT AND AUTH
include_once('../friends_and_followers/friends_and_followers.php'); // INCLUDE THE FUNCTIONS

$twitter_bot = twitter_login(); // CREATE THE BOT
$get_suggested_users = get_suggested($twitter_bot); // RETURNS LIST OF 'SUGGESTED' TWITTER IDS
#print_r($get_suggested_users);
#die;
#$friend_ids = get_friend_ids($twitter_bot, $owner_id); // RETURNS CURSORED LIST OF FRIENDS FOR PROVIDED TWITTER ID. THIS SHOULD BE YOURS. 


/**
# Because following a user often results in a 'follow back', to increase follower count
# this bot increases following count.  To prevent an absurd followers:following ratio,
# you may want to unfollow these 'RANDOM' accounts and hope they dont realize you unfollowed 
# them
**/

#foreach ($friend_ids->{'ids'} as $friend_id) {
#	$unfollow = unfollow_user($twitter_bot, $friend_id);
#	print_r($unfollow);
#	sleep(30);
#}

// die;
// END TRIM

foreach ($get_suggested_users as $suggested_user_list) {
			print 'Following: '.$user->{'id_string'}."\n";
			$follow = follow_user($twitter_bot, $user->{'id_string'});
			sleep(120);
}

?>
