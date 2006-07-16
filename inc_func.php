<?

function hasMapChanged($server) {

	// check to see if the map has changed
	if ($server->map != $server->lastmap) {

		return true;
	
	} else {
	
		// check to see if 25% of players have lost at least 2 frags since last update
		$total = 0;
		$count = 0;
		$countd = 0;
		foreach($server->query->players as $p) {
		
			$player = new Player($p->ename);
			
			// player doesnt exist in our db, so let's not count them
			if (!$player->playerExists()) {
		
				continue;
			
			}
			
			// get the frag difference for this player
			$diff = $p->frags - $player->data->curserverfrags;
			
			if ($diff < -2) {
				$count ++;
			}

			if ($diff < 0) {
				$countd -= $diff;
			}
			
			$total ++;
		
		}
		
		if ($total && $count / $total > .25) {
			print "HMC2\n";
			return true;
		}
		if ($total && $countd > 10) {
			print "HMC3 $countd $total\n";
			return true;
		}
	}
	
	return false;

}

function loadMapData() {

	global $mapdata;
	global $db;
	
	$db->query("select * from map");
	
	$mapdata = $db->fetchAllArrayObject();

}

function getMapID($name) {

	global $db;
	global $mapdata;
	
	if ($name == "")
		trigger_error();
	
	if ($name == "response")
		trigger_error();
	
	if ($name == "4")
		trigger_error();
	
	if ($name == "6")
		trigger_error();
		
	if (!isset($mapdata)) {
	
		loadMapData();	
	
	}
	
	foreach($mapdata as $map) {

		// print_r($map);

		if (strtolower($map->name) == strtolower($name))
			return $map->id;
	
	}

	$dat = $db->quickquery("insert into map (name) values ('$name')");
	$id = mysql_insert_id();
	return $id;
	
	
/*	
	$dat = $db->quickquery("select id from map where name = '$name'");
	
	if (!$db->count()) {
	
		$dat = $db->quickquery("insert into map (name) values ('$name')");
		$id = mysql_insert_id();
		return $id;
			
	} else {
	
		return $dat->id;
	
	}
*/
}

function isMapOfficial($id) {

	global $mapdata;

	if (!isset($mapdata)) {
	
		loadMapData();	
	
	}
	
	foreach($mapdata as $map) {
	
		if ($map->id == $id)
			return $map->official;
	
	}
	
	return 0;
	

/*
	global $db;
	
	$dat = $db->quickquery("select official from map where id = '$id'");
	if (!$db->count())
		return 0;
		
	return $dat->official;
*/
}

function humanTime($seconds, $long = false) {

	if ($seconds < 60 * 2) {
	
		if ($long)
			return $seconds . " seconds";
		
		return $seconds . "s";
	
	} else if ($seconds < 60 * 60 * 2) {
	
		if ($long)
			return floor($seconds / 60) . " minutes";

		return floor($seconds / 60) . "m";
	
	} else if ($seconds < 60 * 60 * 24 * 2) {
	
		if ($long)
			return floor($seconds / 60 / 60) . " hours";
			
		return floor($seconds / 60 / 60) . "h";
	
	} else {
	
		if ($long)
			return floor($seconds / 60 / 60 / 24) . " days";

		return floor($seconds / 60 / 60 / 24) . "d";
	
	}

}



// midnight today
function now() {

	return time();
	return time() + 36000;

}

function mylongdate($ts) {

	return date("l jS F Y h:i:sA", $ts);

}

function myshortdate($ts) {

	return date("d/m/Y h:i:sA", $ts);

}

function mydate($format) {

	return date($format, now());

}

function today() {

	return mktime(0, 0, 0, mydate("m"), mydate("d"), mydate("Y"));

}

function getday($i) {

	return mktime(0, 0, 0, mydate("m"), mydate("d") + $i, mydate("Y"));

}

function gethour() {

	return mktime(mydate("G"), 0, 0, mydate("m"), mydate("d"), mydate("Y"));

}

function utime() {

	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec); 

}

function shortServerName($n) {

	$n = str_replace("eXeTeL Gaming Network: ", "eXeTel ", $n);
	$n = str_replace("Gamespace", "GS", $n);
	$n = str_replace("GameArena CS: Source", "GA", $n);
	$n = str_replace(".net.au|CS-S", "", $n);

	$n = str_replace("ComCen", "", $n);
	$n = ereg_replace("- Assault Pioneers$", "", $n);

	$n = str_replace("Source Server", "", $n);
	$n = str_replace("CS SOURCE", "", $n);
	$n = str_replace("CSS", "", $n);
	$n = str_replace("HL2 Counter-Strike:Source", "", $n);
	$n = str_replace("Counter-Strike:Source", "", $n);
	$n = str_replace("Counter-Strike: Source", "", $n);
	$n = str_replace("CS:Source", "", $n);
	$n = str_replace("CS:S", "", $n);
	$n = str_replace("CS Source", "", $n);
	$n = ereg_replace("-.{0,2}$", "", $n);

	return $n;

}

function checkBanner() {

	global $db;
	
	$db->quickquery("select day from adcounter where day = " . today());

	if ($db->count() == 0) {
		$db->query("insert into adcounter values (".today().", 0, 0, 0)");
	}

}

function getLock($name, $timeout) {

	if (file_exists($name)) {
	
		$timeChanged = filectime($name);
		$diff = time() - $timeChanged;

		print "LOCK FILE IS $diff seconds old\n";

		if (time() - $timeChanged < $timeout)
			return false;

		print "LOCK FILE IS OLD\n";

	}

	print "LOCK TOUCH\n";
	touch($name);
	
	return true;

}
	
function sql_error_check($sql) {
	if (mysql_error()) {
		echo "\nSQL:$sql\n";
		echo "ERROR:\n" . mysql_error() . "\n";
	}
}

function str_to_sql($s) {
	$o = 'CHAR(';
	for ($i = 0; $i < strlen($s); $i++) {
		if ($i > 0) $o .= ',';
		$o .= ord($s[$i]);
	}
	$o .= ')';
	return $o;
}

?>
