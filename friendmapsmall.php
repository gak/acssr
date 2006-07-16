<?

// include("include.php");
require("conf_db.php");
require("c_database.php");
$db = new Database();

$resf = $db->query("
select user.playerid as a, friends.playerid as b, pb.ename as pb, pa.ename as pa
from friends
inner join user on user.id = userid
left join player pa on pa.id = user.playerid
left join player pb on pb.id = friends.playerid
where user.playerid is not null and friends.playerid is not null
");

$resv = $db->query("
select user.playerid as b, playervote.playerid as a, pb.ename as pa, pa.ename as pb, sum(playervotecategory.alignment * playervote.alignment) as moo
from playervote
inner join playervotecategory on playervotecategory.id = playervote.playervotecategoryid
inner join user on user.id = playervote.userid
left join player pa on pa.id = user.playerid
left join player pb on pb.id = playervote.playerid
where user.playerid is not null and playervote.playerid is not null
group by playervote.userid, playervote.playerid
");
echo mysql_error();

echo "digraph G {\n";
echo "\tsize=\"20,20\";\n";
#echo "\tsep=0;\n";
#echo "\toverlap=\"compress\";\n";
echo "\toutputorder=\"edgesfirst\";\n";
echo "\tnode[shape=\"point\"];\n";
echo "\tedge[arrowsize=0.0, len=0.5];\n";

while ($dat = $db->fetchObject($resf)) {
	echo "\tid" . $dat->a . " -> id" . $dat->b . " [color=royalblue];\n";
	$ids[$dat->a] = fix($dat->pa) . " " .$dat->moo;
	$ids[$dat->b] = fix($dat->pb) . " " .$dat->moo;
	$link[$dat->a][] = $dat->b;
}
while ($dat = $db->fetchObject($resv)) {
	if (isset($link[$dat->a]) && in_array($dat->b, $link[$dat->a]))
		continue;
	if ($dat->moo < 0) {
		$col = "firebrick2";
		echo "\tid" . $dat->b . " -> id" . $dat->a . " [color=$col];\n";
	} else {
		$col = "forestgreen";
		echo "\tid" . $dat->a . " -> id" . $dat->b . " [color=$col];\n";
	}
	$ids[$dat->a] = fix($dat->pa);
	$ids[$dat->b] = fix($dat->pb);
}

echo "}\n";

function fix($a) {
	$a = str_replace("\"" , "", $a);
	return $a;
}
?>
