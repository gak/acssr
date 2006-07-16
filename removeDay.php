<?

$noob = 1;
include 'include.php';

$stdin = fopen('php://stdin', 'r');
echo "Player ID: ";
$id = fgets($stdin,100) + 0;
$dat = $db->quickquery('select * from player where id = '.$id);
print "name: {$dat->ename}\n";
print "rank: {$dat->rank}\n";
print "points: {$dat->totalfrags}\n";
print "time: {$dat->totaltime}\n";
print "\n";

for ($i = 14; $i >= 0; $i--) {

	$day = $db->quickquery('select * from playerdaily where playerid = '.$id.' and day = '.getday(-$i));
	if ($db->count())
		printf("%2s) %-25s %5s %5s %5.5f\n", $i, date('l jS F', $day->day), $day->frags, $day->time, $day->frags/$day->time*60);
	
}

print "\nSelect day: ";
$dayid = fgets($stdin,100) + 0;
$ts = getday(-$dayid);

echo "\n";

$day = $db->quickquery('select * from playerdaily where playerid = '.$id.' and day = '.$ts);
$removetime = $day->time;
$removefrags = $day->frags;
$newtotaltime = $dat->totaltime - $removetime;
$newtotalfrags = $dat->totalfrags - $removefrags;
$ppm = $removefrags/$removetime*60;

echo "Removing $removefrags frags and $removetime seconds ($ppm)\n";
echo "\n";

$q1 = "update player set totalfrags = $newtotalfrags, totaltime = $newtotaltime where id = $id";
$q2 = "update playerdaily set time = 0, frags = 0 where playerid = $id and day = $ts";

echo $q1;
echo "\n";
echo $q2;
echo "\n";
echo "\n";
echo "press enter to do it";

fgets($stdin,100);

$db->query($q1);
echo mysql_error();
$db->query($q2);
echo mysql_error();

fclose($stdin); 

?>
