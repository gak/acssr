<?

require_once("include.php");
require_once("login.php");

if (isset($_GET["f"])) {

	$mode = 1;	// find a friend

} else {

	$mode = 0;	// find yourself

}

if (isset($_GET["id"])) {

	echo $mode;

	if ($mode == 0) {
	
		$user->playerid = $_GET["id"] + 0;
		$user->save();
		session_write_close();
		
	} else {

		$a = $_GET['id'] + 0;
	
		$db->query("insert into friends (playerid, userid) values ($a, {$user->id})");
	
	}
	
	header("Location: .");

}


htmlStart();


if ($mode == 0) {
	homeHeading("Find yourself!");
} else {
	homeHeading("Find a friend!");
}

echo "<div class=\"articlebody\">";

$vars = array("search");

foreach($vars as $var) {

	$$var = "";
	if (isset($_GET[$var]))
		$$var = $_GET[$var];

}

$ssearch = stripslashes($search);

if ($mode == 0) {
	echo "Type in your name in the box below. You can type a part of your name if you wish.<br>";
} else {
	echo "Type in a friends name in the box below. You can type a part of the name if you wish. You can also use regular expressions.<br>";
}

?>

<form method="get" action="memberfind.php">
<p><input type="text" name="search" value="<?=$ssearch?>"><input type="submit" value="go"></p>
<? if ($mode == 1) echo '<input type="hidden" name="f" value="1">'; ?>
</form>

</div>

<?

if ($search != "") {

	echo "<h3>Listing players like \"$ssearch\"</h3>";

	$search = "%$search%";
	$search = str_to_sql($search);
	
	$res = $db->query("select id, ename as name from player WHERE player.ename like $search ORDER BY score DESC LIMIT 50");

	echo "<div class=\"articlebody\">";

	if ($mode == 0)
		echo "If you've found yourself, click on the name and I will know who you are!<br><br>";
	else
		echo "If you've found a friend, click on the name and I will add it to your list!<br><br>";

	while (($dat = $db->fetchObject($res))) {

		if ($mode == 0)
			echo "<a href=\"memberfind.php?id=$dat->id\">$dat->name</a><br>";
		else
			echo "<a href=\"memberfind.php?id={$dat->id}&f=1\">$dat->name</a><br>";

	}

	echo "</div>";

}

htmlStop();

?>
