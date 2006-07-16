<?

require_once("include.php");

htmlStart();

homeHeading("ACSSR Member Activation");

if (isset($_GET["u"]) && isset($_GET["uid"])) {

	$username = $_GET["u"];
	$uid = $_GET["uid"];
	
	$user = new User();
	$user->activate($username, $uid);
	echo 'You\'ve been activated! You can now log in from the <a href=".">Home Page</a>.';
	
} else {

	echo "<pre>";
	print_r($_GET);
	echo "</pre>";
	
	trigger_error("Invalid activate URL");

}

htmlStop();

?>