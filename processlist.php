<?

require_once("include.php");


htmlStart();
homeHeading("moo");

echo "<table>";
$db->query("show full processlist");
while (($dat = $db->fetchObject())) {

	$cmd = $dat->Info;	
	
	$cmd = str_replace("\n", "<br>", $cmd);
	$cmd = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $cmd);

	for ($i = 0; $i < 10; $i++)
		$cmd = str_replace("  ", " ", $cmd);
	
	echo "<tr><td>".$dat->Id;	
	echo "<td>".$dat->Command;	
	echo "<td>".$dat->Time;	
	echo "<td>".$dat->State;	
	echo "<td>".$cmd;	

}
echo "</table>";

htmlStop();

?>
