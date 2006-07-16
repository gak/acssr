<?

include("include.php");
#include("login.php");
#include("admin.php");

# if (!$isAdmin) die("Access Denied");

htmlStart();

$ses_life = strtotime("-7 days"); 
$db->query("
select playervote.playerid, player.score, count(userid) as c, sum(playervote.alignment * playervotecategory.alignment) as alignment, player.ename 
from playervote, playervotecategory 
left join player on player.id = playervote.playerid
where playervote.playervotecategoryid = playervotecategory.id
group by playervote.playerid
order by alignment
");

echo '<table>';

echo "<tr><th>id<th>score<th>count<th>alignment<th>player";

while (($dat = $db->fetchObject())) {

	echo "<tr>";

	echo "<td>" . $dat->playerid;
	echo "<td>" . $dat->score;
	echo "<td>" . $dat->c;
	echo "<td>" . $dat->alignment;
	echo "<td><a href=\"playerdetails.php?id={$dat->playerid}\">{$dat->ename}</a>";
	
}

echo "</table>";

htmlStop();

?>
