<?php
// Start the session
session_start();
?>
<!DOCTYPE html>  
<head>
  <title>UPDATE PostgreSQL data with PHP</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>li {list-style: none;}</style>
</head>
<body>
  <h2>Create new project</h2>
  <?php
  if(!empty($_SESSION)){
    echo "<h5>Welcome, ", $_SESSION['first_name'], "</h5>";
    echo "<a href='log_out.php'>Logout</a>";
  } else {
    echo "<h5>You are not logged in.</h5>";
    echo "<h5>Please log in to fund a project</h5>";
    echo "<a href='/crowdfun/log_in.php'>Login<br></a>";
    echo "<a href='create_user.php'>Sign Up</a>";
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
    <form name="display" action="create_project.php" method="POST" >
      <li>Title:</li>
      <li><input type="text" name="title" /></li>
      <li>Description:</li>
      <li><input type="text" name="description" /></li>
       <li>Project ID:</li>
      <li><input type="text" name="project_id" /></li>
      <li>Start date:<li>
      <li><input type="text" name="start_date" /></li>
      <li>Duration:</li>
      <li><input type="text" name="duration" /></li>
      <li>Keywords:</li>
      <li><input type="text" name="keywords" /></li>
      <li>Amount sought:</li>
      <li><input type="text" name="amount_sought" /></li>
      <li>Category:</li>
      <li><input type="text" name="category" /></li>
      <li>Category URL:</li>
      <li><input type="text" name="category_url" /></li>
      <li>Clickthrough URL:</li>
      <li><input type="text" name="clickthrough_url" /></li>
      <li>Image URL:</li>
      <li><input type="text" name="image_url" /></li>
      <li>Is in demand:</li>
      <li><input type="text" name="is_indemand" /></li>
      <li>Product stage:</li>
      <li><input type="text" name="product_stage" /></li>
      <li>Source URL:</li>
      <li><input type="text" name="source_url" /></li>
      <li><input type="submit" name="project" value = "Create" /></li>
    </form>
  </ul>
  <?php
  	// Connect to the database. Please change the password in the following line accordingly
    $db     = pg_connect("host=localhost port=5432 dbname=crowdfun user=postgres password=password");	
    // $result = pg_query($db, "SELECT * FROM project where project.project_id = '$_POST[project_id]'");		// Query template
    // $row    = pg_fetch_adssoc($result);		// To store the result row
    if (isset($_POST['project'])) {
       $result = pg_query($db, "SELECT * FROM project where project.project_id = '$_POST[project_id]'");    // Query template
      if (pg_num_rows($result) == 0) {
        // if project does not already exist
        // Create project
        $result = pg_query($db, "INSERT INTO project VALUES ('$_POST[title]', '$_POST[description]', '$_POST[project_id]', '$_POST[start_date]', '$_POST[duration]', '$_POST[keywords]', '$_POST[amount_sought]', 0, 0, '$_POST[category]', '$_POST[category_url]', '$_POST[clickthrough_url]', '$_POST[image_url]', '$_POST[is_indemand]', '$_POST[product_stage]', '$_POST[source_url]');");

        if (!$result) {
            // echo "Account creation failed!!";
          echo "Project creation failed" . pg_last_error($db);
        } else {
            echo "Project created!";
        }

        $result = pg_query($db, "INSERT INTO creates VALUES ('$_SESSION[email]', '$_POST[project_id]');");

        if (!$result) {
            // echo "Account creation failed!!";
          echo "Failed to insert project into create table" . pg_last_error($db);
        } else {
            echo "Project inserted into create table";
        }

      } else {
        // Project already exists in database
        $result = pg_query($db, "UPDATE project SET title = '$_POST[title]',  
    description = '$_POST[description]',start_date = '$_POST[start_date]',  
    duration = '$_POST[duration]', keywords = '$_POST[keywords]', amount_sought = '$_POST[amount_sought]', category = '$_POST[category]', category_url = '$_POST[category_url]', clickthrough_url = '$_POST[clickthrough_url]', image_url = '$_POST[image_url]', is_indemand = '$_POST[is_indemand]', product_stage = '$_POST[product_stage]', source_url = '$_POST[source_url]' WHERE project_id = '$_POST[project_id]'");
        if (!$result) {
            echo "Update failed!!";
        } else {
            echo "Update successful!";
        }

        // echo "<h3>The given project_id already exists.</h3>";
      }
    }
    // if (isset($_POST['new'])) {	// Submit the update SQL command
    //     $result = pg_query($db, "UPDATE book SET book_id = '$_POST[bookid_updated]',  
    // name = '$_POST[book_name_updated]',price = '$_POST[price_updated]',  
    // date_of_publication = '$_POST[dop_updated]'");
    //     if (!$result) {
    //         echo "Update failed!!";
    //     } else {
    //         echo "Update successful!";
    //     }
    // }
    ?>  
</body>
</html>
