<!DOCTYPE html>
<html lang="en">

<head>
    <title>Music Player</title>
    <link rel="stylesheet" href="styles.css"/>
</head>

<body class="bg_primary">

<?php
session_start();
if ($_SESSION['login']) {
    header('Location: home_page.php');
    exit;
}else{
?>

<div class="container flex align-center height-full">
    <div class="box">

        <h1>Welcome! <br> To Music Player Site</h1>

        <p>Here you can listen download<br> and upload music, register now and enjoy <br> ad free music.</p>
        <br>
        <div class="margin-top">
            <a class="button" href="login_page.php">Login</a>
            <a class="button" href="register_page.php">Register</a>
        </div>
    </div>
</div>
</body>


<?php }
?>

</html>