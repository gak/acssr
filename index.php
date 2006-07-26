<?

require_once("include.php");

htmlStart();

echo '<table><tr><td class="column">';
	
require('static/latestword.htm');
if (1) {
homeHeading('Donations');
?>
<div class="articlebody">
If you enjoy using ACSSR and would like to help support it, please consider making a donation to ACSSR. Your donation will be used for the costs of running, maintaining and upgrading ACSSR.
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but21.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
</form>
</div>
<?
}

if (!isset($_SESSION) || !isset($_SESSION["user"])) {
	$user = null;
	homeHeading("Quick Access");

?>
	<div class="articlebody">
	<form method="POST" action="member.php">

		<div>Access your member profile below. Being an ACSSR member allows you to easily track your friends, vote for players and have a player profile banner. If you don't have a free ACSSR account, <a href="register.php">register here</a>!<br><br>

		<?

		if (isset($_GET["badlogin"])) {

			echo "<b style=\"color: red\">";

			switch($_GET["badlogin"]) {

				case 1:
					echo "Username not found!";
					break;

				case 2:
					echo "Your account is not activated. Did you check your e-mail?";
					break;

				case 3:
					echo "Your password is wrong";
					break;
					
				case 4:
					echo "Your session timed out. Try logging in again.";
					break;
					
				case 5:
					echo "You need to enable cookies to be able to log in.";
					break;
					
				default:


			}

			echo "</b><br><br>";

		}

		?>

		Username: <input type="text" name="username">
		Password: <input type="password" name="password">
		<input type="submit" value="go">

	</div>
	</form>
	</div>

<?
	
} else {

	$user = $_SESSION["user"];
	$user->refresh();

	if (isset($user->playerid)) {
		
		$user->loadplayer();
		
		$s = "or player.id = {$user->player->id}";
		
	}  else {
	
		$s = "";
	
	}

	if ($user->id > 0) {

		$resFriends = $db->query("

			$sqlgenselect
			,server.name as servername
			,server.id as serverid

			FROM friends

			LEFT JOIN player ON friends.playerid = player.id
			LEFT JOIN server ON server.id = player.curserverid

			WHERE friends.userid = {$user->id}

			ORDER BY score DESC");
			
	} else {
	
		Header("Location: logout.php");
	
	}

	homeHeading("ACSSR Member Area - {$user->name}");

	echo "<div class=\"articlebody\">";
	
	if (!isset($user->playerid)) {

		echo "I don't know who you are in the rankings. <a href=\"memberfind.php\">Find Yourself Here</a>.<br><br>";

	} else {

		echo "Hello " . $user->player->ename . ". How are you today?<br><small>If the above isn't right, <a href=\"memberfind.php\">change it</a>!</small><br><br>";

		echo "You are currently ranked <b>" . $user->player->rank . "</b> with a score of <b>" . $user->player->score . "</b>. ";
		echo "You have <b>{$user->player->ppm}</b> points per minute, and have played for a total of <b>".humanTime($user->player->totaltime,true)."</b>. ";
		echo "You last played <b>".humanTime(time() - $user->player->lastserverwhen ,true)."</b> ago.<br>";
		echo "<small>For more details, check <a href=\"playerdetails.php?id={$user->playerid}\">your player details page</a>.</small><br><br>";

	}

	echo "You have <b>" . $db->count($resFriends) . "</b> friend(s).";
	echo ' Activate your <a href="" onclick="window.open(\'friendtracker.php\', \'friends\', \'width=480,height=300,menubar=no,resizable=yes,scrollbars=yes,status=no,toolbar=no\'); return false;"> friend tracker</a>, or use <a href="http://abb.slowchop.com/">Banana Bunch</a> to track friends on your Windows desktop.'; 
	echo "<br><small>Feeling lonely? Add a friend by clicking the <img src=\"img/add.png\" alt=\"\"> icon next to their name!</small><br><br>";
	
	if (isset($user->player)) {
		$vote = $db->query("select * from playervote where userid = {$user->id} group by playerid");
		$votedbyuser = $db->count();
		$vote = $db->query("select * from playervote where playerid = {$user->player->id} group by userid");
		$votedfromothers = $db->count();
		$votealign = $db->quickquery("select sum(playervotecategory.alignment * playervote.alignment) as a from playervote, playervotecategory where playervotecategory.id = playervote.playervotecategoryid and playerid = {$user->player->id}");
		$votealign->a += 0;
		if ($votealign->a > 0) $va = '<span style="color: #0F0">+'.$votealign->a.'</span>'; elseif ($votealign->a < 0) $va = '<span style="color: #F00">'.$votealign->a.'</span>'; else $va = $votealign->a;
		if ($votedfromothers != 1) $mem = "s that have"; else $mem = " that has";
		echo "There are <b>{$votedfromothers}</b> member$mem voted for your alignment to be <b>$va</b>. ";
		Echo "You have voted for <b>{$votedbyuser}</b> player(s).";
		echo "<br><br>";
	}
	
	echo "Configure your <a href=\"memberadvancedprofile.php\">player profile banner</a> to put in your forum signatures and web site.<br><br>";

	$datTag = $db->quickquery("select clantag, clanpos from user where id = {$user->id}");
?>
If you are in a clan, specify your clan tag here to be listed in the clans section.<br>
<form action="setclan.php" method="post">
Clan tag: <input type="text" name="clantag" value="<?=$datTag->clantag?>" size="5">
Tag alignment: <select name="clanpos">
<option value="0"<?if ($datTag->clanpos==0)echo " SELECTED";?>>Left
<option value="1"<?if ($datTag->clanpos==1)echo " SELECTED";?>>Right
</select>
<input type="submit" value="update">
</form><small>Set to nothing if you want to remove the tag. Clan tags must be at least two characters and have a character that isn't a letter.</small><br><br>

<?
	echo "Feel free to <a href=\"logout.php\">log out</a>. ACSSR should remember you for a week otherwise.";
	
	echo "</div>";
	
}

if (!$user) {

	homeHeading("About ACSSR");
	echo "<div class=\"articlebody\">";

?>
ACSSR stands for <b>Australian Counter-Strike:Source Rankings</b>. It tracks <a href="servers.php">Australian servers</a> and collects statistics for players. Feel free to <a href="search.php">search for your player name</a> and check out your stats. I'm usually trolling around the <a href="forum/">forums</a> and answering any questions you may have.
</div>
<?
}

require('static/qs.htm');
require('static/olderwords.htm');

echo "<td class=\"column\">";

if (isset($user)) {
	if ($db->count($resFriends) == 0) {
		// echo "You currently have no friends :(<br><br>";
	} else {
		homeHeading("Friends");
		dumpTable($resFriends, array("servercut"=>true, "small"=>true, "frienddelete"=>true));
	}
}

if ($user) {
	require('static/top10user.htm');
	require('static/clans_front.htm');
	#	require('static/top10onlineuser.htm');
} else {
	require('static/top10.htm');
	require('static/clans_front.htm');
	#	require('static/top10online.htm');
}
	
echo "</table>";

htmlStop();

?>
