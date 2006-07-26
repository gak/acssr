<?

require_once("include.php");
require_once("login.php");

$id = $_GET['id'] + 0;
$db->query("delete from friends where playerid = '$id' and userid = '{$user->id}'");
 
Header("Location: .");

?>
