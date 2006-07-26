<?

require_once("include.php");


if (isset($_GET["id"]))
	$id = $_GET["id"];

$shouldcompare = isset($_GET["compare"]);
if ($shouldcompare)
	$compare = $_GET["compare"];

if (!isset($id) && !isset($compare)) {

//	incorrectURL();
	trigger_error("!id && !compare");

}

if (isset($id) && isset($compare)) {

	trigger_error("id && compare");

}

if (!isset($_GET['historymode'])) {

	$historymode = 0;

} else {

	$historymode = $_GET['historymode'];
	
	
	if ($historymode < 0 || $historymode > 1)
		$historymode = 0;

}

if ($historymode == 0)
	$days = 15;
if ($historymode == 1)
	$days = 51;
	
$vdays = $days - 1;

$colours = $legend_colours;

if ($shouldcompare) {

	$comparelist = explode(",", $compare);

	$i = 0;
	foreach($comparelist as $c) {
	
		$setdata[] = getPlayerData($c, $days);
		$i ++;
		
		if ($i >= sizeof($colours))
			break;
	
	}
	
} else {

	$data = getPlayerData($id, $days);

}


$i = 0;
if ($shouldcompare) {

	htmlStart();
	homeHeading('Comparing Players');
	
	echo "<table class=\"legend\">";

	foreach ($comparelist as $id) {
	
		$i++;
	
		$player = new Player($id+0);	
		echo "<tr><td class=\"legend$i\"><td class=\"legend\">" . $player->data->ename;
		
	}
	
	echo "</table>";

} else {

	$player = new Player($id + 0);
	htmlStart($player->data->ename . " - ");
	
	$player->data->totaltime = humanTime($player->data->totaltime);

	homeHeading($player->data->ename);

	echo "<table><tr><td style=\"vertical-align: top; background-color: transparent; padding: 0px 0px 0px 0px; width: 50%;\">";

		homeHeading('14 Day Summary');
		echo "<table>";
		$alt = 0;
		foreach ($playerdetails_fields as $field) {
			$alt=!$alt;
			$tdalt=($alt)?' class="alt"':'';
			if ($player->data->$field[1] == "")
				$player->data->$field[1] = "0";

			echo "<tr><td$tdalt>{$field[0]}<td$tdalt>".$player->data->$field[1];
			
			if ($field[0] == "Rank") {
				#				$moo = $db->quickquery("select min(rank) as a from playerdaily where playerid = $id and rank != 0");
				$moo = $db->quickquery("select rank,day from playerdaily where playerid = $id and rank != 0 order by rank limit 1");
				
				$alt=!$alt;
				$tdalt=($alt)?' class="alt"':'';
				echo "<tr><td$tdalt>Best Rank<td$tdalt>".$moo->rank;
			}
				
		}

		if ($player->data->curserverid) {
			$lastServer = $db->quickquery("select * from server where id = " . $player->data->curserverid);
			$alt=!$alt;
			$tdalt=($alt)?' class="alt"':'';
			echo "<tr><td$tdalt>Currently playing on<td$tdalt><a href=\"ladder.php?online=" . $lastServer->id . "\">" . $lastServer->name . "</a>";
		} else {
			$lastServer = $db->quickquery("select * from server where id = " . $player->data->lastserverid);
			if ($lastServer) {
				$alt=!$alt;
				$tdalt=($alt)?' class="alt"':'';
				echo "<tr><td$tdalt>Last seen on<td$tdalt><a href=\"ladder.php?online=" . $lastServer->id . "\">" . $lastServer->name . "</a>";
				$alt=!$alt;
				$tdalt=($alt)?' class="alt"':'';
				echo "<tr><td$tdalt>Last seen when<td$tdalt>". humanTime(time() - $player->data->lastserverwhen, 1) . " ago";
			}
		}

		echo "</table>";

		$userid = $db->quickquery("select id from user where playerid = $id");
		if ($db->count())
		if (file_exists("pp/".$userid->id.".png")) {
			homeHeading('Banner');
			echo "<table><tr><td class=\"alt\" style=\"text-align: center; padding: 15px 15px 15px 15px;\"><a href=\"playerdetails.php?id=$id\"><img src=\"http://acssr.slowchop.com/pp/{$userid->id}.png\"></a></table>";
		}

		
function drawAlignment($value, $isgood) {

	$value /= 10;
	$value = floor($value);
	if ($value > 5)
		$value = 5;
	if ($value < -5)
		$value = -5;

	if ($value < 0) {
		$value = -$value;
		$isgood = -$isgood;
	}
	
	if ($isgood == 1) {
		$pos = 'g';
		$neg = 'b';
	} else {
		$pos = 'b';
		$neg = 'g';
	}


	for ($i = 0; $i < $value; $i++) {

		echo "<img alt=\"\" src=\"img/align$pos.png\">";
	}
	
	for ($i = 0; $i < 5 - $value; $i++) {
	
		echo "<img alt=\"\" src=\"img/alignn.png\">";

	}

}

function drawAlignment2($value, $isgood) {


	if ($isgood == 1) {
		$pos = 'g';
		$neg = 'b';
	} else {
		$pos = 'b';
		$neg = 'g';
	}

	$value = floor($value);
	if ($value > 5)
		$value = 5;
	if ($value < -5)
		$value = -5;

	if ($value == 0) {

		for ($i = 0; $i < 10; $i++) {
			echo "<img src=\"img/alignn.png\" alt=\"\">";
		}

	} else if ($value < 0) {

		for ($i = 0; $i < 5 + $value; $i++) {
			echo "<img src=\"img/alignn.png\" alt=\"\">";
		}

		for ($i = 0; $i < - $value; $i++) {
			echo "<img src=\"img/align$neg.png\" alt=\"\">";
		}

		for ($i = 0; $i < 5; $i++) {
			echo "<img src=\"img/alignn.png\" alt=\"\">";
		}

	} else {

		for ($i = 0; $i < 5; $i++) {
			echo "<img src=\"img/alignn.png\" alt=\"\">";
		}

		for ($i = 0; $i < $value; $i++) {
			echo "<img src=\"img/align$pos.png\" alt=\"\">";
		}

		for ($i = 0; $i < 5 - $value; $i++) {
			echo "<img src=\"img/alignn.png\" alt=\"\">";
		}

	}

}

// player voting!!!

	if (1) {

		if (isset($_SESSION) && isset($_SESSION["user"]) && $_SESSION["user"]) {
			$user = $_SESSION["user"];
			$user->refresh();
		} else {
			$user = null;
		}

		if ($user) {
			echo '<form method="post" action="playervote.php?id='.$id.'">';
		}
			
		$resCat = $db->query("

			select playervotecategory.id, playervotecategory.name, playervotecategory.alignment
			from playervotecategory
			order by playervotecategory.alignment desc

		");

		$align = array();
		$vc = array();
		$vc['Overall Alignment'] = "";
		$votes['Overall Alignment'] = 0;
	
		$totalVotes = 0;
		while ($cat = $db->fetchObject($resCat)) {
		
			$dat = $db->quickquery("select count(id) as c, sum(alignment) as s from playervote where playerid = {$id} and playervotecategoryid = {$cat->id}");

			$align[$cat->name] = $cat->alignment;

			$votes['Overall Alignment'] += $dat->s * $cat->alignment;
			$votes[$cat->name] = $dat->s;

			$votesID[$cat->name] = $cat->id;

			$vc[$cat->name] = $dat->c;
			$totalVotes += $dat->c;

		}

		if ($totalVotes)
			$votes['Overall Alignment'] /= $totalVotes;
		else
			$votes['Overall Alignment'] = 0;

		echo "<td style=\"vertical-align: top; background-color: transparent; padding: 0px 0px 0px 1px; width: 50%;\">";

		homeHeading('Voting Statistics');
		echo '<div class="articlebody">';
		echo 'Each ACSSR member has the right to have a vote for any other player in ACSSR. If you are logged in you are able to vote. Some <a href="voting.php">voting details here</a>.';	
		echo '</div>';
		echo "<table>";

		$lastalign=0;

		foreach($votes as $k=>$v) {

			if ($k == 'Overall Alignment')
				continue;

			if (isset($align[$k]) && $lastalign != $align[$k]) {

				$lastalign = $align[$k];
				if ($align[$k] == 1)
					echo "<tr><td colspan=3 class=\"total\">Good Traits";
				else
					echo "<tr><td colspan=3 class=\"total\">Bad Traits";
					
				echo "<td class=\"total\">Vote";

			}

			echo "<tr><td>{$k}<td>{$vc[$k]} vote".(($vc[$k]==1)?'':'s')."<td>";
			drawAlignment($v, $align[$k]);

			if (!$user) {
				echo "<td>-";
			} else {
				$vote = $db->quickquery("select alignment from playervote where userid = {$user->id} and playerid = {$id} and playervotecategoryid = {$votesID[$k]}");
				if ($db->count() == 0) {
					$vote->alignment = 0;
				}
				echo "<td><select name=\"{$votesID[$k]}\">";
				for ($m = 0; $m < 3; $m++) {

					if ($m == $vote->alignment)
						$s = " SELECTED";
					else
						$s = "";

					if ($m > 0)
						$mm = "+" . $m;
					else
						$mm = $m;

					echo "<option value=$m$s>$mm";
				}
			echo "</select>";
			}

			
		}

		echo "<tr><td colspan=4 class=\"total\">Overall";
		echo "<tr><td>Overall Alignment<td>";
		$a =  ($totalVotes * $votes['Overall Alignment']);
		if ($a > 0) $a = "+" . $a;
		print $a. "<td>";
		drawAlignment($votes['Overall Alignment'], 1);
		echo "<td>";
		if ($user) {
			echo "<input type=\"submit\" value=\"vote\">";
		}
		
		echo "</table>";

	}

	echo "</table>";
	
}

if ($shouldcompare)
	$changeidparm = "compare=$compare";
else
	$changeidparm = "id=$id";

if ($historymode == 0) {

	$change = '(<a href="playerdetails.php?'.$changeidparm.'&amp;historymode=1">change to 50 days</a>)';

} else if ($historymode == 1) {

	$change = '(<a href="playerdetails.php?'.$changeidparm.'&amp;historymode=0">change to 14 days</a>)';

}

homeHeading('Recent Server History');
$db->query("
	select psh.starttime, psh.official, psh.points, psh.totaltime, server.name as servername, map.name as mapname, server.id as serverid
	from playerserverhistory psh
	left join server on server.address = psh.serveraddress
	inner join map on map.id = psh.mapid
	where psh.playerid = $id
	and totaltime != 0
	order by psh.starttime desc
	limit 10
");
echo '<table><tr><th>When<th>Server<th>Map<th>Official<th>Points<th>Time<th>P/M<th>';
$alt = 1;
$lastServerID = -1;
while ($dat = $db->fetchObject()) {
	echo '<tr>';
	$alt  = !$alt;
	$td = ($alt)?'<td>':'<td class="alt">';
	echo $td . myshortdate($dat->starttime);
	if ($lastServerID == $dat->serverid)
		echo $td . '...';
	else
		echo $td . '<a href="ladder.php?online='. $dat->serverid . '">' . $dat->servername . '</a>';
	$lastServerID = $dat->serverid;
	echo $td . $dat->mapname;
	echo $td . $dat->official;
	echo $td . $dat->points;
	echo $td . humanTime($dat->totaltime);
	echo $td . number_format($dat->points / $dat->totaltime * 60, 1);
	$p = 'ppm1';
	if (!$dat->official) $p = 'ppm2';
	echo $td . horiz_line($dat->points / $dat->totaltime * 2000, 1, 1, $p);
}
echo '</table>';

homeHeading($vdays . ' Day History Graphs ' . $change);

// set up labels
if ($historymode == 0) {

	for ($i = 0; $i < $days; $i++)
		$labels[$i] = date("D",getday(-$days) + 86400 * ($i + 1));
	$labels[$days-1] = "Now";
	
} else if ($historymode == 1) {

	for ($i = 0; $i < $days; $i++)
		$labels[$i] = date("j/M",getday(-$days) + 86400 * ($i + 1));

	$labels[$days-1] = "Now";

}

if ($shouldcompare) {
	
	echo "<table><tr><td class=\"graph\">";
	makePlayerGraphMultiple(implode("-", $comparelist) . "-score-$historymode.png", "Score over $vdays days", "score", $setdata, $colours, $labels);
	echo "<td class=\"graph\">";
	makePlayerGraphMultiple(implode("-", $comparelist) . "-ppm-$historymode.png", "Points/Minute over $vdays days", "ppm", $setdata, $colours, $labels);
	echo "<tr><td class=\"graph\">";
	makePlayerGraphMultiple(implode("-", $comparelist) . "-rank-$historymode.png", "Rank over $vdays days", "rank", $setdata, $colours, $labels);
	echo "<td class=\"graph\">";
	makePlayerGraphMultiple(implode("-", $comparelist) . "-hours-$historymode.png", "Hours over $vdays days", "hours", $setdata, $colours, $labels);
	echo "</table>";
	
} else {

	echo "<table><tr><td class=\"graph\">";
	makePlayerGraph("$id-score-$historymode.png", "Total Score over $vdays days", $data->score, "brown", $labels);
	
	echo "<td class=\"graph\">";
	makePlayerGraph("$id-ppm-$historymode.png", "Points per Minute over $vdays days", $data->ppm, "green", $labels, array("type"=>"bar"));

	echo "<tr><td class=\"graph\">";
	makePlayerGraph("$id-rank-$historymode.png", "Rank over $vdays days", $data->rank, "purple", $labels, array("type"=>"bar"));

	echo "<td class=\"graph\">";
	$fn = "graphs/player$id-ft-$historymode.png";
	echo "<h3>Points and Minutes over $vdays days</h3>";
	echo "<p><img src=\"$fn\" alt=\"Points and Minutes over $vdays days\" title=\"Points and Minutes over $vdays days\"></p>";
	$graph = graphPlayerNew($labels);
	$bar1 = graphPlayerBar($data->frags, "red");
	$bar1->SetLegend("Points");
	$bar2 = graphPlayerBar($data->time, "blue");
	$bar2->SetLegend("Minutes");
	$moo = new GroupBarPlot(array($bar1, $bar2));
	$graph->legend->SetShadow(false);
	$graph->legend->SetFillColor("#158289");
	$graph->legend->Pos(0.132,0.065,"left","top");
	$graph->legend->SetColor("#ffffff", "#ffffff");
	$graph->Add($moo);
	$graph->Stroke($fn);

	echo "</table>";
	
}

htmlStop();

function makePlayerGraph($file, $desc, $data, $col, $labels, $extra = 0) {

	$fn = "graphs/player$file";
	echo "<h3>$desc</h3>";
	echo "<p><img src=\"$fn\" alt=\"$desc\" title=\"$desc\"></p>";
	makeGraph($fn, $data, $col, $labels, $extra);

}

function makeGraph($file, $data, $col, $labels, $extra) {

	$graph = graphPlayerNew($labels);

	if ($extra && isset($extra["type"]) && $extra["type"] == "bar")
		$bar = graphPlayerBar($data, $col);
	else		
		$bar = graphPlayerLine($data, $col);
	
	$graph->Add($bar);
	$graph->Stroke($file); 

}

function makePlayerGraphMultiple($file, $desc, $meth, $setdata, $setcol, $labels) {

	$fn = "graphs/player$file";
	echo "<h3>$desc</h3>";
	echo "<p><img src=\"$fn\" alt=\"$desc\" title=\"$desc\"></p>";
	makeGraphMultiple($fn, $meth, $setdata, $setcol, $labels);

}

function makeGraphMultiple($file, $meth, $setdata, $setcol, $labels) {

	$graph = graphPlayerNew($labels);

	for ($i = 0; $i < sizeof($setdata); $i++) {
		$data = $setdata[$i]->$meth;
		$col = $setcol[$i];
		$bar[$i] = graphPlayerLine($data, $col, false);
		$graph->Add($bar[$i]);
		
	}
	
	$graph->Stroke($file); 

}

function graphPlayerNew($labels) {

	global $historymode;	// easier!

//	$graph = new Graph(250, 100,"auto");    
	$graph = new Graph(250*1.5, 1.5*100,"auto");    

	$graph->SetScale("textlin");

	$graph->SetMargin(50,12,10,0);
	$graph->xaxis->SetTickLabels($labels);
	
	if ($historymode == 0) {
		$graph->xaxis->SetTextLabelInterval(2);
	} else if ($historymode == 1) {
		$graph->xaxis->SetTextLabelInterval(10);
	}
	$graph->xaxis->SetColor("#ffffff");
	$graph->yaxis->SetColor("#ffffff");
	$graph->SetFrame(true, 'darkblue', 0);
	$graph->SetMarginColor('#116A70');
	$graph->SetColor('#1CADB6');

	return $graph;

}

function graphPlayerBar($data, $colour) {

	$bar = new BarPlot($data);
	$bar->SetFillColor($colour);
	$bar->SetWidth(1);
	
	return $bar;

}

function graphPlayerLine($data, $colour, $fill = true) {

	$bar = new LinePlot($data);
	
	if ($fill) {
		$bar->SetColor("black");
		$bar->SetFillColor($colour);
	} else {
		$bar->SetColor($colour);
		$bar->SetWeight(1);
	}
	
	return $bar;

}


function getPlayerData($id, $days) {

	global $db;

	$firstday = getday(-$days);

	for ($i = 0; $i < $days; $i++) {

		$data->ppm[$i] = 0;
		$data->frags[$i] = 0;
		$data->time[$i] = 0;
		$data->rank[$i] = 0;
		$data->score[$i] = 0;
		$data->hours[$i] = 0;

	}

	// generate graph for player's history HpM
	$sql = "SELECT * from playerdaily where playerid = $id and day >= " . $firstday;
	$db->query($sql);

	// put them in their place
	while (($dat = $db->fetchobject())) {

		$diffseconds = $dat->day - $firstday;
		$diffday = $diffseconds / 86400;

		if ($diffday == 0)
			continue;

		if ($dat->time > 0)
			$data->ppm[$diffday-1] = $dat->frags / $dat->time * 60;

		$data->frags[$diffday-1] = $dat->frags;
		$data->time[$diffday-1] = $dat->time / 60;
		$data->hours[$diffday-1] = $dat->time / 60 / 60;

		if ($dat->rank != 0)
			$data->rank[$diffday-1] = $dat->rank;
			
		$data->score[$diffday-1] = $dat->score;

	}
	
	return $data;
	
}

function makeActivityGraph($id) {

	

}

?>
