<?
/*
Example code to parse player XML data from ACSSR.

You will need PHP 5 with the SimpleXML extension enabled.
See http://au3.php.net/manual/en/ref.simplexml.php for more details.
*/

// comma separated list of player id's. Do not put spaces or letters in there!
$player_list = '286585,54517';

$xml = simplexml_load_file('http://acssr.slowchop.com/xml-player.php?id=' . $player_list);

$br = "\n<br>\n<br>\n";

foreach ($xml->player as $player) {

	print $player['name'] . ' is ranked ' . $player->rank . ' and was last seen on ' . $player->lastserver . '. ';
	print 'Today, ' . $player['name'] . ' has played for ' . $player->history->day[0]->time . ' seconds.' . $br;
	
}

?>
