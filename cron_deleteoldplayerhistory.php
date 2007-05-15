<?

include 'include.php';

$sql = '

delete playerdaily from playerdaily, player
where player.id = playerdaily.playerid
and player.lastserverwhen < ' .  getday(-15) .' 
';

echo $sql . "\n";
#die();

$res = $db->query($sql);
print mysql_affected_rows();
echo "\n";
echo mysql_error();
echo "\n";

?>
