<?

require_once("include.php");

htmlStart();

$vars = array("search", "allhistory", 'exact');

foreach($vars as $var) {

	$$var = "";
	if (isset($_GET[$var]))
		$$var = $_GET[$var];

}

$ssearch = stripslashes($search);

$minc = 3;

?>

<?homeheading('Player Search');?>

<div class="articlebody">
Type in part of all of the player you're looking for. The search is not case sensitive, so don't worry about upper or lower cases. If you don't tick the <i>Exact matches only</i> option, you must use at least <?=$minc?> characters in your search. Only 50 results will be shown sorted by rank, then last seen on a server.
<form method="get" action="search.php">
<p><input type="text" name="search" value="<?=$ssearch?>"><input type="submit" value="go"></p>
<p><input type="checkbox" name="exact" value="1"<? if ($exact) echo " CHECKED"; ?>> Exact matches only</p>
</form>

</div>

<?

if ($search != "") {

	homeheading("Searching for $ssearch");
//	$err = "Search is disabled for a few minutes";

	
	$extra = "";
		$extra .= " score != 0 and ";
	if (!$allhistory && 0) {
		$extra .= " player.lastserverwhen > " .  getday(-14) . " and ";
	}
	if ($exact) {
		$wc1 = '';
	} else {
		$wc1 = '%';
		if (strlen($search) < $minc) {
			$err = "Your search query is too short. You need to have at least $minc characters, unless you tick \"Exact matches only.\"";
		}
	}
	
	if (!isset($err)) {	
		$n = str_to_sql($wc1.$search.$wc1);
		$res = $db->query(
			"
			$sqlserverjoin
			inner join playernames on playernames.playerid = player.id and playernames.ename like 
			#'$wc1$search$wc1'
			$n
			WHERE $extra player.deleted = 0
			order by score desc, lastserverwhen desc
			LIMIT 50
		");
		dumpTable($res, false);
		$db->quickquery("update stats set searches = searches + 1");
	} else {
		echo '<div class="articlebody">';
		echo $err;
		echo '</div>';
	}

}

htmlStop();

?>
