<?

require_once("include.php");
require("admin.php");

htmlStart();

$db = new Database();

homeheading('Servers Monitored');

echo "<div class=\"articlebody\">";

echo "Below is a list of server that ACSSR checks on a regular basis. Servers that are in <b>bold</b> are official ACSSR servers. Servers included in the official list is based on ACSSR's discresion, preferably servers that do not allow cheaters and aren't war servers. If you want your server(s) to be an official server send an email to us with your request. Maps that are in <b>bold</b> are official maps. ACSSR only collects player statstics on servers and maps that are official.";

echo "</div>";

$res = $db->query("

	select server.*, map.official
	from server
	left join map on map.id = server.mapid
	#	where server.name != 'DOWN'
	order by server.name

");

echo "<table>";

echo "<tr><td class=\"total\">Name<tD class=\"total\">Address<td class=\"total\">Map<td class=\"total\">Players";

$alt = 0;
while (($dat = $db->fetchobject($res))) {

	$alt=!$alt;
	$tdalt=($alt)?' class="alt"':'';
	echo "<tr>";
	if ($dat->collect)
		echo "<td$tdalt><b><a href=\"ladder.php?online={$dat->id}\">{$dat->name}</a></b>";
	else
		echo "<td$tdalt><a href=\"ladder.php?online={$dat->id}\">{$dat->name}</a>";

	if ($isAdmin) {
		echo ' <small>(<a href="serversSetOfficial.php?id='.$dat->id.'&v='.($dat->collect?'0':'1').'">toggle</a>)</small>';
	}

	if ($dat->down) {
		echo ' (down for ' . humanTime(time() - $dat->lastscan) . ')';
	}
		
	echo "<td$tdalt>{$dat->address}";
	if ($dat->official)
		echo "<td$tdalt><b>{$dat->map}</b>";
	else
		echo "<td$tdalt>{$dat->map}";
	echo "<td$tdalt>";

	$mp = $dat->maxplayers;
	$cp = $dat->curplayers;
	$mps = $dat->maxplayers;
	$cps = $dat->curplayers;

	while ($mps > 32) {
		$mps /= 2;
		$cps /= 2;
	}
	
	for ($i = 0; $i < $mps; $i++) {
		if ($i < $cps) {
			echo "<img title=\"{$cp} / {$mp}\" src=\"img/aligng.png\">";
		} else {
			echo "<img title=\"{$cp} / {$mp}\" src=\"img/alignn.png\">";
		}
	}
}

echo "</table>";

htmlStop();

?>
