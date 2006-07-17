<?
include 'include.php';

htmlStart();
homeHeading('Clans');
htmlArticleStart();
?>
These are the registered clan ranks. To register your clan you must be a member of ACSSR. Clans only are shown on the list if they have <?=$minclanplayers?> members who have played in the last fortnight. The score is the sum of the best <?=$minclanplayers?> clan members of each clan.
<?
htmlArticleStop();
include 'static/clans.htm';
htmlStop();
?>
