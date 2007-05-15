<?
$nohtml = 1;
include 'include.php';
$clans = array();
$res = $db->query('select clantag, clanpos from user where clantag is not null and clanpos is not null group by clantag, clanpos');
$minclanplayers = 8;

while ($dat = $db->fetchObject($res)) {
#foreach($a as $dat) {

	if ($dat->clanpos == 0)
		$s = str_to_sql($dat->clantag.'%');
	else
		$s = str_to_sql('%'.$dat->clantag);

		#	$s = "'%".$dat->clantag."'";
	
	$dCount = $db->quickquery("
		select count(id) as c, sum(totalfrags) as totalfrags, sum(totaltime) as totaltime
		from player
		where player.ename like $s
		and lastserverwhen > unix_timestamp() - 60*60*24*14
		and player.score > 0
	");

	if ($dCount->c < $minclanplayers)
		continue;

	$dStats = $db->quickquery("
		select sum(score) as clanscore, max(rank) as clanbestrank
		from (
			select score, rank
			from player
			where player.ename like $s
			and lastserverwhen > unix_timestamp() - 60*60*24*14
			and player.score > 0
			order by score desc
			limit $minclanplayers 
		) as poo
	");

	$dOne = $db->quickquery("
		select *
		from player
		where player.ename like $s
		and lastserverwhen > unix_timestamp() - 60*60*24*14
		order by score desc
		limit 1
	");
	
	$clans[] = array($dat, $dCount, $dStats, $dOne);
}
function m($a, $b) {
	$a = $a[2]->clanscore;
	$b = $b[2]->clanscore;
	if ($a < $b) return 1;
	if ($a > $b) return -1;
	return 0;
}
usort($clans, 'm'); 
ob_start();
?>
<table><tr><th>#<th>Clan<th>Score<th>Players<th>Points<th>Time<th>Best Player
<?
$r = 0;
foreach ($clans as $c) {
	$r++;
	$td = ($r % 2)?'<td>':'<td class="alt">';
	print '<tr>';
	print $td;
	print $r;
	print $td;
	$w = ($c[0]->clanpos == 0)?'start':'end';
	print "<a href=\"search.php?{$w}with=1&search=" . urlencode($c[0]->clantag) . "\">".htmlspecialchars($c[0]->clantag)."</a>";
	print $td;
	print $c[2]->clanscore;
	print $td;
	print $c[1]->c;
	print $td;
	print $c[1]->totalfrags;
	print $td;
	print humanTime($c[1]->totaltime, 1);
	print $td;
	print "<a href=\"playerdetails.php?id={$c[3]->id}\">{$c[3]->ename}</a>";
}	
echo '</table>';

$s = ob_get_clean();
$f = fopen('static/clans.htm', 'w');
fwrite($f, $s);
fclose($f);

homeHeading('Top 10 Clans');
?>
<table><tr><th>#<th>Clan<th>Score<th>Players<th>Points<th>Best Player
<?
$r = 0;
foreach ($clans as $c) {
	$r++;
	if ($r == 11) break;
	$td = ($r % 2)?'<td>':'<td class="alt">';
	print '<tr>';
	print $td;
	print $r;
	print $td;
	$w = ($c[0]->clanpos == 0)?'start':'end';
	print "<a href=\"search.php?{$w}with=1&search=" . urlencode($c[0]->clantag) . "\">".htmlspecialchars($c[0]->clantag)."</a>";
	print $td;
	print $c[2]->clanscore;
	print $td;
	print $c[1]->c;
	print $td;
	print $c[1]->totalfrags;
	print $td;
	print "<a href=\"playerdetails.php?id={$c[3]->id}\">{$c[3]->ename}</a>";
}
print '<tr><td class="total"><td class="total"><td class="total"><td class="total"><td class="total"><td class="total" align="right"><a href="clans.php">more</a>';
echo '</table>';

$s = ob_get_clean();
$f = fopen('static/clans_front.htm', 'w');
fwrite($f, $s);
fclose($f);

