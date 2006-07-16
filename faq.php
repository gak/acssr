<?

require_once("include.php");


htmlStart();

homeHeading("FAQ Frequently Asked Questions");

$res = $db->query("select * from faq order by 'order'");

while (($dat = $db->fetchObject())) {

	echo '<div class="articlebody">';
	echo '<p>';
	echo "<b>{$dat->question}</b><br>";
	echo str_replace("\n", "<br>", $dat->answer);
	echo "</p>";
	echo "</div>";

}

htmlStop();

?>