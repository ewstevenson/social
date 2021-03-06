#!/usr/bin/perl

use Kafka::Consumer;
use Kafka::Connection;
use Kafka::IO;
use Kafka::Message;
use Data::Dumper;
use JSON;

use charnames ':full';
binmode(STDOUT, ":utf8");

# connect to local cluster with the defaults
my $connection = Kafka::Connection->new( host => 'localhost' );
my $io = Kafka::IO->new( host => 'localhost' );
$consumer = Kafka::Consumer->new( Connection => $connection );
my $topic = 'twitter_all_streams';
$json = JSON->new->allow_nonref;

use Kafka qw(
	$DEFAULT_MAX_BYTES
	$DEFAULT_MAX_NUMBER_OF_OFFSETS
	$RECEIVE_EARLIEST_OFFSETS
);

# Get a list of valid offsets up to max_number before the given time
my $offsets = $consumer->offsets(
	$topic,                      # topic
	0,                              # partition
	$RECEIVE_EARLIEST_OFFSETS,    #time 
	$DEFAULT_MAX_NUMBER_OF_OFFSETS  # max_number
	);

print "Received offset: $_" foreach @$offsets;

# Consuming messages
my $messages = $consumer->fetch(
	$topic,                      # topic
	0,                              # partition
	377,                              # offset
	$DEFAULT_MAX_BYTES              # Maximum size of MESSAGE(s) to receive
);


foreach my $message ( @$messages ) {
	if( $message->valid ) {
		#print Dumper($message->payload);
		my $tweet = $message->payload;
		chop($tweet);
		$tweet = from_json( $tweet );
		print "Source: " . $tweet->{'source'} . "\n";
		print "Text: " . $tweet->{'text'} . "\n";
		print "URL: " . $tweet->{'url'} . "\n";
		print "ScreenName: " . $tweet->{'user'}{'screen_name'} . "\n";
		print "UserID: " . $tweet->{'user'}{'id'} . "\n";
		#print "#########\n\n payload    : ". $message->payload . "#############\n\n\n";
		#print 'key        : ', $message->key . "\n";
		#print 'offset     : ', $message->offset . "\n";
		#print 'next_offset: ', $message->next_offset . "\n";
	} else {
		print 'error      : ', $message->error . "\n\n";
	}
}
