<?

$debug = 0;
$nohtml = 1;
$noob = 1;

require("include.php");

set_time_limit(0);

$q = "delete from server where down = 1 and ".time()." - lastscan > 60*60*24*7";
$db->query($q);

