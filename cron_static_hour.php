<?
include 'include.php';
$dat = $db->quickquery('select count(id) as c from player');
$db->query('update stats set playersseen = ' . $dat->c);
?>
