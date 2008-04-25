<?

$noob = 1;
require('include.php');
require('c_banner.php');

$res = $db->query('select * from bannerbase order by id');

while ($dat = $db->fetchObject($res)) {

	$name = "b/{$dat->id}.png";
/*	
	if ($dat->deleted) {

		if (!file_exists($name))
			continue;
			
		unlink ($name);
		$name = "b/{$dat->id}-deleted.png";

	}
*/
	echo $name . "\n";
	echo "n\n";
	$b = new banner($dat->id);
	echo "r\n";
	$b->render();
	echo "w\n";
	$b->write($name);
	echo "d\n";
	$b->done();

}

?>
