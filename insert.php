<?php

require_once("rest/dao/UserDao.class.php");

$user_dao = new UserDao();

$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];
$email = $_REQUEST['email'];
$pass = $_REQUEST['pass'];
$role = $_REQUEST['role'];


$result = $user_dao->add($first_name, $last_name, $email, $pass, $role);

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

//     $first_name = $_REQUEST['first_name'];
//     $last_name = $_REQUEST['last_name'];
//     $email = $_REQUEST['email'];
//     $pass = $_REQUEST['pass'];
//     $role = $_REQUEST['role'];
//     $stmt = $conn -> prepare("INSERT INTO user (first_name, last_name, email, pass, role) VALUES ('$first_name', '$last_name', '$email', '$pass', '$role')");
//     $result = $stmt->execute();
//     print_r($result);


//   } catch(PDOException $e) {
//     echo "Connection failed: " . $e->getMessage();
//   }

?>