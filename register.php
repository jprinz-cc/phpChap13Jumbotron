<?php
$loggedin = false;
$error = false;

define('TITLE', 'Registration');

include('templates/header.html');


if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form.

	$problem = FALSE; // No problems so far.

	// Check for each value...
	if (empty($_POST['email'])) {
		$problem = TRUE;
		print '<p class="error">Please enter an email address!</p>';
	}

	if (empty($_POST['password1'])) {
		$problem = TRUE;
		print '<p class="error">Please enter a password!</p>';
	}

	if ($_POST['password1'] != $_POST['password2']) {
		$problem = TRUE;
		print '<p class="error">Your password did not match your confirmed password!</p>';
	}

    include('includes/mysqli_connect.php');

    $query = "SELECT email FROM quote_users WHERE email = '{$_POST['email']}'";
    $result = mysqli_query($dbc, $query);
    if(!$result->num_rows == 0) {
        $problem = TRUE;

		print '<p class="error">The email address you entered already has an account.<br> Please register with another account.</p>';

        mysqli_close($dbc);
    }

	if (!$problem) { // If there weren't any problems...

        $email = mysqli_real_escape_string($dbc, trim(strip_tags($_POST['email'])));
        $pwd = mysqli_real_escape_string($dbc, sha1(trim(strip_tags($_POST['password1']))));


        $query = "INSERT INTO quote_users(email, password)
            VALUES ('$email', '$pwd')";

        mysqli_query($dbc, $query);



		if (mysqli_affected_rows($dbc) == 1) { // Open the file.

			// Print a message:
			print '<p>You are now registered!</p>';
            include('templates/footer.html');
            mysqli_close($dbc);
            exit();

		} else { // Couldn't write to the file.

            print '<p class="error">Could not store the quote because:<br>' . mysqli_error($dbc) . '.</p><br>';
            print "<button onclick=\"history.go(-1);\" class=\"btn btn-primary btn-lg\">Back</button>";

		}

        mysqli_close($dbc);

	}

    ?>

    <h2>Registration:</h2><br>
    <form action="register.php" method="post">
	<p>Email Address: <input type="email" name="email" size="30"></p>
	<p>Password: <input type="password" name="password1" size="20"></p>
	<p>Confirm Password: <input type="password" name="password2" size="20"></p>
	<input type="submit" name="submit" value="Register" class="btn btn-primary btn-lg">
    </form>

    <?php

} else { // Display the form.
    ?>
    <h2>Registration:</h2><br>
    <form action="register.php" method="post">
	<p>Email Address: <input type="email" name="email" size="30"></p>
	<p>Password: <input type="password" name="password1" size="20"></p>
	<p>Confirm Password: <input type="password" name="password2" size="20"></p>
	<input type="submit" name="submit" value="Register" class="btn btn-primary btn-lg">
    </form>
    <?php


} // End of submission IF.

include('templates/footer.html');

?>
