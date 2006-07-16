<?

include('include.php');

htmlStart();

homeheading('ACSSR for IRC');

?>

<div class="articlebody">

<p>

ACSSR lets you run a script on mIRC that display player statistics in your channel. It is called <b>ACSSR Bot</b> and it looks like this:<br><br>

<div style="text-align: center"><img src="img/irc.png"></div>

</p>

<h3>What it can do</h3>
<ul>
<li>Customise a trigger for your own clan. For example <b>!mycoolclan</b> can display all your members.
<li>Customise the output colours
<li>Can do a search on your irc nick or any other name
<li>Displays the current top 10 and top 10 online
<li>Flooding protection -- only one command every 10 seconds</li>
</ul>

<h3>What it may do in the future</h3>
<ul>
<li>Player history graphs</li>
<li>Better flood protection</li>
<li>Customise which channel(s) it responds on</li>
<li>Better clan management</li>
<li>Display links to player details on the ACSSR web site</li>
</ul>

<h3>What it can not do</h3>
<ul>
<li>mIRC does not support utf-8 characters. You won't get wierd and wonderful names.
</ul>

<h3>Rules</h3>
<p>
The ACSSR Bot is freely available to downlod, as long as you follow these few rules.<br><br>

You can use the script and this service as long as:
<ul>
<li>You don't over-use ACSSR's bandwidth.
<li>You take full responsibility for any problems that may occur from ACSSR Bot.
</ul>

You can modify the script in a functional way as long as:
<ul>
<li>You tell me that you have changed it
<li>If you feel your change is useful to the community, show me what you changed and I'll put it in the next version.
<li>The copyright remains intact inside the script and in the !acssr trigger
<li>The !acssr trigger must stay working
<li>The URL request parameters do not change
</ul>
</p>

<h3>Privacy Policy</h3>
<p>Here is the privacy policy of using ACSSR Bot. If you don't agree with it you have the option of not using it, discussing it in the forums or contacting me via the forum. When you use ACSSR Bot your ip address, the server and channel it is run on is sent to ACSSR and stored in the database. This is used internally for bandwidth purposes. I *may* create a page that displays which server and channels it is being used on.</p>

<h3>Installing and Configuring</h3>
<p>
First step to installing is to <a href="ircscript/acssrbot-0.1.zip">download the script</a>. It contains one file called <b>acssr.ini</b>. Put that file in your mIRC directiory.<br><br>
Once <b>acssr.ini</b> is in your mIRC directory, load up mIRC and type in:
</p>

<div class="code"><pre>
/load -rs acssr.ini
</pre></div>

<p>
If it installed correctly, the following command should work:
</p>

<div class="code"><pre>
/acssrhelp
</pre></div>

<p>
It should say something like:
</p>

<div class="code"><pre>
ACSSR Bot Version 0.1 / Copyright Gerald Kaszuba 2005
Some commands are !acssrsearch [name] / !acssrtop10 / !acssrtop10online
For more information see http://acssr.slowchop.com/
</pre></div>

<p>
If that's all good, congratulations you have ACSSR installed! Now to customising your clan listing... You need to collect a list of ID numbers that refer to your clan members. The instructions on getting this list is on the <a href="webmasters.php">ACSSR for Webmasters</a> page (see <b>2. Create a list of player ID numbers</b>). Once you get your player list, you can now configure your custom trigger:
</p>
<div class="code"><pre>
/acssrsetclan !list !online 4102,308,4328 My Cool Clan
</pre></div>
<p>
The first parameter, <b>!list</b>, is to specify what will trigger a stats listing of your members. This will display rank, score, etc. The second parameter will specify a trigger to just display who in your clan is online and in which server. The 3rd is your player ID list. Make sure it doesn't have any spaces. The last is your clan name, this is shown in the !acssr trigger. You can test this listing by using the following commands:
</p>
<div class="code"><pre>
/acssrclanstats
/acssrclanonline
</pre></div>

<h3>Commands</h3>
<p>
Ok, here is a list of commands that you can run. I'll leave you to work out what they mean!
</p>
<div class="code"><pre>
/acssrhelp
/acssrclanstats
/acssrclanonline
/acssrsearch
/acssrtop10
/acssrtop10online
</pre></div>

<p>
Similarily, here are the triggers anyone else can use to see ACSSR stats. Unforuntately mIRC doesn't support self triggering so you'll have to ask someone else to test it for you! These don't include your clan triggers because you've set the names of those yourself.
</p>
<div class="code"><pre>
!acssr
!acssrsearch
!acssrtop10
!acssrtop10online
</pre></div>

<p>Enjoy!</p>

<?

htmlStop();

?>
