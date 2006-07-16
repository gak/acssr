<?

include('include.php');

htmlStart();

homeheading('Miscellaneous');

?>

<div class="articlebody">
<p>There are few cool things you can do with ACSSR. They are shown below...</p>
</div>

<? homeheading('Player Signatures'); ?>

<div class="articlebody">
<p>ACSSR Members can have their own signature to use in forums, email, etc. You must be logged in, then click <a href="memberadvancedprofile.php">here</a>.</p>
<p><img src="pp/406.png"></p>
</p>
</div>

<? homeheading('ACSSR XML (BETA)'); ?>
<div class="articlebody">
<p>ACSSR player information can be retrieved using XML data. It is in BETA which means the format of the XML may change in the future. I will post in the news if it does.<br><br>
You <b>must</b> link to ACSSR if you use this and you may not poll too often. Breaking these two rules will result in an IP address ban.<br><br>
To use it simply find your player ID (from the URL of your player details page) and put it on the end of this URL:<br>
<div class="code">http://acssr.slowchop.com/xml-player.php?id=</div><br>
I have made a <a href="xml-parser.php">sample PHP file</a> to demonstrate the use of parsing the XML file to put on your web page.
</div>

<? homeheading('ACSSR for Webmasters'); ?>

<div class="articlebody">
<p>If you run a web page for your clan or similar, you can display some ACSSR statistics on your web site using <a href="webmasters.php">ACSSR Mini</a>.</p>
<script>
var PlayerList='16655,308,4326,4328';
var Type='2';
var Width='350';
var Height='100';
var StyleSheet='';
document.write('<iframe src="http://acssr.slowchop.com/export.php?type='+Type+'&pl='+PlayerList+'&ss='+StyleSheet+'" width="'+Width+'" height="'+Height+'" frameborder="0" marginwidth="0" marginheight="0" vspace="0" hspace="0" allowtransparency="true" scrolling="no"></iframe>');
</script>
</div>

<? homeheading('ACSSR for IRC'); ?>
<div class="articlebody">
<p>If you are on IRC you can run an IRC Bot called <a href="ircscript.php">ACSSR Bot</a>. ACSSR Bot can do player searches, clan listings and a few other handy things.</p>
<div><img src="img/irc.png"></div>
</div>

</p>

<?

htmlStop();

?>
