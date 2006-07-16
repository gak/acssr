<?

require('include.php');
require('inc_newerror.php');

set_error_handler("acssrerrorhandler");

$db->query("select moo from cow where a = fefefe");

?>
