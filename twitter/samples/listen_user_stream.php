<?php

require_once('../lib/Phirehose.php');
require_once('../lib/UserstreamPhirehose.php');
require_once('../lib/OauthPhirehose.php');
require_once('../direct_messages/dm.php');
require_once('../conf/twitter-info.php');

/**
 * Example of using Phirehose to display a live filtered stream using track words 
 */
class UserStreamListener extends OauthPhirehose
{
  /**
   * Enqueue each status
   *
   * @param string $status
   */


  public function enqueueStatus($status)
  {


    /*
     * In this simple example, we will just display to STDOUT rather than enqueue.
     * NOTE: You should NOT be processing tweets at this point in a real application, instead they should be being
     *       enqueued and processed asyncronously from the collection process. 
     */
    $data = json_decode($status, true);
    if (is_array($data) && isset($data['user']['screen_name'])) {
	// GOT TWEET
	// DO SOMETHING

      $verbs = Array( 'join', 'find', 'leave'); // LISTENING FOR THESE ACTION WORDS
      $have_tags = count($data['entities']['hashtags']);
      for ($i = 0; $i < $have_tags; $i++) {
		$actionable = in_array($data['entities']['hashtags'][$i]['text'], $verbs, true);
		if ($actionable) {
			$uid = $data['user']['id'];

			switch($data['entities']['hashtags'][$i]['text']) {
			case 'join':
				print "Taking action join " . $data['entities']['hashtags'][$i]['text'] . "\n";				
				print "Sending welcome dm to $uid\n";	
				$text = "Thanks for joining!";
				$dm = send_direct_message($uid, $text, $access_token, $access_token_secret, $api_key, $api_secret);
				print_r($dm);
				break;
			case 'find':
				print "Taking action find " . $data['entities']['hashtags'][$i]['text'] . "\n";				
				break;
			case 'leave':
				print "Taking action leave ". $data['entities']['hashtags'][$i]['text'] . "\n";				
				break;
			}
		} else {
			print $data['entities']['hashtags'][$i]['text'] . " is not actionable. \n";
		}
	}	
      
      print $data['user']['screen_name'] . ': ' . urldecode($data['text']) . "\n";

    }
  }
}


define("TWITTER_CONSUMER_KEY", "$api_key");
define("TWITTER_CONSUMER_SECRET", "$api_secret");

// The OAuth data for the twitter account
define("OAUTH_TOKEN", "$access_token");
define("OAUTH_SECRET", "$access_token_secret");

// Start streaming
$sc = new UserStreamListener(OAUTH_TOKEN, OAUTH_SECRET, Phirehose::METHOD_USER);
$sc->consume();

?>
