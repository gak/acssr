<?

require_once("include.php");

htmlStart();

homeHeading("Player Voting");

?>

<div class="articlebody">

<p>ACSSR Members can have one "trait" vote to any other player listed in ACSSR. You can vote for good traits or bad traits, or you can just not vote for a particular trait.</p>

<p>Here are descriptions for the traits you can vote on:<br><br>

<?
$res = $db->query("select * from playervotecategory order by alignment desc");
while ($dat = $db->fetchObject()) {
	print "<b>{$dat->name}</b><br>";
	print $dat->description;
	print "<br>";
}
?>

</p>

</div>

<?
htmlStop();
?>
