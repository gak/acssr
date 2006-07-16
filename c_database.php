<?
/**
* dbFe - A Class Of Simple Database Functions
*
* The Database Class Does All Of Our Database Calls.
*
*/

class Database {
/*
	* @var	var	$result
	* @see	count()
*/
	private $result;

	/**
	* Database() - The Constructor For The Class
	*
	* The Constructor Opens The DB Connection.
	*
	*
	*/

	function Database() {

		$this->db = mysql_pconnect(DB_SERVER, DB_USERNAME, DB_PASSWORD, MYSQL_CLIENT_SSL | MYSQL_CLIENT_COMPRESS) or
			die ("There are too many users on ACSSR. Please try again later.");
		
		mysql_select_db(DB_DATABASE, $this->db);

	}

	/**
	* count() - Returns the number of rows in a result set
	*
	* Returns the number of rows in a result set
	*
	* @param int $result If Passed in then Return The Number Of Rows In $result else use the last result returned.
	* @return int
	*/

	function count($result = 0) {

		if (!$result)
			return @mysql_num_rows($this->result);
		else
			return @mysql_num_rows($result);
	}

	/**
	* num_fields() - Returns the number of fields in a result set
	*
	* Returns the number of fields in a result set
	*
	* @param int $result If Passed in then Return The Number Of Fields In $result else use the last result returned.
	* @return int
	*/

	function num_fields($result = false) {

		if (!$result)
			return @mysql_num_fields($this->result);
		else
			return @mysql_num_fields($result);

	}

	/**
	* affected_rows() - Returns the number of rows affected by the last query
	*
	* Returns the number of rows affected by the last query
	*
	* @param int $result If Passed in then Return The Number Of Affected Rows In $result else use the last result returned.
	* @return int
	*/

	function affected_rows($result = false) {		
	
		if (!$result)
			return @mysql_affected_rows($this->result);
		else
			return @mysql_affected_rows($result);

	}


	/**
	* query() - Runs A Query Against The Database And Returns a Result Set
	*
	* Runs A Query Against The Database And Returns a Result Set
	*
	* @param string $query SQL String to run against the database.
	* @return object $this->result
	*/

	function query($query)
		{
		global $QUERIES;
		global $QUERY_ERROR;

		unset($q);

		$t = 0;

		if (function_exists("utime"))
			$t = utime();

		$this->result = @mysql_query($query, $this->db);
		
		$last_mysql_error = mysql_error();
		if ($last_mysql_error != '') echo '<!--'.$query.'--><!--'.$last_mysql_error.'-->';

		if (function_exists("utime"))
			$q["time"] = (utime() - $t) * 1000;

		$q["sql"] = $query;
		//$q["rows"] = (int)$this->count($this->result);
		$q["rows"] = 0;
		$q["fields"] = 0;//(int)$this->num_fields();
		$q["affectedrows"] = 0;//(int)$this->affected_rows();

		// $output = $query . " <b>rows: " . (int)$this->count() . ", fields: " . (int)$this->num_fields() . ", affected_rows: " . (int)$this->affected_rows()."</b>";

		if ($last_mysql_error != "") {

			$q["error"] = mysql_error();
			// $output .= "<br><b>" . mysql_error() . "</b>";
			// echo mysql_error() . "<br>";
			$QUERY_ERROR = true;
			
			
			global $C_DATABASE_DIEONERROR;
		
			if ($C_DATABASE_DIEONERROR)
				trigger_error("DATABASE ERROR: " . $query . "\n<br>\n" . mysql_error());
			
			
		}

		$QUERIES[] = $q;
		
		return ($this->result);
		}

	// returns the first row into an object
	function quickQuery($query) {

		if (!$this->query($query))
			return false;

		return $this->fetchObject();

	}

	// returns a row as an object
	function fetchObject($result = false) {

		if (!$result)
			return @mysql_fetch_object($this->result);
		else
			return @mysql_fetch_object($result);

	}

	// returns a row as an associative array
	function fetchArray($result = false) {

		if (!$result)
			return mysql_fetch_array($this->result);
		else
			return mysql_fetch_array($result);

	}

	// returns all the rows in an associative array
	function fetchAllArray($result = false) {

		$allarray = array();

		if (!$result)
			while($dat = $this->fetchArray($this->result))
				$allarray[] = $dat;
		else
			while($dat = $this->fetchArray($result))
				$allarray[] = $dat;
		return $allarray;

	}

	// returns all the rows in an associative array
	function fetchAllArrayObject($result = false) {

		$allarray = array();

		if (!$result)
			while($dat = $this->fetchObject($this->result))
				$allarray[] = $dat;
		else
			while($dat = $this->fetchObject($result))
				$allarray[] = $dat;

		return $allarray;

	}

	// returns an array with the first field as the key and the second as the value.
	function fetchSimpleArray($result = false) {

		$allarray = array();

		if (!$result)
			while($dat = mysql_fetch_row($this->result))
				$allarray[$dat[0]] = $dat[1];
		else
			while($dat = mysql_fetch_row($result))
				$allarray[$dat[0]] = $dat[1];


		return $allarray;

	}

}

?>
