<?

$period14d = time() - 60*60*24*14;
$period1d = time() - 60*60*24;
$period1h = time() - 60*60;

$hourstats = Array(

	// ACSSR Web Site
	Array(0, "ACSSR Hits", "select hits from stats", "Number of page views on ACSSR")
	,Array(1, "ACSSR Searches", "select searches from stats", "Number of player searches made on ACSSR")
	
	// Profile Banners
	,Array(2, "Banners", "select count(userid) from userprofile", "Number of player profile banners")
	
	// Voting
	,Array(3, "Average votes per member", "!getVotesPerMember", "")
	,Array(4, "Votes", "select count(id) as c from playervote", "Total votes made")
	,Array(5, "Votes Good", "select count(playervote.id) from playervote inner join playervotecategory on playervotecategory.id = playervote.playervotecategoryid where playervotecategory.alignment = 1", "Total good votes made by members")
	,Array(6, "Votes Bad", "select count(playervote.id) from playervote inner join playervotecategory on playervotecategory.id = playervote.playervotecategoryid where playervotecategory.alignment = -1", "Total bad votes made by members")

	// Friends
	,Array(7, "Average friends per member", "!getFriendsPerMember", "")
	,Array(8, "Friends", "select count(userid) from friends", "Total number of friends made")
	
	// Forum
	,Array(9, "Forum Topics", "select count(*) from acssrforum.phpbb_topics", "")
	,Array(10, "Forum Posts", "select count(*) from acssrforum.phpbb_posts", "")
	,Array(11, "Forum Members", "select count(*) from acssrforum.phpbb_users", "")

	// Servers
	,Array(12, "Servers Total", "select count(*) from server", "Number of servers ACSSR tries to poll")
	,Array(13, "Servers", "select count(*) from server where down = 0", "Number of active servers")
	,Array(14, "Servers Official", "select count(*) from server where collect = 1 and down = 0", "Number of active official servers")
	,Array(15, "Servers Capacity", "select sum(maxplayers) from server where down = 0", "Total amount of player slots on all active servers")
	,Array(16, "Servers Capacity (%)", "select sum(curplayers)/sum(maxplayers) from server where down = 0", "Percentage of player slots used on all active servers")
	,Array(17, "Servers Full", "select count(*) from server where curplayers = maxplayers and down = 0", "")
	,Array(18, "Servers With Players", "select count(*) from server where curplayers > 0 and down = 0", "")
	,Array(19, "Servers Empty", "select count(*) from server where curplayers = 0 and down = 0", "")
	,Array(20, "Servers with Official Maps", "select count(*) from server inner join map on server.mapid = map.id where official = 1 and server.down = 0", "")
	
	// Maps
	,Array(21, "Total Maps Seen", "select count(*) as a from map", "Number of unique map names ever seen")
	
	// Players Online
	,Array(22, "Players Online (14 days)", "select count(id) as c from player where lastserverwhen > $period14d", "Number of unique names seen over 14 days")
	,Array(23, "Players Online (24 hours)", "select count(id) as c from player where lastserverwhen > $period1d", "Number of unique names seen over 24 hours")
	,Array(24, "Players Online (1 hour)", "select count(id) as c from player where lastserverwhen > $period1h", "Number of unique names seen in 1 hour")
	,Array(25, "Players Online (Current)", "select count(id) from player where curserverid is not null", "")
	,Array(26, "Players Total", "select playersseen from stats", "Total number of unqiue names ever seen")

	// Members Online
	,Array(27, "Members Online (14 days)", "select count(id) as c from user where activated = 1 and lasttime > $period14d", "")
	,Array(28, "Members Online (24 hours)", "select count(id) as c from user where activated = 1 and lasttime > $period1d", "")
	,Array(29, "Members Online (1 hour)", "select count(id) as c from user where activated = 1 and lasttime > $period1h", "")

	// Users Online
	,Array(30, "Users Online (14 days)", "select count(id) as c from session where time > $period14d", "")
	,Array(31, "Users Online (24 hours)", "select count(id) as c from session where time > $period1d", "")
	,Array(32, "Users Online (1 hour)", "select count(id) as c from session where time > $period1h", "")

	// Player Times
	,Array(33, "Longest Total Time Online (14 days)", "select totaltime/3600 from player order by totaltime desc limit 1", "The player with the longest time connected to a server in the last 14 days")
	,Array(34, "Average Total Time Online (14 days)", "select avg(totaltime)/3600 from player where score > 0 and totaltime > 0", "The average time connected to a server over the last 14 days")
	,Array(35, "Longest Continuous Time Online", "select curservertime/3600 from player where curserverid is not null order by curservertime desc limit 1", "The player with the longest time connected to a server right now")
	,Array(36, "Average Continuous Time Online", "select avg(curservertime)/3600 from player where score > 0 and curserverid is not null", "The average time connected to a server right now")
	,Array(37, "Total Player Current Online Time (in days)", "select sum(curservertime) /3600/24 from player where curserverid is not null", "The total online time for everyone playing right now")

	// Player Scores
	,Array(38, "Best Score (14 days)", "select score from player where deleted = 0 order by score desc limit 1", "The highest score in the past 14 days")
	,Array(39, "Best Score (Online)", "select score from player where curserverid is not null order by score desc limit 1", "The highest score right now")
	,Array(40, "Average Score (14 days)", "select avg(score) from player where score > 0", "Everyone's average score over the past 14 days")
	,Array(41, "Average Score (Online)", "select avg(score) from player where score > 0 and curserverid is not null", "Everyone's average score over the past 14 days")
	
	// Player Points
	,Array(42, "Total Points Online", "select sum(curserverfrags) from player where curserverid is not null", "The sum of everyone's points/frags right now")

	// Player PPM
	,Array(43, "Average PPM (14 days)", "select avg(ppm) from player where score > 0", "")
	,Array(44, "Average PPM online", "select avg(ppm) from player where score > 0 and curserverid is not null", "")
	
	// Misc
	,Array(45, "Cheaters Removed", "select count(id) from player where deleted = 1", "")
	
	
	,Array(46, "Members", "select count(id) from user where activated = 1", "")
	,Array(47, "News Posts", "select count(id) from news", "")
	,Array(48, "IRC Bot queries", "select count(id) from ircbot", "")
	,Array(49, "Server Query Bytes In", "select bytes_in from bytes order by hour desc limit 1, 1", "")
	,Array(50, "Server Query Bytes Out", "select bytes_out from bytes order by hour desc limit 1, 1", "")
	,Array(51, "Banana Bunch Users Online", "select count(id) from session where abb = 1 and time > $period1h", "")
	,Array(52, "Banana Bunch Average Connection Time", "select AVG(time-start)/3600 from session where abb = 1 and time > $period1h", "")
	,Array(53, "Banana Bunch Current Longest Connection Time", "select MAX(time-start)/3600 from session where abb = 1 and time > $period1h", "")
	,Array(54, "MySQL slow queries", "show status like 'slow_queries'", "")
	,Array(55, "MySQL com_select", "show status like 'com_select'", "")
	,Array(56, "MySQL com_insert", "show status like 'com_insert'", "")
	,Array(57, "MySQL com_update", "show status like 'com_update'", "")
	,Array(58, "MySQL com_delete", "show status like 'com_delete'", "")
	,Array(59, "MySQL bytes_received", "show status like 'bytes_received'", "")
	,Array(60, "MySQL bytes_sent", "show status like 'bytes_sent'", "")
	,Array(61, "MySQL connetions", "show status like 'connections'", "")
	,Array(62, "MySQL questions", "show status like 'questions'", "")
	
);

?>
