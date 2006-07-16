<?
require('abbLogin.php');

function version() {

	global $_SERVER;
	$clientVersionString = $_SERVER["HTTP_USER_AGENT"];

	// stable
	$latestStableVersion = 0;
	$latestStableRevision = 0;

	// beta
	$latestBetaVersion = 0.1;
	$latestBetaRevision = 1;

	$clientBits = explode('-', $clientVersion);
	$clientVersion = $clientBits[1];
	$isClientBeta = (isset($clientBits[2]));
	if ($isClientBeta)
		$clientRevision = substr($clientBits[2], 4);
	else
		$clientRevision = 0;
	$doesClientWantBeta = 1;

	if ($doesClientWantBeta) {
		if ($clientVersionNumber < $latestBetaVersion || $clientRevision < $latestBetaRevision) {
			$p = "http://abb.slowchop.com/dist/abb-$latestBetaVersion-beta$latestBetaRevision.exe\n";
			doCmd("U", $p);
		}
	} else {

	}

}
?>
