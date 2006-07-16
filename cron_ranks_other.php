<?

$noob = 1;
$nohtml = 1;
require("include.php");
set_time_limit(0);
$_p = new Profiler("cron_ranks_other.php");

sep();
echo "Setting Ranks...\n";
$db->query("set @rank = 0");
$db->query("
update player
set
rank = (@rank := @rank + 1)
where player.lastserverwhen > " .  getday(-15) . "
order by score desc;
");
$_p->point("rank");

sep();
echo "Setting rank to the rest of em\n";
$db->query("
update player
set
rank = @rank,
score = 0,
multiplier = 0,
ppm = 0,
totalfrags = 0,
totaltime = 0
where player.lastserverwhen <= " .  getday(-15));
$_p->point("rankrest");
$_p->point("pdnorank");
$_p->done();

function sep() {
    echo "-----------------------------------------------------------------------\n";
}

?>
