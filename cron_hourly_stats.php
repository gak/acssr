<?

$debug = 0;
$nohtml = 1;
$noob = 1;

require("include.php");
include('conf_stats.php');

set_time_limit(0);

function getFriendsPerMember() {
	global $db;
	$members = $db->quickquery('select count(*) as a from user where activated = 1');
	$dat = $db->quickquery("select count(*) / {$members->a} as a from friends");
	return $dat->a;
}

function getVotesPerMember() {
	global $db;
	$members = $db->quickquery('select count(*) as a from user where activated = 1');
	$dat = $db->quickquery("select count(*) / {$members->a} as a from playervote");
	return $dat->a;
}


foreach ($hourstats as $stat) {
	$v = $stat[0];
	print $stat[1]."\n";
	if ($stat[2][0] == "!") {
		$fn = substr($stat[2], 1);
		$value = $fn();
	} else {
		$res = $db->query($stat[2]);
		$d = $db->fetchArray($res);
		if (substr($stat[2], 0, 4) == "show")
			$value = $d[1];
		else
			$value = $d[0];
	}
	$value += 0;
	$sql = 'insert into statshourly (hour, stat, value) values ('.gethour().', '.$v.', '.$value.')';
	$db->query($sql);
	
}


?>
