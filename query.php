<?

$nohtml = 1;
require_once("include.php");

$vars = array("mode", "output", "search", "i", "c", "v");

foreach($vars as $var) {

	$$var = "";
	if (isset($_GET[$var]))
		$$var = $_GET[$var];

}

$g = new generateSQL('ircbot', 'insert');
$g->field('whenn', time());
$g->field('version', $v);
$g->field('ircip', $i);
$g->field('ircchannel', $c);
$g->field('userip', $_SERVER["REMOTE_ADDR"]);
$g->field('output', $output);
$g->field('mode', $mode);
$g->field('search', $search);
$db->query($g->sql());

if ($output != "mirc") {
	ircerror("output '$output' not supported");
}

// mode 0 does a search for a players name
switch ($mode) {
case 0:
	if ($search == '')
		ircerror('ERROR no name specified');
	$res = $db->query("$sqlserverjoin WHERE player.ename like '%$search%' and lastserverwhen > unix_timestamp() - 60*60*24*14 and player.deleted = 0 ORDER BY score DESC LIMIT 5");
	if ($db->count() == 0)
		die("ACSSR\nSorry, no results found for $search...\n");
	formatOutput($res);
	break;

case 1:
	if ($search == '') die('no ID list specified');
	$res = $db->query("$sqlserverjoin WHERE player.id in ($search) ORDER BY score DESC LIMIT 10");
	formatOutput($res);
	break;

case 2:
	$res = $db->query("$sqlserverjoin ORDER BY score and player.deleted = 0 DESC LIMIT 10");
	formatOutput($res);
	break;

case 3:
	$res = $db->query("$sqlserverjoin where curserverid is not NULL and player.deleted = 0 ORDER BY score DESC LIMIT 10");
	formatOutput($res);
	break;

case 4:
	if ($search == '') die('ERROR no ID list specified');
	$res = $db->query("$sqlserverjoin WHERE player.id in ($search) and curserverid is not null and player.deleted = 0 ORDER BY score DESC LIMIT 10");
	if ($db->count() == 0)
		die("ACSSR\nNo members are online...\n");
	formatOutputOnline($res);
	break;

default:
	ircerror('unknown mode');

}

// $db->quickquery("update stats set queries = queries + 1");

function formatOutput($res) {

	global $output,$db;
	
	if ($output != "mirc")
		return;

	$fmt = " %-6s %-20s %-5s %-4s %-5s %-5s %-28s\n";

	printf($fmt, '#', 'Name', 'Score', 'P/M', 'P', 'T', 'Last Seen');

	while (($dat = $db->fetchobject($res))) {

		$dat->servername = shortServerName($dat->servername);
		$dat->servername = substr($dat->servername, 0, 27);

		if ($dat->curserverid > 0)
			$dat->server = $dat->servername;
		else
			$dat->server = humanTime(time() - $dat->lastserverwhen, true) . " ago";
	
		printf($fmt, $dat->rank, substr($dat->ename,0,20), $dat->score, $dat->ppm, $dat->totalfrags, $dat->minutes . 'm', $dat->server);
		
	}

}

function formatOutputOnline($res) {

	global $output,$db;
	
	if ($output != "mirc")
		return;

	$fmt = " %-28s %-20s\n";
	printf($fmt, 'Server', 'Name');

	while (($dat = $db->fetchobject($res))) {

		$dat->servername = shortServerName($dat->servername);
		$dat->servername = substr($dat->servername, 0, 27);

		if ($dat->curserverid > 0)
			$dat->server = $dat->servername;
		else
			$dat->server = humanTime(time() - $dat->lastserverwhen, true) . " ago";
	
		printf($fmt, $dat->server, substr($dat->ename,0,20));
		
	}

}

function ircerror($msg) {
	echo "ERROR\n";
	echo "$msg\n";
	die();	
}

?>
