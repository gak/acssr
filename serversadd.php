<?

include("include.php");

if (isset($_POST["ips"])) {

	$db = new Database();
	
	$servers = $_POST["ips"];
	
	$ips = explode("\n", $servers);
	
	foreach($ips as $ip) {

		$ip = trim($ip);
	
		$db->quickquery("select * from server where address = '$ip'");
		
		if ($db->count()) {
			print 'Undeleting '.$ip.'<br>';
			$sql = "update server set deleted = 0 where address = '$ip'";
			print $sql."<BR>";
			$db->query($sql);
			continue;

		}
	
		$sql = "insert into server (address) values ('$ip');";
		echo $sql . "<br>";
		//echo mysql_error() . "<br>";
		$db->query($sql);
	
	}
	
}
htmlStart();
?>

<form method="post" action="serversadd.php">
<textarea name="ips" rows=20 cols=20></textarea>
<input type="submit">
</form>

<?htmlStop();?>
