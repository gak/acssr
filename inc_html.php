<?

function htmlStart($headextra="") {

	#if ($headextra != "")
	#$headextra = " - " . $headextra;
	
header("Content-type: text/html; charset=utf-8");
header("Cache-Control: no-cache");

?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">

<html>
<head>
<title><?=$headextra?>ACSSR - Australian Counter Strike:Source Rankings</title>
<style type="text/css">
@import "style.php";
</style>
<link rel="shortcut icon" href="img/icon.png">
<meta name="resource-type" content="document">
<meta name="description" content="A Counter-Strike:Source player ranking and tracking system that monitors Australian servers">
</head>
<body><div class="top"><table class="topoutline"><tr><td class="topoutlinebody">

<!--<a href="l.php"><img src="b.php" alt=""></a>-->
<script type="text/javascript"><!--
google_ad_client = "pub-9387561163499032";
google_ad_width = 468;
google_ad_height = 60;
google_ad_format = "468x60_as";
google_ad_type = "text_image";
google_ad_channel ="";
google_color_border = "006666";
google_color_bg = "158289";
google_color_link = "FFFFFF";
google_color_url = "FFF600";
google_color_text = "99FF66";
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
  </script>
</table></div><table class="outline"><tr><td class="outlinebody"><form method="GET" action="search.php"><table style="width: 100%; background-color: #000;" ><tr><td class="navigation"><?

global $db;

/*
checkBanner();
$db->query("update adcounter set tryshow = tryshow + 1 where day = " . today());
*/

global $menus;
$first = 0;
//echo " | ";
foreach ($menus as $menu) {

	echo "<a class=\"navigation\" href=\"{$menu["link"]}\">{$menu["name"]}</a>";	
//	echo "";

}

?>

<td class="search"><input type="text" name="search" value="search for a player"
onfocus="if (this.value == 'search for a player') this.value = '';"
><!--<input type="submit" value="go">-->

</table>
</form>

<?

}

function htmlStop($dbok = 1) {

if ($dbok) {
	global $db;
	$db->query("update stats set hits = hits + 1");
}
	
global $_GET;

if (isset($_GET["debug"])) {

	global $QUERIES;
	
	echo '<table border=1>';
	
	foreach($QUERIES as $q) {
	
		$q["sql"] = str_replace("\n", "<br>", $q["sql"]);
		$q["sql"] = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $q["sql"]);

		for ($i = 0; $i < 10; $i++)
			$q["sql"] = str_replace("  ", " ", $q["sql"]);
	
		echo '<tr><td class=sql';
		
		if ($q["time"] > 100) {
			echo " style='background-color: #500000;'";
		}
		
		echo ">";
		
		echo $q["time"] . "ms<br>";
		echo $q["rows"] . " rows<br>";
		echo $q["fields"] . " fields<br>";
		echo $q["affectedrows"] . " affectedrows<br>";
		
		echo "<td class=sql";
		
		if (isset($q["error"])) {
			echo " style='background-color: #FF0000;'";
		}
		
		echo ">";
		
		echo $q["sql"];
		
	
	}
	
	echo "</table>";

}

global $_SERVER;
if (isset($_SERVER) and isset($_SERVER["REQUEST_URI"]))
	$ref = $_SERVER["REQUEST_URI"];
else
	$ref = '';

?>

<hr><div align="center">
<script type="text/javascript"><!--
google_ad_client = "pub-9387561163499032";
google_ad_width = 728;
google_ad_height = 90;
google_ad_format = "728x90_as";
google_ad_type = "text_image";
google_ad_channel ="";
google_color_border = "006666";
google_color_bg = "158289";
google_color_link = "FFFFFF";
google_color_url = "FFF600";
google_color_text = "99FF66";
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
  </script>
</div><hr>
<span style="float: right;"><script type="text/javascript"><!--
google_ad_client = "pub-9387561163499032";
google_ad_width = 110;
google_ad_height = 32;
google_ad_format = "110x32_as_rimg";
google_cpa_choice = "CAAQpeKZzgEaCL1N-uOV--c-KOP143Q";
//--></script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></span>
<span style="font-size: 9px;">
ACSSR was created by <a href="http://slowchop.com/">Slowchop Studios</a>. Thanks to Jon Skinner and <a href="http://swapoff.org/">Alec Thomas</a> for providing code optimisation and <a href="playerdetails.php?id=539723">ren[FBi]</a> and <a href="http://acssr.slowchop.com/playerdetails.php?id=286585">Wally3K</a> for being good helper monkeys.<br>
ACSSR is best viewed with a resolution of 1024x768 or higher. ACSSR is contactable by emailing 
<script>d="slowchop.com";u="acssr";a="@";e=u+a+d;document.write("<a href=\"mailto:"+e+"\">"+e+"</a>");</script>.
</span>

