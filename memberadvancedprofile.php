<?

require_once("include.php");
require_once("login.php");
require_once('c_banner.php');

htmlStart();
?>

<SCRIPT LANGUAGE="Javascript" SRC="ColorPicker2.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript">
var cp = new ColorPicker('window');
cp.setSize(375,250);
</SCRIPT>

<?
homeHeading("Player Profile Banner Editor");
htmlArticleStart()
?>

<b>Overview</b>
<p>As a member of ACSSR you are able to display some of your statstics on a banner. You can use this profile banner on your web site, signature, etc. You can have multiple banners of different sizes, colours and information. You can still access the <a href="memberprofileeditor.php">older banner editor</a> but it will be phased out soon.</p>

<b>Conditions of Use</b>
<p>
1. ACSSR has the right to change or disable your banner without notice. However we will endeavor to notice you via e-mail with our reasons.<br>
2. You banner must contain the text 'ACSSR Player Profile' or 'ACSSR' and must be visible. The text must be readable in its entirety on your banner.<br>
3. You must link to ACSSR with the code given.<br>
4. You may not abuse this service in a way that can cause problems for ACSSR. This includes significantly increasing server load and bandwidth usage.<br>
5. You may use any background image and text as long as the audience you display your banner to are not offended by it. We will disable banners if we get complaints of its content and we consider it inappropriate.<br>
</p>

<?
htmlArticleStop();

