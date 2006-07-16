<?

require_once("include.php");


htmlStart();

homeHeading("FAQ Frequently Asked Questions");

$res = $db->query("select * from faq order by 'order'");
echo '<div class="articlebody">';
/*$id = 0;
while (($dat = $db->fetchObject())) {
	$id ++;
	echo '<a href="#'.$id.'">' . $dat->question . '</a><br>';
}
*/
echo 'Some common questions are answered here. If your query isn\'t answered try <a href="forum/">posting in the forum</a>.';
echo "</div>";

$res = $db->query("select * from faq order by 'order'");
$id = 0;
while (($dat = $db->fetchObject())) {

	$id ++;
	echo '<a name="'.$id.'"></a>';
	homeHeading($dat->question);
	echo '<div class="articlebody">';
	echo str_replace("\n", "<br>", $dat->answer);
	echo "</div>";

}

htmlStop();

?>
