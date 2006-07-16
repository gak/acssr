<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html dir="{S_CONTENT_DIRECTION}">
<head>
<!-- <meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}"> -->
<meta http-equiv="Content-Type" content="text/html; charset="UTF-8">
<meta http-equiv="Content-Style-Type" content="text/css">
{META}
{NAV_LINKS}
<title>{SITENAME} :: {PAGE_TITLE}</title>
<!-- link rel="stylesheet" href="templates/acssr/{T_HEAD_STYLESHEET}" type="text/css" -->
<style type="text/css">
<!--
/*
  The original acssr Theme for phpBB version 2+
  Created by subBlue design
  http://www.subBlue.com

  NOTE: These CSS definitions are stored within the main page body so that you can use the phpBB2
  theme administration centre. When you have finalised your style you could cut the final CSS code
  and place it in an external file, deleting this section to save bandwidth.
*/

/* General page style. The scroll bar colours only visible in IE5.5+ */
body { 
	background-color: {T_BODY_BGCOLOR};
	scrollbar-face-color: {T_TR_COLOR2};
	scrollbar-highlight-color: {T_TD_COLOR2};
	scrollbar-shadow-color: {T_TR_COLOR2};
	scrollbar-3dlight-color: {T_TR_COLOR3};
	scrollbar-arrow-color:  {T_BODY_LINK};
	scrollbar-track-color: {T_TR_COLOR1};
	scrollbar-darkshadow-color: {T_TH_COLOR1};

        margin: 0px 0px 0px 0px;
        padding: 0px 0px 0px 0px;
}

/* General font families for common tags */
font,th,td,p { font-family: {T_FONTFACE1} }
a:link,a:active,a:visited { color : {T_BODY_LINK}; }
a:hover		{ text-decoration: underline; color : {T_BODY_HLINK}; }
/*hr	{ height: 0px; border: solid {T_TR_COLOR3} 0px; border-top-width: 1px;}*/

