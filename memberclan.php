<?

require_once("include.php");
require_once("login.php");

$clan = $db->quickquery("SELECT * from clan where id = {$user->clanid}");

htmlStart();
homeHeading("Clan Administration");
htmlArticle("Hello, and welcome!");
homeHeading('Clan Details');
htmlArticleStart();
htmlArticleText('Update your clan information here.');
htmlTitle('Full Clan Name');
htmlFormTextLine('name', $clan->name);
htmlArticleStop();
homeHeading('Clan Members');

htmlStop();

die();

?>

<b>Overview</b>
<p></p>
<br><b>Configure Background Image</b><br>
<form enctype="multipart/form-data" method="post" action="memberprofileeditor.php">
<p>Upload your background image here. The image dimensions should be 468x35, if not it'll be cropped automatically. PNG, GIF and JPG file formats are supported. No porn images allowed.</p>
<input name="bg" size="40" type="file"><br>

echo "<br><b>Submit</b><br>Once you have changed these settings hit update and your new profile image will be updated immediately.<br><br><input type=\"submit\" value=\"update\">";
echo "</form>";

} // if user has a playerid

echo "</div>";
<?
htmlStop();
?>
