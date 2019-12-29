<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <title>People Plus</title>
        <script src="../include/jquery.min.js" ></script>
        <script src="../include/bootstrap.min.js"></script>
        <script src="../include/jquery-ui.min.js" ></script>
        <link rel="stylesheet" href="../include/jquery-ui.css">
        <link rel="stylesheet" href="../include/bootstrap.min.css">
        <link rel="stylesheet" href="../include/bootstrap-theme.min.css">
        <link rel="stylesheet" href="../include/jquery.rateyo.min.css">
        <link rel="shortcut icon" href="favicon.ico" />
    </head>
    <body>
    <form action="../signout.php" method="post">
        <div class="">
            <button class="" type="submit" name="Signout" value="Signout">Sign out</button>
        </div>
    </form>
    <a href="../project/project-list.php">Project List</a>
    <?php
    if ($_SESSION['userType'] == 'superuser' || $_SESSION['userType'] == 'employer' || $_SESSION['userType'] == 'administrator') {
        echo '<a href="profile-users.php">My Account</a>';
    }
    else { echo '<a href="profile-customer.php">My Account</a>'; }
    ?>