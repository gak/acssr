<?

/*

	dbSQL.php
	Generates SQL INSERT/UPDATE statements

*/

class generateSQL {

	function generateSQL($table, $type, $id = 0, $idname = "id") {
	/*
	$table: table to modify
	$type: type of sql statement: insert/update
	$id: only used for update, to specify what row to update
	$idname: name of the field for the identifier (other then id)
	*/

		$this->table = $table;
		$this->type = $type;
		$this->id = $id;
		$this->idname = $idname;

	}

	function field($name, $value, $type = 'string') {
	/*
	$name: name of the field (in the db)
	$value: value to insert/update
	$type:
		- string: inserts field as a string.
		- number: inserts the field as is (Can be a number, a function, etc).
	*/

		$out['name'] = $name;
		$out['value'] = $value;
		$out['type'] = $type;
		$this->fields[] = $out;

	}

	function sql() {

		//if (sizeof($this->fields == 0))
		//	die("You don't have any fields...");

		$out = "";
		
		/* update */
		if ($this->type == 'update') {

			$out = "UPDATE $this->table SET ";

			$needcomma = false;

			reset($this->fields);
			while (list($a, $field) = each($this->fields)) {

				$name = $field["name"];
				$value = $field["value"];
				$type = $field["type"];

				($needcomma)?$out.=",":$needcomma = true;

				if ($type == 'string')
					$out .= "$name = '$value'";
				elseif ($type == 'number')
					$out .= "$name = $value";
				else
					trigger_error("Unknown Field Type - $type");

			}

			$out .= " WHERE ".$this->idname." = ".$this->id;

			return $out;

		} else if ($this->type == 'insert') {

			$out = "INSERT INTO $this->table (";

			$needcomma = false;
			reset($this->fields);
			while (list($a, $field) = each($this->fields)) {

				($needcomma)?$out.=",":$needcomma = true;

				$out .= $field["name"];

			}

			$out .= ") VALUES (";

			$needcomma = false;

			reset($this->fields);
			while (list($a, $field) = each($this->fields)) {

				$value = $field["value"];
				$type = $field["type"];

				($needcomma)?$out.=",":$needcomma = true;

				if ($type == 'string')
					$out .= "'$value'";
				elseif ($type == 'number')
					$out .= "$value";
				else
					trigger_error("Unknown Field Type - $type");

			}

			$out .= ")";

			return $out;


		} else {

			trigger_error("Unknown SQL type - ".$this->type);

		}

	}

}

?>