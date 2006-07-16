<?

include('include.php');

$protocol = "a";

function respond($res,$die=true) {
	global $protocol;
	echo "$res$protocol\n";
	if ($die) die();
}

function l($a) {
	file_put_contents("l", $a."\n", FILE_APPEND);
}

if (isset($_POST["username"]) && isset($_POST["password"])) {

	$user = new User();
	$result = $user->login($_POST["username"], $_POST["password"]);
	if ($result)
		respond($result);
	$_SESSION["user"] = $user;
}

if (!isset($_SESSION["user"])) {
	respond(4);
}

$user = $_SESSION["user"];
$user->refresh();
$user->abb = 1;

respond(0,false);

?>
