<?

$debug = 1;
$nohtml = 1;
$noob = 1;

require("include.php");
set_time_limit(0);

if (!getLock("poll.lock", 60*15)) die();

$_p = new Profiler("cron_poll.php");

// build a command line for qstat
$cmd = "$qstatpath -nocfg -hpn -nh -ts -P";
// note that this is a copy and paste from below, i presume there is a way not
// to have to repeat it
$res = $db->query("select * from server");
while (($dat = $db->fetchobject($res))) {
	$cmd = $cmd . " -a2s " . $dat->address;
}
$_p->point("qstat prep", false);
$text = `$cmd`;
$_p->point("qstat");

// parse text into a map of address -> output for that addres
$serveroutput = array();
$lines = explode("\n", $text);
$cur = array();

/*** this is the traffic measurement. qstat's last output line should be something like "TRAFFIC 500 50" ***/
$traffic = array_pop($lines);	// the last line is a \n
$traffic = array_pop($lines);	// the second last line is the traffic count

echo $traffic . "\n";

$bytes = explode(" ", $traffic);
echo "IN:".$bytes[1] . " OUT:". $bytes[2] . "\n";

// see if the row exists for this hour
global $db;
$dat = $db->quickquery("select * from bytes where hour = " . gethour());

if ($db->count()) {

	$db->query("update bytes set bytes_in = bytes_in + {$bytes[1]}, bytes_out = bytes_out + {$bytes[2]} where hour = " . gethour());

} else {

	$db->quickquery("insert into bytes (hour, bytes_in, bytes_out) values (".gethour().", {$bytes[1]}, {$bytes[2]})");
}
$_p->point("byte stats", false);

////

foreach ($lines as $line) {

	if ($line == "")  {
//		echo "blank\n";
	}
	else if ($line[0] == "\t") {
		// Looks like a player info line, don't bother checking for a server address
		$cur[] = $line;
	}
	else {
		// Looks like a server address
		$linedata = explode(" ", $line);
		$serveraddress = $linedata[0];

		$serveroutput[$serveraddress] = array();
		$cur = & $serveroutput[$serveraddress];

		$cur[] = $line;
	}

	// TODO: Handle IN:100 OUT:60 information at end
}

$_p->point("output to array", false);

$res = $db->query("select * from server");

