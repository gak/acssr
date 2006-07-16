<?

class Server {

	public $fields = array("id", "address", "name", "map", "mapid", "curplayers", "maxplayers", "collect", 'down');

	function Server($data) {

		foreach($this->fields as $field) {

			$this->$field = $data->$field;

		}
	

	}

	function update($qstatoutput) {

		global $db;

		$this->query = new ServerQuery($this->address, & $qstatoutput);
		if ($this->query->name == "DOWN") {
			$this->down = 1;
		} else {
			$this->name = $this->query->name;
			$this->down = 0;
		}
		
		$this->lastmap = $this->map;
		$this->map = $this->query->map;
		$this->curplayers = $this->query->curplayers;
		$this->maxplayers = $this->query->maxplayers;
		
		if ($this->map != "" && strlen($this->map) > 2)
			$this->mapid = getMapID($this->map);
		
		$gsql = new generateSQL("server", "update", $this->id);

		foreach($this->fields as $field) {

			if (isset($this->$field)) {
				$gsql->field($field, mysql_real_escape_string($this->$field));
			}
			if (!$this->down) {
				$gsql->field('lastscan', time());
			}

		}

		$db->query($gsql->sql());

	}
	

}

?>
