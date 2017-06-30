<?php
if (isset($_COOKIE['Samuel'])) {

    setcookie('Samuel', FALSE, time()-300);

    $logging_out = true;

}


define('TITLE', 'Logout');
include('templates/header.html');

print '<p>You are now logged out.</p>';


include('templates/footer.html');
?>
