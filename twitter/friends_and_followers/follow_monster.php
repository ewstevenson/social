<?php
include_once('../conf/twitter-info.php');

$twitter_bot = twitter_login(); // CREATE THE BOT

$get_em = get_suggested($twitter_bot); // RETURNS LIST OF 'RANDOM' TWITTER IDS
$friend_ids = get_friend_ids($twitter_bot, '1661589386'); // RETURNS CURSORED LIST OF FOLLWINGS


/**
# Because following a user often results in a 'follow back', to increase follower count
# this bot increases following count.  To prevent an absurd followers:following ratio,
# you may want to unfollow these 'RANDOM' accounts
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
		$unfollow = unfollow_user($twitter_bot, array_pop($friend_ids->{'ids'}));
		$unfollow = unfollow_user($twitter_bot, array_pop($friend_ids->{'ids'}));
		$unfollow = unfollow_user($twitter_bot, array_pop($friend_ids->{'ids'}));
		sleep(120);
	}
}


function follow_user($bot, $userid) {
	$post_url = 'https://api.twitter.com/1.1/friendships/create.json?user_id='.$userid.'&follow=true';
	return $bot->post($post_url);
}

function unfollow_user($bot, $userid) {
	$post_url = 'https://api.twitter.com/1.1/friendships/destroy.json?user_id=' . $userid ;
	return $bot->post($post_url);

}

function get_suggested($bot) {
	return $bot->get('https://api.twitter.com/1.1/users/suggestions/twitter.json');
}

function get_friend_ids($bot, $userid) {
	$get_url = 'https://api.twitter.com/1.1/friends/ids.json?cursor=-1&user_id=' . $userid . '&count=1000';
	return $bot->get($get_url);
}

function get_followers($bot, $userid, $cursor) {
	$get_url = 'https://api.twitter.com/1.1/followers/list.json?cursor=' . $cursor . '&user_id=' . $userid;
	return $bot->get($get_url);

}



?>
