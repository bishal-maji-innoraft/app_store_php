<?php

class Auth
{
    //this function returns true if user exist in db.
    public $env;
    public $servername;
    public $dbname;
    public $username;
    public $password_sql;


   //constructor for init.
    public function __construct()
    {
        $this->env = parse_ini_file('.env');
        $this->servername = $this->env["SERVERNAME"];
        $this->dbname = $this->env["DB_NAME"];
        $this->username = $this->env["USERNAME"];
        $this->password_sql = $this->env["PASSWORD"];
    }

    //function to insert new user in db.
    public function isRegisterDone()
    {   $conn=null;
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password_sql);
            // setting the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        /* Step 1: prepare */
        $sql = "INSERT INTO user_table(name, email,password) VALUES (?, ?, ?)";
        $query = $conn->prepare($sql);

        $param_name = $_POST['name'];
        $param_email = $_POST['email'];
        $param_password = $_POST['password'];


        $query->bindParam(1, $param_name, PDO::PARAM_STR);
        $query->bindParam(2, $param_email, PDO::PARAM_STR);
        $query->bindParam(3, $param_password, PDO::PARAM_STR);


        if ($query->execute()) {
            session_start();
            $_SESSION["uid"] = $conn->lastInsertId();
            return true;
        } else {
            return false;
        }
    }
    //this function returns true if user exist in db.
    public function isUserExist()
    {    $conn=null;
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password_sql);
            // setting the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        $sql_query = "SELECT id, email, password FROM user_table";
        $result = $conn->query($sql_query);
        while ($row = $result->fetch()) {
            if ($row["email"] == $_POST['email'] &&  $row["password"] == $_POST['password']) {
                session_start();
                $_SESSION['uid'] = $row['id'];
                return true;
            }
        }
        return false;
    }
}