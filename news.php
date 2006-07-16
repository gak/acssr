<?

require_once("include.php");

htmlStart();

$db = new Database();
?>

<h2>News</h2>

<table>

<tr><td class="total">Bugs fixed...
<tr><td class="alt">22 December 2004 9:41am
<tr><td>When I moved the site over, I didn't think to check what time the server runs on. It was running on GMT, so any stats you got in the last 10 hours were counted as yesterdays stats. I've fixed this, so midnight is actually midnight in GMT+10 time.
</table>

<?

htmlStop();

?>
