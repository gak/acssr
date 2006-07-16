<?
require('include.php');
require('admin.php');

if (!$isAdmin)
	die();

$db->query('update player set deleted = 1 where id = '.$_GET['id']);

header('Location: /');

?>
