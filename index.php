<?php
define('TITLE', 'My Site of Quotes');

include('templates/header.html');

include('includes/mysqli_connect.php');


//<!-- Main jumbotron for a primary marketing message or call to action -->

print "<h1>My Site of Quotes</h1>";


if (isset($_GET['random'])) {

    $query = 'SELECT id, quote, source, favorite FROM quotes ORDER BY RAND() DESC LIMIT 1';

} elseif (isset($_GET['favorite'])) {

    $query = 'SELECT id, quote, source, favorite FROM quotes WHERE favorite=1 ORDER BY RAND() DESC LIMIT 1';

} else {

    $query = 'SELECT id, quote, source, favorite FROM quotes ORDER BY date_entered DESC LIMIT 1';

}

if ($r = mysqli_query($dbc, $query)) {

    $row = mysqli_fetch_array($r);

    print "<div><blockquote>{$row ['quote']}</blockquote>-{$row['source']} ";

    if ($row['favorite'] == 1) {
        print ' <strong>Favorite!</strong>';
    }

    print '</div>';


    if (is_administrator()) {
        print "<p><b>Quote Admin:</b> <a href=\"edit_quote.php?id={$row['id']}\" class=\"btn\">Edit</a>  |  <a href=\"delete_quote.php?id={$row['id']}\" class=\"btn\">Delete</a></p>\n";
    }

} else {
    print '<p class="error">Could not retrieve the data because:<br>' . mysqli_error($dbc) . '.</p><p>The query being run was: ' . $query . '</p>';
}

mysqli_close($dbc);

print '<br><p><a href="index.php" class="btn btn-primary btn-sm">Latest</a>
    <a href="index.php?random=true" class="btn btn-primary btn-sm">Random</a>
    <a href="index.php?favorite=true" class="btn btn-primary btn-sm">Favorite</a></p>';


include('templates/footer.html');
?>
