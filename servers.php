<?

require_once("include.php");
require("admin.php");

htmlStart();

$db = new Database();

homeheading('Servers Monitored');

echo "<div class=\"articlebody\">";

echo "Below is a list of server that ACSSR checks on a regular basis. Servers that are in <b>bold</b> are official ACSSR servers. Servers included in the official list is based on ACSSR's discresion, preferably servers that do not allow cheaters and aren't war servers. If you want your server(s) to be an official server post a message in the <a href=\"/forum/\">forum</a> with your request. Maps that are in <b>bold</b> are official maps. ACSSR only collects player statstics on servers and maps that are official.";

echo "</div>";

$a = array('search','official','sort');

foreach ($a as $var) {
	if (isset($_GET[$var]))
		$$var = $_GET[$var];
}

if (!isset($official)) $official = 1;

homeheading('Filter Servers');
$st = ' style="display: table-cell;"';
?>
<div class="articlebody">
<form method="get" action="servers.php">
<div<?=$st?>>Search<br><input name="search" type="text" size="30" value="<?=$search?>"></div>
<?
$ops = array(0=>'All Servers', 1=>'Official Servers Only', 2=>'Unofficial Servers Only');
?>
<div<?=$st?>>Official Servers<br><select name="official">
<? foreach ($ops as $k=>$v) { ?>
<option value="<?=$k?>"<?if ($k == $official) echo ' SELECTED';?>><?=$v?>
<? } ?>
</select></div>
<?
$ops = array(0=>'Name', 1=>'Players Online', 2=>'Map');
?>
<div<?=$st?>>Sorting<br><select name="sort">
<? foreach ($ops as $k=>$v) { ?>
<option value="<?=$k?>"<?if ($k == $sort) echo ' SELECTED';?>><?=$v?>
<? } ?>
</select></div>
<div<?=$st?>>&nbsp;<br><input type="submit" value="update"></div>
</form>
</div><br>
<?

switch($sort) {
	case 0: $s = 'server.name'; break;
	case 1: $s = 'server.curplayers'; break;
	case 2: $s = 'map.name'; break;
}

switch($official) {
	case 0: $o = ''; break;
	case 1: $o = 'and collect = 1'; break;
	case 2: $o = 'and collect = 0'; break;
}

$sear = '';
if ($search != '') {
	$sear = "and (server.name like '%$search%' or map.name = '$search' or server.address like '%$search%')";
}

$res = $db->query("

	select server.*, map.official
	from server
	left join map on map.id = server.mapid
	where 1 = 1 $o $sear
	and deleted = 0
	order by $s

");
?>
<style>
.ser1 {
	height: 7px;
	display: table-cell;
	background-color: #0B2;
}
.ser2 {
	height: 7px;
	display: table-cell;
	background-color: black;
}
</style>
<?

echo "<table>";

echo "<tr><td class=\"total\">Name<tD class=\"total\">Address<td class=\"total\">Map<td class=\"total\">Players<td class=\"total\">";

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
	$mp = $dat->maxplayers;
	$cp = $dat->curplayers;
	$mps = $dat->maxplayers;
	$cps = $dat->curplayers;

	echo "<td$tdalt>";
	if ($mp) echo $cp . ' / ' . $mp;
	echo "<td$tdalt>";

	while ($mps > 64) {
		$mps /= 2;
		$cps /= 2;
	}
	if (0)	
	for ($i = 0; $i < $mps; $i++) {
		if ($i < $cps) {
			echo "<img title=\"{$cp} / {$mp}\" src=\"img/aligng.png\">";
		} else {
			echo "<img title=\"{$cp} / {$mp}\" src=\"img/alignn.png\">";
		}
	}

	echo '<span alt="yo" class="ser1" style="width: '.$cps.'px;"></span>';
	echo '<span class="ser2" style="width: '.$mps.'px;"></span>';
}

echo "</table>";

htmlStop();

?>
