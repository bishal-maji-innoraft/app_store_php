<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="styles.css"/>
    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include 'Home.php';
    $home = new Home();
    $update_id = $_GET['update_id'];
    $app_file_err = $app_name_err = $image_err = $desc_err = $developer_err = "";

    if ($_SERVER['REQUEST_METHOD'] == $_POST) {
        $app_file = test_input($_POST["apk_file_link"]);
        $app_name = test_input($_POST["app_name"]);
        $developer = test_input($_POST["developer"]);
        $description = test_input($_POST["description"]);
        $image = test_input($_POST["image"]);

        if (empty($app_file)) {
            $app_file_err = "Apk file can not be empty";
        }
        if (empty($app_name)) {
            $app_name_err = "App Name can not be empty";
        }
        if (empty($developer)) {
            $developer_err = "Developer Name can not be empty";
        }
        if (empty($description)) {
            $desc_err = "Description can not be empty";
        }
        if (empty($image)) {
            $image_err = "image can not be empty";
        }
    }

    if (array_key_exists('update_app', $_POST)) {
        if ($app_file_err == "" && $app_name_err == "" && $image_err == "" && $desc_err == "" && $developer_err == "") {
            if (isset($_POST['update_app'])) {
                if ($home->isUpdateDone($update_id)) {
                    header('Location: home_page.php');

                } else {
                    header('Location: error_page.php');
                }
                exit;
            }
        }
    }

    //function to avoid sql injection.
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    ?>
</head>

<body class="bg_primary">
<div class="container flex align-center height-full">
    <div class="box background">
        <div class="margin-bottom text-align-start"><h1>Update Profile</h1></div>
        <form name="update_app_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
              enctype="multipart/form-data" method="post">
            <div class="flex">
                <label for="apk_file_link">App File</label>
                <input type="file" name="apk_file_link"><span>*<?php echo $app_file_err; ?></span>
            </div>
            <div class="flex">
                <label for="image">App Cover</label>
                <input type="file" name="image"><span>*<?php echo $image_err; ?></span>
            </div>
            <div class="flex">
                <label for="app_name">App Name</label>
                <input type="text" name="app_name"><span>*<?php echo $app_name_err; ?></span>
            </div>
            <div class="flex">
                <label for="description">App Description</label>
                <input type="text" name="description"><span>*<?php echo $desc_err; ?></span>
            </div>
            <div class="flex">
                <label for="developer">App Developer</label>
                <input type="text" name="developer"><span>*<?php echo $developer_err; ?></span>
            </div>

            <div class="">
                <input type="submit" name="update_app" value="Update App">
            </div>
        </form>
    </div>
</div>


</body>

</html>