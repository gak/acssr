<?
require('abbLogin.php');

// player must be assigned to user
if (!isset($user->playerid) || !$user->playerid) die();
$user->playerid = 879591;

// Get the server the player is on
$datPlayer = $db->quickquery("
	select curserverid
	from player
	where player.id = {$user->playerid}
");
if (!$db->count()) die();
$resServer = $db->query("
	select rank, ename
	from player
	where curserverid = {$datPlayer->curserverid}
	order by rank
	limit 3
");

while ($dat = $db->fetchObject($resServer)) {

	echo "{$dat->rank},{$dat->ename}\n";

}

?>
