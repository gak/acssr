<?

require_once('include.php');
include('login.php');

$id = $_GET['id'] + 0;

print_r($_POST);

$db->query("delete from playervote where playerid = $id and userid = {$user->id}");

foreach ($_POST as $p=>$v) {

	if (!$v) continue;
	
	$q = "
	insert into playervote
	(userid, playerid, playervotecategoryid, alignment)
	VALUEs
	({$user->id}, $id, $p, $v)
	";

	$db->query($q);
	
}

header("Location: playerdetails.php?id=$id");
