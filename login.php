<?php
$error = false;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!empty($_POST['email']) && !empty($_POST['password'])) {

        include('includes/mysqli_connect.php');

        $query = "SELECT email, password FROM quote_users WHERE email = '{$_POST['email']}'";

        $result = mysqli_query($dbc, $query);

        if (mysqli_num_rows($result) == 1) {

            while ($row = mysqli_fetch_array($result)) {
                if ($row['password'] == sha1($_POST['password'])){

                    setcookie('Samuel', 'Clemens', time()+3600);
                    $loggedin = true;

                } else {

                    $error = 'Your email address or password could not be verified, please try again!';

                }

            }

        } else {

            $error = 'Your email address or password could not be verified, please try again!';

        }

        mysqli_close($dbc);

    } else { // Forgot a field.

        $error = 'Please make sure you enter both an email address and a password!';

    }

}

define('TITLE', 'Login');

include('templates/header.html');

if ($error) {

    print '<p class="error">' . $error . '</p>';

}

if ($loggedin) {

    print '<p>You are now logged in!</p>';

} else {

    print '<h2>Login Form</h2>
        <form action="login.php" method="post">
        <p><label>Email Address: <input type="email" name="email"></label></p>
        <p><label>Password: <input type="password" name="password"></label></p>
        <p><input type="submit" name="submit" value="Log In!"></p>
        </form>';
}

include('templates/footer.html');

?>
