<?php

define('BASEPATH', true); //access connection script if you omit this line file will be blank
include '../config/db.php'; //require connection script
// print_r($_GET);die() ;
 if(isset($_GET['contact_id'])){  
        try {
            $dsn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
            $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $id = $_GET['contact_id'];
            
            
            $sql = "SELECT *  FROM numbers WHERE contact_id = :id";
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($row);
            
        }catch(PDOException $e){
            $error = "Error: " . $e->getMessage();
            echo '<script type="text/javascript">alert("'.$error.'");</script>';
        }
}else{
    die('salah');
}

?>