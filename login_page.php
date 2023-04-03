<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <link href="styles.css" rel="stylesheet" />
</head>

<body class="bg_primary">
<?php

include 'Auth.php';
$auth = new Auth();
$mail_err = "";
$pass_err = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);

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
    if ($mail_err == "" && $pass_err == "") {
        if($auth->isUserExist()){
                session_start();
                $_SESSION['login']=1;
                header('Location: home_page.php');
            } else {
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
    $data = htmlspecialchars($data);
    return $data;
}
?>
<div class="container flex align-center height-full">
    <div class="box ">
        <div ><h1>Login Page</h1></div>
        <form name="login_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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