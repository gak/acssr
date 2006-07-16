<?

include 'include.php';
include 'admin.php';

// Put this in httpd.conf to count image view hits
// RewriteRule ^/b/(.*)\.png$ /bannerredirect.php?id=$1

// if ($_SERVER["REMOTE_ADDR"] == '70.86.95.146') die();

$id = $_GET['id'] + 0;
$db = new Database();
$dat = $db->quickquery('select deleted from bannerbase where id = ' . $id);
$db->query('update bannerbase set hits = hits + 1 where id = ' . $id);

if ($dat->deleted && !$isAdmin) die();

$name = "b/$id.png";
if (!file_exists($name)) die();

$fp = fopen($name, 'rb');

header('Content-Type: image/png');
header('Content-Length: ' . filesize($name));
fpassthru($fp);
fclose($fp);

?>
