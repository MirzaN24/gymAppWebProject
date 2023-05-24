<?php

class UserDao{

    private $conn;

    //constructor used to establish connection to db

    public function __construct(){

        $servername = "localhost";
        $username = "root";
        $password = "mirza123";
        $schema = "web-project-gym-app";


        try {
            $this->conn = new PDO("mysql:host=$servername; dbname=$schema", $username, $password);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully"; 
          } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
          }
    }
    
    //Method used to get all objects from db

    public function get_all(){
        $stmt = $this->conn -> prepare("SELECT * FROM users");
        $stmt->execute();
        return $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

    //Method used to add objects into db

    public function add($first_name, $last_name, $email, $password, $role, $created){
      $stmt = $this->conn -> prepare("INSERT INTO users (first_name, last_name, email, password, role, created) VALUES 'user2', 'user2', 'user2@user2', 'user2', 'user', '2023-05-24 12:30:40'");
      $stmt->execute();
  }

}

?>