<br>

</table>

<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-214748-1";
urchinTracker();
</script>

</body>
</html>
<?
if ($dbok)
	session_write_close();

}

function serverLink($name, $address) {

	return '<a href="steam://connect/'.$address.'"><img src="img/join.png" title="Join '.$name.' ('.$address.')"></a>';

}

// function dumpTable($res, $total = true, $header = true, $tablestart = true, $tableend = true) {
function dumpTable($res, $vars = array()) {

	// get user
	global $_SESSION;
	if (!isset($_SESSION["user"])) {
			$usersession = null;
	} else {
		$usersession = $_SESSION["user"];
	}

	include('admin.php');
		
	$options = array(
	
		array("name" => "total", "default" => true)
		,array("name" => "tablestart", "default" => true)
		,array("name" => "tableend", "default" => true)
		,array("name" => "header", "default" => true)
		,array("name" => "servercol", "default" => true)
		,array("name" => "scorecol", "default" => true)
		,array("name" => "secondscol", "default" => true)
		,array("name" => "totalfragscol", "default" => true)
		,array("name" => "ppmcolcol", "default" => true)
		,array("name" => "servercut", "default" => false)
		,array("name" => "reorderrank", "default" => false)
		,array("name" => "small", "default" => false)
		,array("name" => "compare", "default" => false)
		,array("name" => "morelink", "default" => "")
		,array("name" => "frienddelete", "default" => false)
		,array("name" => "user", "default" => false)
		,array("name" => "export", "default" => false)
		,array("name" => "format", "default" => 0)
		,array("name" => "meat", "default" => 0)
	
	);

	
	foreach($options as $option) {

		$name = $option["name"];
		$default = $option["default"];

		if (isset($vars[$name])) {

			$$name = $vars[$name];

		} else {

			$$name = $default;

		}

	}

	global $db;
	global $rank_fields;

	if ($usersession) $user = true;

	// rank, name
	if ($format == 1) {

		$servercol = false;
		$secondscol = false;
		$totalfragscol = false;
		$ppmcol = false;
		$scorecol = false;

	// rank, name, server
	} else if ($format == 2) {

		$scorecol = false;
		$secondscol = false;
		$totalfragscol = false;
		$ppmcol = false;

	}

	if ($export)
		echo "<table class=\"acssr\">";

	else if ($tablestart)
		echo "<table>";
	
	if ($header) {

		echo "<tr>";
		foreach($rank_fields as $field) {

			if (!$field[RANK_SHOW])
				continue;

//			if ($field[1] == "server" && !$servercol)
//				continue;

			$variable = $field[1] . 'col';
			if (isset($$variable))
				if (!$$variable) {
		//			echo "Skipping " . $variable . "<br>";
					continue;
				}
				

			echo "<th class=\"{$field[1]}\">";
			
			if ($small)
				echo $field[0];
			else
				echo $field[5];

		}

	}

	unset($totals);
	$totals = new stdclass();
	foreach($rank_fields as $field) {
		$totals->$field[1] = 0;
	}
	$rows = 0;	// used for rank too
	unset($id);
	while (($dat = $db->fetchobject($res))) {

		$id[] = $dat->id;

		$rows++;

		$tdtag = ($rows % 2) ? '<td' : '<td class="alt"';
		$pname = $dat->ename;

		if (!$dat->score)
			$dat->rank = "-";

		$origservername = $dat->servername;
		
		if ($servercut) {

			$dat->servername = shortServerName($dat->servername);
			$dat->servername = substr($dat->servername, 0, 25);

		}

		if ($dat->curserverid > 0)
			$dat->server = serverLink($origservername, $dat->serveraddress) . " <a href=\"ladder.php?online={$dat->curserverid}\">$dat->servername</a>";
		else {
			$dat->server = humanTime(time() - $dat->lastserverwhen, true) . " ago";
			
		}

/*		
		if ($dat->clanid > 0) {
		
			if ($dat->tagalign == 0) {
			
				if ($dat->tag != substr($dat->ename, 0, strlen($dat->tag))) {
				
					$l = "<a href=\"playerdetails.php?id={$dat->id}\">{$dat->ename}</a>";
				
				} else {
			
					$l = "<a class=\"ausourcelink\" href=\"http://ausource.slowchop.com/clandetails.php?id={$dat->clanid}\">{$dat->tag}</a>";
					$l .= "<a href=\"playerdetails.php?id={$dat->id}\">";
					$l .= substr($dat->ename, strlen($dat->tag));		
					$l .= "</a>";

				}

				$dat->ename = $l;
			
			}
			
			// $dat->ename = "yo";
		
		} else {
*/		
			$dat->ename = "<a href=\"playerdetails.php?id={$dat->id}\">".htmlspecialchars($dat->ename)."</a>";

//		}

			
		if ($frienddelete) {
			$dat->ename .= " <a href=\"memberfrienddelete.php?id={$dat->id}\"><img title=\"Delete from friends\" alt=\"Delete from friends\" src=\"img/delete.png\"></a>";
		}

		else if ($user) {
				$dat->ename .= " <a href=\"memberfind.php?id={$dat->id}&f=1\"><img title=\"Add $pname to your friends list\" alt=\"\" src=\"img/add.png\"></a>";
		}

		if ($isAdmin) {
				$dat->ename .= " <a onclick=\"return confirm('Delete {$pname}?');\" href=\"memberdelete.php?id={$dat->id}\" style=\"color:black\">x</a>";
		}
			
		if ($reorderrank) {

			$dat->rank = $rows;
				
		}

	
		echo "<tr>";
		foreach($rank_fields as $field) {
		
//			if (!isset($dat->$field[1]))
//				continue;
			
			$totals->$field[1] += $dat->$field[1];
			
			if (!$field[RANK_SHOW])
				continue;
				
		//	if ($field[1] == "server" && !$servercol)
		//		continue;
			$variable = $field[1] . 'col';
			if (isset($$variable))
				if (!$$variable) {
		//			echo "Skipping " . $variable . "<br>";
					continue;
				}
	
			if ($small && !$export)
				echo $tdtag . " style=\"font-size: " . $field[4] . "px;\">";
			else
				echo $tdtag . ">";

			if ($field[1] == "seconds") {
			
				echo htmlspecialchars(humanTime($dat->seconds));
				
			} else {

				echo $dat->$field[1];
				
			}
			
		}

	}

	if ($total && $totals->seconds > 0 && $totals->minutes > 0 && $rows > 1) {

		$id = implode(",", $id);

		echo "<tr>";
 
		unset($values);
		$values = new stdclass();
		$ratio = $totals->totalfrags / $totals->seconds;
		$values->multiplier = 1 - FORMULA_OFFSETT / ($totals->seconds + FORMULA_OFFSETB);
		$values->score = number_format($ratio * $values->multiplier * FORMULA_SCOREMULTIPLIER, 0, "", "");
		$values->ename = "OVERALL";
		
		$nameextra = "";
		
		if ($compare)
			$nameextra .= " <a href=\"playerdetails.php?compare=$id\">compare</a>";
		
		if ($morelink) {
			for ($yay=0;$yay < 6;$yay++)
			echo '<td class="total">';
			echo '<td class="total" align="right">' . $morelink;
		} else {
			
			if ($nameextra != "") {
			
				$nameextra = trim($nameextra);
			
				$nameextra = " <small>($nameextra)</small>";
				$values->ename .= $nameextra;
			
			}

			$values->multiplier = number_format($values->multiplier, 2);
			$values->ppm = number_format($totals->totalfrags / $totals->minutes, 2);
			$values->seconds = humanTime($totals->seconds);
			$values->totalfrags = $totals->totalfrags;
		
			foreach($rank_fields as $field) {
			
				if (!$field[RANK_SHOW])
					continue;
				
				if ($field[1] == "server" && !$servercol)
					continue;
			
				echo "<td class=\"total\">";

				if (isset($values->$field[1])) {
				
						echo $values->$field[1];

				}
				
			}
		}
	}

	if ($tableend)
		echo "</table>";

}

