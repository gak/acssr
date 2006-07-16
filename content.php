<?
require_once("include.php");
require_once('admin.php');
htmlStart();
$page = $_GET['page'];
$dat = $db->quickquery("SELECT * FROM content where id = '$page'");

echo '<br>';
$edit = isset($_GET['edit']);
$update = isset($_GET['update']);

if ($update) {
$db->query("delete from content where id = '$page'");
$db->query("insert into content (id, content) values ('$page', '$content')");
echo doWiki($content);
} else if ($edit) {
?>
<form method="post" action="content.php?page=<?=$page?>&update=1">
<textarea name"content" :w
rows=50 cols=120><?=$dat->content?></textarea><br>
<input type="submit" value="make it live">
</form>
<?
} else {

	echo doWiki($dat->content);
	if ($isAdmin) {
		echo '<a href="content.php?page='.$page.'&edit=1">edit</a>';
	}

}





function doWiki($a) {
	$a = preg_replace('.== ([^=]*) ==.', '<b>$1</b><br><p/>', $a);
	$a = preg_replace('.= ([^=]*) =.', '<table><tr><td style="background-color: black; font-size: 12px; font-weight: 900; padding: 5px 5px 5px 5px;">$1</table><p/>', $a);
	$a = preg_replace('.\[([^ ]*) ([^\]]*)].', '<a href="$1">$2</a>', $a);
	return $a;
}

htmlStop();

?>
