<?
include 'include.php';

$user = $_SESSION["user"];
$user->refresh();
		
$clantag = $_POST['clantag'];
$clanpos = $_POST['clanpos'];

if (trim($clantag) == '') {
	$db->query('update user set clanpos = NULL, clantag = NULL where id = '.$user->id);
} else {
	$q = 'update user set clantag = "'.$clantag.'", clanpos = "'.$clanpos.'" where id = '.$user->id;
	$db->query($q);
}
header('Location: /');

?>