function homeHeading($a) {

//	old heading
//	echo '<h2>'.$a.'</h2>';

	echo '<br>';
	echo '<table><tr>';

//	echo '<td style="background-color: black; font-size: 12px; font-weight: 900; padding: 5px 5px 5px 5px; width: 10px;">';
//	echo '<img src="img/icon.png">';

	echo '<td style="background-color: black; font-size: 12px; font-weight: 900; padding: 5px 5px 5px 5px;">';
	echo $a;

//	echo '<td style="background-color: black; font-size: 12px; font-weight: 900; padding: 5px 5px 5px 5px; width: 10px;">';
//	echo '<img src="img/close.png">';

	echo '</table>';

}

function htmlQuickStats($ajax = 0) {

	global $db;

	$dat1 = $db->quickquery("select count(id) as c from player");
	$dat4 = $db->quickquery("

		select stats.*,
		player.ename, player.id, player.totaltime,
		yesterdaysbestplayer.ename as yesterdaysbestename, yesterdaysbestplayer.id as yesterdaysbestid
		
		from stats
		left join player on player.id = stats.totaltimeid
		left join player as yesterdaysbestplayer on yesterdaysbestplayer.id = stats.yesterdaysbestid
		
		");

	$datOnline = $db->quickquery("select count(id) as c from session where " . (time() - 60 * 30) . " < time");
	$datMembers = $db->quickquery('select count(id) as c from user where activated = 1 and lasttime > ' . (time() - 60*60*24*14));
	$datVotes = $db->quickquery('select count(id) as c from playervote');
	$datFriends = $db->quickquery('select count(userid) as c from friends');

	if ($ajax) {

		echo $dat1->c;
		echo ',';
		echo $dat4->onlinecount;
		echo ',';
		echo $datOnline->c;
		echo ',';
		echo $dat4->hits;
		echo ',';
		echo $dat4->searches;
		
	} else {
	
		echo "ACSSR has seen a total of <b id=\"qs0\">{$dat1->c}</b> players, <b id=\"qs1\">{$dat4->onlinecount}</b> of which are in an Australian server right now. ";
		echo "There are currently <b id=\"qs2\">{$datOnline->c}</b> people browsing ACSSR. So far, there has been a total of <b id=\"qs3\">{$dat4->hits}</b> hits and <b id=\"qs4\">{$dat4->searches}</b> searches made since ACSSR opened <b>" . humanTime(time() - 1103634000, true). " ago</b>. ";

		echo "There are <b>{$datMembers->c}</b> members that have logged in recently and there has been a total of <b>{$datFriends->c}</b> friends made and <b>{$datVotes->c}</b> votes cast by members. ";

		echo "The player with the longest accumulated playing time in the last 14 days is <a href=\"playerdetails.php?id={$dat4->id}\">{$dat4->ename}</a> who has played for <b>".humanTime($dat4->totaltime, true)."</b> which is <b>".floor($dat4->totaltime / 1209600 * 100)."%</b> of the time. ";
		echo "Yesterdays best player was <a href=\"playerdetails.php?id={$dat4->yesterdaysbestid}\">{$dat4->yesterdaysbestename}</a> who had <b>{$dat4->yesterdaysbestfrags} points</b> in <b>".humanTime($dat4->yesterdaysbesttime, true)."</b>.";
		echo " Here is a daily <a href=\"friendmap/friendmap.png\">social network graph</a> of all ACSSR friends and voters (400KB).";
	}
}
	


function htmlTitle($a) {
	echo "<b>$a</b>";
}

function htmlArticleText($a) {
	echo $a;
}

function htmlArticle($a) {
	htmlArticleStart();
	htmlArticleText($a);
	htmlArticleStop();
}

function htmlArticleStart() {
	echo '<div class="articlebody">';
}

function htmlArticleStop() {
	echo '</div>';
}

function htmlFormTextLine($name, $value = "", $size = 0, $class = "") {
	htmlFormText($name, $value, $size, $class);
	echo '<br>';
}

function htmlFormText($name, $value = "", $size = 0, $class = "") {
	echo '<input type="text" value="'.$value.'"';
	if ($size)
		echo ' size="'.$size.'"';
	if ($class != "")
		echo ' class="'.$class.'"';
	echo '>';

}
function news($dat) {
	$subject = $dat->topic_title;
	$when = $dat->topic_time;
	$body = $dat->post_text;

	global $db;
	$d = $db->quickquery('select username from acssrforum.phpbb_users where user_id = ' . $dat->topic_poster);
	$name = $d->username;
	$d = $db->quickquery('select count(*) as replies from acssrforum.phpbb_posts where topic_id = ' . $dat->topic_id);
	$comments = $d->replies - 1;
	
    echo "<div class=\"articlebody\">";
    echo "<b>" . $subject . "</b><br>";
    echo "<div class=\"articlesub\">";

    $ago = now() - $when;
    if ($ago > 172800)
        echo mylongdate($when);
    else
        echo "Posted " . humantime($ago) . " ago by $name";

    echo "</div>";
	if ($comments == 1) $plural = ''; else $plural = 's';
	$body = str_replace("\n", "<br>", $body);
    echo $body;
	echo '<div class="articlesub"><br><a href="/forum/viewtopic.php?t='.$dat->topic_id.'">'.$comments.' comment'.$plural.'</a> | ';
	echo '<a href="/forum/viewforum.php?f=5">older news</a></div>';
	#	echo '<div class="articlesub"><br><a href="/forum/posting.php?mode=reply&t=' . $dat->topic_id . '">post comment</a></div>';
    echo "</div>";
}


?>
