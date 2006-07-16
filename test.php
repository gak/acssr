<?
include 'include.php';
header("Content-type: text/plain; charset=utf-8");
$t = file_get_contents('erk.txt');
$t = substr($t, 0, strlen($t)-1);
$t = '«T.A» Bitch Kayla™';
$t = 'fur-ie';
$t = '';
foreach (array(121,97,110,49,115) as $c) $t .= chr($c);
print $t;
$a = str_to_sql($t);

$player = new Player($t);

function br() { echo  "\n\n----------\n\n"; }

br();

if ($player->playerExists())
	print "Player exists";
else
	print "Player doesn't exist";

br();

$player->data->ename = $t;
$player->data->name = $t;
$player->insertPlayer();

?>
