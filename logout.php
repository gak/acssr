<?

require_once("include.php");

unset($_SESSION["user"]);
unset($user);

session_write_close();
header("Location: .");

?>