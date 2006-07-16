<?
require_once('include.php');
$id = $_GET['i'] + 0;
if (!$id) {
	header('Location: http://acssr.slowchop.com/');
} else {
	$dat = $db->quickquery("select bannerbase.id, user.playerid from bannerbase left join user on user.id = bannerbase.userid where bannerbase.userid = '$id' order by rand()");
	$db->query('update bannerbase set clicks = clicks + 1 where id = ' . $dat->id);
	if ($dat->playerid) {
		header('Location: http://acssr.slowchop.com/playerdetails.php?id='.$dat->playerid);
	} else {
		header('Location: http://acssr.slowchop.com/');
	}
}
?>
