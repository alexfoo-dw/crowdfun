<?php
// Start the session
session_start();
?>
<!DOCTYPE html>  
<head>
  <title>User fund form</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>li {list-style: none;}</style>
</head>
<body>
  <h2>Fund Project</h2>
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
  <ul>
    <li><a href='index.php'>Home</a></li>
    <li><a href='create_project.php'>Create a project</a></li>
    <li><a href='fund.php'>Fund a project</a></li>
  </ul>

  <ul>
    <form name="display" action="fund.php" method="POST" >
      <li>Project ID:</li>
      <li><input type="text" name="projectid" /></li>
      <li><input type="submit" name="search" value = "Search" /></li>
    </form>
  </ul>
  <?php
 	// Connect to the database. Please change the password in the following line accordingly	
  	$db     = pg_connect("host=localhost port=5432 dbname=crowdfun user=postgres password=password");
  	$result = pg_query($db, "SELECT * FROM project where project_id = '$_POST[projectid]'");
  	$row    = pg_fetch_assoc($result);		// To store the result row

  	if(isset($_POST['search'])){
  		if(pg_num_rows($result) == 0){
  			echo "<h5>Project does not exist!</h5>";
  		} else {
			$_SESSION['last_funded_project'] = $row;
  			echo "<ul>  
	    	<li>Project Title: $row[title]</li>  
	    	<li>Amount Sought: $row[amount_sought]</li>  
	    	<li>Amount Collected: $row[amount_collected]</li>  
	    	<li>Percentage Funded: $row[percent_collected]</li> 
	    	<li>Fund Amount:</li>
	    	<form name='update' action='fund.php' method='POST'>
	    	<li><input type='text' name='fund_amount' /></li>
	    	<li><input type='submit' name='fund' value= 'Fund'/></li>  
	    	</form>
	    	</ul>";
  		}
  	}
  	if(isset($_POST['fund'])){
  		if ($_POST[fund_amount] < 1){
  			echo "<h5>Please place an amount more than 0.</h5>";
  		} else {
  			$curr_project = $_SESSION['last_funded_project'];
  			$curr_amount = $curr_project[amount_collected];
  			$curr_percent = $curr_project[percent_collected];
  			$new_amount = $curr_amount + $_POST[fund_amount];
  			$new_percent = $new_amount / $curr_project[amount_sought] * 100;
  			$result = pg_query($db, "UPDATE project SET amount_collected = $new_amount, percent_collected = $new_percent WHERE project_id = '$curr_project[project_id]'");
  			if(!$result){
  				echo "Funding Failed!";
  			} else {
  				echo "<h4>Success!</h4>";
	  			echo "<ul>  
		    	<li>Project Title: $curr_project[title]</li>  
		    	<li>Amount Sought: $curr_project[amount_sought]</li>  
		    	<li>New Amount Collected: $new_amount</li>  
		    	<li>New Percentage Funded: $new_percent</li> 
		    	</ul>";
		    }
  		}  	
  	}
  ?>
  <ul>

</body>
</html>





