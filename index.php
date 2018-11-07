<?php
// Start the session
session_start();
?>
<!DOCTYPE html>  
<head>
  <title>Crowdfun Index Page</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="stylesheet.css">
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

  <ul>
    <form name="display" action="index.php" method="POST" >
      <li>Select project category:</li>
      <li><input type="radio" name="category" value="All">All</li>
      <li><input type="radio" name="category" value="Art">Art</li>
      <li><input type="radio" name="category" value="Audio">Audio</li>
      <li><input type="radio" name="category" value="Camera Gear">Camera Gear</li>
      <li><input type="radio" name="category" value="Comics">Comics</li>
      <li><input type="radio" name="category" value="Energy & Green Tech">Energy & Green Tech</li>
      <li><input type="radio" name="category" value="Fashion & Wearables">Fashion & Wearables</li>
      <li><input type="radio" name="category" value="Film">Film</li>
      <li><input type="radio" name="category" value="Food & Beverages">Food & Beverages</li>
      <li><input type="radio" name="category" value="Health & Fitness">Health & Fitness</li>
      <li><input type="radio" name="category" value="Home">Home</li>
      <li><input type="radio" name="category" value="Phones & Accessories">Phones & Accessories</li>
      <li><input type="radio" name="category" value="Productivity">Productivity</li>
      <li><input type="radio" name="category" value="Tabletop Games">Tabletop Games</li>
      <li><input type="radio" name="category" value="Transportation">Transportation</li>
      <li><input type="radio" name="category" value="Travel & Outdoors">Travel & Outdoors</li>
      <li><input type="radio" name="category" value="Video Games">Video Games</li>
      <li><input type="submit" name="project" value="Search"/></li>
    </form>
  </ul>
  <?php
  	// Connect to the database. Please change the password in the following line accordingly
    $db     = pg_connect("host=localhost port=5432 dbname=crowdfun user=postgres password=password");
    // $result = pg_query($db, "SELECT * FROM book where book_id = '$_POST[bookid]'");		// Query template
    if($_POST[category] == "All"){
        $result = pg_query($db, "SELECT * FROM project");  
    } else {
        $result = pg_query($db, "SELECT * FROM project WHERE category = '$_POST[category]';");
    }
    $num_rows = pg_num_rows($result);
    // $row    = pg_fetch_assoc($result);		// To store the result row

    // echo "$row['first_name']";

    if (isset($_POST['project'])) {
      $html = "<h1>Project table</h1>
      <h4>Number of projects: $num_rows</h4>
      <table>
      <tr>
      <th>title</th>
      <th>description</th>
      <th>project_id</th>
      <th>start_date</th>
      <th>amount_sought</th>
      <th>amount_collected</th>
      <th>percent_collected</th>
      <th>category</th>
      </tr>";

      while ($row = pg_fetch_assoc($result)) {
        $html .= "<tr>
        <td>$row[title]</td>
        <td>$row[description]</td>
        <td>$row[project_id]</td>
        <td>$row[start_date]</td>
        <td>$ $row[amount_sought]</td>
        <td>$ $row[amount_collected]</td>
        <td>$row[percent_collected] %</td>
        <td>$row[category]</td>
        </tr>";
        
      }
      $html .= "</table>";
      // $html .= "<h1>Users table</h1><br>
      // <table>
      // <tr>
      // <th>first_name</th>
      // <th>last_name</th>
      // <th>password</th>
      // <th>email</th>
      // <th>dob</th>
      // <th>since</th>
      // <th>birth_country</th>
      // <th>phone</th>
      // </tr>";
      // $html .= "</table>";



      // <ul><form name='update' action='index.php' method='POST' >  
      // <li>Title:</li>  
      // <li><input type='text' name='bookid_updated' value='$row[title]' /></li>  
      // <li>Book Name:</li>  
      // <li><input type='text' name='book_name_updated' value='$row[name]' /></li>  
      // <li>Price (USD):</li><li><input type='text' name='price_updated' value='$row[price]' /></li>  
      // <li>Date of publication:</li>  
      // <li><input type='text' name='dop_updated' value='$row[date_of_publication]' /></li>  
      // <li><input type='submit' name='new' /></li>  
      // </form>  
      // </ul>";
        echo $html;

      // echo "$row['first_name']";
    }
    if (isset($_POST['new'])) {	// Submit the update SQL command
        $result = pg_query($db, "UPDATE book SET book_id = '$_POST[bookid_updated]',  
    name = '$_POST[book_name_updated]',price = '$_POST[price_updated]',  
    date_of_publication = '$_POST[dop_updated]'");
        if (!$result) {
            echo "Update failed!!";
        } else {
            echo "Update successful!";
        }
    }

      // echo "$row[0]";
    ?>  

    <ul>
      <form name="display" action="index.php" method="POST" >
        <li>Search user email:</li>
        <li><input type="text" name="email" /></li>
        <li><input type="submit" name="users" value = "Search"/></li>
      </form>
    </ul>
  <?php
    // Connect to the database. Please change the password in the following line accordingly
    $db     = pg_connect("host=localhost port=5432 dbname=crowdfun user=postgres password=password"); 
    // $result = pg_query($db, "SELECT * FROM book where book_id = '$_POST[bookid]'");    // Query template
    $result = pg_query($db, "SELECT * FROM users WHERE users.email = '$_POST[email]';");
    // $row    = pg_fetch_assoc($result);   // To store the result row

    // echo "$row['first_name']";

    if (isset($_POST['users'])) {
      $html = "";
      $html .= "
      <table>
      <tr>
      <th>first_name</th>
      <th>last_name</th>
      <th>email</th>
      </tr>";

      // $result = pg_query($db, "SELECT * FROM users;");

      while ($row = pg_fetch_assoc($result)) {
        $html .= "<tr>
        <td>$row[first_name]</td>
        <td>$row[last_name]</td>
        <td>$row[email]</td>
        </tr>";
        
      }
      $html .= "</table>";



      // <ul><form name='update' action='index.php' method='POST' >  
      // <li>Title:</li>  
      // <li><input type='text' name='bookid_updated' value='$row[title]' /></li>  
      // <li>Book Name:</li>  
      // <li><input type='text' name='book_name_updated' value='$row[name]' /></li>  
      // <li>Price (USD):</li><li><input type='text' name='price_updated' value='$row[price]' /></li>  
      // <li>Date of publication:</li>  
      // <li><input type='text' name='dop_updated' value='$row[date_of_publication]' /></li>  
      // <li><input type='submit' name='new' /></li>  
      // </form>  
      // </ul>";
        echo $html;

      // echo "$row['first_name']";
    }
    if (isset($_POST['new'])) { // Submit the update SQL command
        $result = pg_query($db, "UPDATE book SET book_id = '$_POST[bookid_updated]',  
    name = '$_POST[book_name_updated]',price = '$_POST[price_updated]',  
    date_of_publication = '$_POST[dop_updated]'");
        if (!$result) {
            echo "Update failed!!";
        } else {
            echo "Update successful!";
        }
    }

      // echo "$row[0]";
    ?>  
</body>
</html>
