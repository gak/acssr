<?

$debug = 0;
$nohtml = 1;
$noob = 1;

require("include.php");

set_time_limit(0);

$mres = $db->query("select * from userprofile");

while (($dat = $db->fetchObject($mres))) {
	$_GET['userid'] = $dat->userid;
	include('playerprofile.php');
}
