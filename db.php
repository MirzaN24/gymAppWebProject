<?php

require_once("rest/dao/UserDao.class.php");

$user_dao = new UserDao();

$result = $user_dao->get_all();
print_r($result);

// $servername = "localhost";
// $username = "root";
// $password = "mirza123";
// $schema = "web-project-gym-app";

// try {
//     $conn = new PDO("mysql:host=$servername; dbname=$schema", $username, $password);
//     // set the PDO error mode to exception
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     echo "Connected successfully"; 

//     $stmt = $conn -> prepare("SELECT * FROM user");
//     $stmt->execute();
//     $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);
//     print_r($result);


//   } catch(PDOException $e) {
//     echo "Connection failed: " . $e->getMessage();
//   }

?>