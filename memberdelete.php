<?
require('include.php');
require('admin.php');

if (!$isAdmin)
	die();

$id = $_GET['id'] + 0;
$db->query('update player set deleted = 1 where id = '.$id);

header('Location: /');

?>
