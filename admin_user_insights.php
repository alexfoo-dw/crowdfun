<!DOCTYPE html>  
<head>
  <title>Crowdfun Admin Page</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>li {list-style: none;}</style>
</head>
<body>
  <h2>Crowdfun Admin</h2>
    <ul>
    <form name="display" action="admin_user_insights.php" method="POST" >
      <li>View Metric:</li>
      <!-- list metrics here -->
      <!-- list users who funded all projects -->
      <li><input type="submit" name="insight" value = "user_fund_all"/></li>
      <li><input type="submit" name="insight" value = "user_not_funded_any"/></li>
      <li><input type="submit" name="insight" value = "user_not_created_any"/></li>
      <li><input type="submit" name="insight" value = "user_all"/></li>
    </form>
  </ul>

  <?php
    // Connect to the database. Please change the password in the following line accordingly
    $db     = pg_connect("host=localhost port=5432 dbname=crowdfun user=postgres password=password"); 
    $insight_type = $_POST['insight'];
    $metrics;
    // fetch data according to insight requested
    switch ($insight_type) {
      case "user_fund_all":
        $metrics = pg_query($db, "SELECT * FROM users u WHERE NOT EXISTS (SELECT * FROM project p WHERE NOT EXISTS (SELECT * FROM funds f WHERE u.email = f.u_email AND p.project_id = f.p_projectid ));");    
        break;
      case "user_not_funded_any":
        $metrics = pg_query($db, "SELECT * FROM users u WHERE NOT EXISTS (SELECT * FROM funds f INNER JOIN project p ON u.email = f.u_email AND p.project_id = f.p_projectid );");    
        break;
      case "user_not_created_any":
        $metrics = pg_query($db, "SELECT * FROM users u WHERE NOT EXISTS (SELECT * FROM creates c INNER JOIN project p ON u.email = c.u_email AND p.project_id = c.p_projectid );");    
        break;
      case "user_all":
        $metrics = pg_query($db, "SELECT * FROM users;");
        break;
    }
    
    if (isset($_POST['insight'])) {
      $html = "";
      $html .= "<h1>Users table</h1><br>
      <table>
      <tr>
      <th>first_name</th>
      <th>last_name</th>
      <th>password</th>
      <th>email</th>
      <th>dob</th>
      <th>since</th>
      <th>birth_country</th>
      <th>phone</th>
      </tr>";

      // $result = pg_query($db, "SELECT * FROM users;");

      while ($row = pg_fetch_assoc($metrics)) {
        $html .= "<tr>
        <td>$row[first_name]</td>
        <td>$row[last_name]</td>
        <td>$row[password]</td>
        <td>$row[email]</td>
        <td>$row[dob]</td>
        <td>$row[since]</td>
        <td>$row[birth_country]</td>
        <td>$row[phone]</td>
        </tr>";
        
      }
      $html .= "</table>";


      echo $html;

    }

    ?>
</body>
</html>