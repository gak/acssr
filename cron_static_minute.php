<?

$debug = 0;
$nohtml = 1;
$noob = 1;

require("include.php");

$_p = new Profiler("cron_poll.php");
$_p->point('session gc');

// just piggybacking sesion garbage collection in here..
$ses_life = strtotime("-14 days");
$db->query("delete from session where time < $ses_life");

function sb($f) {
	file_put_contents("static/$f.htm", ob_get_contents()); ob_end_clean(); ob_start();
}

set_time_limit(0);
ob_start();

/*****************************************************************************************************/
// olderwords (belongs in cron_static_hourly, or when new news is made ... )
homeHeading("Older Words");                                                                                  ;
$res = $db->query("select * from news order by 'when' desc limit 5");
while (($dat = $db->fetchObject($res))) {
    news($dat);
}
sb('olderwords');
$_p->point('news');

/*****************************************************************************************************/
// latest word
if (0) {
	homeHeading("Latest Word");
	$dat = $db->quickQuery("select * from news order by 'when' desc limit 1");
	news($dat);
	sb('latestword');
	$_p->point('latestword');
}

/*****************************************************************************************************/
// latest word dev
$dat = $db->quickQuery("select * from news order by 'when' desc limit 1");
//echo '<table><tr><td style="vertical-align:top; width: 50%;">';

homeHeading("Latest Word");
news($dat);

