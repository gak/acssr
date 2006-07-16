<?

	require_once("include.php");
	header("Content-type: text/css");
	header("Expires: " . gmdate("D, d M Y H:i:s", time() + 86400) . " GMT");
	header("Cache-Control: max-age=86400");

?>
body {

	margin: 0px 0px 0px 0px;
	padding: 0px 0px 0px 0px;
	background-color: black;
	color: black;
	font-family: tahoma, sans-serif;
	font-size: 10px;
	color: #FFFFFF;

}

a {

	color: #FFF600;
	text-decoration: none;

}

a:hover {

	text-decoration: underline;

}

img {

	border: 0;

}

table {

	border-spacing: 1px;
	border-collapse: collapse;
	empty-cells: show;
	width: 100%;

}

td {

	padding: 2px 2px 2px 2px;
	background-color: #116A70;
	font-size: 10px;

}

th {

	padding: 2px 2px 2px 2px;

}

td.alt {

	background-color: #0D5257;

}	

td.total {

	background-color: #000000;
	font-weight: 900;

}

th {

	text-align: left;
	font-size: 12px;

}


<?

global $rank_fields;
foreach($rank_fields as $field) {

?>th.<?=$field[1]?> {

	font-size: 11px;	
	background-color: #000000;
	width: <?=$field[2]?>%;

}

<?}?>


