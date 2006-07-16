<?
require_once('include.php');
require_once('inc_pp.php');
$FONT='font/lsansuni.ttf';

if (!isset($_GET['d']))
header('Content-type: image/png');

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	if ($id == 0) die();
	$player = new Player($id+0);
} else if (isset($_GET['userid'])) {
	$id = $_GET['userid'];
	if ($id == 0) die();
	$u = new User();
	$u->loadFromID($id);
	$player = new Player($u->playerid+0);
	$dat = $db->quickquery("select * from userprofile where userid = $id");
}
	
$im = imagecreatetruecolor(468, 35);
$black = imagecolorallocate($im, 0, 0, 0);
$COL[0] = imagecolorallocate($im, 127, 127, 127);
$COL[1] = imagecolorallocate($im, 255, 255, 255);
$COL[2] = imagecolorallocate($im, 255, 255, 255);
$COL[3] = imagecolorallocate($im, 255, 255, 255);
$COL[4] = imagecolorallocate($im, 255, 255, 255);

if (isset($_GET['userid'])) {

	for ($i = 1; $i < 6; $i++) {

		$cc = "c$i";
		$c = $dat->$cc;
		$r = hexdec(substr($c, 0, 2));
		$g = hexdec(substr($c, 2, 2));
		$b = hexdec(substr($c, 4, 2));
		$COL[$i-1] = imagecolorallocate($im, $r, $g, $b);

	}

} else {

	for ($i = 1; $i < 6; $i++) {

		if (isset($_GET['c'.$i])) {
			$c = $_GET['c'.$i];
			$r = hexdec(substr($c, 0, 2));
			$g = hexdec(substr($c, 2, 2));
			$b = hexdec(substr($c, 4, 2));
			$COL[$i-1] = imagecolorallocate($im, $r, $g, $b);
		}

	}

}
if (isset($_GET['userid'])) {

	if ($dat->bg != "") {
		$bg = @imagecreatefromstring($dat->bg);	
		if ($bg) {
			imagecopy ($im, $bg, 0, 0, 0, 0, 468, 35);
			imagedestroy($bg);
		} else {
			file_put_contents('pp/'.$id.'-invalid', $dat->bg);
		}
	}
		
} else if (isset($_GET['bg'])) {

	$bg = $_GET['bg'];
	$bgc = 'profilecache/'.md5($bg);
	$bgct = $bgc.'tmp';
	$imbg = false;

	$refresh = 0;
	if (isset($_GET['refresh']))
		$refresh = $_GET['refresh'];

	if ($refresh)
		$refresh = 1;
	
	if (!$refresh) {
		// check if img is cached
		if (file_exists($bgc)) {
			@$imbg = imagecreatefrompng($bgc);
		}
		if (!$imbg) $refresh = 2;
	}
	// load image if it isn't cached or a forced refresh is made
	if ($refresh) {
		@$imbg = imagecreatefrompng($bg);
	}
	if (!$imbg) {
		imgerr($im, "Could not load " . $bg);
	}
	if ($refresh)
		imagepng($imbg,$bgct);

	// compare cache with fetched. if they match, do an error
	if ($refresh == 1 && file_exists($bgc)) {
		$md5a = md5(file_get_contents($bgct));
		$md5b = md5(file_get_contents($bgc));
		if ($md5a == $md5b) {
			unlink($bgct);
			imgerr($im, 'Remove refresh=1 from URL if your image hasn\'t changed');
		}
	}
	if ($refresh)
		rename($bgct, $bgc);

	
	imagecopy ($im, $imbg, 0, 0, 0, 0, 468, 35);
	imagedestroy($imbg);

}

$name = $player->data->ename;
$namewidth = 140;
$namesize = 15;
do {
$namesize--;
$box = imagettfbbox($namesize, 0, $FONT, $name);
} while ($box[4] > $namewidth);
txt($im, $namesize, 3, 3, $COL[2], $name);

stxt($im, 7, 3, 23, $COL[4], 'ACSSR Player Profile');

$x = 150;
$y1 = 3;
$y2 = 13;
$y3 = 23;

stxt($im, 14, $x, $y1, $COL[3], "#" . $player->data->rank);
ctxt($im, 7, $x, $y3, "^0Score: ^1".($player->data->score+0));

$x+=80;
ctxt($im, 7, $x, $y1, '^1'.(0+$player->data->ppm) . " ^0ppm, ^1".$player->data->score." ^0score over ^1".humanTime($player->data->totaltime, 0)." ^0in ^114 ^0days");
if (isset($player->today) && isset($player->today->time) && $player->today->time) {
	$tppm = number_format((0+$player->today->frags)/$player->today->time*60,2);
//	ctxt($im, 7, $x, $y2, '^1'.$tppm . " ^0ppm, ^1".$player->today->score." ^0points over ^1".humanTime(0+$player->today->time, 0)." ^0today");
	ctxt($im, 7, $x, $y2, '^1'.$tppm . " ^0ppm, ^1".$player->today->frags."^0points over ^1".humanTime(0+$player->today->time, 0)." ^0today");
} else {
	$tppm = 0;
}

if ($player->data->curserverid) {
	$lastServer = $db->quickquery("select * from server where id = " . $player->data->curserverid);
	$s = "^1Currently ^0playing on ^1" . shortServerName($lastServer->name);
} else {
	$lastServer = $db->quickquery("select * from server where id = " . $player->data->lastserverid);
	if ($lastServer) {
			$s = "^0Last seen ^1" . humanTime(time() - $player->data->lastserverwhen, 0) . " ^0ago on ^1" . shortServerName($lastServer->name);
	} else {
		$s = "";
	}
}

if ($s != "")
	ctxt($im, 7, $x, $y3, $s);

if (isset($_GET['userid'])) {
	imagepng($im, "pp/$id.png");
} else {
	imagepng($im);
}
imagedestroy($im);

?>
