<!DOCTYPE html>  
<head>
  <title>Crowdfun Admin Page</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="stylesheet.css">
  <style>table, th, td {border: 1px solid black;}
          li {list-style: none;}</style>
</head>
<body>
  <h2>Crowdfun Admin</h2>
  <ul>
      <li><a href='admin.php'>Admin Home</a></li>
      <li><a href='admin_edit.php'>Admin Edit</a></li>
      <li><a href='admin_project_summary.php'>Project Insights</a></li>
      <li><a href='admin_user_insights.php'>User Insights</a></li>
      <li><a href='admin_top_users.php'>Top Contributing Users</a></li>
  </ul>
  <ul>
    <form name="display" action="admin.php" method="POST" >
      <li>Search project category:</li>
      <li><input type="text" name="bookid" /></li>
      <li><input type="submit" name="project" value = "Search"/></li>
    </form>
  </ul>
  <?php
  	// Connect to the database. Please change the password in the following line accordingly
    $db     = pg_connect("host=localhost port=5432 dbname=crowdfun user=postgres password=password");	
    // $result = pg_query($db, "SELECT * FROM book where book_id = '$_POST[bookid]'");		// Query template
    $result = pg_query($db, "SELECT * FROM project WHERE category = '$_POST[bookid]';");
    // $row    = pg_fetch_assoc($result);		// To store the result row
    // echo "$row['first_name']";

    if (isset($_POST['project'])) {
      $html = "<h1>Project table</h1><br>
      <table>
      <tr>
      <th>title</th>
      <th>description</th>
      <th>project_id</th>
      <th>start_date</th>
      <th>duration</th>
      <th>keywords</th>
      <th>amount_sought</th>
      <th>amount_collected</th>
      <th>percent_collected</th>
      <th>category</th>
      <th>category_url</th>
      <th>clickthrough_url</th>
      <th>image_url</th>
      <th>is_indemand</th>
      <th>product_stage</th>
      <th>source_url</th>
      </tr>";

      while ($row = pg_fetch_assoc($result)) {
        $html .= "<tr>
        <td>$row[title]</td>
        <td>$row[description]</td>
        <td>$row[project_id]</td>
        <td>$row[start_date]</td>
        <td>$row[duration]</td>
        <td>$row[keywords]</td>
        <td>$row[amount_sought]</td>
        <td>$row[amount_collected]</td>
        <td>$row[percent_collected]</td>
        <td>$row[category]</td>
        <td>$row[category_url]</td>
        <td>$row[clickthrough_url]</td>
        <td>$row[image_url]</td>
        <td>$row[is_indemand]</td>
        <td>$row[product_stage]</td>
        <td>$row[source_url]</td>
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
      <form name="display" action="admin.php" method="POST" >
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

      while ($row = pg_fetch_assoc($result)) {
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

     <ul>
    <form name="display" action="admin.php" method="POST" >
      <li>View All Projects:</li>
      <li><input type="submit" name="viewall" value = "View"/></li>
    </form>
  </ul>

  <?php
    // Connect to the database. Please change the password in the following line accordingly
    $db     = pg_connect("host=localhost port=5432 dbname=crowdfun user=postgres password=password"); 
    $showall = pg_query($db, "SELECT * FROM project;");

    if (isset($_POST['viewall'])) {

    $html = "<h1>Project table</h1><br>
      <table>
      <tr>
      <th>title</th>
      <th>description</th>
      <th>project_id</th>
      <th>start_date</th>
      <th>duration</th>
      <th>keywords</th>
      <th>amount_sought</th>
      <th>amount_collected</th>
      <th>percent_collected</th>
      <th>category</th>
      <th>category_url</th>
      <th>clickthrough_url</th>
      <th>image_url</th>
      <th>is_indemand</th>
      <th>product_stage</th>
      <th>source_url</th>
      </tr>";

      while ($row = pg_fetch_assoc($showall)) {
        $html .= "<tr>
        <td>$row[title]</td>
        <td>$row[description]</td>
        <td>$row[project_id]</td>
        <td>$row[start_date]</td>
        <td>$row[duration]</td>
        <td>$row[keywords]</td>
        <td>$row[amount_sought]</td>
        <td>$row[amount_collected]</td>
        <td>$row[percent_collected]</td>
        <td>$row[category]</td>
        <td>$row[category_url]</td>
        <td>$row[clickthrough_url]</td>
        <td>$row[image_url]</td>
        <td>$row[is_indemand]</td>
        <td>$row[product_stage]</td>
        <td>$row[source_url]</td>
        </tr>";
        
      }

      $html .= "</table>";

      echo $html;
    }
    ?>  

    <ul>
    <form name="display" action="admin.php" method="POST" >
      <li>View All Users:</li>
      <li><input type="submit" name="viewallusers" value = "View"/></li>
    </form>
  </ul>

  <?php
    // Connect to the database. Please change the password in the following line accordingly
    $db     = pg_connect("host=localhost port=5432 dbname=crowdfun user=postgres password=password"); 
    $showallusers = pg_query($db, "SELECT * FROM users;");

    /*if (isset($_POST['reset'])) {
      echo "done";
      exit();
      } */

    if (isset($_POST['viewallusers'])) {
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

      while ($row = pg_fetch_assoc($showallusers)) {
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
