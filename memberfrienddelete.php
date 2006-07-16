<?

require_once("include.php");
require_once("login.php");

$db->query("delete from friends where playerid = '{$_GET["id"]}' and userid = '{$user->id}'");
 
Header("Location: .");

?>