<?php
   include '../includes/layouts/header.php';
?>

<!--
This is the webpage about FRED Economic Data Series -->

<h1> Step I: Search for Time Series </h1>

  <div>
    <!-- form I is  about searching -->
    <form action="fred_query.php" method="post">
      Search Text (required): <input type="text" name="search_text" value="" />
      <br />
      Result Limit: <input type="text" name="limit" value="" />
      <br />
      Clean Results?
      <input type="radio" NAME="beauty" VALUE="1">Yes
      <input type="radio" NAME="beauty" VALUE="0">No
      <br />
      <input type="submit" name="submit" value="Submit1" />
    </form>
  </div>


<h1> Step II: Display or Plot Time Series </h1>
<div>
  <!-- form II is  displaying the data or plot it -->
  <form action="fred_query.php" method="post">
    Data Series (required): <input type="text" name="dat" value="" />
    <br />
    Sort Order?
    <input type="radio" NAME="sort_order" VALUE="asc">Ascending
    <input type="radio" NAME="sort_order" VALUE="desc">Desending
    <br />
    Start Date: <input type="text" name="t0" value=""/> (example: 1776-07-04)
    <br />
    End Date: <input type="text" name="t1" value=""/> (example: 9999-12-31)
    <br />
    Unit of Observations?
    <br />
    <input type="radio" NAME="unit" VALUE="lin">Levels (No transformation)
    <br />
    <input type="radio" NAME="unit" VALUE="chg">Change
    <br />
    <input type="radio" NAME="unit" VALUE="pch">Percent Change
    <br />
    <input type="radio" NAME="unit" VALUE="pc1">Percent Change from Year Ago
    <br />
    <input type="radio" NAME="unit" VALUE="pca">Compounded Annual Rate of Change
    <br />
    <input type="radio" NAME="unit" VALUE="cch">Continuously Compounded Rate of Change
    <br />
    <input type="radio" NAME="unit" VALUE="cca">Continuously Compounded Annual Rate of Change
    <br />
    <input type="radio" NAME="unit" VALUE="log">Natural Log
    <br />
    Frequency?
    <br />
    <input type="radio" NAME="freq" VALUE="d">Daily
    <br />
    <input type="radio" NAME="freq" VALUE="w">Weekly
    <br />
    <input type="radio" NAME="freq" VALUE="bw">Bi-Weekly
    <br />
    <input type="radio" NAME="freq" VALUE="m">Monthly
    <br />
    <input type="radio" NAME="freq" VALUE="q">Quarterly
    <br />
    <input type="radio" NAME="freq" VALUE="sa">Semiannual
    <br />
    <input type="radio" NAME="freq" VALUE="a">Annual
    <br />

    <input type="submit" name="submit" value="Submit2" />
  </form>
</div>

<?php
  include("../includes/layouts/footer.php");
?>
