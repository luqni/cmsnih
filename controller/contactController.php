<?php

define('BASEPATH', true); //access connection script if you omit this line file will be blank
include '../config/db.php'; //require connection script

 if(isset($_POST['submit'])){  
        try {
            $dsn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
            $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $name = $_POST['name'];
            $user_id = intval($_POST['user_id']);

            
            //encrypt password
            $pass = password_hash($pass, PASSWORD_BCRYPT, array("cost" => 12));
            
            //Check if username exists
            $sql = "SELECT COUNT(name) AS num FROM contacts WHERE name = :name";
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindValue(':name', $name);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            

            if($row['num'] > 0){
                echo '<script>alert("Username already exists")</script>';
            }else{

            $stmt = $dsn->prepare("INSERT INTO contacts (name, user_id) 
            VALUES (:name,:user_id)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':user_id', $user_id);
    
                if($stmt->execute()){
                    echo '<script>alert("New account created.")</script>';
                    //redirect to another page
                    echo '<script>window.location.replace("../view/contacts.php")</script>';
                    
                }else{
                    echo '<script>alert("An error occurred")</script>';
                }
            }
        }catch(PDOException $e){
            $error = "Error: " . $e->getMessage();
            echo '<script type="text/javascript">alert("'.$error.'");</script>';
        }
}else{
    die('salah');
}

?>