<?

$nohtml = 1;
include ("include.php");

checkBanner();
$db->query("update adcounter set realshow = realshow + 1 where day = " . today());

header("Location: banners/estyles_clanhosting_468x60.gif");

?>
