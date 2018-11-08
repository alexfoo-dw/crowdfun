<!DOCTYPE html>
<head>
  <title>Admin Project Summary</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="stylesheet.css">
  <style>li {list-style: none;}</style>
</head>
<body>
  <h2>Crowdfun Admin</h2>
  <h3>View Every Project Summary </h3>
    <ul>
      <li><a href='admin.php'>Admin Home</a></li>
      <li><a href='admin_edit.php'>Admin Edit</a></li>
      <li><a href='admin_project_summary.php'>Project Insights</a></li>
      <li><a href='admin_user_insights.php'>User Insights</a></li>
      <li><a href='admin_top_users.php'>Top Contributing Users</a></li>
  </ul>
  <ul>
    <form name="display" action="admin_project_summary.php" method="POST" >
      <li>View Project Summary:</li>
      <li><input type="submit" name="project" value = "View" /></li>
    </form>
  </ul>

  <?php
  ini_set('display_errors',1);
  error_reporting(E_ALL);
    $db     = pg_connect("host=localhost port=5432 dbname=crowdfun user=postgres password=password");
    $result = pg_query($db, "SELECT p1.title, sum(p1.amount_sought) as amount_sought, sum(p1.amount_collected) as amount_collected
    						 FROM project p1 GROUP BY p1.title");   // Query template

    if (isset($_POST['project'])) {
      $html = "";
      $html = "<h1>Project Summary Table</h1><br>
      <table>
      <tr>
      <th>title</th>
      <th>total_amount_sought</th>
      <th>total_amount_collected</th>

      </tr>";

      while ($row = pg_fetch_assoc($result)) {
        $html .= "<tr>
        <td>$row[title]</td>
        <td>$row[amount_sought]</td>
		    <td>$row[amount_collected]</td>

        </tr>";
      }

      $html .= "</table>";
      echo $html;
  }
  ?>



</body>
</html>
