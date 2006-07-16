<?

	global $_SERVER;

	error_reporting(E_ALL);
	//error_reporting(E_ALL - E_NOTICE - E_USER_NOTICE);

	if (!isset($noob))
		ob_start("ob_gzhandler");
		//ob_start();

	require("inc_error.php");
	set_error_handler("errorhandler");
//	require('inc_newerror.php');
//	set_error_handler("acssrerrorhandler");

	require("inc_func.php");
	require("inc_html.php");
	require("inc_session.php");
	require("conf_qstat.php");
	require("conf_db.php");
	require("conf_vars.php");
	require("c_database.php");
	require("c_generatesql.php");
	require("c_player.php");
	require("c_server.php");
	require("c_serverquery.php");
	require("c_user.php");
	require("c_profiler.php");
	require("c_captcha.php");

	include ("jpgraph/src/jpgraph.php");
	include ("jpgraph/src/jpgraph_line.php");
	include ("jpgraph/src/jpgraph_bar.php");

	function diemessage($m) {
		
		htmlStart();
		echo "<h1>ACSSR is busy!</h1><p>$m</p>";
		htmlStop(0);
		die();

	}

	#	if (!isset($_GET['meh'])) diemessage("Unfortunately there are problems with the database upgrade, but I need to sleep so I'll finish fixing it on Friday.");
	
	if (file_exists("backup.lock") || 0) {
		diemessage('ACSSR daily backup is currently running. This usually takes about 5 minutes.');
	}
	
	if (file_exists("dailycull.lock") && 0) {
		diemessage('ACSSR player maintenance is currently running. This usually doesn\'t take too long. Please come back soon!');
	}
	
	$db = new Database();

	if (!isset($noob)) {

		// turns off transparent sid linking
		// ini_set('url_rewriter.tags', '');
		/*
		// doesnt work in php4 GR
		ini_set('session.use_only_cookies', true);	
		ini_set('session.use_trans_sid', false);
		*/

		ini_set('session.gc_maxlifetime', 60*60*24*14);
		session_name("ACSSR");
		session_set_cookie_params (60*60*24*14);
		session_set_save_handler('sOpen', 'sClose', 'sRead', 'sWrite', 'sDestroy', 'sGC');
		session_start();
	
	}

?>
