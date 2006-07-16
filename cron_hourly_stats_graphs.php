<?

$debug = 0;
$nohtml = 1;
$noob = 1;

require("include.php");
include('conf_stats.php');

set_time_limit(0);
$labels = null;
$dd = null;

foreach ($hourstats as $v=>$stat) {

	$id = $stat[0];
	$data = getData($id,24,$labels,'ga',$dd);
	
	// 24 hours
	$g = gNew();
	$g->xaxis->SetTickLabels($labels);
	$g->xaxis->SetTextLabelInterval(4);
	gAddLine($g, $data);
	$g->Stroke("stats/$id-day-small.png");
	
	$g = gNew();
	$g->xaxis->SetTickLabels($labels);
	$g->xaxis->SetTextLabelInterval(4);
	gAddLine($g, $dd);
	$g->Stroke("stats/$id-day-diff-small.png");

	// Week
	$data = getData($id,24*7,$labels,'D',$dd);
	
	$g = gNew();
	$g->xaxis->SetTickLabels($labels);
	$offset = -(now() - today()) / 3600;
	$g->xaxis->SetTextTickInterval(24, $offset+24);
	gAddLine($g, $data);
	$g->Stroke("stats/$id-week-small.png");
	
	$g = gNew();
	$g->xaxis->SetTickLabels($labels);
	$offset = -(now() - today()) / 3600;
	$g->xaxis->SetTextTickInterval(24, $offset+24);
	gAddLine($g, $dd);
	$g->Stroke("stats/$id-week-diff-small.png");

	// Month 
	$data = getData($id,24*30,$labels,'j M',$dd);
	
	$g = gNew();
	$g->xaxis->SetTickLabels($labels);
	$offset = -(now() - today()) / 3600;
	$g->xaxis->SetTextTickInterval(24*7, $offset+24);
	gAddLine($g, $data);
	$g->Stroke("stats/$id-month-small.png");
	
	$g = gNew();
	$g->xaxis->SetTickLabels($labels);
	$offset = -(now() - today()) / 3600;
	$g->xaxis->SetTextTickInterval(24*7, $offset+24);
	gAddLine($g, $dd);
	$g->Stroke("stats/$id-month-diff-small.png");

	// Year
	$data = getData($id,24*365,$labels,'M',$dd);
	
	$g = gNew();
	$g->xaxis->SetTickLabels($labels);
	$offset = -(now() - today()) / 3600;
	$g->xaxis->SetTextTickInterval(24*30, $offset+24);
	gAddLine($g, $data);
	$g->Stroke("stats/$id-year-small.png");
	
	$g = gNew();
	$g->xaxis->SetTickLabels($labels);
	$offset = -(now() - today()) / 3600;
	$g->xaxis->SetTextTickInterval(24*30, $offset+24);
	gAddLine($g, $dd);
	$g->Stroke("stats/$id-year-diff-small.png");

}
	
function getData($id, $samples, &$labels, $lformat, &$diffdata) {

	global $db;

	// sleep here to lower the spike in cpu usage
	sleep(5);
	
	$samples++;
	$res = $db->query("select * from statshourly where stat = {$id} order by hour desc limit $samples");
	$data = Array();
	$diffdata = Array();
	$labels = Array();
	for ($i = 0; $i < $samples; $i++) {
		$data[$i] = null;
		$diffdata[$i] = null;
		$labels[$i] = '';
	}
	$i = $samples-1;
	$lastvalue = null;
	while (($dat = $db->fetchobject())) {
		$data[$i] = $dat->value;
		if (!$lastvalue) $lastvalue = $data[$i];
		$diffdata[$i] = $lastvalue - $data[$i]; 
		$lastvalue = $data[$i];
		$labels[$i] = date($lformat,$dat->hour);
		$i--;
	}
	$labels[$samples-1] = "Now";

	return $data;
	
}
	
function gAddLine(&$g, $data) {

	 $plot = new LinePlot($data);
	 $plot->SetColor('#002020'); 
	 $g->Add($plot);

}

function gNew() {

    $graph = new Graph(250*1.0, 1.0*100,"auto");

    $graph->SetScale("textlin");

    $graph->SetMargin(50,12,10,0);

	#if ($historymode == 0) {
	#    $graph->xaxis->SetTextLabelInterval(2);
	#} else if ($historymode == 1) {
	#  $graph->xaxis->SetTextLabelInterval(10);
	#}

    $graph->xaxis->SetColor("#ffffff");
    $graph->yaxis->SetColor("#ffffff");
    $graph->SetFrame(true, 'darkblue', 0);
    $graph->SetMarginColor('#116A70');
    $graph->SetColor('#1CADB6');

	return $graph;	

}

?>
