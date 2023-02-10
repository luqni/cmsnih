<?php

define('BASEPATH', true); //access connection script if you omit this line file will be blank
include '../config/db.php'; //require connection script

 if(isset($_POST['submit'])){  
        try {
            $dsn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
            $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $id         = $_POST['id'];
            $name       = $_POST['name'];
            $user_id    = intval($_POST['user_id']);

            $stmt = $dsn->prepare("UPDATE contacts SET name = '$name', user_id = $user_id WHERE id = $id");

            if($stmt->execute()){
                echo '<script>alert("Update Contact Success.")</script>';
                //redirect to another page
                echo '<script>window.location.replace("../view/contacts.php")</script>';
                
            }else{
                echo '<script>alert("An error occurred")</script>';
            }
            
        }catch(PDOException $e){
            $error = "Error: " . $e->getMessage();
            echo '<script type="text/javascript">alert("'.$error.'");</script>';
        }
}else{
    die('salah');
}

?>