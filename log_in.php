<?php
// Start the session
session_start();
?>
<!DOCTYPE html>  
<head>
  <title>User log in form</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>li {list-style: none;}</style>
</head>
<body>
  <h2>Log in</h2>
  <?php
  if(!empty($_SESSION)){
    echo "<h5>Welcome, ", $_SESSION['first_name'], "</h5>";
    echo "<a href='log_out.php'>Logout</a>";
  }
  ?>
  <!--nav-->
  <ul>
    <li><a href='index.php'>Home</a></li>
    <li><a href='create_project.php'>Create a project</a></li>
    <li><a href='fund.php'>Fund a project</a></li>
  </ul>
  
  <ul>
    <form name="display" action="log_in.php" method="POST" >
      <li>Email:</li>
      <li><input type="text" name="email" /></li>
      <li>Password:</li>
      <li><input type="text" name="password" /></li>
      <li><input type="submit" name="log_in" value = "Log in" /></li>
    </form>
  </ul>
  <?php
  	// Connect to the database. Please change the password in the following line accordingly
    $db     = pg_connect("host=localhost port=5432 dbname=crowdfun user=postgres password=password");	
    $result = pg_query($db, "SELECT * FROM users where users.email = '$_POST[email]'");		// Query template
    $row    = pg_fetch_assoc($result);		// To store the result row

    if (isset($_POST['log_in'])) {
      // if user exists
      if (pg_num_rows($result) != 0) {
        // check password
        if($row[password] == $_POST[password]){
          $_SESSION["first_name"] = $row[first_name];
          $_SESSION["last_name"] = $row[last_name];
          $_SESSION["email"] = $row[email];
          $_SESSION["password"] = $row[password];
          header('Location: index.php');
        } else {
          echo "<h5>Wrong password, please try again.</h5>";
        }
      } else {
        // Email already exists in database
        echo "<h5>User does not exist</h5>";
      }
    }
    ?>  
</body>
</html>
