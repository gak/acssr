<?

// this file is included to make sure you're logged in. It also processes the login form.
/*
if (isset($_REQUEST) && isset($_REQUEST["ACSSR"])) {

	header("Location: .?badlogin=5");
	die();

}
*/

//phpinfo();
//die();

if (isset($_POST["username"]) && isset($_POST["password"])) {

	$user = new User();
	$result = $user->login($_POST["username"], $_POST["password"]);
	
	if ($result > 0) {
	
		header("Location: .?badlogin=$result");
		die();
	
	} else {
	
		$_SESSION["user"] = $user;
		
	}

}

if (!isset($_SESSION["user"])) {

		header("Location: .?badlogin=4");
		die();

}

$user = $_SESSION["user"];
$user->refresh();

?>
