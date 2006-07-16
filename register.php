<?

require_once("include.php");

htmlStart();

$username = "";
$password = "";
$email = "";
$html = 0;

$error = "";

if (isset($_POST["username"])) {

	$username = $_POST["username"];
	$password = $_POST["password"];
	$email = $_POST["email"];
	// $html = isset($_POST["html"]);
	$html = 0;
	
	# $cap = $_SESSION['cap'];-->
	if (0 || $cap->word != strtolower($_POST['cap'])) {
		$error = "Image Verification failed. Please try it again.";
	} else {
		$user = new User();
		$error = $user->register($_POST);
	}
}

if ($error != "" || $username == "") {

	homeHeading('ACSSR Member Registration');

?>

<div class="articlebody">

Being an ACSSR member allows you to do the following:<br>
- Track friends in real time<br>
- Have your own banner<br>
- Vote on other players<br>
<!-- - Receive an e-mail of your daily stats<br> -->

<br>
Please fill out this small form below and you will be emailed an activation link.<br>

</div>

<?	homeHeading('ACSSR Member Form'); ?>

<div class="articlebody">

<?

if ($error != "") {

	echo "<b style=\"color: red;\">$error</b>";
	
	echo "<br><br>";

}

$p = '/usr/X11R6/lib/X11/fonts/TTF';
$fonts = array("$p/comicbd.ttf");
$cap = new Captcha(120, 50, $fonts);
$cap->generate();
$_SESSION['cap'] = $cap;

?>
<form action="register.php" method="post">
<div>

<b>Username</b><br>
<small>Between 2 and 20 characters. No spaces please. This does <b>not</b> have to match your Counter-Strike name. </small><br>
<input type="text" name="username" value="<?=$username?>"><br><br>

<b>Password</b><br>
<small>Betwwen 3 and 20 characters. You'll need to remember this. Try typing it carefully :)</small><br>
<input type="password" name="password"><br><br>

<b>E-mail Address</b><br>
<small>You need to have access to this email account if you want to log in.</small><br>
<input type="text" name="email" value="<?=$email?>" size="40"><br><br>

<!--
<b>Image Verification</b><br>
<small>Simply type in the word you see.</small><br>
<img src="<?=$cap->filename?>"><br>
<input type="text" name="cap" value="" size="10"><br><br>
-->

<input type="submit" value="Register Now">

</div>
</form>

</div>

<h2></h2>
<?homeheading('ACSSR Member Privacy');?>
<div class="articlebody">

If you're concerned about privacy, I've made this little privacy policy for you. If you feel that there is something I missed please inform me right away.<br><br>

<b>Passwords</b><br>
Your password is not stored in clear text. This means I can not read your password.<br><br>

<b>E-mail</b><br>
I will not send you an e-mail unless you specifically request it. Every e-mail sent will have a link to change your member preferences.<br><br>

These are example cases where an e-mail may be sent:<br>
- When you sign up for the first time, a confirmation e-mail will be sent to you.<br>
- If you forget your password, you need to type in your username and e-mail address. An email will be sent to you with a new password.<br>
- If you sign up to a daily report e-mail, you will get an e-mail once a day.<br><br>

<b>3rd Party</b><br>
I will not give your e-mail address to anyone.

</div>

<?

}

else if ($error == "") {

	echo "Thank you for registering. Please check your e-mail to receive your activation link.";

}

htmlStop();

?>
