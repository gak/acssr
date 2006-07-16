<?

function sOpen($path, $name) {

	sGC(0);
	
	return true;	

}

function sClose() {

	return true;	

}

function sRead($id) {

	global $db;
	$dat = $db->quickquery("select * from session where id = '$id'");

	if ($db->count() == 0) {

		return "";

	}

	return $dat->value;

}

function sWrite($id, $data) {

	global $db;
	global $_SERVER;
	global $_SESSION;
	
	$abb = (isset($_SESSION['user']) && isset($_SESSION['user']->abb));
	
// 	$data = str_replace("'", "''", $data); // this cause problems with wierd utf8 player names (i think)
	$data = addSlashes($data);
	
	$db->query("select * from session where id = '$id'");

	$page = $_SERVER["REQUEST_URI"];

	if ($page == "/style.php")
		$page = "";
	
	if ($db->count()) {
	
		if ($page != "")			
			$sqlpage = ",page = '$page'";
		else
			$sqlpage = "";

		$db->query("

			update session
			set
				time = ".time().",
				value = '$data',
				abb = '$abb'
				$sqlpage

			where id = '$id'

		");
		
	} else {

		global $_SESSION;
		$abb = (isset($_SESSION['user']) && isset($_SESSION['user']->abb));
		 
		$db->query("

			insert into session
			(id, time, start, value, abb)
			values
			('$id', ".time().", ".time().", '$data', '$abb')

		");
		
	}

	return true;

}

function sDestroy($id) {

	global $db;
	$db->query("delete from session where id = '$id'");

	return true;

}

function sGC($life) {

//	global $db;
//	$ses_life = strtotime("-7 days"); 
//	$db->query("delete from session where time < $ses_life");
	return true;

}

?>
