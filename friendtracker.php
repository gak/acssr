<?

include("include.php");

header("Content-type: text/html; charset=utf-8");
header("Cache-Control: no-cache");

?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">

<html>
<head>
<title>ACSSR Friend Tracker</title>
<style type="text/css">
@import "style.php";
</style>
<link rel="shortcut icon" href="img/icon.png">
<meta name="resource-type" content="document">
<meta name="description" content="A Counter-Strike:Source player ranking and tracking system that monitors Australian servers">
<meta name="keywords" content="australian, australia, aussie, internode, gamearena, gamespace, 3fl, egn, ihug, iconz, iinet, sgn, swiftgames, xges, css, counter-strike, counter-strike:source, counter, strike, half, life, source, stats, statistics, rank, ranks, ranking, position, positions, ladder, ladders, point, points, frags, score, player, players, clan, clans, stat, game, player, players, server, servers, graph, graphs">
<meta http-equiv="refresh" content="120">
</head>
<body class="tracker">

<table class="tracker"><tr><td class="tracker">
<?

if (isset($_SESSION) && isset($_SESSION["user"])) {

	$user = $_SESSION["user"];
	$user->refresh();

	if (isset($user->playerid)) {
		
		$user->loadplayer();
		
		$s = "or player.id = {$user->player->id}";
		
	}  else {
	
		$s = "";
	
	}

	$resFriends = $db->query("
		
		$sqlgenselect
		,server.name as servername
		,server.id as serverid

		FROM friends

		LEFT JOIN player ON friends.playerid = player.id
		LEFT JOIN server ON server.id = player.curserverid
	
		WHERE friends.userid = {$user->id}
	
		ORDER BY score DESC");
		
		
		dumpTable($resFriends, array("servercut"=>true, "small"=>true, "frienddelete"=>true));


} else {

	echo "You are not logged in! Please log in from the home page...";

}

?>

</table>

</body>
</html>

<?



?>
