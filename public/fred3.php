<?php
include '../includes/layouts/header.php';
?>


<?php
/*

   Copyright (c) 2009, 2015 Federal Reserve Bank of St. Louis

   This source file is subject to the BSD license,
   that is bundled with this package in the file LICENSE, and is
   available through the world-wide-web at the following url:
   https://research.stlouisfed.org/docs/api/licenses/BSD_LICENSE


 */


// This is an example PHP client for the FRED API.
// It's assumed you have PHP5 and the curl extension installed locally.
// Run this program from the command line using:
//
// php example.php
//
// var_dump is used to print to standard output.

require_once('fred_api.php');



// Read https://research.stlouisfed.org/docs/api/api_key.html to request and view your API key.
// This program with throw an exception if your API key is not set.
// Insert your api key in the line below.
$api_key = "05a9e868c684b3af9a0704be8e02b04b";

if (!$api_key) {
      throw new Exception('Your API key has not been set.  Read https://research.stlouisfed.org/docs/api/api_key.html.');
}

// fred_api is a class object, $api is an instance
$api = new fred_api($api_key);
//// test what's inside
//$methods = get_class_methods('fred_api');
//foreach($methods as $method) {
//      echo "{$method}<br />";
//}

// Create FRED Category API
$category_api = $api->factory('category');
//// test what's inside
//$class = get_class($category_api);
//$vars = get_class_vars($class);
//foreach($vars as $var => $value){
//      echo "{$var}: {$value}<br />";
//}
//$methods = get_class_methods($class);
//foreach($methods as $method) {
//      echo "{$method}<br />";
//}

// Get Category 18: Gross Domestic Product (GDP) and Components
$parameters = array('category_id' => 22, 'file_type' => 'json');
$category = $category_api->get($parameters);
// var_dump($category);
// echo "<br />";


 // Get children categories for category 18: Gross Domestic Product (GDP) and Components
 $category_children = $category_api->children($parameters);
 // var_dump($category_children);
 // echo "<br />";

   // Get the 10 most recently updated quarterly FRED series in category 106:
   // Gross Domestic Product (GDP) and Components > GDP/GNP
   $parameters = array();
   $parameters = array('category_id' => 106, 'order_by' => 'last_updated',
   'sort_order' => 'desc', 'limit' => 10, 'file_type' => 'json',
   'filter_variable' => 'frequency', 'filter_value' => 'Quarterly');
   $series = $category_api->series($parameters);
   // var_dump($series);


   // Create FRED Series API
   $series_api = $api->factory('series');

   // search for economic data series that match keywords

   $param_search = array('file_type' => 'json', 'search_type' => 'full_text',
   'search_text' => 'core PCE', 'limit' => 50);
   $results_search = $series_api -> search($param_search);
   var_dump($results_search);



   // Get series CBIC1: Real Change in Private Inventories, 1 Decimal
   $parameters = array();
   //$parameters = array('series_id' => 'CBIC1', 'realtime_start' => '1990-01-01');
   $parameters = array('series_id' => 'CBIC1', 'file_type' => 'json');
   $series = $series_api->get($parameters);
   //var_dump($series);

   // Get observations for series CBIC1: Real Change in Private Inventories, 1 Decimal
   //$parameters['file_type'] = 'txt';
   //$parameters['file_type'] = 'xls';
   $observations = $series_api->observations($parameters);

   /*
   // If file_type is 'txt' or 'xls'
   // Save binary zip file to the file system.
   $fp = fopen('test.zip', 'w');
   fwrite($fp, $observations);
   fclose($fp);
   */

   //var_dump($observations);




include("../includes/layouts/footer.php");
?>
