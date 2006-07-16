<?

require_once("include.php");

htmlStart();

$db = new Database();

?>

<h2>About ACSSR</h2>

<h3>Overview</h3>

<p>Hi, I'm called /dev/gak in CS:S. I've written this site because one doesn't seem to exist for Australian servers.<br><br>

The site is in development at the moment, so there will be new features popping up every now and then. I may reset all the stats too. I'll try not to unless it's completely necessary.

This system is brand new. It works 99% well. Please don't take it too seriously. Compare your frags and online time after you play a game and tell me how much of a difference there is.

If you would like to contact me about this site email "acssr at gakman dot com"

</p>

<h3>Rules</h3>

Your stats will not be counted if you are on an unofficial map. I've done this because aim/fun maps give you an unnatural P/M ratio.

<h3>Simple Details</h3>
<p>

The web site scans a <a href="servers.php">list of servers</a> for player information. The only useful data it can get are "points" and "time". So unfortunately I can't collect information like what weapon you've killed another player with. Internode stats CAN do this because they have logfiles that tell them that information.<br><br>
It works out how long you've played for, and how many points you've made... It gives you a P/M value. It also works out a multiplier depending on how long you've played. Then your score is worked out by multiplying the two together. I've done this in a way so that people who only play for a short time with a high P/M won't necessarily get a high score.

</p>
<h3>Technical Details</h3>
<p>
- A process checks a list of servers every minute. The # (rank) value is updated every five minutes due to server load.<br>
- The actual process 
- multiplier = 1 - <?=FORMULA_OFFSETT?> / ( seconds + <?=FORMULA_OFFSETB?> )<br>
- score = multiplier * frags / seconds * <?=FORMULA_SCOREMULTIPLIER?><br>
</p>

<h3>Problems</h3>
<p>
There are a few problems that come with the system:<br>
- I poll servers once a minute, so if the map changes in that minute any points you get won't be collected. This also counts for the start of the map. Your time on the server won't be collected for that minute either, making your Points per Minute still accurate for the sample taken.<br>
- The way Half Life 2's query system works is limited and therefore not so useful to us stats freaks. It doesn't tell us your Death score so we can't calculate Score per Death.
</p>

<?

htmlStop();

?>