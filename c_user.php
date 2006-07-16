<?

class User {

	public $name;
	public $pass;
	public $html;
	public $email;
	public $id;
	public $playerid;

	function User() {
	
	
	}
	
	function register($form) {
	
		global $db;
		
		$l = strlen($form["username"]);
	
		if ($l < 2) {
		
			return "Username is too short. Try more letters.";
		
		}
		
		if ($l > 20) {
		
			return "Username is too long. Try something smaller.";
		
		}
		
		$l = strlen($form["password"]);
	
		if ($l < 3) {
		
			return "Password is too short. Try more letters.";
		
		}
		
		if ($l > 20) {
		
			return "Password is too long. Try something smaller.";
		
		}
		
		if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $form["email"])) {
		
			return "E-mail address looks invalid.";
		
		}
		
		$db->query("select id from user where name = '{$form["username"]}'");
		
		if ($db->count() == 1) {
	
			return "Username is already taken. Please try another one.";
			
		}
		
		$this->name = $form["username"];
		$this->pass = $form["password"];
		$this->email = $form["email"];
		$this->html = isset($form["html"])?1:0;

		$g = new generateSQL("user", "insert");
		$g->field("name", $this->name);
		$g->field("pass", "MD5('$this->pass')", 'number');
		$g->field("email", $this->email);
		$g->field("html", $this->html);
		
		// echo $g->sql();
		$db->query($g->sql());
		
		$this->id = mysql_insert_id();
		
		// send email
		
		$body = $this->name . ",\n\n";
		$body .= "Thank you for registering with ACSSR.\n\n";
		
		$url = "http://acssr.slowchop.com/activate.php?u={$this->id}&uid=" . $this->getuid();
//		$url = "activate.php?u=".htmlspecialchars($this->name)."&uid=" . $this->getuid();
		
		if ($this->html)
			$body .= "Click <a href=\"$url\">here</a> to activate your account.\n\n";
		else
			$body .= "Click on the link below to activate your account:\n$url";
			
		if ($this->html)
			$body = str_replace("\n", "<br>", $body);

		$headers = "";

		if ($this->html) {
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=utf-8\r\n";
		}

		$headers .= "From: ACSSR <acssr@slowchop.com>\r\n";

		mail($this->email, "ACSSR Registration", $body, $headers);

		return "";
	
	}
	
	function getuid() {
	
		$t = $this->id . "???" . $this->name . "/!/fuck";
	
		return sha1($t);
	
	}
	
	function activate($user, $uid) {
	
		global $db;
	
		$this->loadFromID($user);
		
		$genuid = $this->getuid();
		
		if ($genuid != $uid) {
		
			trigger_error("uid mismatch");
			return false;
		
		}
		
		$sql = "update user set activated = '1' where id = " . $this->id;
		
		$db->query($sql);
		
		return true;
	
	}
	
	function loadFromName($user) {
	
		global $db;
		
//		$user = addSlashes($user);
		$q = "select * from user where name='$user'";
		$dat = $db->quickquery($q);
		$this->loadFromData($dat);
		
	
	}
	
	function loadFromID($user) {
	
		global $db;
		$dat = $db->quickquery("select * from user where id='$user'");
		$this->loadFromData($dat);
	
	}
	
	function refresh() {
	
		global $db;
		
		$dat = $db->quickquery("select * from user where id='$this->id'");
		$this->loadFromData($dat);
		
		$db->query("update user set lasttime  = ".time().", lastip = '{$_SERVER["REMOTE_ADDR"]}' where id='$this->id'");
	
	}
	
	function save() {
	
		global $db;
	
		$fields = array("email", "html", "playerid");
		
		$g = new generateSQL("user", "update", $this->id);
		
		foreach($fields as $field) {
			$g->field($field, $this->$field);
		}
	
		$db->query($g->sql());
	
	}
	
	function loadFromData($dat) {

		if (!isset($dat->name))
			return;
		
		$this->name = $dat->name;
		$this->pass = $dat->pass;
		$this->email = $dat->email;
		$this->id = $dat->id;
		$this->html = $dat->html;
		$this->activated = $dat->activated;
		
		if (isset($dat->playerid))
			$this->playerid = $dat->playerid;
	
	}
	
	function login($u, $p) {
	
		$this->loadFromName($u);

		if (!isset($this->name))
			return 1;
			
		if (!$this->activated)
			return 2;
			
		if (md5($p) != $this->pass)
			return 3;
			
		return 0;
	
	}	
	
	function loadplayer() {
	
		global $db;
		$this->player = $db->quickquery("select * from player where id = " . $this->playerid);
	
	}
	
}

?>
