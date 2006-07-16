<?

require_once("include.php");

htmlStart();

$db = new Database();

$incomingvariables = array(
	
	array("field"=>"order","default"=>"score")
	,array("field"=>"count","default"=>"50")
	,array("field"=>"page","default"=>"0")
	,array("field"=>"reverse","default"=>"0")
	,array("field"=>"online","default"=>0)

);

$sorts = array(

	"name" => array("Name", "name", 0)
	,"score" => array("Score", "score", 1)
	,"ppm" => array("Points/Minute", "ppm", 1)
	,"points" => array("Points", "totalfrags", 1)
	,"time" => array("Time", "totaltime", 1)

//	,"pointstoday" => array("// Points Today", "totalfrags", 1)
//	,"timetoday" => array("// Time Today", "totaltime", 1)

);

foreach ($incomingvariables as $i) {

	global $_GET;

	$field = $i["field"];
	$def = $i["default"];
	if (isset($_GET[$field])) {
	
		$$field = $_GET[$field];
	
	} else {
	
		$$field = $def;
	
	}
	
}

$on = "";
$desc = "";

if (!isset($sorts[$order])) {

	trigger_error("sort '$order' specified isn't allowed");

}

$ordersql = $sorts[$order][1];

$reversenice = $reverse;
if ($sorts[$order][2]) {

	$reversenice = !$reverse;

}

if ($reversenice) {

	$desc = "DESC";

}

$where = "";

if ($online > 0) {

	$dat = $db->quickquery("select * from server where id = $online");

	$where .= " AND curserverid = $online";
	if (isset($dat->name) && isset($dat->address))
		$on = " currently on {$dat->name} ({$dat->address})";

}

else if ($online == -1) {

	$where .= " AND curserverid is null";
	$on .= " who are currently not on-line";

} else if ($online == -2) {

	$where .= " AND curserverid is not null";
	$on .= " who are currently on-line";

}

$where .= " AND player.rank > 0 AND player.score > 0 AND deleted = 0";

#$sqlcounter = "select count(id) as c from player WHERE 1 = 1 $where";
#$dat = $db->quickquery($sqlcounter);
#$rows = $dat->c;

$start = $page * $count;

$sql = "$sqlserverjoin WHERE 1 = 1 $where ORDER BY player.$ordersql $desc LIMIT $start, $count";
$res = $db->query($sql);
$rows = $db->count();

if ($count > 0)
	$pages = 1000;
else
	$pages = 0;

if ($start > $rows) {
	
	$start = 0;
	$page = 0;
	
}


#if ($db->count() < $count) {
	#	$count = $db->count();
	#}

homeHeading('Rankings');

?>


<form name="ladder" method="GET" action="ladder.php">

<table class="f">

<tr>

<td  class="f">Sorting order:<br>

	<select name="order">
	<?

	foreach ($sorts as $k=>$s) {

		echo '<option';
		
		if ($k == $order)
			echo ' SELECTED';
		
		echo ' value="';

		echo $k;

		echo '">';

		echo $s[0];

	}

	?>
	</select>
	
<td  class="f">Reversed?<br>
	
	<input type="checkbox" name="reverse" value="1"<? if ($reverse) echo " CHECKED"?>>

<td  class="f">Online:<br>

	<select name="online">

	<?

	$sel = ($online == 0)?' SELECTED':"";
	echo "<option value=\"0\"$sel>N/A";
	
	$sel = ($online == -1)?' SELECTED':"";
	echo "<option value=\"-1\"$sel>Currently Not Online";

	$sel = ($online == -2)?' SELECTED':"";
	echo "<option value=\"-2\"$sel>Online On Any Server";

	$res2 = $db->query("select * from server order by name");

	while (($dat = $db->fetchObject($res2))) {

		echo '<option';
		
		if ($dat->id == $online)
			echo ' SELECTED';
		
		echo ' value="';

		echo $dat->id;

		echo '">';

		echo shortServerName($dat->name);

	}

	?>
	</select>
	
<td  class="f">Page<br>
	
	<select name="page">
	
	<?
	
	for ($i = 0; $i < $pages; $i++) {
	
		$c = ($i == $page)?" SELECTED":"";
		
		if (abs($i - $page) >= 6 && $i >= 10) {
		
			if ($i % 10 != 9)
				continue;
		
		}
			
		echo "<option value=\"$i\"$c>" . ($i + 1);
	
	}
	
	
	?>
	
	</select>
	
<tr><td class="f" colspan="4">
	
	| <a href="javascript:document.forms.ladder.submit();">Update</a> |
	
	<? if ($page > 0 ) { ?>
	<a href="javascript:document.forms.ladder.page.value=<?=$page-1?>; document.forms.ladder.submit();">Previous Page</a> |
	<? } ?>
	
	<? if ($page <= $pages - 2) { ?>
	
	<a href="javascript:document.forms.ladder.page.value=<?=$page+1?>; document.forms.ladder.submit();">Next Page</a> |
	<? } ?>
	
</table>

</form>

<?

if ($page == 0) {

	if ($pages > 1)
		$f = "First $count";
		
	else
		$f = $rows;

} else {

	$f = "Page " . ($page + 1) . " of";

}

homeHeading("$f Players sorted by {$sorts[$order][0]}$on");

dumpTable($res, array("total"=>false));

htmlStop();

?>
