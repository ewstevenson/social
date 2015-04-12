<?php

// https://api.twitter.com/1.1/trends/place.json?id=1 
require_once('../oauth/twitteroauth.php');
require_once('../conf/twitter-bot.php');
// WOEID == yahoo woeid

error_reporting(0);

$connection = twitter_login();
$locations = $connection->get('https://api.twitter.com/1.1/trends/available.json');
$rate_limit = $connection->get('https://api.twitter.com/1.1/application/rate_limit_status.json?resources=help,users,search,statuses');

while (1) {
	foreach ($locations as $location) {
		$woeid = $location->{'woeid'};
		//$country = $location->{'country'};
		$trends = $connection->get('https://api.twitter.com/1.1/trends/place.json?id='. $woeid);
		print_r($trends);
		foreach ($trends as $trend) {
			for ($i=0; $i<9; $i++) {
				$loc = $trend->locations[0]->{'name'};
				$tag = $trend->trends[$i]->{'name'};
				$query = $trend->trends[$i]->{'query'};
				$promoted = $trend->trends[$i]->{'promoted_content'};
				$url = $trend->trends[$i]->{'url'};
				if ($trend->{'message'}) {
					print $trend->{'message'};
					sleep(7);
				}
			}
		}
#		print_r($trends);
		sleep(60);
	}
}

# $worldwide = $connection->get('https://api.twitter.com/1.1/trends/place.json?id=1');
# $UT = $connection->get('https://api.twitter.com/1.1/trends/place.json?id=12794146');
# print_r($worldwide);
# print_r($UT);
# print_r($locations);
?>
