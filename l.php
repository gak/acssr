<?

$nohtml = 1;
include ("include.php");

checkBanner();
$db->query("update adcounter set click = click + 1 where day = " . today());

header("Location: http://www.estyles.com.au/index.php?area=webhosting&page=clansite&affid=4");

?>
