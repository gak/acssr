<?

function acssrerror($message = "") {

	if (error_reporting() == 0)
		return;
		
	global $nohtml;

	if (ob_get_length()) {

		$html = ob_get_contents();
		ob_end_clean();
		ob_start();
		
	} else {
	
		$html = "";
	
	}
	
	if (!isset($nohtml)) {
	
		$nohtml = 0;
		
	}
	
	if (!$nohtml) {
	
		htmlStart();
	?>
		<h2>OOOPS!</h2>

		<p>

		There has been an error on this web site. It might be a little glitch... Refreshing may or may not help!<br><br>

		Every error that happens on ACSSR is recorded so I can tell what went wrong, when and where.<br><br>

		If this error keeps happening please try the page at a later time...

		</p>

	<?
		htmlStop();
		
	} else {
	
		echo $html;
	
	}

	$bt = debug_backtrace();

	$outt = "";
	$outh = "";

	$outt .= "\nERROR ERROR ERROR\n";

	$td1 = "<td style=\"padding: 1px 1px 1px 1px; background-color: #9DD; font-family: tahoma; font-size: 12px;\">";
	
	$outh .= "\n<table style=\"border: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 0px;\">";
	$outh .= "\n<tr>".$td1;
		
	$outt .= $message;
	$outh .= $message;

	$i = 0;

	foreach($bt as $t) {
	
		$i++;
		if ($i <= 2)
			continue;

		$outt .= "\n";
		$outh .= "\n<tr>".$td1;

		if (isset($t["file"]) && isset($t["line"])) {
			$outt .= $t["file"] . ":" . $t["line"];
			$outh .= $t["file"] . ":" . $t["line"];
		}
		
		$outt .= "\t";
		$outh .= $td1;
			
		$outt .= $t["function"];
		$outh .= $t["function"];
		
	}

	$outt .= "\n\n";
	$outh .= "\n</table>";

	if ($nohtml)
		$outh .= "<pre>";
	
	$outh .= $html;

	if ($nohtml)
		$outh .= "</pre>";

	if ($nohtml) {

		echo $outt;
		
	}

	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=utf-8\r\n";
	$headers .= "From: ACSSR Error <gak@slowchop.com>\r\n";

	mail("gak@slowchop.com", $message, $outh, $headers);

	global $_SERVER;
	global $_GET;
	if (!$nohtml && ($_SERVER["HTTP_HOST"] == "gak.kicks-ass.org" || isset($_GET["debug"])))
		echo $outh;
	
	die();	

}

function acssrerrorhandler($errno, $errstr, $errfile, $errline) {
	global $_GET;
//	if (!isset($_GET['e']))
//		return;
	acssrerror("$errfile:$errline $errstr ($errno)");
//	switch ($errno) {
//		case 2048:
//			return;
//	}
//	echo "<!-- $errfile:$errline $errstr ($errno)\n<br>";
//	debug_print_backtrace();
//	echo "<br> -->";
//	//die();

}

?>
