<?

include("include.php");

$id = 4326;
// get current serverid
$serid = $db->quickquery("select curserverid from player where id = $id");
$serid->curserverid = 704;

if ($serid->curserverid) {

	$nl = "\n";

	$db->query("

				$sqlgenselect
				,server.name as servername
				,server.id as serverid

				FROM player
				LEFT JOIN server ON server.id = player.curserverid
				WHERE curserverid = '{$serid->curserverid}'
				ORDER BY score DESC
				LIMIT 5

				");

	$i = 0;
	while (($dat = $db->fetchObject())) {

		$i++;
		echo 'alias ser'.$i.' say "';
		echo $dat->ename;
		echo ' | ranked '.$dat->rank;	
		echo ' with a score of '.$dat->score;
		echo ' and '.$dat->ppm.' points/minute';
		echo '"'.$nl;

		echo 'bind F'.($i+4).' ser'.$i.$nl;

	}

}

$db->query("

		$sqlgenselect
		,server.name as servername
		,server.id as serverid
		,server.address as address

		FROM friends

		LEFT JOIN player ON friends.playerid = player.id
		LEFT JOIN server ON server.id = player.curserverid
	
		WHERE friends.userid = '1'
		AND curserverid IS NOT NULL
	
		ORDER BY curserverid
		
");

$hmm = "";
$lastserver = 0;
$i = 0;
while (($dat = $db->fetchObject())) {

	$i++;
	$hmm .= 'alias con'.$i.' connect '.$dat->address.' '.$dat->servername.' '.$dat->ename.$nl;

}

echo $hmm;

// htmlStop();

?>