while (($dat = $db->fetchobject($res))) {

	$server = new Server($dat);
	$server->update(& $serveroutput);

	if ($server->name == "" && $server->down) {
		$db->query("update server set deleted = 1 where id = '{$server->id}'");
		continue;
	}	
	
	if ($debug) {
		echo "\n===================================================================\n";
		echo $server->name."\n";
		echo $server->map."\n";
		echo $serveroutput[$server->address][0];
		echo "\n";
		echo "-------------------------------------------------------------------\n";
	}
	
	$good = true;
	
	if (!isset($server->query)) {
	
		if ($debug)		
			echo "No response\n";
		$good = false;
		
	}
	
	if (!isset($server->query->players)) {
		
		if ($debug)		
			echo "No players\n";
		$good = false;
		
	}
	
	if (!$good) {
	
		$sql = "update player set curserverid = NULL where curserverid = {$server->id}";
		$db->quickquery($sql);
		sql_error_check($sql);
		continue;
	
	}
/*	
	$mapchange = hasMapChanged($server);
	if ($mapchange) {

		if ($debug)		
			echo "MAP HAS CHANGED\n";
		
		// if the map has changed, make every player be removed from the server.
		$sql = "update player set curserverid = NULL where curserverid = {$server->id}";
		// echo "\n$sql\n";
		$db->quickquery($sql);
		
	}
*/

	$mapofficial = isMapOfficial($server->mapid);

	$playerlist = array();
	$playersToProcess = array();

	// servers with less then 8 people are not counted.
	if (count($server->query->players) < 8)
		$notenough = true;
	else
		$notenough = false;

	$negFragCount = 0; // number of players with a negative frag diff
	$negFragTotal = 0; // number of players tested for negative frag diff
		
	foreach($server->query->players as $p) {
	
		if ($debug)		
			$msg = "";
		
		if ($p->name == "")
			continue;

		$player = new Player($p->name);

//		print_r($player->data);
		
		if (!$mapofficial) {

			if ($debug)		
				$msg .= " UNOFFICIALMAP";

		}

		if (!$server->collect) {

			if ($debug)
				$msg .= " UNOFFICIALSERVER";

		}

		if ($notenough) {
			if ($debug) $msg .= " NOTENOUGHPLAYERS";
			$mapofficial = 0;
		}

		$player->data->ename = $p->name;
		
		// player doesnt exist in our db
		if (!$player->playerExists()) {

			#			$player->data->name = $p->ename;
			$player->data->curserverid = $server->id;
			$player->data->curservertime = $p->time;
			$player->data->curserverfrags = $p->frags;
			$player->data->lastserverid = $server->id;
			$player->data->lastserverwhen = time();
			
			$player->today->frags = 0;
			$player->today->time = 0;
			
			$fragdiff = 0;
			$timediff = 0;
			
			$player->insertPlayer();
			$player->Player($p->name);	// reload the row from the db
			$sql = 'insert into playernames (playerid, ename) values (' . $player->data->id . ',' . str_to_sql($p->name) . ')';
			$db->query($sql);
			sql_error_check($sql);

			if ($debug)		
				printf(" - %-30s F:%-2d T:%-5d (NEW PLAYER)", $p->name, $p->frags, $p->time);

		// player does exist in our db.
		} else {
		
			$fragdiff = $p->frags - $player->data->curserverfrags;
			$timediff = $p->time - $player->data->curservertime;
			$serverchange = ($server->id != $player->data->curserverid);
			$mapnamechange = ($server->map != $server->lastmap);
		
			// if the timediff is too big while serverchange is false and map is the same
			// it means that this script hasnt polled in at least that many seconds and will cause
			// acssr to poll incorrectly. In this case we will force fragdiff and timediff to 0.
			if ($timediff > 900 && !$serverchange && !$mapnamechange) { // 15 minutes of not polling will be ignored

				if ($debug) $msg .= " UBERTIMEDIFF ($timediff,{$p->time},{$player->data->curservertime})";
				$timediff = 0;
				$fragdiff = 0;

			}
			
			// this persons timediff is negative
			// this means they've reconnected. (OR two ppl with the same name on diff servers)
			else if ($timediff < 0) {
			
				if ($debug) $msg .= " TIMEDIFFNEGATIVE";
				$fragdiff = 0;
				$timediff = 0;
			
			}

			// name of the map has changed
			else if ($mapnamechange) {

				if ($debug) $msg .= " MAPNAMECHANGE";
				$fragdiff = 0;
				$timediff = 0;

			}
			
			// player changed servers
			else if ($serverchange) {
			
				if ($debug) $msg .= " SERVERCHANGE";
				$fragdiff = 0;
				$timediff = 0;
			
			}

			if ($fragdiff != 0 && $timediff != 0) {
				if ($fragdiff < 0) {
					$negFragCount++;
				}
				$negFragTotal++;
			}

			if ($debug)		
				printf(" - %-30s F:%-2d T:%-5d FDIFF:%-4d TDIFF:%-6d", $p->ename, $p->frags, $p->time, $fragdiff, $timediff);
			
			if ($debug)
				echo $msg;

		}
		
		#		echo ("\ninsert low_priority ignore into playernames (playerid, ename) values ({$player->data->id},'{$p->ename}')\n\n");
		$sql = "insert low_priority ignore into playernames (playerid, ename) values ({$player->data->id},".str_to_sql($p->ename).")";
		$db->query($sql);
		sql_error_check($sql);
		
		$player->fragdiff = $fragdiff;
		$player->timediff = $timediff;
		$player->ptime = $p->time;
		$player->pfrags = $p->frags;
		$playersToProcess[] = $player;
		if ($player->data->id > 0)
			$playerlist[] = $player->data->id;
		print "\n";

	}

	unset($p);

	echo "negFragCount: $negFragCount\n";
	echo "negFragTotal: $negFragTotal\n";

	$restartedSameMap = 0;
	if ($negFragCount > $negFragTotal / 2) {
		$restartedSameMap = 1;
		echo "MAP SEEMS TO BE RESTARTED, not counting stats {$server->map}\n";
	}
	
	foreach ($playersToProcess as $player) {
		
		$player->data->curserverfrags = $player->pfrags;
		$player->data->curservertime = $player->ptime;
		$player->data->curserverid = $server->id;
			
		$player->data->lastserverid = $server->id;
		$player->data->lastserverwhen = time();
		
		if ($restartedSameMap) {
			$player->fragdiff = 0;
			$player->timediff = 0;
			$player->data->curserverid = 'NULL';
		}
		
		if ($mapofficial && $server->collect) {
		
			$player->data->totalfrags += $player->fragdiff;
			$player->data->totaltime += $player->timediff;

			if (!isset($player->today->frags)) {

				$player->today->frags = $player->fragdiff;
				$player->today->time = $player->timediff;

			} else {

				$player->today->frags += $player->fragdiff;
				$player->today->time += $player->timediff;

			}
			
		}

		// player history
		$newRow = false;
		$sql = "select * from playerserverhistory where playerid = {$player->data->id} order by starttime desc limit 1"; 
		$datLastMap = $db->quickquery($sql);
		sql_error_check($sql);
		
		if (!$db->count() || !$datLastMap->iscurrent) {
			$newRow = true;
			print "Row doesnt exist\n";
		} else if (!$player->timediff) {
			print "timediff = 0\n";
			$newRow = true;
			$sql = "update playerserverhistory set iscurrent = 0 where id = {$datLastMap->id}"; 
			$db->query($sql);
			sql_error_check($sql);
		}

		if ($newRow) {
			$g = new generateSQL('playerserverhistory','insert');
			$g->field('playerid', $player->data->id, 'number');
			$g->field('serveraddress', $server->address, 'string');
			$g->field('mapid', $server->mapid, 'number');
			$g->field('starttime', 'UNIX_TIMESTAMP()', 'number');
			$g->field('iscurrent', 1, 'number');
			$g->field('points', $player->fragdiff, 'number');
			$g->field('totaltime', $player->timediff, 'number');
		} else {
			$g = new generateSQL('playerserverhistory','update', $datLastMap->id);
			$g->field('iscurrent', 1, 'number');
			$g->field('points', $datLastMap->points + $player->fragdiff, 'number');
			$g->field('totaltime', $datLastMap->totaltime + $player->timediff, 'number');
		}
		$sql = $g->sql();
		$db->query($sql);
		sql_error_check($sql);

		if ($debug)		
			echo("\n");

		$player->updatePlayer();
		
	}

	$imploded = implode(",", $playerlist);
	if ($imploded{0} == ',')
		$imploded = substr($imploded, 1);
	if ($imploded{strlen($imploded)-1} == ',')
		$imploded = substr($imploded, -1, 1);
	$sql = "update player set curserverid = NULL where curserverid = {$server->id} and id not in (".implode(",", $playerlist).")";
	#	echo "$sql\n";
	$db->query($sql);
	sql_error_check($sql);

}
$_p->point("big loop");
/*
	function cmp($a, $b) {
	
		global $QUERIES;
	
		$a = $QUERIES[$a];
		$b = $QUERIES[$b];
	
		if ($a["time"] == $b["time"]) {
			return 0;
		}
		
		return ($a["time"] < $b["time"]) ? -1 : 1;
		
	}

	global $QUERIES;
	
	uksort( $QUERIES, "cmp" );
	
	foreach($QUERIES as $q) {
	
		$q["sql"] = str_replace("\n", " ", $q["sql"]);
		$q["sql"] = str_replace("\t", " ", $q["sql"]);
		$q["sql"] = str_replace("  ", " ", $q["sql"]);
	
		printf("%20f %s\n", $q["time"], $q["sql"]);
	
	}
*/

echo "all ok\n";
$_p->done();
unlink("poll.lock");

?>