homeHeading("Popular Forum Topics");
//echo '<td style="vertical-align:top; width: 50%;">';
$db2 = new Database($forum=True);
$res = $db2->query("
select 
	phpbb_posts.topic_id,
	topic_title,
	count(*) as c,
	unix_timestamp() - max(phpbb_posts.post_time) as lpt,
	((phpbb_topics.topic_views / 20) + count(*)) / (unix_timestamp() - max(phpbb_posts.post_time) + 3600) as score,
	topic_vote,
	topic_views

from acssrforum.phpbb_posts

inner join acssrforum.phpbb_topics on acssrforum.phpbb_topics.topic_id = acssrforum.phpbb_posts.topic_id

group by acssrforum.phpbb_topics.topic_id
order by score desc
limit 5

");
//echo mysql_error();
//htmlArticleStart();
echo '<table class="acssr">';
$rows = 0;
while ($dat = $db->fetchObject($res)) {
	echo '<tr>';
	$rows++;
	if ($rows % 2)
		$r = '<td class="alt">';
	else
		$r = '<td>';
	echo $r;
	echo '&nbsp;<a href="/forum/viewtopic.php?t=' . $dat->topic_id . '">';
	$th = 60;
	$f = 0;
	$len = strlen($dat->topic_title);
	if ($dat->topic_vote) {
		$dat->topic_title = "<b><small>(POLL)</small></b> ".$dat->topic_title;
		$len += 4;
		$f = 25;
	}
	if ($len > $th)
		$dat->topic_title = substr($dat->topic_title, 0, $th-2+$f) . "..." ;
	echo $dat->topic_title;
	echo '</a>';
	echo $r . $dat->c . ' posts'.$r.$dat->topic_views.' views';
}
echo '</table>';
//htmlArticleStop();

//echo '</table>';
sb('latestword');
$_p->point('latestword');



/*****************************************************************************************************/
// top 10
homeHeading("Top 10 Players");
$res = $db->query("$sqlserverjoin where player.deleted = 0 ORDER BY score DESC LIMIT 10");
dumpTable($res, array("servercut"=>true, "reorderrank"=>true, "small"=>true, "morelink"=>'<a href="'.htmlspecialchars('ladder.
php?order=score&online=0&page=0').'">more</a>'));
sb('top10');
$_p->point('top10');

/*****************************************************************************************************/
// top 10 (with add.png)
homeHeading("Top 10 Players");
$res = $db->query("$sqlserverjoin where player.deleted = 0 ORDER BY score DESC LIMIT 10");
dumpTable($res, array('user'=>true, "servercut"=>true, "reorderrank"=>true, "small"=>true, "morelink"=>'<a href="'.htmlspecialchars('ladder.
php?order=score&online=0&page=0').'">more</a>'));
sb('top10user');
$_p->point('top10user');

/*****************************************************************************************************/
// top 10 online
#homeHeading("Top 10 Players who are Online");
$t10o = "

      SELECT

            player.id,
            player.ename,
            player.rank,
            player.ppm,
            player.score,
            player.multiplier,
            player.totalfrags,
            floor(player.totaltime / 60) as minutes,
            floor(player.totaltime) as seconds,
            player.curserverfrags,
            player.curserverid,
            player.curservertime,
            player.totaltime,
            player.lastserverwhen,
            player.clanid


      ,server.name as servername
      ,server.id as serverid

      FROM player, server

    WHERE player.curserverid != 0
    AND player.curserverid = server.id
    AND player.deleted = 0
    ORDER BY score DESC LIMIT 10

";
#$res = $db->query($t10o);
#dumpTable($res, array("servercut"=>true, "small"=>true, "morelink"=>'<a href="'.htmlspecialchars('ladder.php?order=score&online=-2&page=0').'">more</a>'));
sb('top10online');
$_p->point('top10on');

/*****************************************************************************************************/
// top 10 online (add.png)
#homeHeading("Top 10 Players who are Online");
#$res = $db->query($t10o);
#dumpTable($res, array('user'=>true, "servercut"=>true, "small"=>true, "morelink"=>'<a href="'.htmlspecialchars('ladder.php?order=score&online=-2&page=0').'">more</a>'));
sb('top10onlineuser');
$_p->point('top10on2');

/*****************************************************************************************************/
// Quick stats
$datStats = $db->quickquery("select * from stats");
$_p->point('q1');

$datMostPlayed = $db->quickquery("select ename, id, totaltime from player order by totaltime desc limit 1");
$_p->point('q2');
$datServerOnline = $db->quickquery("select count(id) as c from player where curserverid is not null");
$_p->point('q3');
#$datServerTotal = $db->quickquery("select count(playerid) as c from playernames");
$datServerTotal = $db->quickquery("select playersseen as c from stats");
$_p->point('q4');
#$datYesterdaysBest = $db->quickquery("$sqlsel_gen_daily WHERE day = " . getday(-1) . " and deleted = 0 ORDER BY score DESC LIMIT 1");
#$_p->point('q5');

$datOnline = $db->quickquery("select count(id) as c from session where " . (time() - 60 * 30) . " < time");
$_p->point('q6');
$datABBOnline = $db->quickquery("select count(id) as c from session where abb = 1 and " . (time() - 60 * 30) . " < time");
$_p->point('q7');
$datMembers = $db->quickquery('select count(id) as c from user where activated = 1 and lasttime > ' . (time() - 60*60*24*14));
$_p->point('q8');
$datVotes = $db->quickquery('select count(id) as c from playervote');
$_p->point('q9');
$datFriends = $db->quickquery('select count(userid) as c from friends');
$_p->point('q10');
$datPopularMap = $db->quickquery('
select map.name, sum(totaltime) as tt
from playerserverhistory psh, map
where map.id = psh.mapid
and map.official = 1
and psh.starttime > unix_timestamp() - 24*60*60
group by mapid
order by tt desc
limit 1
');
$datPpmMap = $db->quickquery('
select map.name, sum(points) / sum(totaltime) * 60 as tt
from playerserverhistory psh
inner join map on map.id = psh.mapid where map.official = 1
group by mapid
order by tt desc
limit 1
');

$datPpmMapLowest = $db->quickquery('
select map.name, sum(points) / sum(totaltime) * 60 as tt
from playerserverhistory psh
inner join map on map.id = psh.mapid where map.official = 1
group by mapid
order by tt
limit 1
');
$datSkilledServer = $db->quickquery('
select server.id, server.name, avg(ppm) as tt
from player, server, map
where
player.curserverid != 0 and player.curserverid is not null
and map.id = server.mapid
and map.official = 1
and server.id = player.curserverid
and server.collect = 1
and server.curplayers > 7
group by server.id
order by tt desc
limit 1
');


$_p->point('quick');

homeHeading("Quick Stats");

$datServerTotal->c = number_format($datServerTotal->c);
$datServerOnline->c = number_format($datServerOnline->c);
$datStats->hits = number_format($datStats->hits);
$datStats->searches = number_format($datStats->searches);
$datFriends->c = number_format($datFriends->c);
$datVotes->c = number_format($datVotes->c);
$datPpmMap->tt = number_format($datPpmMap->tt, 2);
$datPpmMapLowest->tt = number_format($datPpmMapLowest->tt, 2);
$datSkilledServer->tt = number_format($datSkilledServer->tt, 2);

echo "<div class=\"articlebody\">";
echo "ACSSR has seen a total of <b>{$datServerTotal->c}</b> players, <b>{$datServerOnline->c}</b> of which are in an Australian server right now. ";
echo "There are currently <b>{$datOnline->c}</b> people browsing ACSSR and <b>{$datABBOnline->c}</b> people running <a href=\"http://abb.slowchop.com/\">Banana Bunch</a>. So far, there has been a total of <b>{$datStats->hits}</b>
 hits and <b>{$datStats->searches}</b> searches made since ACSSR opened <b>" . humanTime(time() - 1103634000, true). " ago</b>. ";

echo "There are <b>{$datMembers->c}</b> members that have logged in recently and there has been a total of <b>{$datFriends->c}
</b> friends made and <b>{$datVotes->c}</b> votes cast by members. ";
echo "The player with the longest accumulated playing time in the last 14 days is <a href=\"playerdetails.php?id={$datMostPlayed->id}\">{$datMostPlayed->ename}</a> who has played for <b>".humanTime($datMostPlayed->totaltime, true)."</b> which is <b>".floor($datMostPlayed->totaltime / 1209600 * 100)."%</b> of the time. ";
#echo "Yesterdays best player was <a href=\"playerdetails.php?id={$datYesterdaysBest->id}\">{$datYesterdaysBest->ename}</a> who had <b>{$datYesterdaysBest->frags} points</b> in <b>".humanTime($datYesterdaysBest->time, true)."</b>.";
// echo " Here is a daily <a href=\"friendmap/friendmap.png\">social network graph</a> of all ACSSR friends and voters (400KB).";

echo "The most popular map is <a href=\"servers.php?search=$datPopularMap->name\">{$datPopularMap->name}</a> with <b>".humanTime($datPopularMap->tt, 1)."</b> of accumulated player time in the last 24 hours. ";
echo "The map with the highest points per minute is <a href=\"servers.php?search={$datPpmMap->name}\">{$datPpmMap->name}</a> with an average of <b>{$datPpmMap->tt} P/M</b>. The lowest is <a href=\"search.php?search={$datPpmMapLowest->name}\">{$datPpmMapLowest->name}</a> with <b>{$datPpmMapLowest->tt} P/M</b>. ";
echo "Currently the server with the best players is <a href=\"ladder.php?online={$datSkilledServer->id}\">{$datSkilledServer->name}</a> with an average of <b>{$datSkilledServer->tt} P/M</b>. ";

echo "</div>";
sb('qs');
$_p->done();

?>
