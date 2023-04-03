<!DOCTYPE html>
<html lang="en">

<head>
    <title>Upload Music</title>
    <link rel="stylesheet" href="styles.css"/>

    <?php
    include 'Home.php';
    $home = new Home();
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

    if (array_key_exists('upload_app', $_POST)) {
        if ($app_file_err == "" && $app_name_err == "" && $image_err == "" && $desc_err == "" && $developer_err == "") {
            if (isset($_POST['upload_app'])) {
                if ($home->isUploadDone()) {
                    header('Location: home_page.php');
                } else {
                    header('Location: error_page.php');
                }
            }
        } else {
            echo "Ho";
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
<div class="container">
    <div class="box ">
        <div><h1>Upload App</h1></div>

        <form name="upload_app_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
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
                <input type="submit" name="upload_app" value="Upload App">
            </div>
        </form>
    </div>
</div>
</body>

</html>