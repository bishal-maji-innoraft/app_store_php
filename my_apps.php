<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css"/>

    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include 'Home.php';
    $home = new Home();
    $fetchApps = $home->fetch_my_apps();
    ?>
</head>
<body>
<div class="container">
    <div class="box">
        <form name="my_app_list_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <table class="table">
                <thead>
                <tr class="flex">
                    <th class="title"><h2>App Logo</h2></th>
                    <th class="title"><h2>App Name</h2></th>
                    <th class="title"><h2>Description</h2></th>
                    <th class="title"><h2>Downloads </h2></th>
                    <th class="title"><h2>Developer</h2></th>
                    <th class="title"><h2>User Review</h2></th>
                    <th class="title"><h2>Update App</h2></th>
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
                            <td class="title"><img id="image" class="cover" src="http://localhost/uploads/image/<?php echo $data['image']?>" alt="Logo"></td>
                            <td class="title"> <h2><?php echo $data['app_name']?></h2></td>
                            <td class="desc"><h2><?php echo $data['description']?></h2></td>
                            <td class="title"><h2><?php echo $data['download_count']?></h2></td>
                            <td  class="title"><h2><?php echo $data['developer']?></h2></td>
                            <td class="title" >
                                <a href="http://localhost/user_reviews.php?appid=<?php echo $data['id']?>">User Reviews</a>
                            </td>
                            <td>
                                <a class="icon" href="http://localhost/update_app.php?update_id=<?php echo $data['id']?>">Update APP</a>
                            </td>
                            <td>
                                <a class="icon" href="http://localhost/uploads/apk/<?php echo $data['apk_file_link']?>"> <img id="download_icon" class="icon" src="http://localhost/uploads/icons/download_icon.png" alt="Download"></a>
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
</div>

</body>
</html>