<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Reviews</title>
</head>
<body>
<?php
$app_id = $_GET['appid'];
include 'Home.php';
$home = new Home();
$fetchReview = $home->fetch_reviews_by_app($app_id);
?>
<table class="table">
    <thead>
    <tr class="flex">
        <th class="title"><h2>Sr.NO</h2></th>
        <th class="title"><h2>Name</h2></th>
        <th class="title"><h2>Review</h2></th>

    </tr>
    </thead>
    <tbody>
    <?php

    foreach ($fetchReview as $data) {
        ?>
        <tr class="flex">
            <td class="title"><h2><?php echo $data['id'] ?></h2></td>
            <td class="title"><h2><?php echo $data['title'] ?></h2></td>
            <td class="desc"><h2><?php echo $data['review'] ?></h2></td>

        </tr>
        <?php

    }
    ?>
    </tbody>
</table>
<button>Add a review</button>
</body>
</html>