<!DOCTYPE html>
<head>
  <title>Admin Edit Page</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>li {list-style: none;}</style>
</head>
<body>
  <h1>Edit Projects and Users</h1>
  <h2>Create Users</h2>
  <ul>
    <form name="display" action="admin_edit.php" method="POST" >
      <li>First name:</li>
      <li><input type="text" name="first_name" /></li>
      <li>Last name:</li>
      <li><input type="text" name="last_name" /></li>
      <li>Password:</li>
      <li><input type="text" name="password" /></li>
      <li>Email:</li>
      <li><input type="text" name="email" /></li>
      <li>Date of birth:</li>
      <li><input type="text" name="dob" /></li>
      <li>Since:</li>
      <li><input type="text" name="since" /></li>
      <li>Birth country:</li>
      <li><input type="text" name="birth_country" /></li>
      <li>Phone number:</li>
      <li><input type="text" name="phone" /></li>
      <li><input type="submit" name="users" value = "Create" /></li>
    </form>
  </ul>

  <?php
    $db     = pg_connect("host=localhost port=5432 dbname=crowdfun user=postgres password=password");
    $result = pg_query($db, "SELECT * FROM users where users.email = '$_POST[email]'");   // Query template
    $row    = pg_fetch_assoc($result);

    if (isset($_POST['users'])) {
      if (pg_num_rows($result) == 0) {
        // Create account
        $result = pg_query($db, "INSERT INTO users VALUES ('$_POST[first_name]', '$_POST[last_name]', '$_POST[password]', '$_POST[email]', '$_POST[dob]', '$_POST[since]', '$_POST[birth_country]', '$_POST[phone]');");
        if (!$result) {
            // echo "Account creation failed!!";
          echo pg_last_error($db);
        } else {
            echo "Account created!";
        }

      } else {
        // Email already exists in database
        echo "<h3>The associated email already has an account.</h3>";
        header('location: admin_edit.php');
      }
    }
  ?>

  <h2>Edit Users</h2>
  <ul>
    <form name="display" action="admin_edit.php" method="POST" >
      <li>Enter email:</li>
      <li><input type="text" name="email" /></li>
      <li><input type="submit" name="submit" /></li>
    </form>
  </ul>
  <?php
  	// Connect to the database. Please change the password in the following line accordingly
    $db     = pg_connect("host=localhost port=5432 dbname=crowdfun user=postgres password=password");
    $result = pg_query($db, "SELECT * FROM users where users.email = '$_POST[email]'");		// Query template
    $row    = pg_fetch_assoc($result);		// To store the result row

    if (isset($_POST['submit'])) {
        echo "<ul><form name='update' action='admin_edit.php' method='POST' >
    	<li>First name:</li>
    	<li><input type='text' name='firstname_updated' value='$row[first_name]' /></li>
    	<li>Last name:</li>
    	<li><input type='text' name='lastname_updated' value='$row[last_name]' /></li>
    	<li>Password:</li><li><input type='text' name='password_updated' value='$row[password]' /></li>
    	<li>Date of birth:</li>
    	<li><input type='text' name='dob_updated' value='$row[dob]' /></li>
      <li>Since:</li>
      <li><input type='text' name='since_updated' value='$row[since]' /></li>
      <li>Birth country:</li>
      <li><input type='text' name='birthcountry_updated' value='$row[birth_country]' /></li>
      <li>Phone number:</li>
      <li><input type='text' name='phone_updated' value='$row[phone]' /></li>
    	<li><input type='submit' name='new' /></li>
    	</form>
    	</ul>";
    }

    if (isset($_POST['new'])) {	// Submit the update SQL command
        $result = pg_query($db, "UPDATE users SET first_name = '$_POST[firstname_updated]',
    last_name = '$_POST[lastname_updated]',password = '$_POST[password_updated]',
    dob = '$_POST[dob_updated]', since = '$_POST[since_updated]', birth_country = '$_POST[birthcountry_updated]', phone = '$_POST[phone_updated]'");
        if (!$result) {
            echo "Update failed!!";
        } else {
            echo "Update successful!";
            header('location: admin_edit.php');
        }
    }
    ?>
    <h2>Edit Project</h2>
    <ul>
      <form name="display" action="admin_edit.php" method="POST" >
        <li>Enter project_id:</li>
        <li><input type="text" name="project_id" /></li>
        <li><input type="submit" name="submit" /></li>
      </form>
    </ul>
    <?php
    	// Connect to the database. Please change the password in the following line accordingly
      $db     = pg_connect("host=localhost port=5432 dbname=crowdfun user=postgres password=password");
      $result = pg_query($db, "SELECT * FROM project where project.project_id = '$_POST[project_id]'");		// Query template
      $row    = pg_fetch_assoc($result);		// To store the result row

      if (isset($_POST['submit'])) {
          echo "<ul><form name='update' action='admin_edit.php' method='POST' >
      	<li>title:</li>
      	<li><input type='text' name='title_updated' value='$row[title]' /></li>
        <li>description:</li>
      	<li><input type='text' name='description_updated' value='$row[description]' /></li>
        <li>start_date:</li>
      	<li><input type='text' name='startdate_updated' value='$row[start_date]' /></li>
        <li>duration:</li>
      	<li><input type='text' name='duration_updated' value='$row[duration]' /></li>
        <li>keywords:</li>
      	<li><input type='text' name='keywords_updated' value='$row[keywords]' /></li>
        <li>amount_sought:</li>
      	<li><input type='text' name='amountsought_updated' value='$row[amount_sought]' /></li>
        <li>amount_collected:</li>
        <li><input type='text' name='amountcollected_updated' value='$row[amount_collected]' /></li>
        <li>percent_collected:</li>
        <li><input type='text' name='percentcollected_updated' value='$row[percent_collected]' /></li>
        <li>category:</li>
        <li><input type='text' name='category_updated' value='$row[category]' /></li>
        <li>category_url:</li>
        <li><input type='text' name='categoryurl_updated' value='$row[category_url]' /></li>
        <li>clickthrough_url:</li>
        <li><input type='text' name='clickthroughurl_updated' value='$row[clickthrough_url]' /></li>
        <li>image_url:</li>
        <li><input type='text' name='imageurl_updated' value='$row[image_url]' /></li>
        <li>is_indemand:</li>
        <li><input type='text' name='isindemand_updated' value='$row[is_indemand]' /></li>
        <li>product_stage:</li>
        <li><input type='text' name='productstage_updated' value='$row[product_stage]' /></li>
        <li>source_url:</li>
        <li><input type='text' name='sourceurl_updated' value='$row[source_url]' /></li>
        <li><input type='submit' name='new2' /></li>
      	</form>
      	</ul>";
      }

      if (isset($_POST['new2'])) {	// Submit the update SQL command
          $result = pg_query($db, "UPDATE project SET
      title = '$_POST[title_updated]',
      description = '$_POST[description_updated]',
      start_date = '$_POST[startdate_updated]',
      duration = '$_POST[duration_updated]',
      keywords = '$_POST[keywords_updated]',
      amount_sought = '$_POST[amountsought_updated]',
      amount_collected = '$_POST[amountcollected_updated]',
      percent_collected = '$_POST[percentcollected_updated]',
      category = '$_POST[category_updated]',
      category_url = '$_POST[categoryurl_updated]',
      clickthrough_url = '$_POST[clickthroughurl_updated]',
      image_url = '$_POST[imageurl_updated]',
      is_indemand = '$_POST[isindemand_updated]',
      product_stage = '$_POST[productstage_updated]',
      source_url = '$_POST[sourceurl_updated]'");
          if (!$result) {
              echo "Update failed!!";
          } else {
              echo "Update successful!";
              header('location: admin_edit.php');
          }
      }
      ?>

      <h2>Delete Project</h2>
      <ul>
        <form name="display" action="admin_edit.php" method="POST" >
          <li>Enter project_id:</li>
          <li><input type="text" name="project_id" /></li>
          <li><input type="submit" name="submit" /></li>
        </form>
      </ul>

      <?php
   // Connect to the database. Please change the password in the following line accordingly
     $db     = pg_connect("host=localhost port=5432 dbname=crowdfun user=postgres password=password");
     $result = pg_query($db, "SELECT project where project.project_id = '$_POST[project_id]'");		// Query template
     $row    = pg_fetch_assoc($result);

     if (isset($_POST['submit'])) {
       $result = pg_query($db, "DELETE project where project.project_id = '$_POST[project_id]'");
     }
     if (!$result) {
         echo "Delete failed!!";
     } else {
         echo "Delete successful!";
         header('location: admin_edit.php');
     }

   ?>





</body>
</html>
