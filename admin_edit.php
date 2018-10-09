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
        }
    }
    ?> 
</body>
</html>
