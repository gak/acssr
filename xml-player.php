<?

require_once("include.php");

header ("content-type: text/xml");

if (isset($_GET["id"]))
	$id = $_GET["id"];
else
	die('<error>id is not set</error>');
	
$idlist = explode(',', $id);
	
echo "<?xml version='1.0' standalone='yes' ?>";
echo '<players>';
	
foreach ($idlist as $id) {

	$id = $id + 0;
	if ($id == 0) continue;
	$player = new Player($id + 0);

	echo '<player id="'.$player->data->id.'" name="' . htmlspecialchars($player->data->ename) . '">';

	foreach ($playerdetails_fields as $field) {
		if ($player->data->$field[1] == "") $player->data->$field[1] = "0";
		echo '<'.$field[1].'>'.$player->data->$field[1].'</'.$field[1].'>';
				
		if ($field[0] == "Rank") {
			$moo = $db->quickquery("select rank,day from playerdaily where playerid = $id and rank != 0 order by rank limit 1");
			if (!$moo or !isset($moo->rank)) {
				$rank = 0;	
			} else {
				$rank = $moo->rank;
			}
			echo '<bestrank>'.$rank.'</bestrank>';
		}
			
	}

	if ($player->data->curserverid) {
		$lastServer = $db->quickquery("select * from server where id = " . $player->data->curserverid);
		echo '<currentserverid>' . ($lastServer->id) . '</currentserverid>';
		echo '<currentserver>' . htmlspecialchars($lastServer->name) . '</currentserver>';
		echo '<currentserveraddress>' . $lastServer->address . '</currentserveraddress>';
	} else {
		echo '<currentserverid/>';
		echo '<currentserver/>';
		echo '<currentserveraddress/>';
	}

	$lastServer = $db->quickquery("select * from server where id = " . $player->data->lastserverid);
	if ($lastServer) {
		echo '<lastserverid>'.($lastServer->id).'</lastserverid>';
		echo '<lastserver>'.htmlspecialchars($lastServer->name).'</lastserver>';
		echo '<lastserveraddress>'.htmlspecialchars($lastServer->address).'</lastserveraddress>';
		echo '<lastservertime>' .( $player->data->lastserverwhen) . '</lastservertime>';
		echo '<lastserverago>' .( time() - $player->data->lastserverwhen) . '</lastserverago>';
	} else {
		echo '<lastserverid/><lastserver/><lastserveraddress/><lastservertime/><lastserverago/>';
	}

	$days = 14;
	$data = getPlayerData($id, $days);

	echo '<history days="'.$days.'">';
	for ($i = $days-1; $i >= 0; $i--) {
		if (!isset($data->timestamp[$i]))
			$data->timestamp[$i] = 0;
		echo '<day ago="'.($days-$i-1).'" date="'.date('r',$data->timestamp[$i]).'">';
		$vars = array('rank', 'score', 'time', 'frags', 'ppm');
		foreach ($vars as $var) {
			$m = $data->$var;
			echo "<$var>".$m[$i]."</$var>";	
		}
		echo '</day>';
		
	}
	echo '</history>';

	echo '</player>';
}

echo '</players>';

function getPlayerData($id, $days) {

	global $db;

	$firstday = getday(-$days);

	for ($i = 0; $i < $days; $i++) {

		$data->ppm[$i] = 0;
		$data->frags[$i] = 0;
		$data->time[$i] = 0;
		$data->rank[$i] = 0;
		$data->score[$i] = 0;

	}

	// generate graph for player's history HpM
	$sql = "SELECT * from playerdaily where playerid = $id and day >= " . $firstday;
	$db->query($sql);

	// put them in their place
	while (($dat = $db->fetchobject())) {

		$diffseconds = $dat->day - $firstday;
		$diffday = $diffseconds / 86400;

		if ($diffday == 0)
			continue;

		$data->timestamp[$diffday-1] = $dat->day;
		
		if ($dat->time > 0)
			$data->ppm[$diffday-1] = $dat->frags / $dat->time * 60;

		$data->frags[$diffday-1] = $dat->frags;
		$data->time[$diffday-1] = $dat->time;

		if ($dat->rank != 0)
			$data->rank[$diffday-1] = $dat->rank;
			
		$data->score[$diffday-1] = $dat->score;

	}
	
	return $data;
	
}


?>
