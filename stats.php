<?
require_once("include.php");
require_once('conf_stats.php');

htmlStart();
homeHeading("Stats of ACSSR");

$datHour = $db->quickquery("select max(hour) as val from statshourly");
$hour = $datHour->val;

$lastHour = $hour - 3600;
$lastDay = $hour - 3600*24;
$lastWeek = $hour - 3600*24*7;

$rs = 5;
$gs = "";//vertical-align: top; ";
foreach ($hourstats as $stat) {

	$alt = 1;
	$id = $stat[0];
	$name = $stat[1];
	$dat1 = $db->quickquery("select value from statshourly where stat = $id and hour = $hour");
	$dat2 = $db->quickquery("select value from statshourly where stat = $id and hour = $lastHour");
	$dat3 = $db->quickquery("select value from statshourly where stat = $id and hour = $lastDay");
	$dat4 = $db->quickquery("select value from statshourly where stat = $id and hour = $lastWeek");
	echo "<table border=1>";
	echo "<tr><td style=\"background-color: black\" colspan=\"6\">$name";
//	echo "<tr><td style=\"vertical-align: top; background-color: transparent; padding: 0px 0px 0px 0px;\">";

	$alt=!$alt;	$tdalt=($alt)?' class="alt"':'';
	echo "<tr><td style=\"$gs width: 300px;\" colspan=\"2\">" . $stat[3];
	echo "<td rowspan=$rs><img src=\"stats/{$id}-day-small.png\"><br><img src=\"stats/{$id}-day-diff-small.png\">";
	echo "<td rowspan=$rs><img src=\"stats/{$id}-week-small.png\"><br><img src=\"stats/{$id}-week-diff-small.png\">";
	echo "<td rowspan=$rs><img src=\"stats/{$id}-month-small.png\"><br><img src=\"stats/{$id}-month-diff-small.png\">";
	echo "<td rowspan=$rs><img src=\"stats/{$id}-year-small.png\"><br><img src=\"stats/{$id}-year-diff-small.png\">";
	$alt=!$alt;	$tdalt=($alt)?' class="alt"':'';
	echo "<tr><td $tdalt style=\"$gs width: 150px;\">This hour<td $tdalt style=\"$gs\"><b>{$dat1->value}</b>";
	$alt=!$alt;	$tdalt=($alt)?' class="alt"':'';
	echo "<tr><td $tdalt style=\"$gs width: 150px;\">Last hour<td $tdalt style=\"$gs\"><b>{$dat2->value}</b> (<b>" . ($dat2->value - $dat1->value). "</b>)";
	$alt=!$alt;	$tdalt=($alt)?' class="alt"':'';
	echo "<tr><td $tdalt style=\"$gs width: 150px;\">24h ago<td $tdalt style=\"$gs\"><b>{$dat3->value}</b> (<b>" . ($dat3->value - $dat1->value). "</b>)";
	$alt=!$alt;	$tdalt=($alt)?' class="alt"':'';
	echo "<tr><td $tdalt style=\"$gs width: 150px;\">A week ago<td $tdalt style=\"$gs\">{$dat4->value}</b> (<b>" . ($dat4->value - $dat1->value). "</b>)";
	echo "</table>";
	
}

//echo "</table>";

htmlStop();

?>
