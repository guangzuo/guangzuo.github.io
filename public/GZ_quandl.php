<?php
   include '../includes/layouts/header.php';
?>


<h1> Step I: Search for Datasets </h1>
  <div>
    <form action="GZ_quandl_query.php" method="post">
      Search Text (required): <input type="text" name="query" value="" />
      <br />
      Database Code: <input type="text" name="database_code" value="" />
      <br />
      Per Page: <input type="text" name="per_page" value="" />
      <br />
      Page: <input type="text" name="page" value="" />
      <br />
      <input type="submit" name="submit" value="Submit1" />
    </form>
  <div>

<h1> Step II: Display and Plot Data </h1>
  <div>
    <form action="GZ_quandl_query.php" method="post">
      Database Code (required): <input type="text" name="database_code" value="" />
      <br />
      Dataset Code (required): <input type="text" name="dataset_code" value="" />
      <br />
      Plot?
      <input type="radio" NAME="plot" VALUE="1">Yes
      <input type="radio" NAME="plot" VALUE="0">No
      <br />
      Limit: <input type="text" name="limit" value="" />
      <br />
      Column Index: <input type="text" name="column_index" value="" />
      <br />
      Order:
      <select name="order" >
        <option value="asc">Ascending</option>
        <option value="desc">Descending</option>
      </select>
      <br />
      Collapse:
      <select name="collapse" >
        <option value="none">NONE</option>
        <option value="daily">daily</option>
        <option value="weekly">weekly</option>
        <option value="monthly">monthly</option>
        <option value="quarterly">quarterly</option>
        <option value="annual">annual</option>
      </select>
      <br />
      Transform:
      <select name="transform" >
        <option value="none">NONE</option>
        <option value="diff">y[t]-y[t-1]</option>
        <option value="rdiff">(y[t]-y[t-1])/y[t-1]</option>
        <option value="rdiff_from">(y[n]-y[t])/y[t]</option>
        <option value="cumul">y[t]+y[t-1]+…+y[0]</option>
        <option value="normalize">(y[t]/y[0])*100</option>
      </select>
      <br />
      <input type="submit" name="submit" value="Submit2" />
    </form>
  <div>



<?php
  include("../includes/layouts/footer.php");
?>
