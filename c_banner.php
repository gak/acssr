<?

class Banner {

	function Banner($id) {
		global $db;
		$id += 0;
		$this->bannerbase = $db->quickquery("select bannerbase.*, user.playerid from bannerbase inner join user on user.id = bannerbase.userid where bannerbase.id = $id");
		if ($db->count() == 0)
			$this->player = null;
		else
			$this->player = new Player($this->bannerbase->playerid+0);
	}

	function done() {
		imagedestroy($this->image);
	}

	function render() {
		if (!$this->player) return;
		
		global $db;

		// 
		$this->image = imagecreatetruecolor($this->bannerbase->width, $this->bannerbase->height);

		$this->backgroundcolour = $this->allocateColourFromHex($this->bannerbase->bgcolour);
		imagefill($this->image, 0, 0, $this->backgroundcolour);
		
		imagealphablending($this->image, TRUE);
		
		// background image	
		if (strlen($this->bannerbase->bgimage)) {
			$bg = @imagecreatefromstring($this->bannerbase->bgimage);
			if ($bg) {
				imagecopy ($this->image, $bg, 0, 0, 0, 0, $this->bannerbase->width, $this->bannerbase->height);
				imagedestroy($bg);
			}
		}

		$res = $db->query("select * from bannertext where bannerid = {$this->bannerbase->id} order by id");
		while ($dat = $db->fetchObject($res)) {
			$colour = $this->allocateColourFromHex($dat->coloura);
			$colourHighlight = $this->allocateColourFromHex($dat->colourb);

			// work out widths and alignment
			$textFilled = $this->fillControlCodes($dat->text);
			$w = $this->getRenderWidth($dat->fontsize, $textFilled, 'font/lsansuni.ttf');
			if ($dat->align == 1) {	// 1 - center
				$dat->x = $dat->x - $w / 2;
			} else if ($dat->align == 2) { // 2 - right
				$dat->x = $dat->x - $w;
			}
			
			// $this->renderSimpleText($dat->fontsize, $dat->x, $dat->y, $dat->text, $colour, 'font/lsansuni.ttf');
			$this->renderControlCodeText($dat->fontsize, $dat->x, $dat->y, $dat->text, $colour, $colourHighlight, 'font/lsansuni.ttf');
		}
	}

	function write($f = "") {
		if ($f == "") $f = 'b/'.$this->bannerbase->id.'.png';
		imagepng($this->image, $f);
	}

	function allocateColourFromHex($c) {
        $r = hexdec(substr($c, 0, 2));
        $g = hexdec(substr($c, 2, 2));
        $b = hexdec(substr($c, 4, 2));
		$c = imagecolorallocate($this->image, $r, $g, $b);
		return $c;
	}

	// does what renderControlCOdes does but doesnt render anything and ignores colours
	function fillControlCodes($text) {
		$out = "";
        $text = "^0" . $text;
        $tok = strtok($text, '^');
		$selectedPlayer = $this->player;
        while ($tok != "") {
            $code = substr($tok, 0, 1);
			$out .= $this->getControlCodeValue($code, $selectedPlayer);
			if ($code == 'I') {
				$selectedPlayer = new Player(substr($tok,1)+0);
			} else {
				$out .= substr($tok, 1);
			}
			
            if (0) {
                print "C".$code."<br>";
                print $tok."<br>";
                print $text."<br>";
                print "<br>";
            }
            $tok = strtok('^');
        }
		return $out;
	}
	
	function getRenderWidth($size, $text, $font) {
		$b = imagettfbbox ( $size, 0, $font, $text);
		$width = $b[4];
		return $width;
	}

	function renderSimpleText($size, $x, $y, $text, $colour, $font) {
		return imagettftext ($this->image, $size, 0, $x, $y+$size, $colour, $font, $text);
	}

	function getControlCodeValue($code, $p) {

		global $db;
		$text = "";
		switch($code) {
			case 'N': $text = $p->data->ename; break;
			case 'R': $text = $p->data->rank + 0; break;
			case 'S': $text = $p->data->score + 0; break;
			case 'P': $text = $p->data->ppm + 0; break;
			case 'F': $text = $p->data->totalfrags + 0; break;
			case 'T': $text = humanTime($p->data->totaltime + 0); break;
			case 'L':
				$lastServer = $db->quickquery("select * from server where id = " . $p->data->lastserverid);
				$text = shortServerName($lastServer->name);
				break;
			case 'A': $text = humanTime(time() - $p->data->lastserverwhen); break;
			// today values
			case 'f': $text = $p->today->frags + 0; break;
			case 't': $text = humanTime($p->today->time + 0); break;
		}
		return $text;
	}
	
	function renderControlCodeText($size, $x, $y, $text, $colour, $colourHighlight, $font) {

		$text = "^0" . $text;
		$tok = strtok($text, '^');
		$col = $colour;
		$selectedPlayer = $this->player;
		while ($tok != "") {
			$code = substr($tok, 0, 1);
			$text = substr($tok, 1);
			switch($code) {
				case '0': $col = $colour; break;
				case '1': $col = $colourHighlight; break;
			}
			$textCode = $this->getControlCodeValue($code, $selectedPlayer);
			if (0) {
				print "C".$code."<br>";
				print "TOK: '$tok'<br>";
				print "TEXT: '$text'<br>";
				print "<br>";
			}
			if ($code == 'I') {
				$selectedPlayer = new Player($text+0);
			} else if ($textCode.$text == " ") {
				$x += $size * .4;
			} else {
				$box = $this->renderSimpleText($size, $x, $y, $textCode.$text, $col, $font);
				$x = $box[4];
			} 
			$tok = strtok('^');
		}
	}

}

?>
