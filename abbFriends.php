<?
require('abbLogin.php');

$resFriends = $db->query("
	
	$sqlgenselect
	,server.name as servername
	,server.id as serverid
	,server.name as servername
	,server.address as serveraddress

	FROM friends

	LEFT JOIN player ON friends.playerid = player.id
	LEFT JOIN server ON server.id = player.curserverid

	WHERE friends.userid = {$user->id}

	ORDER BY score DESC");

	
while ($dat = $db->fetchObject($resFriends)) {

	if ($dat->servername == "") $dat->servername = "-";
	if ($dat->serveraddress == "") $dat->serveraddress = "-";
	echo "{$dat->id},{$dat->ename},{$dat->servername},{$dat->serveraddress}\n";

}

?>
