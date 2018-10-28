<!DOCTYPE html>
<head>
  <title>Admin Top Users Page</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>li {list-style: none;}</style>
</head>
<body>
  <h1>View Every Project Summary </h1>
  <ul>
    <form name="display" action="admin_project_summary.php" method="POST" >
      <li>View Project Summary:</li>
      <li><input type="submit" name="project" value = "View" /></li>
    </form>
  </ul>

  <?php
    $db     = pg_connect("host=localhost port=5432 dbname=crowdfun user=postgres password=password");
    $result = pg_query($db, "SELECT p1.title, CAST(avg(CAST(p1.start_date AS INT)) AS DATETIME), sum(p1.amount_sought) as amount_sought, sum(p1.amount_collected) as amount_collected
    						 FROM project p1 GROUP BY p1.title");   // Query template

    if (isset($_POST['project'])) {
      $html = "";
      $html = "<h1>Project Summary Table</h1><br>
      <table>
      <tr>
      <th>title</th>
      <th>start_date</th>
      <th>total_amount_sought</th>
      <th>total_amount_collected</th>
      </tr>";

      while ($row = pg_fetch_assoc($result)) {
        $html .= "<tr>
        <td>$row[title]</td>
        <td>$row[DATETIME]</td>
        <td>$row[amount_sought]
		    <td>$row[amount_collected]</td>
        </tr>";
      }

      $html .= "</table>";
      echo $html;
  }
  ?>



</body>
</html>
