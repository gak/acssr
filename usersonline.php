<?

include("include.php");
include("login.php");

if ($user->name != "gak" && $user->name != "renwald")
	die("Access Denied");

htmlStart();

$ses_life = strtotime("-7 days"); 
$db->query("select *, time-start as diff from session where time > $ses_life and page != '' order by time desc");

echo '<table>';

echo "<tr><th>last hit<th>first hit<th>Time<th>user";;

while (($dat = $db->fetchObject())) {

	if ($dat->time > strtotime("-1 minutes")) {
		$c = " style=\"background-color: #023;\"";
	} else if ($dat->time > strtotime("-30 minutes")) {
		$c = " class=\"alt\"";
	} else {
		$c = "";
	}

	echo "<tr><td$c>" . humanTime(time() - $dat->time) . " ago <td$c>" . humanTime(time() - $dat->start) . " ago";
	echo "<td$c>" . humanTime($dat->diff);

	echo "<td$c>";

//	$dat->value = substr($dat->value, 0, -1);
//	echo $dat->value;	
	
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
				if (isset($user_copy->abb))
					echo"<class style=\"color: #A0A000;\">";
				echo $user_copy->name;
			}
		}
		
	}
	
	echo "<td$c>" . substr($dat->page, 0, 30);

}

echo "</table>";

htmlStop();

?>
