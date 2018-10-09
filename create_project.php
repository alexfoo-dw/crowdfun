<!DOCTYPE html>  
<head>
  <title>UPDATE PostgreSQL data with PHP</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>li {list-style: none;}</style>
</head>
<body>
  <h2>Create new project</h2>
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
    $result = pg_query($db, "SELECT * FROM project where project.project_id = '$_POST[project_id]'");		// Query template
    // $row    = pg_fetch_adssoc($result);		// To store the result row
    if (isset($_POST['project'])) {
      if (pg_num_rows($result) == 0) {
        // Create account
        $result = pg_query($db, "INSERT INTO project VALUES ('$_POST[title]', '$_POST[description]', '$_POST[project_id]', '$_POST[start_date]', '$_POST[duration]', '$_POST[keywords]', '$_POST[amount_sought]', 0, 0, '$_POST[category]', '$_POST[category_url]', '$_POST[clickthrough_url]', '$_POST[image_url]', '$_POST[is_indemand]', '$_POST[product_stage]', '$_POST[source_url]');");
        if (!$result) {
            // echo "Account creation failed!!";
          echo pg_last_error($db);
        } else {
            echo "Project created!";
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