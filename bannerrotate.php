<?

include 'include.php';

// Put this in httpd.conf to count image view hits
// RewriteRule ^/r/(.*)\.png$ /bannerrotate.php?id=$1

$userid = $_GET['id'] + 0;
$db = new Database();
$dat = $db->quickquery('select id from bannerbase where deleted = 0 and userid = ' . $userid . ' order by rand() limit 1');
$id = $dat->id;
$db->query('update bannerbase set hits = hits + 1 where id = ' . $id);

$name = "b/$id.png";
if (!file_exists($name)) die();

$fp = fopen($name, 'rb');

header('Content-Type: image/png');
header('Content-Length: ' . filesize($name));
fpassthru($fp);
fclose($fp);

?>
