<?
require('abbLogin.php');
/*

Format (including login)
[RESPONSE char][VERSION char]\n
F[PACKETSIZE]\n
ID,NAME,SERVERNAME,ADDRESS\n
etc
I[PACKETSIZE]\n
*/

version();
friends();
inGame();

function version() {

	global $_SERVER;
	$clientVersionString = $_SERVER["HTTP_USER_AGENT"];

	// stable
	$latestStableVersion = 0;
	$latestStableRevision = 0;

	// beta
	$latestBetaVersion = 0.1;
	$latestBetaRevision = 1;

	$clientBits = explode('-', $clientVersionString);
	$clientVersion = $clientBits[1];
	$isClientBeta = (isset($clientBits[2]));
	if ($isClientBeta)
		$clientRevision = substr($clientBits[2], 4);
	else
		$clientRevision = 0;
	$doesClientWantBeta = 1;
	$clientVersionNumber = $clientBits[0];
	if ($doesClientWantBeta) {
		if ($clientVersionNumber < $latestBetaVersion || $clientRevision < $latestBetaRevision) {
			$p = "abb.slowchop.com\n/dist/abb-$latestBetaVersion-beta$latestBetaRevision.exe\n";
			doCmd("U", $p);
		}
	} else {

	}

} 
function friends() {

	global $db;
	global $sqlgenselect;
	global $user;
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

	$p = "";
	while ($dat = $db->fetchObject($resFriends)) {

		if ($dat->servername == "") $dat->servername = "-";
		if ($dat->serveraddress == "") $dat->serveraddress = "-";
		$p .= "{$dat->id}\n{$dat->ename}\n{$dat->servername}\n{$dat->serveraddress}\n";

	}

	doCmd('F',$p);

}

function inGame() {

	global $db;
	global $user;
	// player must be assigned to user
//	if (!isset($user->playerid) || !$user->playerid) return;
//	$user->playerid = 295358;
	// Get the server the player is on
	$datPlayer = $db->quickquery("
		select curserverid
		from player
		where player.id = {$user->playerid}
	");
	if (!$db->count()) {
		doCmd('I','');
		return;
	}
	if (!$datPlayer->curserverid) {
		doCmd('I','');
		return;
	}
	$resServer = $db->query("
		select rank, ename
		from player
		where curserverid = {$datPlayer->curserverid}
		and rank != 0
		order by rank
		limit 3
	");

	$p = "";
	while ($dat = $db->fetchObject($resServer)) {
		$p .= "{$dat->rank}\n{$dat->ename}\n";
	}
	doCmd('I',$p);

}

function doCmd($code, $p) {
	echo $code.strlen($p)."\n".$p;
}

?>
