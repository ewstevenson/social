<?php

require_once('../streaming/lib/Phirehose.php');
require_once('../streaming/lib/UserstreamPhirehose.php');
require_once('../streaming/lib/OauthPhirehose.php');
require_once('../conf/twitter-info.php');

/**
 * Example of using Phirehose to display a live filtered stream using track words 
 */
class FilterTrackConsumer extends OauthPhirehose
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
	print_r($data);
    if (is_array($data) && isset($data['user']['screen_name'])) {
      print $data['user']['screen_name'] . ': ' . urldecode($data['text']) . "\n";
    }
  }
}

// The OAuth credentials you received when registering your app at Twitter
define("TWITTER_CONSUMER_KEY", "$api_key");
define("TWITTER_CONSUMER_SECRET", "$api_secret");

// The OAuth data for the twitter account
define("OAUTH_TOKEN", "$access_token");
define("OAUTH_SECRET", "$access_token_secret");

// Start streaming
$sc = new FilterTrackConsumer(OAUTH_TOKEN, OAUTH_SECRET, Phirehose::METHOD_FILTER);
$sc->setTrack(array('join', 'jion', '#join', '#jion'));
$sc->consume();

?>
