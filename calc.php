<?

require_once("include.php");

htmlStart();

echo "<table>";

echo "<tr><th>Time<th>Multiplier";

$alt = 0;
for ($i = 0; $i < 60*60*12 + 60; $i+=60) {

	$val = humanTime($i);
	$m = 1 - FORMULA_OFFSETT / ($i + FORMULA_OFFSETB);

	$alt=!$alt;
	$tdalt=($alt)?' class="alt"':'';
	echo "<tr><td$tdalt>$val<td$tdalt>$m";
	
	// 1000 = frags / time * multi
	// 1000 / multi = frags / time
	// (1000 / multi) * time = frags
	
	echo "<td$tdalt>" . ((1000 / $m) * $i / 100000) / $i;
	
}

echo "</table>";

htmlStop();

?>