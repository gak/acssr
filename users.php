<?

include("include.php");
include("login.php");

if ($user->name != "gak" && $user->name != "renwald")
	die("Access Denied");

htmlStart();

$ses_life = strtotime("-7 days"); 
$db->query("select *, time-start as diff from session where time > $ses_life and page != '' order by time desc");

while (($dat = $db->fetchObject())) {

	if ($dat->time > strtotime("-1 minutes")) {
		$c = " style=\"color: #000;\"";
	} else if ($dat->time > strtotime("-30 minutes")) {
		$c = " style=\"color: #333;\"";
	} else {
		$c = "";
	}

	if (strlen($dat->value) > 2) {
	
		$tok = explode('|', $dat->value);
		for ($i = 0; $i < sizeof($tok); $i+=2) {

//			echo "<br><br>{$tok[$i]} = unserialize({$tok[$i+1]}) = ";
			$tok[$i] .= "_copy";
			$$tok[$i] = @unserialize($tok[$i+1]);
//			echo $$tok[$i];
//			echo "<br>";

		}

		if ($dat->value != "") {
			//unserialize($dat->value);
			if (isset($user_copy) && isset($user_copy->name)) {
				if (isset($user_copy->abb)) {}
				echo "<span $c>" . $user_copy->name . "</span>, ";
			}
		}
		
	}
	
}


htmlStop();

?>
