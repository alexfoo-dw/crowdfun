<!DOCTYPE html>  
<head>
  <title>Crowdfun Admin Page</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="stylesheet.css">
  <style>li {list-style: none;}</style>
</head>
<body>
  <h2>Crowdfun Admin</h2>
  <h3>User Insights</h3>
    <ul>
      <li><a href='admin.php'>Admin Home</a></li>
      <li><a href='admin_edit.php'>Admin Edit</a></li>
      <li><a href='admin_project_summary.php'>Project Insights</a></li>
      <li><a href='admin_user_insights.php'>User Insights</a></li>
      <li><a href='admin_top_users.php'>Top Contributing Users</a></li>
  </ul>
    <ul>
    <form name="display" action="admin_user_insights.php" method="POST" >
      <li>View Metric:</li>
      <!-- list metrics here -->
      <!-- list users who funded all projects -->
      <li><input type="submit" name="insight" value = "user_fund_all"/>Users who funded all projects</li>
      <li><input type="submit" name="insight" value = "user_not_funded_any"/>Users who have yet to fund any projects</li>
      <li><input type="submit" name="insight" value = "user_not_created_any"/>Users who have yet to create any project</li>
      <li><input type="submit" name="insight" value = "user_all"/>Display all users</li>
      <h5>Users who have funded this category</h5>
      <select name = "category">
        <option value="Art">Art</option>
        <option value="Audio">Audio</option>
        <option value="Camera Gear">Camera Gear</option>
        <option value="Comics">Comics</option>
        <option value="Energy & Green Tech">Energy & Green Tech</option>
        <option value="Fashion & Wearables">Fashion & Wearables</option>
        <option value="Film">Film</option>
        <option value="Food & Beverages">Food & Beverages</option>
        <option value="Health & Fitness">Health & Fitness</option>
        <option value="Home">Home</option>
        <option value="Phones & Accessories">Phones & Accessories</option>
        <option value="Productivity">Productivity</option>
        <option value="Tabletop Games">Tabletop Games</option>
        <option value="Transportation">Transportation</option>
        <option value="Travel & Outdoors">Travel & Outdoors</option>
        <option value="Video Games">Video Games</option>
      </select>
      <input type="submit" name="insight" value = "user_fund_category"/>
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
      case "user_fund_category":
        $metrics = pg_query($db, "SELECT * FROM users u WHERE EXISTS (SELECT * FROM funds f INNER JOIN project p ON p.category = '$_POST[category]' AND p.project_id = f.p_projectid AND u.email = f.u_email );");    
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