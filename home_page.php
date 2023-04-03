<!DOCTYPE html>
<html lang="en">


<head>
    <?php
    session_start();
    if (!$_SESSION['login']) {
        header('Location: index.php');
        exit;
    } ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="styles.css"/>

</head>

<body class="bg_primary">
<div class="container ">
    <header class="flex">
        <h1 class="heading">App Store</h1>
        <div class="nav-bar">
            <form name="home_page_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <input type="submit" name="add_app" value="Add App">
                <input type="submit" name="my_apps" value="My Apps">
                <input type="submit" name="logout" value="Logout">
            </form>
        </div>
    </header>

    <?php
    include 'Home.php';
    $uid = $_SESSION['uid'];
    $home = new Home();
    $fetchApps = $home->fetch_apps();
    ?>

    <div class="margin-top-low">
        <form name="app_list_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <table class="table">
                <thead>
                <tr class="flex">
                    <th class="title"><h2>App Logo</h2></th>
                    <th class="title"><h2>App Name</h2></th>
                    <th class="title"><h2>Description</h2></th>
                    <th class="title"><h2>Downloads </h2></th>
                    <th class="title"><h2>Developer</h2></th>
                    <th class="title"><h2>User Review</h2></th>
                    <th class="icon"><h2>Download </h2></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (is_array($fetchApps)) {
                    $sn = 1;
                    foreach ($fetchApps as $data) {
                        ?>
                        <tr class="flex">
                            <td class="title"><img id="image" class="cover"
                                                   src="http://localhost/uploads/image/<?php echo $data['image'] ?>"
                                                   alt="Logo"></td>
                            <td class="title"><h2><?php echo $data['app_name'] ?></h2></td>
                            <td class="title"><h2><?php echo $data['description'] ?></h2></td>
                            <td class="title" id="download_count"><h2><?php echo $data['download_count'] ?></h2></td>
                            <td class="title"><h2><?php echo $data['developer'] ?></h2></td>
                            <td class="title">
                                <a href="http://localhost/user_reviews.php?appid=<?php echo $data['id'] ?>">User
                                    Reviews</a>
                            </td>
                            <td>
                                <a class="icon"
                                   onclick="Download(<?php echo $data['id'] ?>,<?php echo $data['download_count'] ?>)"
                                   id="download"
                                   href="http://localhost/uploads/apk/<?php echo $data['apk_file_link'] ?>"> <img
                                            id="download_icon" class="icon"
                                            src="http://localhost/uploads/icons/download_icon.png" alt="Download"></a>
                            </td>

                        </tr>
                        <?php
                        $sn++;
                    }
                } else { ?>
                <tr>
                    <td colspan="8">
                        <?php echo $fetchApps; ?>
                    </td>
                <tr>
                    <?php } ?>

                </tbody>
            </table>
        </form>

    </div>
    <?php

    if (array_key_exists('add_app', $_POST)) {
        header('Location: upload_app.php');
        exit;
    }
    if (array_key_exists('logout', $_POST)) {
        session_start();
        unset($_SESSION['login']);
        header('Location: index.php');
        exit;
    }
    if (array_key_exists('my_apps', $_POST)) {
        header('Location: my_apps.php');
        exit;
    }

    ?>

</div>
</body>

</html>