if (!$user->playerid) {
	
	homeHeading("Oops!");
	htmlArticleStart();	
	echo '<p style="font-weight: 900;">You must find your <a href="memberfind.php">player name</a> before you can use this feature!</p>';
	htmlArticleStop();	
		
} else if (isset($_GET['delete'])) {

	$bannerid = $_GET['delete']+0;
	$q = "update bannerbase set deleted = 1 where id = $bannerid and userid = {$user->id} and deleted = 0";
	$dat = $db->query($q);
	header("Location: http://acssr.slowchop.com/memberadvancedprofile.php");
	
} else if (isset($_GET['new'])) {

	$template = $_POST['template'] + 0;
	if ($template) {

		$db->query("
			insert into bannerbase (userid, name, bgcolour, width, height)
			select {$user->id}, name, bgcolour, width, height
			from bannerbase
			where bannerbase.id = $template
		");

		echo mysql_error();
		echo "@<br>";
		$id = mysql_insert_id();

		$db->query("
			insert into bannertext (bannerid, x, y, text, align, coloura, colourb, fontsize)
			select $id, x, y, text, align, coloura, colourb, fontsize
			from bannertext
			where bannertext.bannerid = $template
			order by id
		");
		
	} else {

		if (isset($_POST)) {
			if (isset($_POST['width']))
				$w = $_POST['width'];
			else
				$w = 0;
			if (isset($_POST['height']))
				$h = $_POST['height'];
			else
				$h = 0;
		} else {
			$w = $h = 0;
		}

		if ($w+0 == 0 || $h+0 == 0) {
			$w = 468;
			$h = 64;
		}
		
		$g = new generateSQL('bannerbase', 'insert');
		$g->field('userid', $user->id);
		$g->field('name', 'My Banner');
		$g->field('bgcolour', '000000');
		$g->field('width', $w);
		$g->field('height', $h);
		$db->query($g->sql());
	
		$id = mysql_insert_id();
		
	}
		
	
	header("Location: http://acssr.slowchop.com/memberadvancedprofile.php?edit=$id");
	
} else if (isset($_GET['editpost'])) {
	
	if (isset($_POST['cancel'])) {
		header('Location: http://acssr.slowchop.com/memberadvancedprofile.php');
		die();
	}
	
	$bannerid = $_GET['editpost']+0;
	$q = "select * from bannerbase where id = $bannerid and userid = {$user->id} and deleted = 0";
	$dat = $db->quickquery($q);
	if (!$db->count())
		die("oops, theres an error");

	if ($_POST['width'] < 100) $_POST['width'] = 100;
	if ($_POST['width'] > 600) $_POST['width'] = 600;
	if ($_POST['height'] < 20) $_POST['height'] = 20;
	if ($_POST['height'] > 200) $_POST['height'] = 200;
		
	$g = new generateSQL('bannerbase', 'update', $dat->id);
	
	/*
    [name] => 
    [width] => 200
    [height] => 35
    [bgcolour] => 660000
    [text0] => my texxxxxxxxxxt
    [x0] => 5
    [y] => 5
    [fontsize0] => 12
    [coloura0] => 660099
    [colourb0] => 343434
	*/

	foreach(array('name','width','height','bgcolour') as $f)
		$g->field($f, $_POST[$f]);	

	$f = $_FILES['bg'];
	if (is_uploaded_file($f['tmp_name']) && $f['size'] > 0 && $f['size'] < 65535) {
		$g->field('bgimage', addSlashes(file_get_contents($f['tmp_name'])));
		unlink($f['tmp_name']);
	}

	if (isset($_POST['delbg']))
		$g->field('bgimage', 'null', 'number');

	$db->query($g->sql());
	
	// now for the fields, delete all fields then re-add them
	$db->query("delete from bannertext where bannerid = {$dat->id}");

	$id = -1;
	while (1) {
		$id++;
		if (!isset($_POST['text'.$id]))
			break;
		if (trim($_POST['text'.$id]) == "")
			continue;
		if (isset($_POST['delete'.$id]))
			continue;
		if ($_POST['fontsize'.$id] < 5) $_POST['fontsize'.$id] = 5;
		if ($_POST['fontsize'.$id] > 100) $_POST['fontsize'.$id] = 100;
		$g = new generateSQL('bannertext', 'insert');

		foreach(array('text','x','y','coloura','colourb', 'fontsize', 'align') as $f)
				$g->field($f, $_POST[$f.$id]);
		$g->field('bannerid', $dat->id);
		$db->query($g->sql());

	}

	$b = new Banner($dat->id);
	$b->render();
	$b->write();
	$b->done();
	
	if (isset($_POST['update']))	
		header("Location: http://acssr.slowchop.com/memberadvancedprofile.php");
	else
		header("Location: http://acssr.slowchop.com/memberadvancedprofile.php?edit={$dat->id}");
	
	die();
		
} else if (isset($_GET['edit'])) {

	$bannerid = $_GET['edit']+0;
	$dat = $db->quickquery("select * from bannerbase where id = $bannerid and userid = {$user->id} and deleted = 0");

	$b = new Banner($dat->id);
    $b->render();
    $b->write();
    $b->done();

	homeHeading("Banner Preview");
	htmlArticleStart();
	echo "<img src=\"b/{$dat->id}.png\">";
	htmlArticleStop();
	
	homeHeading("Banner Code");
	htmlArticleStart();
	echo '<b>HTML Code</b><br>The following is HTML code you can stick on your web site or HTML email.<br><br>';
	echo '<div class="code">';
	echo htmlentities('<a href="http://acssr.slowchop.com/p.php?i='.$dat->id.'"><img alt="ACSSR Player Banner" src="http://acssr.slowchop.com/b/'.$dat->id.'.png"></a>');
	echo '</div>';

?>
<br><b>BB Code</b><br>
The following code is used for message boards that support BBCode.<br><br>
<div class="code">
[url=http://acssr.slowchop.com/p.php?i=<?=$dat->id?>][img]http://acssr.slowchop.com/b/<?=$dat->id?>.png[/img][/url]
</div>
<?
	htmlArticleStop();

	homeHeading("Banner Details");
	htmlArticleStart();
?>

	<form enctype="multipart/form-data" action="memberadvancedprofile.php?editpost=<?=$dat->id?>" method="post" name="moo">

	Banner Name<br>
	<small>This is just a name to be used for yourself. It won't be displayed to anyone else.</small><Br>
	<input type="text" size="30" name="name" value="<?=$dat->name?>"><br><br>
	
	Width and Height<br>
	<small>The dimentions of the banner. The minimum size is 100 x 20. The maximum is 600 x 200.</small><br>
	<input type="text" size="3" name="width" value="<?=$dat->width?>"> x <input type="text" size="3" name="height" value="<?=$dat->height?>"><br><br>

	HTML Background colour<br>
	<small>This needs to be 6 characters in hexadecimal, just like HTML colours. For example FF0000 is red and FFFFFF is white. Don't include the #. Use the "Pick" link to display a popup with some sample colours. If you don't enter any text or you are using the wrong format in these fields your colours will probably be black!</small><br>
#<input type="text" size="6" name="bgcolour" value="<?=$dat->bgcolour?>">
<A HREF="#" onClick="cp.select(document.forms.moo.bgcolour,'pick');return false;" NAME="pick" ID="pick">Pick</A><br><br>

	Background Image<br>
<small>Upload your background image here. This will replace your current image. If the image is larger then the banner it will be cropped automatically. PNG, GIF and JPG file formats are supported. Maximum file size is 64KB.<? if (strlen($dat->bgimage)) { ?> Tick the checkbox if you want to delete your background image.<? } ?></small><br>
	<input name="bg" size="60" type="file"><br>
<? if (strlen($dat->bgimage)) { ?>
	<input type="checkbox" name="delbg" value="1"> Delete Background Image?<br>
<? } ?>

<?

	htmlArticleStop();
	homeHeading("Banner Text");
	htmlArticleStart();
?>	
The following lists all the text on your banner. You can specify the text, X and Y co-ordinates (0 x 0 being the top left), the font size (5-100), and two colours. The text will come out as you've typed it except when you use control codes. A control code is two characters that ACSSR replaces with a statistic or some other value. For example, to display your rank you can type in "My current rank is #^R!"<br><br>
Control Codes (case sensitive): <b>^1</b> Use Highlight Colour, <b>^0</b> Use Normal Colour, <b>^N</b> Your player name, <b>^R</b> Current Rank, <b>^S</b> Current Score, <b>^P</b> Points per Minute, <b>^F</b> Total Frags, <b>^T</b> Total Time Played, <b>^L</b> Last Server, <b>^A</b> Time since last played, <b>^f</b> Frags today, <b>^t</b> Time played today<br><br>

<table><tr><th>Text<th>Position<th>Font Size<th>Colour<th>Highlight Colour<th>Alignment<th>Delete
<? function textRow($id, $dat) {
	foreach (array('text','x','y','fontsize','coloura','colourb','align') as $attr) {
		if (!isset($dat->$attr)) $dat->$attr = '';
	}
?>
	<tr>
	<td><input type="text" name="text<?=$id?>" size="50" value="<?=$dat->text?>">
	<td><input type="text" size="3" name="x<?=$id?>" value="<?=$dat->x?>"> x <input type="text" size="3" name="y<?=$id?>" value="<?=$dat->y?>">
	<td><input type="text" name="fontsize<?=$id?>" size="2" value="<?=$dat->fontsize?>">
	<td><input type="text" name="coloura<?=$id?>" size="6" value="<?=$dat->coloura?>"> <A HREF="#" onClick="cp.select(document.forms.moo.coloura<?=$id?>,'pick');return false;" NAME="pick" ID="pick">Pick</A>
	<td><input type="text" name="colourb<?=$id?>" size="6" value="<?=$dat->colourb?>"> <A HREF="#" onClick="cp.select(document.forms.moo.colourb<?=$id?>,'pick');return false;" NAME="pick" ID="pick">Pick</A>
	<td><select name="align<?=$id?>"><?
	foreach (array(0=>'Left',1=>'Center',2=>'Right') as $a=>$v) {
		$s = ($dat->align == $a)?" selected":"";
		echo "<option value=\"$a\"$s>$v";
	}
?></select>
	<td><input type="checkbox" name="delete<?=$id?>" value="1">
<?}

$res = $db->query("SELECT * from bannertext where bannerid = {$dat->id} order by id");

$id = 0;
while ($dat = $db->fetchObject($res)) { 
	textRow($id, $dat);
	$id++;
} 
textRow($id, null);

	echo '</table>';
	
	htmlArticleStop();
	homeHeading("Update Banner");
	htmlArticleStart();
?>
Make sure your changes are correct. Updating your banner will have an immediate effect.<br><br>
<input type="submit" name="update" value="Update">
<input type="submit" name="update2" value="Update and Keep Editing">
<input type="submit" name="cancel" value="Back">
</form>
<?
	htmlArticleStop();
	
} else {
	
	$res = $db->query("SELECT * from bannerbase where userid = 0 and deleted = 0 order by id");

	homeHeading("Create a New Banner");
	htmlArticleStart()
?>
	<p>You can create your banner based of an existing template or start your own from scratch.</p>
	<form method="post" action="memberadvancedprofile.php?new=1">
<? while ($dat = $db->fetchObject($res)) { ?>
	<input type="radio" name="template" value="<?=$dat->id?>"> <?=$dat->name?><br>
<? } ?>
	<input type="radio" name="template" value="0"> Custom<br>
	<p style="padding: 0px 10px 0px 20px">
	Width and Height<br>
	<input type="width" size="3"> x <input type="height" size="3"><br><br>
	</p>
	<input type="submit" value="Create Banner"><br>

	</form>
	
<?	
	htmlArticleStop();
	
	// List Banners
	$res = $db->query("SELECT * from bannerbase where userid = {$user->id} and deleted = 0 order by id");
	if ($db->count()) {
		
		homeHeading("Your Existing Banners");
		htmlArticleStart();

		echo '<table><tr><th>Name<th>Preview<th>Size<th>Edit<th>Delete';
		while ($dat = $db->fetchObject($res)) {

			$b = new Banner($dat->id);
			$b->render();
			$b->write();
			$b->done();
		
			echo "<tr><td>{$dat->name}<td><img src=\"http://acssr.slowchop.com/b/{$dat->id}.png\" width=\"{$dat->width}\" height=\"{$dat->height}\"><td>{$dat->width}x{$dat->height}<td><a href=\"memberadvancedprofile.php?edit={$dat->id}\">Edit</a><td><a href=\"memberadvancedprofile.php?delete={$dat->id}\">Delete</a>";
			
		}

		echo '</table>';
		htmlArticleStop();
		
		homeHeading("Rotating Banner Code");
		htmlArticleStart();
		echo 'The following shows you how to have a rotating banner. This will randomly pick one of your banners every time someone sees your banner!<br><br>';
		echo '<b>HTML Code</b><br>The following is HTML code you can stick on your web site or HTML email.<br><br>';
		echo '<div class="code">';
		echo htmlentities('<a href="http://acssr.slowchop.com/r.php?i='.$user->id.'"><img alt="ACSSR Player Banner" src="http://acssr.slowchop.com/r/'.$user->id.'.png"></a>');
		echo '</div>';

?>
<br><b>BB Code</b><br>
The following code is used for message boards that support BBCode.<br><br>
<div class="code">
[url=http://acssr.slowchop.com/r.php?i=<?=$user->id?>][img]http://acssr.slowchop.com/r/<?=$user->id?>.png[/img][/url]
</div>
<?
	htmlArticleStop();


	}

}

echo '<SCRIPT LANGUAGE="JavaScript">cp.writeDiv()</SCRIPT>';

htmlStop();

?>
