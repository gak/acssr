<?
include 'include.php';

$db->query('update server set deleted = 0 where deleted = 1 and down = 0');

?>
