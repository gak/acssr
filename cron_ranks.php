<?

$noob = 1;
$nohtml = 1;
require("include.php");
set_time_limit(0);
$_p = new Profiler("cron_ranks.php");

sep();
echo "Setting Ranks...\n";
if (1){
$db->query("set @rank = 0");
$db->query("
update player
set
rank = (@rank := @rank + 1)
where player.lastserverwhen > " .  getday(-15) . "
and player.deleted = 0
order by score desc;
");
$_p->point("rank");
}
if (0) {
	// update people who have already played today
	sep();
	echo "Setting rank to the rest of em\n";
	$db->query("
	update player
	set
	rank = @rank
	where player.lastserverwhen <= " .  getday(-15));
	$_p->point("rankrest");
}
$d = $db->quickquery("select @rank as r");
print $d->r . "\n";
sep();
$sql = 'update playerdaily, player
set playerdaily.rank = player.rank, playerdaily.score = player.score
where playerdaily.playerid = player.id and playerdaily.day = ' .today(). '
and playerdaily.score != 0 and player.score != 0
and player.lastserverwhen > ' .  getday(-15);

echo $sql . "\n";
$db->query($sql);
print mysql_affected_rows() . "\n";
$_p->point("pdrank");

// create new playerdaily rows for people who don't have one yet
sep();

$sql = 'select player.id, player.score, player.rank
from player
left join playerdaily as pd on player.id = pd.playerid and pd.day = ' .today() .'
where pd.playerid is null
and player.rank is not null
and player.lastserverwhen > ' .  getday(-15);

echo $sql . "\n";
$res = $db->query($sql);
print mysql_affected_rows() . "\n";

while (($dat = $db->fetchobject($res))) {

	$sql = "insert into playerdaily (rank, score, playerid, day) values ({$dat->rank}, {$dat->score}, {$dat->id}, " . today() . ')';
	$db->query($sql);
//	echo $sql . "\n";

}

$_p->point("pdnorank");
$_p->done();

function sep() {

	echo "-----------------------------------------------------------------------\n";

}

?>
