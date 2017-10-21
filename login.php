<?php # Script 9.10 - login.php (4th version after Scripts 9.1, 9.3 & 9.6)
// Send NOTHING to the Web browser prior to the session_start() line!

// Check if the form has been submitted.
if (isset($_POST['submitted'])) {

	// Make the connection.
	$dbc = mysqli_connect ('localhost', 'root', '', 'git') 
	OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

	/*// Select the database.
	mysqli_select_db ($dbc, 'git') 
	OR die ('Could not select the database: ' . mysqli_connect_error() );*/
		
	$errors = array(); // Initialize error array.
	
	// Check for an email address.
	if (empty($_POST['username'])) {
		$errors[] = 'You forgot to enter your username.';
	} else {
		$e =$_POST['username'];
	}
	
	// Check for a password.
	if (empty($_POST['password'])) {
		$errors[] = 'You forgot to enter your password.';
	} else {
		$p =$_POST['password'];
	}
	
	if (empty($errors)) { // If everything's OK.

		/* Retrieve the user_id and first_name for 
		that email/password combination. */
		$query = "SELECT username FROM users WHERE username='$e' AND password='$p'";		
		$result = @mysqli_query ($dbc, $query); // Run the query.
		$row = mysqli_fetch_array ($result, MYSQLI_NUM); // Return a record, if applicable.

		if ($row) { // A record was pulled from the database.
				
			/*// Set the session data & redirect.
			session_name ('YourVisitID');
			session_start();
			$_SESSION['user_id'] = $row[0];
			$_SESSION['fname'] = $row[1];*/

			// Redirect the user to the loggedin.php page.
			// Start defining the URL.
			$url = /*'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
			// Check for a trailing slash.
			if ((substr($url, -1) == '/') OR (substr($url, -1) == '\\') ) {
				$url = substr ($url, 0, -1); // Chop off the slash.
			}
			// Add the page.
			$url .= */'/index.php';
			
			header("Location: $url");
			exit(); // Quit the script.
				
		} else { // No record matched the query.
			$errors[] = 'The username and password entered do not match those on file.'; // Public message.
			$errors[] = mysqli_error($dbc) . '<br /><br />Query: ' . $query; // Debugging message.
		}
		
	} // End of if (empty($errors)) IF.
		
	mysqli_close($dbc); // Close the database connection.

} else { // Form has not been submitted.

	$errors = NULL;

} // End of the main Submit conditional.

// Begin the page now.
$page_title = 'Login';
/*include ('./includes_css/header.html');*/

if (!empty($errors)) { // Print any error messages.
	echo '<h1 id="mainhead">Error!</h1>
	<p class="error">The following error(s) occurred:<br />';
	foreach ($errors as $msg) { // Print each error.
		echo " - $msg<br />\n";
	}
	echo '</p><p>Please try again.</p>';
}

// Create the form.
?>
<h2>Login</h2>
<form action="login.php" method="post">
	<p>Email Address: <input type="text" name="username" size="20" maxlength="40" /> </p>
	<p>Password: <input type="password" name="password" size="20" maxlength="20" /></p>
	<p><input type="submit" name="submit" value="Login" /></p>
	<input type="hidden" name="submitted" value="TRUE" />
</form>
<?php
/*include ('./includes_css/footer.html');*/
?>
