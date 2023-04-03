<?php

class Home
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

    //fetch reviews of user of a particular app with id.
    public function fetch_reviews_by_app($app_id){
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password_sql);
            // setting the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        $sql_query = "SELECT * FROM user_review WHERE app_id=$app_id";
        $result = $conn->query($sql_query);
        $row = $result->fetchAll();
        return $row;
    }

    //returns the list of song present in server.
    public function fetch_apps()
    {
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password_sql);
            // setting the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        $sql_query = "SELECT * FROM app_list_table";
        $result = $conn->query($sql_query);
        $row = $result->fetchAll();
        return $row;
    }
    //returns the list of song present in server.
    public function fetch_my_apps()
    {
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password_sql);
            // setting the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        session_start();
        $uid=$_SESSION['uid'];
        $sql_query = "SELECT * FROM app_list_table WHERE id=$uid";
        $result = $conn->query($sql_query);
        return $result->fetchAll();
    }

    //function to update the db.
    public function isUpdateDone($app_id)
    {
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password_sql);
            // setting the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
//        app_name,description,image,developer,apk_file_link

        $sql = "UPDATE app_list_table SET  app_name=?, description=?, image=? ,developer=?,apk_file_link=? WHERE id=?";
        // Prepare statement and bind data
        session_start();

        $param_app_name = $_POST['app_name'];
        $param_description = $_POST['description'];
        $param_image = $_POST['image'];
        $param_developer = $_POST['developer'];
        $param_apk = $_POST['apk_file_link'];
        $param_id =$app_id;


        $statement = $conn->prepare($sql);

        // If UPDATE succeeded or not.
        if ($statement->execute([$param_app_name, $param_description, $param_image, $param_developer,$param_apk,$param_id])) {
            return  true;
        } else {
            return false;
        }
    }
    //function to upload app.
    public function isUploadDone()
    {
        $appUploadDir = './uploads/apk/';
        $imageUploadDir = './uploads/image/';
        $upload_apk_file = $appUploadDir . basename($_FILES['apk_file_link']['name']);
        $upload_image_file = $imageUploadDir . basename($_FILES['image']['name']);


        if (file_exists($upload_apk_file)) {
            // delete the existing file with same name
            unlink($upload_apk_file);
        }
        if (file_exists($upload_image_file)) {
            // delete the existing file with same name
            unlink($upload_image_file);
        }
        //if upload done insert in db.
        if (move_uploaded_file($_FILES['apk_file_link']['tmp_name'], $upload_apk_file)) {
            if(move_uploaded_file($_FILES['image']['tmp_name'], $upload_image_file)){
                try {
                    $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password_sql);
                    // setting the PDO error mode to exception
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
                /* Step 1: prepare */
                $sql = "INSERT INTO app_list_table(app_name,description,image,developer,download_count,user_reviews_id,apk_file_link) VALUES ( ?, ?, ?, ?, ?, ?, ?)";
                $query = $conn->prepare($sql);

                $param_app_name = $_POST['app_name'];
                $param_desc = $_POST['description'];
                $param_developer=$_POST['developer'];
                $param_app=basename($_FILES['apk_file_link']['name']);
                $param_image=basename($_FILES['image']['name']);
                $param_dc=0;

                session_start();
                $param_upload_by= $_SESSION['uid'];

                $query->bindParam(1, $param_app_name, PDO::PARAM_STR);
                $query->bindParam(2, $param_desc, PDO::PARAM_STR);
                $query->bindParam(3, $param_image, PDO::PARAM_STR);
                $query->bindParam(4, $param_developer, PDO::PARAM_STR);
                $query->bindParam(5, $param_dc, PDO::PARAM_INT);
                $query->bindParam(6, $param_upload_by, PDO::PARAM_INT);
                $query->bindParam(7, $param_app, PDO::PARAM_STR);


                if ($query->execute()) {
                    return true;
                } else {
                    //if problem in db upload delete the audio
                    unlink($upload_apk_file);
                    unlink($upload_image_file);
                    return false;
                }
            }else{
                return false;
            }
        } else {
            return false;
        }
    }

}