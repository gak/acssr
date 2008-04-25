<?

require_once("include.php");

htmlStart();

$vars = array("search", "allhistory", 'exact', 'startwith', 'endwith');

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

<br>
<script type="text/javascript"><!--
google_ad_client = "pub-9387561163499032";
google_ad_width = 728;
google_ad_height = 15;
google_ad_format = "728x15_0ads_al";
//2007-09-06: acssr search
google_ad_channel = "9916894886";
google_color_border = "006666";
google_color_bg = "006666";
google_color_link = "FFFFFF";
google_color_text = "99FF66";
google_color_url = "FFF600";
//-->
</script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<br>

<?

if ($search != "") {

	homeheading("Searching for $ssearch");
//	$err = "Search is disabled for a few minutes";

	
	$extra = "";
	#	$extra .= " score != 0 and ";
	if (!$allhistory && 0) {
		$extra .= " player.lastserverwhen > " .  getday(-14) . " and ";
	}
	$wc1 = '';
	$wc2 = '';
	if ($exact) {
	} elseif ($startwith) {
		$wc2 = '%';
	} elseif ($endwith) {
		$wc1 = '%';
	} else {
		$wc1 = '%';
		$wc2 = '%';
		if (strlen($search) < $minc) {
			$err = "Your search query is too short. You need to have at least $minc characters, unless you tick \"Exact matches only.\"";
		}
	}

	if (!isset($err)) {	
		$n = str_to_sql($wc1.$search.$wc2);
		$res = $db->query(
			"
			$sqlserverjoin
			inner join playernames on playernames.playerid = player.id and playernames.ename like 
			$n
			WHERE $extra player.deleted = 0
			group by playernames.playerid
			order by score desc, lastserverwhen desc
			LIMIT 50
		");
		dumpTable($res, false);
		$db->query("update stats set searches = searches + 1");
	} else {
		echo '<div class="articlebody">';
		echo $err;
		echo '</div>';
	}

}

htmlStop();

?>
