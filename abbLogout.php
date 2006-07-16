<?

include('abbLogin.php');

$_SESSION = array();
session_destroy();
respond(0);

?>
