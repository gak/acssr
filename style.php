<?
	$ct = 60*60*24*14;
	header("Content-type: text/css");
	header("Expires: " . gmdate("D, d M Y H:i:s", time() + $ct) . " GMT");
	header("Cache-Control: max-age=$ct");
?>
body {

	margin: 0px 0px 0px 0px;
	padding: 0px 0px 0px 0px;
	background-image: url("img/title.png");
	background-repeat: no-repeat;
	background-color: black;
	color: black;
	font-family: tahoma, sans-serif;
	font-size: 13px;
	color: #FFFFFF;

}

form {

	padding: 0px 0px 0px 0px;
	margin: 0px 0px 0px 0px;

}

ul {
	margin-left: 10px;
	padding-left: 0px;
}

li {

	list-style: square inside;
	text-indent: 0px;

}

body.tracker {

	background-image: none;
	height: 100%;

}

table.tracker {

	width: 100%;
	height: 100%;
	padding: 0px 0px 0px 0px;
	margin: 0px 0px 0px 0px;

}

td.tracker {

	background-color: #158289;
	padding: 0px 0px 0px 0px;
	margin: 0px 0px 0px 0px;

}

a {

	color: #FFF600;
	text-decoration: none;

}

a:hover {

	text-decoration: underline;

}

a.ausourcelink {

	color: #FFA000;

}

a.navigation {

	width: 300px;
	font-weight: bold;
	border-right: 1px solid white;
	padding: 2px 20px 2px 20px;

}

a.navigation:hover {

	background-color: #FFF;
	color: #000;
	text-decoration: none;

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
	font-size: 11px;

}

th {

	padding: 2px 2px 2px 2px;

}

td.alt {

	background-color: #0D5257;

}	

td.total {

/*	background-color: #0D4247;*/
	background-color: #000000;
	font-weight: 900;

}

td.graph {

	text-align: center;

}

th {

	text-align: left;
	font-size: 13px;

}

table.legend {

	border: 1px solid black;

}


td.legend1 {

	width: 12px;
	height: 10px;
	background-color: #F00020;

}


td.legend2 {

	width: 12px;
	height: 10px;
	background-color: #20F010;

}


td.legend3 {

	width: 12px;
	height: 10px;
	background-color: #000000;

}


td.legend4 {

	width: 12px;
	height: 10px;
	background-color: #1010F0;

}


td.legend5 {

	width: 12px;
	height: 10px;
	background-color: #F0F010;

}


td.legend6 {

	width: 12px;
	height: 10px;
	background-color: #FFFFFF;

}


td.legend7 {

	width: 12px;
	height: 10px;
	background-color: #C010F0;

}


td.legend8 {

	width: 12px;
	height: 10px;
	background-color: #FF8400;

}


td.legend9 {

	width: 12px;
	height: 10px;
	background-color: #A0A0A0;

}


td.legend10 {

	width: 12px;
	height: 10px;
	background-color: #794700;

}

th {
	font-size: 11px;	
	background-color: #0D3237;
}

th.rank {

	font-size: 11px;	
	background-color: #0D3237;
	width: 5%;

}
th.ename {

	font-size: 11px;	
	background-color: #0D3237;
	width: 30%;

}
th.score {

	font-size: 11px;	
	background-color: #0D3237;
	width: 10%;

}
th.ppm {

	font-size: 11px;	
	background-color: #0D3237;
	width: 5%;

}
th.totalfrags {

	font-size: 11px;	
	background-color: #0D3237;
	width: 5%;

}
th.minutes {

	font-size: 11px;	
	background-color: #0D3237;
	width: 5%;

}
th.seconds {

	font-size: 11px;	
	background-color: #0D3237;
	width: 5%;

}
th.server {

	font-size: 11px;	
	background-color: #0D3237;
	width: 30%;

}

table.outline {

	width: 1000px;
	padding: 0px 0px 0px 0px;
	margin: 0px 0px 0px 0px;

}

td.outlinebody {

	background-color: #158289;
	padding: 0px 10px 0px 10px;
	margin: 0px 0px 0px 0px;

}

table.topoutline {

	width: 1000px;
	background-color: transparent;
	padding: 0px 0px 0px 0px;
	margin: 0px 0px 0px 0px;

}

td.topoutlinebody {

	background-color: transparent;
	padding: 0px 0px 0px 0px;
	margin: 0px 0px 0px 0px;
	text-align: right;

}


div.top {

	height: 65px;
	width: 1px;
	padding: 0px 0px 0px 0px;
	margin: 0px 0px 0px 0px;
	border-spacing: 0px;

}

td.sql {

	vertical-align: top;
	font-family: monospace;
	font-size: 12px;

}

table.error {

	background-color: #000000;
	color: #FFFFFF;
	width: 1024px;
	vertical-align: top;
	font-family: monospace;
	font-size: 12px;

}

td.search {

	width: 200px;
	vertical-align: top;
	text-align: right;
	background-color: #0D3237;

}


td.navigation {

	vertical-align: middle;
	background-color: black;
	background-color: #0D3237;
	padding: 6px 6px 6px 6px;
	padding: 0;

}

td.column {

	width: 50%;
	vertical-align: top;
	background-color: transparent;

}

td.articleheading {

	font-size: 14px;
	background-color: #000000;
	font-weight: 900;

}

div.articlesub {

	font-size: 9px;

}

div.articlebody, td.articlebody {

	font-size: 12px;
	background-color: #0D5257;
	padding: 5px 5px 5px 5px;

}

input,submit,checkbox,select {

	border: solid 1px #000000;
	font-size: 10px;
	background-color: #116A70;
	color: #ffffff;
	background-color: #0D3237;
	margin-right: 10px;
}

submit {
	margin-top: 2px;
}

td.search input {
	font-size: 15px;
	margin: 0;
	padding: 0;
	text-align: right;
	background-color: #0D3237;
}

table.f {

	width: 500px;
	text-align: left;

}

td.f {

	padding: 5px 5px 5px 5px;

}



div.code {

	font-family: monospace;
	background-color: black;
	padding: 5px 5px 5px 5px;

}

.hline1 {
    height: 7px;
    display: table-cell;
    background-color: #0B2;
}

.hline2  {
    height: 7px;
    display: table-cell;
    background-color: #000;
}

.ppm1 {
	border: 1px solid black;
    height: 7px;
    display: table-cell;
	background-color: #0F0;
}

.ppm2 {
	border: 1px solid black;
    height: 7px;
    display: table-cell;
	background-color: #0A0;
}

