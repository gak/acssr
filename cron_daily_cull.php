<?

$debug = 0;
$nohtml = 1;
$noob = 1;

require("include.php");

set_time_limit(0);

touch("dailycull.lock");

$q = "

select
playerid,
sum(frags) as f,
sum(time) as t,
floor((sum(frags) / sum(time)) * (1 - ".FORMULA_OFFSETT." / (sum(time) + ".FORMULA_OFFSETB." )) * ".FORMULA_SCOREMULTIPLIER.") as s

from playerdaily
where day > ".today()." - 60*60*24*14
group by playerid

";

echo $q . "\n";

$res = $db->query($q);

while (($dat = $db->fetchObject($res))) {

	$dat->f += 0;
	$dat->t += 0;
	$dat->s += 0;

	$q = "update player set score = {$dat->s}, totalfrags = {$dat->f}, totaltime = {$dat->t} where id = {$dat->playerid}";
	$db->query($q);
//	echo $q."\n";

}
unlink("dailycull.lock");

?>
