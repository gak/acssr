<?

#function error($message = "") {
function errorhandler($errno, $errstr, $errfile, $errline) {

	global $nohtml;

	if (error_reporting() == 0) return;	
	if ($errno == 2048) return;

	$message = "$errfile:$errline $errstr ($errno)";
	
	if (ob_get_length()) {
		$html = ob_get_clean();

	} else {
	
		$html = "";
	
	}

	if (!isset($nohtml)) {
	
		$nohtml = 0;
		
	}
	
	if (1 || !$nohtml) {
	
		htmlStart();
		homeHeading('OOPS!');
		htmlArticleStart();
		
	?>
		There has been an error on this web site. It might be a little glitch... Refreshing may or may not help!<br><br>
		Every error that happens on ACSSR is recorded so I can tell what went wrong, when and where.<br><br>
		If this error keeps happening please try the page at a later time...

	<?
		htmlArticleStop();
		htmlStop(0);
		
	} else {
	
		echo $html;
	
	}

	$bt = debug_backtrace();

	$outt = "";
	$outh = "<style>
	body, td {
		font-size: 10px;
	}
	</style>
	";

	$outt .= "\nERROR ERROR ERROR\n";

	$outh .= "\n<table class=\"error\">";
	$outh .= "\n<tr><td>";
		
	$outt .= $message;
	$outh .= $message;

	$i = 0;

	foreach($bt as $t) {
	
		$i++;
		#		if ($i <= 2)
		#	continue;

		$outt .= "\n";
		$outh .= "\n<tr><td>";

		if (isset($t["file"]) && isset($t["line"])) {
			$outt .= $t["file"] . ":" . $t["line"];
			$outh .= $t["file"] . ":" . $t["line"];
		}
		
		$outt .= "\t";
		$outh .= "<td>";
			
		$outt .= $t["function"];
		$outh .= $t["function"];
		
		$outt .= "\t";
		$outh .= "<td>";

		foreach ($t['args'] as $var) {
			$outh .= $var.'<br>';
		}
		
	}

	$outt .= "\n\n";
	$outh .= "\n</table>";

	if ($nohtml)
		$outh .= "<pre>";
	
		#	$outh .= $html;

	if ($nohtml)
		$outh .= "</pre>";

	if ($nohtml) {
		#		echo $outt;
	}

	$headers  = "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/html; charset=utf-8\n";
	$headers .= "From: ACSSR Error <gak@slowchop.com>\n";

	mail("gak@slowchop.com", $message, $outh, $headers);

	#	echo $outh;
	
	die();	

}

function _errorhandler($errno, $errstr, $errfile, $errline) {
	global $_GET;
	if ($errno == 2048) return;
	error("$errfile:$errline $errstr ($errno)");
}

?>
