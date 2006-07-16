<?

class Profiler {

	function Profiler($name = "", $logFile = "profiler.log") {
		$this->name = $name;
		$this->logFile = $logFile;
		$this->log("BEGIN");
		$this->startTime = $this->lastTime = utime();
	}

	function done() {
		$n = utime() - $this->startTime;
		$this->log("DONE $n");
	}
	
	function log($text) {
		$fp = fopen($this->logFile, "a");
		fwrite($fp, sprintf("%s %s %s: %s\n", date('r'), $this->name, posix_getpid(), $text));
		fclose($fp);
	}
	
	function point($text, $shouldLog = true) {
		$n = utime();
		$t = $n - $this->lastTime;
		$this->lastTime = $n;
		if ($shouldLog)
			$this->log("POINT ($t): $text");
	}

}

?>
