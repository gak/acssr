<?

class Player {

	public $data;
	public $fields = array(
	
		#		"name",
		"ename",
		"totalfrags",
		"totaltime",
		"curserverid",
		"curservertime",
		"curserverfrags",
		"lastserverid",
		"lastserverwhen",
		"score",
		"ppm",
		"multiplier",
		"rank"
		
	);

	function player($id = NULL) {

		if ($id == NULL) {

			return;

		} else if (is_string($id)) {

			$this->getPlayerFromName($id);

		} else if ($id != 0) {

			$this->getPlayerFromID($id + 0);

		}

	}

	function playerExists() {
	
		return isset($this->data->id);

	}

	function getPlayerFromID($id) {

		global $db;
		global $sqlsel_gen;

		$id += 0;		
		$this->data = $db->quickquery("$sqlsel_gen from player where player.id = $id");

		if (!$db->count()) {
			return;
		}

		$this->today = $db->quickquery("select * from playerdaily where playerid = $id and day = " . today());

	}

	function getPlayerFromName($name) {

		global $db;
		global $sqlsel_gen;
	
		$sql = "$sqlsel_gen from player where player.ename = ".str_to_sql($name);
		$this->data = $db->quickquery($sql);
		sql_error_check($sql);

		if (!$db->count()) {
			echo "\n** NO RECORDS\n";
			return;
		}
		
		$this->today = $db->quickquery("select * from playerdaily where playerid = {$this->data->id} and day = " . today());
		
	}

	function insertPlayer() {

		$this->updatePlayer(true);

	}

	function updatePlayer($new = false) {

		global $db;
		
		if ($new) {
			
			$gsql = new generateSQL("player", "insert");

		} else {

			if (!$this->playerExists())
				trigger_error("updatePlayer failed: player '{$this->data->name}' does not exist.");

			$gsql = new generateSQL("player", "update", $this->data->id);
			
		}

		foreach($this->fields as $field) {

			if (isset($this->data->$field)) {
					
				// dont update player name!
				if ($field == "name" && !$new)
					continue;

				if ($field == "ename" or $field == "name") {
					$gsql->field($field, str_to_sql($this->data->$field), 'number');
					continue;
				}
					
				if ($new)
					$val = mysql_real_escape_string($this->data->$field);
				else
					$val = mysql_real_escape_string($this->data->$field);
				
				$gsql->field($field, $val);
				
			}

		}
		
		$q = $gsql->sql();
		$db->query($q);
		#echo $q . "\n" . mysql_error . "\n";
		sql_error_check($q);

//		print_r($db->quickquery('select * from player where id = '.$this->data->id));
		
		if ($new) {
		
			$this->data->id = mysql_insert_id();
		
		}

		if (!isset($this->data->score))
			$this->data->score = 0;
			
		if (!isset($this->data->frags) || $this->data->frags == "")
			$this->data->frags = 0;
		if (!isset($this->data->time) || $this->data->time == "")
			$this->data->time = 0;		
		
		if (!isset($this->today->frags) || $this->today->frags == "")
			$this->today->frags = 0;
		if (!isset($this->today->time) || $this->today->time == "")
			$this->today->time = 0;		
		
		// lets update the daily stats
		if (isset($this->today->playerid)) {
		
			$sql = "
			
				update playerdaily
				set frags = {$this->today->frags}, time = {$this->today->time}, score = {$this->data->score}
				where playerid = '{$this->today->playerid}' and day = ".today()."
				
			";			
	
		} else {
		
			$sql = "
			
				insert into playerdaily
				(playerid, day, frags, time, score)
				values
				({$this->data->id}, ".today().", '{$this->today->frags}', '{$this->today->time}', {$this->data->score})
				
			";

//			echo $sql . "\n";
				
		}
		
		$db->query($sql);
		# echo $sql . "\n" . mysql_error . "\n";
		sql_error_check($sql);
		
	}

	function updateFromQuery($server,$q) {

//		echo "\n" . $this->data->name . "\n";

		if (!$this->playerExists()) {
		
			echo "Player don't exist: " . $q->name . "\n";
			$this->data->name = $q->name;
			$this->data->curserverid = $server->id;
			$this->data->curservertime = $q->time;
			$this->data->curserverfrags = $q->frags;
			$this->insertPlayer();
			$this->Player($q->name);	// reload the row from the db

		}

		$fragdiff = $q->frags - $this->data->curserverfrags;
		$timediff = $q->time - $this->data->curservertime;
		$serverdiff = ($server->id != $this->data->curserverid);
		$mapdiff = ($server->map != $q->map);

		if ($mapdiff) {
		
			echo "- changed map\n";
			$fragdiff = $q->frags;
			$timediff = $q->time;
			
		} else if ($serverdiff) {

			echo "- changed server\n";
			$fragdiff = $q->frags;
			$timediff = $q->time;

		} else if ($timediff < 0) {

			echo "- time reset\n";
			$fragdiff = $q->frags;			

		}

		$this->data->curserverfrags = $q->frags;
		$this->data->curservertime = $q->time;
		$this->data->curserverid = $server->id;
		$this->data->totalfrags += $fragdiff;
		$this->data->totaltime += $timediff;
		
		printf("FRAGS: +%-2d cur:%-2d tot:%-4d TIME: +%d\n", $fragdiff, $q->frags, $this->data->totalfrags, $timediff);

		$this->updatePlayer();

	}

}

?>
