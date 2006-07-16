<?

global $_SESSION;
$isAdmin = 0;

if (isset($_SESSION["user"])) {

	$user = $_SESSION["user"];
	$users = array("gak", "renwald", "WaLLy3K");

	foreach($users as $u) {
		if ($user->name == $u)
			$isAdmin = 1;
	}

}

?>
