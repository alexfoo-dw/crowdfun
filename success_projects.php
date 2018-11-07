<?php
// Start the session
session_start();
?>
<!DOCTYPE html>  
<head>
  <title>Successful Projects</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="stylesheet.css">
  <style>li {list-style: none;}</style>
</head>
<body>
  <h2>Crowdfun</h2>
  <?php
  if(!empty($_SESSION)){
    echo "<h5>Welcome, ", $_SESSION['first_name'], "</h5>";
    echo "<a href='log_out.php'>Logout</a>";
  } else {
    echo "<h5>You are not logged in.</h5>";
    echo "<span class='buttons'><a href='/crowdfun/log_in.php'>Login</a></span>";
    echo "<span class='buttons'><a href='create_user.php'>Sign Up</a></span>";
  }
  ?>
  <!--nav-->
  <?php
  if(empty($_SESSION)){
    echo "
          <ul>
            <li><a href='index.php'>Home</a></li>
            <li><a href='success_projects.php'>Successful Projects</a></li>
            <li><a href='create_project.php'>Create a project</a></li>
            <li><a href='fund.php'>Fund a project</a></li>
          </ul>";
  } else {
    echo "
          <ul>
            <li><a href='index.php'>Home</a></li>
            <li><a href='success_projects.php'>Successful Projects</a></li>
            <li><a href='create_project.php'>Create a project</a></li>
            <li><a href='fund.php'>Fund a project</a></li>
            <li><a href='user_view_funded.php'>View your contributed projects</a></li>
            <li><a href='user_view_created.php'>View your created projects</a></li>
          </ul>";
  }
  ?>

  <?php
  
  // Connect to the database. Please change the password in the following line accordingly  
    $db     = pg_connect("host=localhost port=5432 dbname=crowdfun user=postgres password=password");
    $curr_user = $_SESSION['email'];
    $result = pg_query($db, "SELECT * FROM project p WHERE percent_collected >=100;");
    $num_rows = pg_num_rows($result); 
    //$stats = pg_query($db, "SELECT COUNT(*) FROM project p WHERE percent_collected >=100;");
    //$stats_row = pg_fetch_assoc($stats);
    //$sum = $stats_row[sum];
    $html = "<h2>Successful Projects:</h2>
    <h4>Number of successful projects: $num_rows </h4>
      <table>
      <tr>
      <th>Date of Launch</th>
      <th>Project Title</th>
      <th>Project Description</th>
      <th>Amount Sought</th>
      <th>Amount Collected</th>
      <th>Percent Collected</th>
      <th>Category</th>
      </tr>";

    while ($row = pg_fetch_assoc($result)) {
        $html .= "<tr>
        <td>$row[start_date]</td>
        <td>$row[title]</td>
        <td>$row[description]</td>
        <td>$ $row[amount_sought]</td>
        <td>$ $row[amount_collected]</td>
        <td>$row[percent_collected] %</td>
        <td>$row[category]</td>
        </tr>";
      
      $html .="</table";  
      }  
      echo $html;
  ?>

</body>
</html>





