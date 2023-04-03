<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
    <link href="../styles.css" rel="stylesheet" />
    <?php
    include 'Auth.php';
    $auth = new Auth();
    $mail_err = "";
    $pass_err = "";
    $name_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = test_input($_POST["email"]);
        $name = test_input($_POST["name"]);
        $password = test_input($_POST["password"]);

        if (empty($name)) {
            $name_err = "name can not be empty";
        }
        if (empty($email)) {
            $mail_err = "mail can not be empty";
        }
        if (empty($password)) {
            $pass_err = "password can not be empty";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $mail_err = "Invalid email format";
        }

    }
    if (array_key_exists('submit', $_POST)) {
        if ($mail_err == "" && $pass_err == "" && $name_err == "") {
            if ($auth->isRegisterDone()) {
                session_start();
                $_SESSION['login'] = 1;
                header('Location: home_page.php');
            } else {
                echo "No";
                require 'error_page.php';
                header('Location: error_page.php');
            }
            exit;

        }
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }
    ?>
</head>

<body class="bg_primary">
<div class="container flex align-center height-full">
    <div class="box background">
        <div class="margin-bottom text-align-start"><h1>Registration Page</h1></div>
        <form name="register_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="flex">
                <label for="name">Name</label>
                <input name="name" type="name" value="name" /><span>*<?php echo $mail_err; ?></span>
            </div>
            <div class="flex">
                <label for="email">Email</label>
                <input name="email" type="email" value="email@e.com" /><span>*<?php echo $mail_err; ?></span>
            </div>

            <div class="flex">
                <label for="password">Password</label>
                <input name="password" type="password" /><span>*<?php echo $pass_err; ?></span>
            </div>
            <br>
            <div class="text-align-start margin-top-low">
                <input class="button" type="submit" name="submit" value="Submit" />
            </div>
        </form>
    </div>
</div>

</body>

</html>