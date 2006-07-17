<?
include 'include.php';

$user = $_SESSION["user"];
$user->refresh();
		
$clantag = $_POST['clantag'];
$clanpos = $_POST['clanpos'];
if (strlen($clantag) < 2)
	$clantag = '';
$good = 0;
for ($i = 0; $i < strlen($clantag); $i++) {
	if (strtolower($clantag[$i]) < 'a' || strtolower($clantag[$i]) > 'z')	
		$good = 1;
}
if (!$good)
	$clantag = '';

if (trim($clantag) == '') {
	$db->query('update user set clanpos = NULL, clantag = NULL where id = '.$user->id);
} else {
	$q = 'update user set clantag = "'.$clantag.'", clanpos = "'.$clanpos.'" where id = '.$user->id;
	$db->query($q);
}
header('Location: /');

?>
