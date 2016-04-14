<?php
//make a simple plot, include the code
require_once 'phplot.php';

// $url = 'http://api.bls.gov/publicAPI/v2/timeseries/data/';
// $method = 'POST';
// $query = array(
//     'seriesid'  => array('LEU0254555900', 'APU0000701111'),
//     'startyear' => '2002',
//     'endyear'   => '2012'
// );
// $pd = json_encode($query);
// $contentType = 'Content-Type: application/json';
// $contentLength = 'Content-Length: ' . strlen($pd);
//
// $result = file_get_contents(
//     $url, null, stream_context_create(
//         array(
//             'http' => array(
//                 'method' => $method,
//                 'header' => $contentType . "\r\n" . $contentLength . "\r\n",
//                 'content' => $pd
//             ),
//         )
//     )
// );
//
// var_dump($http_response_header);
// var_dump($result);
// echo $result;

$jsondata = file_get_contents("bls.json");
//$jsondata = $result;
$json = json_decode($jsondata, true);
$data1 = $json["Results"]["series"][0]; // first data series

//Define some data
$plot_data = array();

foreach($data1['data'] as $years) {

    $output = "";
    $output .= "year: ". $years['year'];
    $output .= "value: ". $years['value']. "<br />";
    //echo $output;
    $yr = $years['year'];
    $val = $years['value'];
    $plot_data[] = array($yr, $val);
    //print_r($plot_data);
    //echo "<br />";
}

//Re-arrange year in ascending order
$plot_data = array_reverse($plot_data);

//Define the object
$plot = new PHPlot();
$plot -> SetDataValues($plot_data);

//Set titles
$title = "Time Series Plot of ";
$title .= $data1['seriesID'];
$plot->SetTitle($title);
$plot->SetXTitle('YEAR');
$plot->SetYTitle('value');

//Turn off X axis ticks and labels because they get in the way:
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');

//Draw it
$plot->DrawGraph();


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	  "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
      <head>
	    <title>CPI Index</title>
      </head>
      <body>


      </body>


</html>
