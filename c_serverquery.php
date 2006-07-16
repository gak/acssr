<?

class ServerQuery {

	function ServerQuery($ip, $qstatoutput) {

		/*
		$cmd = "qstat -nh -ts -P -hl2s $ip";
		$text = `$cmd`;
		$this->parse($text);
		*/

		$this->parse(& $qstatoutput[$ip]);
	}

/*
	function parse($text) {

		$lines = explode("\n", $text);
*/
	function parse($lines) {
		// header looks like this:
		// 218.214.224.105:27015 22/22 cs_italy     28 / 0   SwiftGames CS:Source Sydney

		$this->curplayers = 0;
		$this->maxplayers = 0;

		$header = $lines[0];

		if (strlen($header) == 0) {
			
			$this->map = "";
			$this->name = "DOWN";
			return;
			
		}
		
		// this fixes the 22/22 when the denominatior is one digit: "5/ 8" to "5/8"
		$header = str_replace("0/ ", "0/", $header);
		
		// rem all spaces
		while (strstr($header, "  "))
			$header = str_replace("  ", " ", $header);
			
		$headbits = explode(" ", $header);
		
		// server is up!
		if ($headbits[1] == "DOWN" || $headbits[2] == "response") {
		
			$this->map = "";
			$this->name = "DOWN";

		} else {
		
			$this->map = strtolower($headbits[2]);
			
			// get player stats
			$t = explode('/', $headbits[1]);
			$this->curplayers = $t[0];
			$this->maxplayers = $t[1];
			
			$this->name = "";
			for ($i = 7; $i < sizeof($headbits); $i++)
				$this->name .= $headbits[$i] . " ";
			$this->name = trim($this->name);

			unset($this->players);
			for ($i = 1; $i < sizeof($lines); $i++) {

				$line = $lines[$i];
				
				$s = explode("\t", $line);

				unset($player);
				$player->frags = $s[1]+0;
				$player->time = $s[2]+0;
				$player->ename = $s[3];
				$player->name = $s[4];
				
				// convert hex player name to acsii
				
				$o = '';
				for ($j = 0; $j < strlen($player->ename); $j+=2) {
				
					$o .= chr(hexdec($player->ename[$j]) * 16 + hexdec($player->ename[$j+1]));
				
				}
				
				$player->ename = $o;
				$player->name = $o;
				
				//echo $player->ename . " ----- ";
				//echo $player->name . "\n";
				
				$this->players[] = $player;

			}
			
		
		}

	}
	
}


?>
