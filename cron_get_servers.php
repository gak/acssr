<?

$debug = 0;
$nohtml = 1;
$noob = 1;

require("include.php");

set_time_limit(0);

$text = `./qstat -nh -cfg qstat.cfg -stmhl2,game=cstrike,region=5 steam1.steampowered.com`;
$lines = explode("\n", $text);

for ($i = 1; $i < sizeof($lines)-2; $i++) {

	$line = $lines[$i];
	$address = substr($line, 5);
	$address = substr($address, 0, strpos($address, " "));
	$ip = substr($address,0,strpos($address,":"));
	$db->query("select id from server where address = '$address'");
	if ($db->count()) continue;
	echo "\n\n";
	echo $line."\n";
	$r = `whois $ip | grep -i ^country`;
	echo $r;
	if (!strpos($r,"AU")) continue;
	$sql = "insert into server (address) values ('$address')";
	$db->query($sql);
	
}

