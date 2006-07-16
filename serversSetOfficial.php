<?

require_once("include.php");
require("admin.php");
if (!$isAdmin) die("FOOZ!");

global $_GET;
$v = $_GET['v'];
$id = $_GET['id'];
$db->query("update server set collect = $v where id = $id");

header("Location: servers.php");

?>
