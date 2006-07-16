<?

require_once("include.php");
require_once("login.php");

/*
[userprofile]
userid
bg
c1
c2
c3
c4
c5
*/

$dat = $db->quickquery("SELECT * from userprofile where userid = {$user->id}");

if (isset($_POST) && isset($_POST['c1'])) {

		if (isset($dat->userid))
			$g = new generateSQL('userprofile', 'update', $dat->userid, 'userid');
		else
			$g = new generateSQL('userprofile', 'insert');
		$g->field('userid', $user->id);
		$f = $_FILES['bg'];
		if (is_uploaded_file($f['tmp_name']) && $f['size'] > 0) {
			$g->field('bg', addSlashes(file_get_contents($f['tmp_name'])));
			unlink($f['tmp_name']);
		}
		for ($i = 1; $i <= 5; $i++) {
			$g->field('c'.$i,$_POST['c'.$i]);
		}
		$db->query($g->sql());
		$_GET['userid'] = $user->id;
		include("playerprofile.php");
}

$dat = $db->quickquery("SELECT * from userprofile where userid = {$user->id}");

htmlStart();
homeHeading("Member Profile Editor");
echo "<div class=\"articlebody\">";
?>

<b>Overview</b>
<p>As a member of ACSSR you are able to display some of your statstics on a banner. You can use this profile banner on your web site, signature, etc. You're able to customise the background image and text colours. Please note that I may change the formatting of the banner at any time.</p>

<?

if (!$user->playerid) {
		echo '<p style="font-weight: 900;">You must find your <a href="memberfind.php">player name</a> before you can use this feature!</p>';
} else {
?>
<b>Preview</b><br>
<? if (isset($dat->userid)) { ?>
<p>Here is your current profile image.</p>
<p><a href="http://acssr.slowchop.com/playerdetails.php?id=<?=$user->playerid?>"><img src="http://acssr.slowchop.com/pp/<?=$dat->userid?>.png"></a></p>
<b>Code to use</b><br>
<p>The HTML code to do this is:</p>
<div class="code">
<?=htmlentities('<a href="http://acssr.slowchop.com/playerdetails.php?id='.$user->playerid.'"><img src="http://acssr.slowchop.com/pp/'.$dat->userid.'.png"></a>');?>
</div>
<p>The BBCode to do this is:</p>
<div class="code">
[url=http://acssr.slowchop.com/playerdetails.php?id=<?=$user->playerid?>][img]http://acssr.slowchop.com/pp/<?=$dat->userid?>.png[/img][/url]
</div>
<? }else{ ?>
<p>You currently haven't configured your profile. Below is your default profile. Once you have filled in some colour values and maybe a background image you'll be able to start using your profile image.</p>
<p><img src="playerprofile.php?id=<?=$user->playerid?>"></p>
<? } ?>
<br><b>Configure Background Image</b><br>
<?
echo "<form enctype=\"multipart/form-data\" method=\"post\" action=\"memberprofileeditor.php\">";
echo "<p>Upload your background image here. The image dimensions should be 468x35, if not it'll be cropped automatically. PNG, GIF and JPG file formats are supported. No porn images allowed.</p>";
echo "<input name=\"bg\" size=\"40\" type=\"file\"><br>";

$cd = Array(
"The normal colour of your information text:",
"The highlight colour of your information text:",
"The colour of your name:",
"The colour of your current rank:",
"The colour of the 'ACSSR Player Profile' text:"
);

echo '<br><b>Configure Colours</b><br><p>The fields below are colour values for the text in your profile. They are required to be 6 characters in hex, just like HTML colours. For example FF0000 is red and FFFFFF is white. Don\'t include the #. For more information on these colours, take a look over <a href="http://www.w3schools.com/html/html_colors.asp">here</a>. If you don\'t enter any text or you are using the wrong format in these fields your colours will probably be black!</p>';

for ($i = 1; $i <= 5; $i++) {
	$cv = "c$i";
	if (isset($dat) && isset($dat->$cv))
		$c = $dat->$cv;
	else
		$c = "FFFFFF";
	echo '<p>'.$cd[$i-1].'</p>';
	echo "<input size=\"8\" type=\"text\" name=\"c{$i}\" value=\"{$c}\"><br>";
}
echo "<br><b>Submit</b><br>Once you have changed these settings hit update and your new profile image will be updated immediately.<br><br><input type=\"submit\" value=\"update\">";
echo "</form>";

} // if user has a playerid

echo "</div>";
htmlStop();

?>
