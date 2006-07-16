<?

include("include.php");

if (isset($_POST["ips"])) {

	$db = new Database();
	
	$servers = $_POST["ips"];
	
	$ips = explode("\n", $servers);
	
	foreach($ips as $ip) {

		$ip = trim($ip);
	
		$db->quickquery("select * from server where address = '$ip'");
		
		if ($db->count())
			continue;
	
		$sql = "insert into server (address) values ('$ip');";
		echo $sql . "<br>";
		//echo mysql_error() . "<br>";
		$db->quickquery($sql);
	
	}
	
}

?>

<form method="post" action="serversadd.php">
<textarea name="ips" rows=20 cols=20></textarea>
<input type="submit">
</form>
