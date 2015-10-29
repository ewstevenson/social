<?php

/**
# A sample script that follows 'RANDOM' users in a loop.
#
# A sample script that unfollows friends in a loop
# 
# Author: ericwilliamstevenson@gmail.com
**/


include_once('../conf/twitter-info.php'); // INCLUDE THE BOT AND AUTH
include_once('../conf/twitter-bot.php'); // INCLUDE THE BOT AND AUTH
include_once('../friends_and_followers/friends_and_followers.php'); // INCLUDE THE FUNCTIONS

$twitter_bot = twitter_login(); // CREATE THE BOT
$get_em = get_suggested($twitter_bot); // RETURNS LIST OF 'RANDOM' TWITTER IDS
$friend_ids = get_friend_ids($twitter_bot, $owner_id); // RETURNS CURSORED LIST OF FRIENDS FOR PROVIDED TWITTER ID. THIS SHOULD BE YOURS. 


/**
# Because following a user often results in a 'follow back', to increase follower count
# this bot increases following count.  To prevent an absurd followers:following ratio,
# you may want to unfollow these 'RANDOM' accounts and hope they dont realize you unfollowed 
# them
**/

foreach ($friend_ids->{'ids'} as $friend_id) {
	$unfollow = unfollow_user($twitter_bot, $friend_id);
	print_r($unfollow);
	sleep(30);
}

// die;
// END TRIM

foreach ($get_em->{'users'} as $user) {
	$followers = $twitter_bot->get('https://api.twitter.com/1.1/followers/ids.json?cursor=-1&user_id='. $user->{'id_str'} .'&count=200');
	foreach ($followers->{'ids'} as $id) {
		print "Following: $id \n";
		$follow = follow_user($twitter_bot, $id);
#		$unfollow = unfollow_user($twitter_bot, array_pop($friend_ids->{'ids'}));
#		$unfollow = unfollow_user($twitter_bot, array_pop($friend_ids->{'ids'}));
#		$unfollow = unfollow_user($twitter_bot, array_pop($friend_ids->{'ids'}));
		sleep(120);
	}
}

?>
