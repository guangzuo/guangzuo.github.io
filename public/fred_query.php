<?php
include '../includes/layouts/header.php';
require_once('fred_api.php');
?>

<div>
  <?php

    // Read https://research.stlouisfed.org/docs/api/api_key.html to request and view your API key.
    // This program with throw an exception if your API key is not set.
    // Insert your api key in the line below.
    $api_key = "05a9e868c684b3af9a0704be8e02b04b";

    // fred_api is a class object, $api is an instance
    $api = new fred_api($api_key);

    if (!$api_key) {
          throw new Exception('Your API key has not been set.
                    Read https://research.stlouisfed.org/docs/api/api_key.html.');
    }

    $submit = $_POST["submit"];
    switch ($submit) {
      case 'Submit1':
        // Create FRED Series API
        $series_api = $api->factory('series');

        // search for economic data series that match keywords
        $search_text = $_POST["search_text"];
        (!isset($_POST["limit"]))? $limit = 20 : $limit = $_POST["limit"];
        $param_search = array('file_type' => 'json', 'search_type' => 'full_text',
        'search_text' => $search_text, 'limit' => $limit);
        $results_search = $series_api -> search($param_search);
        $result = json_decode($results_search, true);
        // store the search results regarding series
        $results_series = $result["seriess"];

        echo "<ul>";
              echo "<li>" . "<strong> Values in _POST </strong>" . "</li>";
              foreach ($_POST as $k => $v) {
                echo "{$k}:  {$v}<br />";
              }

        echo "</ul>";
        // test if beautify the json results
        (!isset($_POST["beauty"])) ? $beauty = 0 : $beauty = $_POST["beauty"];
        if ($beauty > 0) {
            // print out the results nicely
            echo "<ul>";
                  echo "<li>" . "<strong> Info. in Search Results </strong>" . "</li>";

                  echo "<ul>";
                  echo "<li>" . "<u>GENERAL INFO.</u>" . "</li>";
                  foreach ($result as $k => $v) {
                    if ($k != "seriess") {
                        echo "{$k}:  {$v}<br />";
                    }
                  }
                  // loop over the info title inside Series
                  echo "<li>" . "<u>ATTRIBUTES of SERIES</u>" . "</li>";
                  foreach ($results_series[0] as $k => $v) {
                      echo "<em>{$k}</em><br />";
                  }
                  echo "</ul>";
            echo "</ul>";

            echo "<ul>";
                  echo "<li>" . "<strong> Related Data Series </strong>" . "</li>";
                  $sty = "overflow-x:auto;";
                  echo "<div style=$sty>";
                  echo "<table>";
                    $prop = array("No.","Seried ID","Title","Date Range",
                                  "Freq.","Units","Adjust");
                    echo "<tr>";
                        foreach ($prop as $nm) {
                          echo "<th>{$nm}</th>";
                        }
                    echo "</tr>";

                  $seq = 1;
                  foreach ($results_series as $data) {
                      echo "<tr>";
                          // sequence id
                          echo "<td>";
                          echo "{$seq}";
                          echo "</td>";
                          // data id
                          echo "<td>";
                          echo "{$data["id"]}";
                          echo "</td>";
                          // data title
                          echo "<td>";
                          echo "{$data["title"]}";
                          echo "</td>";
                          // date range
                          echo "<td>";
                          echo "{$data["observation_start"]}~{$data["observation_end"]}";
                          echo "</td>";
                          // date range
                          echo "<td>";
                          echo "{$data["frequency_short"]}";
                          echo "</td>";
                          // data units
                          echo "<td>";
                          echo "{$data["units_short"]}";
                          echo "</td>";
                          // seasonal adjust
                          echo "<td>";
                          echo "{$data["seasonal_adjustment_short"]}";
                          echo "</td>";
                          $seq ++;
                      echo "</tr>";
                  }
                  echo "</table>";
                  echo "</div>";
            echo "</ul>";


        } else {
          var_dump($results_search);
        }

        break;

      case 'Submit2':
        // Create FRED Series API
        $series_api = $api->factory('series');

        // return data series
        $obs_id = $_POST["dat"];
        !isset($_POST["sort_order"])? $sort_order="asc" : $sort_order = $_POST["sort_order"];
        !isset($_POST["t0"])? $t0="" : $t0 = $_POST["t0"];
        !isset($_POST["t1"])? $t1="" : $t1 = $_POST["t1"];
        !isset($_POST["unit"])? $unit="" : $unit = $_POST["unit"];
        !isset($_POST["freq"])? $freq="" : $freq = $_POST["freq"];
        !isset($_POST["grp"])? $grp="0" : $grp = $_POST["grp"];


        $param_obs = array('series_id' => $obs_id, 'sort_order' => $sort_order,
                     'file_type' => 'json', 'observation_start' => $t0,
                     'observation_end' => $t1, 'units' => $unit,
                     'frequency' => '', 'aggregate_method' => '');
        $obs = $series_api -> observations($param_obs);
        $obs = json_decode($obs, true);

        $obs_val = $obs["observations"];  // this is a json data

        echo "<ul>";
              echo "<li>" . "<strong> Info. in Selected Data </strong>"
                   . "</li>";
              echo "<ul>";
                  echo "<li>" . "<u>GENERAL INFO.</u>" . "</li>";
                  foreach ($obs as $k => $v) {
                    if ($k != "observations") {
                        echo "{$k}:  {$v}<br />";
                    }
                  }
                  // display plots
                  echo "<li>" . "<u> Data Plot </u>" . "</li>";

                  $id_name = "data_plot";
                  $sty = "float:left; width:800px; height:350px; aligh:middle";
                  echo "<div id={$id_name} style={$sty}></div>";

                  // loop over and display each observation
                  echo "<li>" . "<u>Observation Lists</u>" . "</li>";
                  foreach ($obs_val as $v) {
                      echo "{$v["date"]}:  <em>{$v["value"]}</em><br />";
                  }

              echo "</ul>";
        echo "</ul>";




        break;
    }







  ?>
</div>


<script>
    // need to first pass php variable here
    var $obs = <?php echo json_encode($obs) ?>;
    $obs_val = $obs["observations"];

    var date = new Array($obs_val.length);
    var value = new Array($obs_val.length);
    for (i = 0; i < $obs_val.length; i++) {
        date[i] = $obs_val[i]["date"];
        value[i] = $obs_val[i]["value"];
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
