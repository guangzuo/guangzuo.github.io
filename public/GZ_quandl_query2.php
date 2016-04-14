<?php
   include '../includes/layouts/header.php';
?>

<?php
	//--------------------------------------------------------------
	// Examples: Quandl API
	//--------------------------------------------------------------
	require_once "../includes/_lib/Quandl.php";
	$api_key = "iCAfcho7CugzhSxWHxsL";
	//$symbol  = "GOOG/NASDAQ_AAPL";
  $symbol = "NBSC/A06060117_A";
  // $params = ["start_date" => '2012-11-01',
  //            "end_date" => '2012-11-30'];
  $params = ["sort_order" => "asc"];
	// Modify this call to check different samples
	$data = example2($api_key, $symbol, $params);
  $obs = json_decode($data, true);
  $obs_val = $obs["dataset"]["data"];


  $id_name = "data_plot";
  $sty = "float:left; width:500px; height:350px; aligh:middle";
  echo "<ul>";
  echo "<li>" . "<u> Data Plot </u>" . "</li>";
  echo "<div id={$id_name} style={$sty}></div>";

  echo "</ul>";

  var_dump($obs_val);
	// Example 1: Hello Quandl
	// Example 2: API Key + JSON
	function example2($api_key, $symbol, $params) {
		$quandl = new Quandl($api_key);
		$quandl->format = "json";
		return $quandl->getSymbol($symbol, $params);
	}
	// Example 3: Date Range + Last URL
	function example3($api_key, $symbol) {
		$quandl = new Quandl($api_key);
		print $quandl->last_url;
		return $quandl->getSymbol($symbol, [
			"trim_start" => "today-30 days",
			"trim_end"   => "today",
		]);
	}
	// Example 4: CSV + More parameters
	function example4($api_key, $symbol) {
		$quandl = new Quandl($api_key, "csv");
		return $quandl->getSymbol($symbol, [
			"sort_order"      => "desc", // asc|desc
			"exclude_headers" => true,
			"rows"            => 10,
			"column"          => 4, // 4 = close price
		]);
	}
	// Example 5: XML + Frequency
	function example5($api_key, $symbol) {
		$quandl = new Quandl($api_key, "xml");
		return $quandl->getSymbol($symbol, [
			"collapse" => "weekly" // none|daily|weekly|monthly|quarterly|annual
		]);
	}
	// Example 6: Search
	function example6($api_key, $symbol) {
		$quandl = new Quandl($api_key);
		return $quandl->getSearch("crude oil");
	}
	// Example 7: Symbol Lists
	function example7($api_key, $symbol) {
		$quandl = new Quandl($api_key, "csv");
		return $quandl->getList("WIKI", 1, 10);
	}
	// Example 8: Error Handling
	function example8($api_key, $symbol) {
		$quandl = new Quandl($api_key, "csv");
		$result = $quandl->getSymbol("DEBUG/INVALID");
		if($quandl->error and !$result)
			return $quandl->error . " - " . $quandl->last_url;
		return $result;
	}
?>

<script>
  var $obs = <?php echo json_encode($obs) ?>;

  var $obs_val = $obs["dataset"]["data"];

      var date = new Array($obs_val.length);
      var value = new Array($obs_val.length);
      for (i = 0; i < $obs_val.length; i++) {
          date[i] = $obs_val[i][0];;
          value[i] = $obs_val[i][1];
          // window.alert(date[i]);
          // window.alert(value[i]);
      }

      var layout = {
        autosize: true,
        width: 800,
        height: 450,
        margin: {
          l: 35,
          r: 35,
          b: 35,
          t: 35,
          pad: 4
        }
      };
      PLOT_HERE = document.getElementById('data_plot');
    	Plotly.plot( PLOT_HERE,
                   [{x: date, y: value}],
                   layout);

</script>


<?php
  include("../includes/layouts/footer.php");
?>
