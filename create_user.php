<!DOCTYPE html>  
<head>
  <title>UPDATE PostgreSQL data with PHP</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>li {list-style: none;}</style>
</head>
<body>
  <h2>Create new user account</h2>
  <ul>
    <form name="display" action="create_user.php" method="POST" >
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
      <li><input type="submit" name="create" value = "Create" /></li>
    </form>
  </ul>
  <?php
  	// Connect to the database. Please change the password in the following line accordingly
    $db     = pg_connect("host=localhost port=5432 dbname=crowdfun user=postgres password=password");	
    $result = pg_query($db, "SELECT * FROM users where users.email = '$_POST[email]'");		// Query template
    $row    = pg_fetch_assoc($result);		// To store the result row
    if (isset($_POST['create'])) {
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