<?
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
	$b = new banner($dat->id);
	$b->render();
	$b->write($name);
	$b->done();
		
}

?>
