<?

include('include.php');

htmlStart();

homeheading('ACSSR for Webmasters');

?>

<div class="articlebody">

<p>

ACSSR lets you display player statistics on your web site. It looks like this:<br><br>

<script>
var PlayerList='16655,308,4326,4328';
var Type='2';
var Width='350';
var Height='100';
var StyleSheet='';
document.write('<iframe src="http://acssr.slowchop.com/export.php?type='+Type+'&pl='+PlayerList+'&ss='+StyleSheet+'" width="'+Width+'" height="'+Height+'" frameborder="0" marginwidth="0" marginheight="0" vspace="0" hspace="0" allowtransparency="true" scrolling="no"></iframe>');
</script>

<br><br>
I'm going to refer to it as "ACSSR Mini" for now :)<br><br>

You have the option of picking from a few formats, and you may also use your own stylesheet to match your web sites theme.<br><br>

At the moment ACSSR Mini creates an IFRAME in your web site at a certain dimension with some settings and shows ACSSR stats within it.

</p>

<h3>Rules</h3>
<p>
Before we start I want to mention some simple rules for using this script on your web site. You may not abuse or take credit for this system. You may not change or remove the copyright and URL information in the script. That is all :)
</p>

<h3>Implementation</h3>
<p>
Here's a step-by-step guide on how to deploy ACSSR Mini to your web site.
</p>

<b>1. Copy the Code into your HTML file</b><br>

<p>Copy all the text in the box below:</p>

<textarea rows="10" cols="100">
<!-- ACSSR Mini Begin -->
<!-- Copyright 2005 ACSSR -->
<!-- http://acssr.slowchop.com/ -->
<script>

var PlayerList='';
var Type='0';
var Width='350';
var Height='200';
var StyleSheet='http://acssr.slowchop.com/style-export.css';

document.write('<iframe src="http://acssr.slowchop.com/export.php?type='+Type+'&pl='+PlayerList+'&ss='+StyleSheet+'" width="'+Width+'" height="'+Height+'" frameborder="0" marginwidth="0" marginheight="0" vspace="0" hspace="0" allowtransparency="true" scrolling="no">');
</script>
<!-- ACSSR Mini End -->

</textarea>

<p>Paste it into your HTML code where you want ACSSR Mini to be shown. Don't bother trying to load the page, it'll probably give you an error :)</p>

<b>2. Create a list of player ID numbers</b><br>
<p>

The script has to know which players you want to display. You need to create a list of players by their ACSSR ID number for the ACSSR Mini. To find out a player's ID number, go into their player profile page. In the URL it will show it after "id=". For example:<br>

<div class="code">http://acssr.slowchop.com/playerdetails.php?id=4102</div><br>

The ID number of this player is 4102.<br><br>

You can also look at your status bar in your browser for the link to the playerdetails page to make things a bit quicker!<br><br>
Once you've collected all the numbers, you need to arrange them in a comma seperated list like this:<br><br>

<div class="code">4102,308,4328</div><br>

</p>

<b>3. Configure ACSSR Mini</b><br>

<p>

The lines in the script that start with <b>var</b> are variables that control how ACSSR Mini looks. You need to put your Player ID List into the PlayerList variable like this:<br>

<div class="code">var PlayerList='4102,308,4328';</div><br>

The <b>Type</b> variable states what columns to show. They can be 0, 1 or 2. I may add more some time in the future.<br>
- 0 shows all fields<br>
- 1 shows rank, name and score<br>
- 2 shows rank, name and server/last seen<br><br>

For example:<br><br>
<div class="code">var Type='2';</div><br>

The <b>Width</b> and <b>Height</b> variables are how big your IFRAME is going to be. You'll probably have to tweak this a few times to get it right.<br><br>

The <b>StyleSheet</b> variable is a location of your stylesheet. By default it will use ACSSR's colour scheme. You need to specify a full URL to your style sheet file. I've made an example style sheet you can download and modify to your own needs. A screenshot of it is displayed...<br><br>

<img src="img/mini-sample.png"><br><br>

The style sheet for it is shown here:<br><br>

<div class="code">
<pre>
body {

        background-color: white;
        color: black;
        font-family: monospace;

}

table {

        border: 1px solid black;
        width: 100%;

}

th {

        text-align: left;

}

div {

        font-family: sans-serif;
        font-size: 10px;
        text-align: right;

}
</pre>
</div>
<br>

Save this file, modify it to your liking and call it something like acssr.css on your web site. Attempt to load it up in your browser to make sure the URL is right then throw it in the StyleSheet variable like so:<br><br>

<div class="code">var StyleSheet='http://your.clans.website.com/acssr.css';</div><br>

At this stage you should have tried the script out... Hopefully it works!

If you have any problems or feedback make a post in the <a href="forum">forum</a> with the details of what you broke ;)

</p>

</div>

<?

htmlStop();

?>
