<?php
   include '../includes/layouts/header.php';

   require_once "../includes/_lib/Quandl.php";
?>

<div>
  <?php
  	//--------------------------------------------------------------
  	// Examples: Quandl API
  	//--------------------------------------------------------------
  	$api_key = "iCAfcho7CugzhSxWHxsL";

    //var_dump($_POST);

    if (!$api_key) {
        throw new Exception('Your API key has not been set.
                  Read https://www.quandl.com/account/api.');
    }

    $submit = $_POST["submit"];
    switch ($submit) {
      case 'Submit1':
        // set default Values
        $query = $_POST["query"];
        !isset($_POST["per_page"])? $per_page = 300:  $per_page = $_POST["per_page"];
        !isset($_POST["page"])? $page = 1:  $page = $_POST["page"];
        if (isset($_POST["database_code"])) {
          $database_code = $_POST["database_code"];
        }
        // get search results
        $quandl = new Quandl($api_key);
        $dta = $quandl->getSearch($query, $page, $per_page, $database_code);
        $dta1 = json_encode((array)$dta, true);
        $dta1 = json_decode($dta1, true);
        //var_dump($dta1);
        $dta = $dta1;
        for($i = 0; $i < sizeof($dta1["datasets"]); $i++){
            $dta1["datasets"][$i]["description"] = "";
        }
        echo "<ul>";
          echo "<li>" . "<strong>Description of Datasets:</strong>";
            $sty = "overflow-x:auto;";
            echo "<div style=$sty>";
            echo "<table>";
              echo "<tr>";
                echo "<th> <strong> id: </strong> </th>";
                echo "<th> <strong> Description: </strong> </th>";
              echo "</tr>";

                  for($i = 0; $i < sizeof($dta["datasets"]); $i++){
                    echo "<tr>";
                      echo "<td>{$dta["datasets"][$i]["id"]}</td>";
                      echo "<td>{$dta["datasets"][$i]["description"]}</td>";
                    echo "</tr>";
                  }

            echo "</table>";
            echo "</div>";
            // echo "<ul>";
            // for($i = 0; $i < sizeof($dta["datasets"]); $i++){
            //     echo "<li>" . "<strong> id: </strong>";
            //     echo $dta["datasets"][$i]["id"];
            //     echo "</li>";
            //     var_dump($dta["datasets"][$i]["description"]);
            //     echo "<br />";
            // }
            // echo "</ul>";
            //var_dump($dta1);
            echo "<li>" . "<strong>Detailed Search Results:</strong>";
            echo "<pre>";
            echo json_encode($dta1, JSON_PRETTY_PRINT);
            echo "</pre>";

        echo "</ul>";
          break;
      case 'Submit2':
      $database_code = $_POST["database_code"];
      $dataset_code = $_POST["dataset_code"];
      (!isset($_POST["limit"]))? $limit = null: $limit = $_POST["limit"] ;
      (!isset($_POST["column_index"]))? $column_index = null: $column_index = $_POST["column_index"];
      (!isset($_POST["order"]))? $order = null: $order = $_POST["order"];
      (!isset($_POST["collapse"]))? $collapse = null: $collapse = $_POST["collapse"];
      (!isset($_POST["transform"]))? $transform = "none": $transform = $_POST["transform"];
      (!isset($_POST["plot"]))? $plot = 0: $plot = $_POST["plot"];
      //var_dump($_POST);

      // use Quandl api to retrieve dataset_code
      $quandl = new Quandl($api_key);
      $quandl -> format = "json";
      $symbol = "{$database_code}" . "/" . "{$dataset_code}";
      $params = ["limit" => $limit,
                 "order" => $order,
                 "transform" => $transform,
                 "collapse" => $collapse];
      $data = $quandl -> getSymbol($symbol, $params);
      $obs = json_decode($data, true);

      // make plot

      echo "</ul>";

      echo "<ul>";

            // basic information
            echo "<li>" . "<strong> Info. in Selected Data </strong>"
                 . "</li>";
            echo "<ul>";
                echo "<li>" . "<u>GENERAL INFO.</u>" . "</li>";
                $obs_val = $obs["dataset"];
                foreach ($obs_val as $key => $value) {
                  if ($key!="data" && $key!="column_names") {
                      echo "<strong>{$key}</strong>: {$value}<br />";
                  }
                  if ($key == "column_names"){
                    $i = 0;
                    foreach ($obs_val[$key] as $v) {
                      echo "<strong>column_names_{$i}</strong>: {$v}<br />";
                      $i++;
                    }

                  }
                }

                if ($plot == 1){
                  // display plots
                  echo "<li>" . "<u> Data Plot </u>" . "</li>";

                  $id_name = "data_plot";
                  //$sty = "float:left; width:300px; height:350px; aligh:middle";
                  $sty = "position:relative; width:100%; height:400px";
                  echo "<div id={$id_name} style={$sty}></div>";
                } else {
                  // loop over and display each observation
                  echo "<li>" . "<u>Observation Lists</u>" . "</li>";
                  //var_dump($obs);
                  $sty = "overflow-x:auto;";
                  echo "<div style=$sty>";
                  echo "<table>";
                  echo "<tr>";
                  foreach ($obs_val["column_names"] as $v) {
                    echo "<th>{$v}</th>";
                  }
                  echo "</tr>";

                  $obs = $obs_val["data"];
                  $n_max = count($obs);
                  $m_max = count($obs[0]);
                  for ($k=0; $k < $n_max; $k++) {
                    echo "<tr>";
                      for ($j=0; $j < $m_max; $j++) {
                        echo "<td>";
                        echo $obs[$k][$j];
                        echo "</td>";
                      }
                    echo "</tr>";
                  }
                  // for ($j=0; $j < $i-1; $j++) {
                  //   # code...
                  // }
                  //
                  //
                  echo "</table>";
                }


            echo "</ul>";
      echo "</ul>";














    }    // for swith


  ?>
</div>


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
