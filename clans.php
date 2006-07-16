<?
include 'include.php';
$clans = array();
$res = $db->query('select clantag, clanpos from user where clantag is not null and clanpos is not null group by clantag, clanpos');
while ($dat = $db->fetchObject($res)) {
	if (1)
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
	");

	if ($dCount->c < 6)
		continue;

	$dStats = $db->quickquery("
		select sum(score) as clanscore, max(rank) as clanbestrank
		from (
			select score, rank
			from player
			where player.ename like $s
			and lastserverwhen > unix_timestamp() - 60*60*24*14
			order by score desc
			limit 6
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
htmlStart();
homeHeading('Clans');
htmlArticleStart();
?>
These are the daily registered clan ranks. To register your clan you must be a member of ACSSR. These rankings are calculated daily. Clans only are shown on the list if they have 6 members who have played in the last fortnight. The score is the sum of the best 6 clan members of each clan.
<?
htmlArticleStop();
homeHeading('Rankings');
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
	print $c[0]->clantag;
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
htmlStop();
?>
