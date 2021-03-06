<?php

/**
# A sample script that follows 'SUGGESTED' users in a loop.
#
# A sample script that unfollows friends in a loop
# 
# Author: ericwilliamstevenson@gmail.com
**/

include_once('../conf/twitter-bot.php'); // INCLUDE THE BOT AND AUTH
include_once('../friends_and_followers/friends_and_followers.php'); // INCLUDE THE FUNCTIONS

$twitter_bot = twitter_login(); // CREATE THE BOT
$get_suggested_user_lists = get_suggested($twitter_bot); // RETURNS LIST OF 'SUGGESTED' TWITTER IDS
$friend_ids = get_friend_ids($twitter_bot, '3255871182'); // RETURNS CURSORED LIST OF FRIENDS FOR PROVIDED TWITTER ID. THIS SHOULD BE YOURS. 


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
#               $unfollow = unfollow_user($twitter_bot, array_pop($friend_ids->{'ids'}));

#}

// die;
// END TRIM

foreach ($get_suggested_user_lists as $user_list) {
	#print_r($user_list);
	foreach ($user_list as $users) {
		foreach ($users as $user) { 
			#print_r($user);
			print 'Following: '.$user->{'name'}." ".$user->{'id_str'}."\n";
			$follow = follow_user($twitter_bot, $user->{'id_str'});
			$unfollow = unfollow_user($twitter_bot, array_pop($friend_ids->{'ids'}));
			$unfollow = unfollow_user($twitter_bot, array_pop($friend_ids->{'ids'}));
			sleep(120);
		}
	}
}

?>