/* This is the border line & background colour round the entire page */
.bodyline	{ background-color: #158289; border: 0px {T_TH_COLOR1} solid; }

/* This is the outline round the main forum tables */
.forumline	{ background-color: {T_TD_COLOR2}; border: 2px {T_TH_COLOR2} solid; }

/* Main table cell colours and backgrounds */
td.row1	{ background-color: {T_TR_COLOR1}; }
td.row2	{ background-color: {T_TR_COLOR2}; }
td.row3	{ background-color: {T_TR_COLOR3}; }

/*
  This is for the table cell above the Topics, Post & Last posts on the index.php page
  By default this is the fading out gradiated silver background.
  However, you could replace this with a bitmap specific for each forum
*/
td.rowpic {
		background-color: {T_TD_COLOR2};
		background-image: url(templates/acssr/images/{T_TH_CLASS3});
		background-repeat: repeat-y;
}

/* Header cells - the blue and silver gradient backgrounds */
th	{
	color: {T_FONTCOLOR3}; font-size: {T_FONTSIZE2}px; font-weight : bold; 
	background-color: {T_BODY_LINK}; height: 25px;
	background-image: url(templates/acssr/images/{T_TH_CLASS2});
}

td.cat,td.catHead,td.catSides,td.catLeft,td.catRight,td.catBottom {
			background-image: url(templates/acssr/images/{T_TH_CLASS1});
			background-color:{T_TR_COLOR3}; border: {T_TH_COLOR3}; border-style: solid; height: 28px;
}

/*
  Setting additional nice inner borders for the main table cells.
  The names indicate which sides the border will be on.
  Don't worry if you don't understand this, just ignore it :-)
*/
td.cat,td.catHead,td.catBottom {
	height: 29px;
	border-width: 0px 0px 0px 0px;
}
th.thHead,th.thSides,th.thTop,th.thLeft,th.thRight,th.thBottom,th.thCornerL,th.thCornerR {
	font-weight: bold; border: {T_TD_COLOR2}; border-style: solid; height: 28px;
}
td.row3Right,td.spaceRow {
	background-color: {T_TR_COLOR3}; border: {T_TH_COLOR3}; border-style: solid;
}

th.thHead,td.catHead { font-size: {T_FONTSIZE3}px; border-width: 1px 1px 0px 1px; }
th.thSides,td.catSides,td.spaceRow	 { border-width: 0px 1px 0px 1px; }
th.thRight,td.catRight,td.row3Right	 { border-width: 0px 1px 0px 0px; }
th.thLeft,td.catLeft	  { border-width: 0px 0px 0px 1px; }
th.thBottom,td.catBottom  { border-width: 0px 1px 1px 1px; }
th.thTop	 { border-width: 1px 0px 0px 0px; }
th.thCornerL { border-width: 1px 0px 0px 1px; }
th.thCornerR { border-width: 1px 1px 0px 0px; }

/* The largest text used in the index page title and toptic title etc. */
.maintitle	{
	font-weight: bold; font-size: 18px; font-family: "{T_FONTFACE2}",{T_FONTFACE1};
	text-decoration: none; line-height : 120%; color : {T_BODY_TEXT};
}

a.maintitle, a.maintitle:visited {
	color: #FFFFFF;
}

/* General text */
.gen { font-size : {T_FONTSIZE3}px; }
.genmed { font-size : {T_FONTSIZE2}px; }
.gensmall { font-size : {T_FONTSIZE1}px; }
.gen,.genmed,.gensmall { color : {T_BODY_TEXT}; }
a.gen,a.genmed,a.gensmall { color: {T_BODY_HLINK}; text-decoration: none; }
a.gen:hover,a.genmed:hover,a.gensmall:hover	{ color: {T_BODY_HLINK}; text-decoration: underline; }
.gensmall a, .nav a { color: yellow; }

td.row1 span.gensmall a { color: {T_BODY_LINK}; }
td.row2 span.gensmall a { color: {T_BODY_LINK}; }

.gensmall2 { font-size : {T_FONTSIZE1}px; }
.gen2,.genmed2,.gensmall2 { color : #FFFFFF; }
a.gen2,a.genmed2,a.gensmall2 { color: #FFF600; text-decoration: none; }
a.gen2:hover,a.genmed2:hover,a.gensmall2:hover	{ color: #FFF600; text-decoration: underline; }

/* The register, login, search etc links at the top of the page */
.mainmenu		{ font-size : 11px; color : #FFFFFF; }
a.mainmenu		{ text-decoration: none; color : #FFF600 }
a.mainmenu:hover	{ text-decoration: underline; color : #FFF600; }
td.mainmenu	{

	margin: 0px 0px 0px 0px;
	background-color: #000;
	height: 18px;
}

/* Forum category titles */
.cattitle		{ font-weight: bold; font-size: {T_FONTSIZE3}px ; letter-spacing: 1px; color : {T_BODY_LINK}}
a.cattitle		{ text-decoration: none; color : {T_BODY_LINK}; }
a.cattitle:hover{ text-decoration: underline; }

/* Forum title: Text and link to the forums used in: index.php */
.forumlink		{ font-weight: bold; font-size: {T_FONTSIZE3}px; color : {T_BODY_LINK}; }
a.forumlink 	{ text-decoration: none; color : {T_BODY_LINK}; }
a.forumlink:hover{ text-decoration: underline; color : {T_BODY_HLINK}; }

/* Used for the navigation text, (Page 1,2,3 etc) and the navigation bar when in a forum */
.nav			{ font-weight: bold; font-size: {T_FONTSIZE2}px; color : #FFFFFF; ;}
a.nav, a.nav:visited			{ text-decoration: none; color : #FFF600; } 
a.nav:hover		{ text-decoration: underline; #FFF600; }

.nav2			{ font-weight: bold; font-size: {T_FONTSIZE2}px; color : #000000; ;}
a.nav2			{ text-decoration: none; color : #000000; } 
a.nav2:hover		{ text-decoration: underline; #000000; }


/* titles for the topics: could specify viewed link colour too */
.topictitle,h1,h2	{ font-weight: bold; font-size: {T_FONTSIZE2}px; color : {T_BODY_TEXT}; }
a.topictitle:link   { text-decoration: none; color : {T_BODY_LINK}; }
a.topictitle:visited { text-decoration: none; color : {T_BODY_VLINK}; }
a.topictitle:hover	{ text-decoration: underline; color : {T_BODY_HLINK}; }

/* Name of poster in viewmsg.php and viewtopic.php and other places */
.name			{ font-size : {T_FONTSIZE2}px; color : {T_BODY_TEXT};}

/* Location, number of posts, post date etc */
.postdetails		{ font-size : {T_FONTSIZE1}px; color : {T_BODY_TEXT}; }

/* The content of the posts (body of text) */
.postbody { font-size : {T_FONTSIZE3}px; line-height: 18px}
a.postlink:link	{ text-decoration: none; color : #000000; }
a.postlink:visited { text-decoration: none; color : {T_BODY_VLINK}; }
a.postlink:hover { text-decoration: underline; color : red; }

/* Quote & Code blocks */
.code { 
	font-family: {T_FONTFACE3}; font-size: {T_FONTSIZE2}px; color: {T_FONTCOLOR2};
	background-color: {T_TD_COLOR1}; border: {T_TR_COLOR3}; border-style: solid;
	border-left-width: 1px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px
}

.quote {
	font-family: {T_FONTFACE1}; font-size: {T_FONTSIZE2}px; color: {T_FONTCOLOR1}; line-height: 125%;
	background-color: {T_TD_COLOR1}; border: {T_TR_COLOR3}; border-style: solid;
	border-left-width: 1px; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px
}

/* Copyright and bottom info */
.copyright		{ font-size: {T_FONTSIZE1}px; font-family: {T_FONTFACE1}; color: {T_FONTCOLOR1}; letter-spacing: -1px;}
a.copyright		{ color: {T_FONTCOLOR1}; text-decoration: none;}
a.copyright:hover { color: {T_BODY_TEXT}; text-decoration: underline;}

/* Form elements */
input,textarea, select {
	color : {T_BODY_TEXT};
	font: normal {T_FONTSIZE2}px {T_FONTFACE1};
	border-color : {T_BODY_TEXT};
}

/* The text input fields background colour */
input.post, textarea.post, select {
	background-color : {T_TD_COLOR2};
}

input { text-indent : 2px; }

/* The buttons used for bbCode styling in message post */
input.button {
	background-color : {T_TR_COLOR1};
	color : {T_BODY_TEXT};
	font-size: {T_FONTSIZE2}px; font-family: {T_FONTFACE1};
}

/* The main submit button option */
input.mainoption {
	background-color : {T_TD_COLOR1};
	font-weight : bold;
}

/* None-bold submit button */
input.liteoption {
	background-color : {T_TD_COLOR1};
	font-weight : normal;
}

/* This is the line in the posting page which shows the rollover
  help line. This is actually a text box, but if set to be the same
  colour as the background no one will know ;)
*/
.helpline { background-color: {T_TR_COLOR2}; border-style: none; }

/* Import the fancy styles for IE only (NS4.x doesn't use the @import function) */
@import url("templates/acssr/formIE.css"); 

td.navigation {

    vertical-align: middle;
    background-color: black;
    padding: 0;
	margin: 0;

}


a.navigation, a.navigation:visited {

    font-weight: bold;
    border-right: 1px solid white;
	margin: 0;
    padding: 2px 20px 2px 20px;
    background-color: #116A70;
    background-color: black;
	color: yellow;
	text-decoration: none;
	font-size: 11px;

}

a.navigation:hover {

    background-color: #FFF;
    color: #000;
    text-decoration: none;

}

-->
</style>
<!-- BEGIN switch_enable_pm_popup -->
<script language="Javascript" type="text/javascript">
<!--
	if ( {PRIVATE_MESSAGE_NEW_FLAG} )
	{
		window.open('{U_PRIVATEMSGS_POPUP}', '_phpbbprivmsg', 'HEIGHT=225,resizable=yes,WIDTH=400');;
	}
//-->
</script>
<!-- END switch_enable_pm_popup -->
</head>
<body bgcolor="{T_BODY_BGCOLOR}" text="{T_BODY_TEXT}" link="{T_BODY_LINK}" vlink="{T_BODY_VLINK}">

<a name="top"></a>

<table width="1000" cellspacing="0" cellpadding="0" border="0" align="left"> 
	<tr> 
		<td class="bodyline">

<table width="1000" cellspacing="0" cellpadding="0" border="0">
<tr><td height="65" valign="top" align="right" background="http://acssr.slowchop.com/img/title.png">
<script type="text/javascript"><!--
google_ad_client = "pub-9387561163499032";
google_ad_width = 468;
google_ad_height = 60;
google_ad_format = "468x60_as";
google_ad_type = "text_image";
google_ad_channel ="";
google_color_border = "006666";
google_color_bg = "158289";
google_color_link = "FFFFFF";
google_color_url = "FFF600";
google_color_text = "99FF66";
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
  </script>
</table>
<style>
td.search {

    width: 200px;
    vertical-align: top;
    text-align: right;
    background-color: black;

}

td.search input {
	color: #fff;
    font-size: 13px;
    margin: 0;
    padding: 0;
    text-align: right;
	background-color: #000;
	border: 0px;
}
</style>
<form method="GET" action="/search.php" style="width: 980; padding:0; margin:0; margin-left: 10px; margin-right: 10px;"><table style="width: 100%; background-color: #000;"><tr><td class="navigation"><a class="navigation" href="/">Home</a><a class="navigation" href="/search.php">Search</a><a class="navigation" href="/ladder.php">Ranks</a><a class="navigation" href="/clans.php">Clans</a><a class="navigation" href="/servers.php">Servers</a><a class="navigation" href="/faq.php">FAQ</a><a class="navigation" href="/forum/">Forum</a><a class="navigation" href="/misc.php">Miscellaneous</a>
<td class="search"><input type="text" name="search" value="search for a player"
onfocus="if (this.value == 'search for a player') this.value = '';"
>
</table>

<table width="980" cellspacing="0" border="0" align="center" style="padding-top: 2px;"><tr><td align="left" valign="top" class="mainmenu">
<a class="navigation" hreF="/forum/">Index</a><a class="navigation" href="{U_SEARCH}">{L_SEARCH}</a><!--<a class="navigation" href="{U_MEMBERLIST}">{L_MEMBERLIST}</a>--><a class="navigation" href="{U_REGISTER}">{L_REGISTER}</a><a class="navigation" href="{U_PROFILE}">{L_PROFILE}</a><a class="navigation" href="{U_PRIVATEMSGS}">{PRIVATE_MESSAGE_INFO}</a><a class="navigation" href="{U_LOGIN_LOGOUT}">{L_LOGIN_LOGOUT}</a>
</table></form><table width="1000" cellspacing="0" border="0" style="padding: 0 10 0 10;"><tr><td>
