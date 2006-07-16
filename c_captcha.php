<?

header('Content-type: image/png');

class Captcha {

	function Captcha($w, $h, $fonts) {
		$this->fonts = $fonts;
		$this->w = $w;
		$this->h = $h;
	}

	function generate() {
		
		$words = file('captchawords');
		$this->word = $words[array_rand($words)];
		$this->word = trim(strtolower($this->word));
		$this->font = $this->fonts[array_rand($this->fonts)];
		$this->filename = 'captcha/' . rand() . '.png';
		$this->im = imagecreatetruecolor($this->w,$this->h);
		$col = imagecolorallocate ($this->im, 0, 0, 0);
		imagefill($this->im, 0, 0, $col);
		$fontsize = $this->h - 30;
		$size = imagettfbbox ($fontsize, 0, $this->font, $this->word);
		$width = $size[2] - $size[0];
		$height = $size[3] - $size[1];
		$posx = $this->w/2 - $width / 2;
		$posy = $this->h/2 - $height / 2 + 10;
		$col = imagecolorallocate ($this->im, $this->col_component(), $this->col_component(), $this->col_component());
		imagettftext($this->im, $fontsize, 0, $posx, $posy, $col, $this->font, $this->word);
		imagepng($this->im, $this->filename);
		$swirl = rand(30, 50);
		if (rand(0,1)) $swirl = -$swirl;
		$wave = rand(1,3) . 'x' . rand(50,50);
		$implode = (float)rand(0,1) * .2 - 0.1;
		system("mogrify -background black -wave $wave -implode $implode -swirl $swirl " . $this->filename);
		#		print file_get_contents($this->filename);
	}

	function col_component() {
		return rand(50,200);
	}

}

/*
$p = '/usr/X11R6/lib/X11/fonts/TTF';
$fonts = array("$p/comicbd.ttf");
$c = new Captcha(120, 50, $fonts);
$c->generate();
*/

?>
