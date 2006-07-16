<?

$C_DATABASE_DIEONERROR = true;

$menus = array(

	array("link"=>".", "name"=>"Home"),
	array("link"=>"search.php", "name"=>"Search"),
//	array("link"=>"news.php", "name"=>"News"),
//	array("link"=>"about.php", "name"=>"About"),
	array("link"=>"ladder.php", "name"=>"Ranks"),
	array("link"=>"clans.php", "name"=>"Clans"),
	array("link"=>"servers.php", "name"=>"Servers"),
	array("link"=>"faq.php", "name"=>"FAQ"),
	array("link"=>"forum/", "name"=>"Forum"),
	array("link"=>"misc.php", "name"=>"Miscellaneous")
	
	
);

$bannerFonts[0] = array("Lucida Sans","lsansuni.ttf");

define("RANK_NAME", 0);
define("RANK_FIELD", 1);
define("RANK_TDWIDTH", 2);
define("RANK_SHOW", 3);

$rank_fields = array(

	array("#", "rank", 			5,	1,	10, 	"#"),
	array("Player", "ename", 		30, 	1,	10, 	"Player"),
	array("Score", "score",			10,	1,	10, 	"Score"),
//	array("Multiplier", "multiplier", 	70,	1,	10,	"Multiplier"),
	array("P/M", "ppm", 			5, 	1,	10,	"P/M" ),
	array("P", "totalfrags", 		5,	1,	10,	"Points"),
	array("M", "minutes", 			5,	0,	10,	""),
	array("T",	 "seconds", 		5,	1,	10,	"Time"),
	array("Server/Seen",	 "server",		30,	1,	9,	"Current Server/Last Seen")

);

$server_fields = array(

	array("Name", "name")
	,array("IP Address", "address")

);

$playerdetails_fields = array(

	array("Score", "score")
	,array("Rank", "rank")
	,array("Points/Minute", "ppm")
	,array("Multiplier", "multiplier")
	,array("Total Frags", "totalfrags")
	,array("Total Time", "totaltime")

);

$legend_colours = array(

	"#F00020"
	,"#20F010"
	,"#000000"
	,"#1010F0"
	,"#F0F010"
	,"#FFFFFF"
	,"#C010F0"
	,"#FF8400"
	,"#A0A0A0"
	,"#794700"
	
	
);

//define("FORMULA_OFFSETT", 21600);
//define("FORMULA_OFFSETB", 21600);
define("FORMULA_OFFSETT", 3600);
define("FORMULA_OFFSETB", 3600);
define("FORMULA_SCOREMULTIPLIER", 100000);

$sqlgenselect = "

	SELECT
	
		player.id,
		#		player.name,
		player.ename,
		player.rank,
		format(player.ppm, 2) as ppm,
		player.score,
		format(player.multiplier, 2) as multiplier,
		player.totalfrags,
		floor(player.totaltime / 60) as minutes,
		floor(player.totaltime) as seconds,
		player.curserverfrags,
		player.curserverid,
		player.curservertime,
		player.totaltime,
		player.lastserverwhen,
		player.clanid

";

$sqlsel = "

	$sqlgenselect

	FROM player
	
";

$sqlsel_gen = "

	SELECT
	
		id,
		#		name,
		ename,
		rank,
		totalfrags / totaltime * 60 as ppma,
		format(totalfrags / totaltime * 60, 2) as ppm,
		floor((totalfrags / totaltime) * (1 - ".FORMULA_OFFSETT." / (totaltime + ".FORMULA_OFFSETB." )) * ".FORMULA_SCOREMULTIPLIER.") as score,
		format((1 - ".FORMULA_OFFSETT." / (totaltime + ".FORMULA_OFFSETB.")),2) as multiplier,
		totalfrags,
		floor(totaltime / 60) as minutes,
		floor(totaltime) as seconds,
		curserverfrags,
		curserverid,
		curservertime,
		totaltime,
		lastserverwhen,
		lastserverid

";

$sqlserverjoin = "

	$sqlgenselect
	,server.name as servername
	,server.id as serverid

	FROM player

	LEFT JOIN server ON server.id = player.curserverid

";

$sqlsel_gen_daily = "

	SELECT

		playerid as id,
		#		player.name,
		player.ename,
		player.rank,
		format(frags / time * 60, 2) as ppm,
		floor((frags / time) * (1 - ".FORMULA_OFFSETT." / (time + ".FORMULA_OFFSETB." )) * ".FORMULA_SCOREMULTIPLIER.") as score,
	#	(1 - ".FORMULA_OFFSETT." / (time + ".FORMULA_OFFSETB.")) as multiplier,
		frags as totalfrags,
		floor(time / 60) as minutes,
		floor(time) as seconds,
		curserverfrags,
		curserverid,
		curservertime,
		time,
		frags,
		lastserverwhen,
		clanid
		
	
	,server.name as servername
	,server.id as serverid

	FROM playerdaily

	LEFT JOIN player ON player.id = playerdaily.playerid
	LEFT JOIN server ON server.id = player.curserverid

";


?>
