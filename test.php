<?

include 'include.php';

$a = 0;
try {
	$a /= 0;
} catch (Exception $e) {
	print $e;
}

?>
