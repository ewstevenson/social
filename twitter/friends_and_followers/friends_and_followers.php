<?php

function follow_user($bot, $userid) {
	$post_url = 'https://api.twitter.com/1.1/friendships/create.json?user_id='.$userid.'&follow=true';
	return $bot->post($post_url);
}

function unfollow_user($bot, $userid) {
	$post_url = 'https://api.twitter.com/1.1/friendships/destroy.json?user_id=' . $userid ;
	return $bot->post($post_url);

}

function get_suggested($bot,$slug) {
	return $bot->get('https://api.twitter.com/1.1/users/suggestions/'.$slug.'.json');
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
