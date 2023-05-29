<?php

class UserDao{

    private $conn;

    private $servername = "localhost";
    private $username = "root";
    private $password = "mirza123";
    private $schema = "web-project-gym-app";

    //constructor used to establish connection to db

    public function __construct(){


        try {
            $this->conn = new PDO("mysql:host=$this->servername; dbname=$this->schema", $this->username, $this->password);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully"; commenting it for now 
          } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
          }
    }
    
    //Method used to get all objects from db

    public function get_all(){
        $stmt = $this->conn -> prepare("SELECT * FROM user");
        $stmt->execute();
        return $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

   //Method used to get users' id from db

   public function get_by_id($id){
        $stmt = $this->conn -> prepare("SELECT * FROM user WHERE id=:id");
        $stmt->execute([':id' => $id]); //binding params
        return $result = $stmt -> fetch();
    }

    //Method used to add objects into db

    public function add($user){
      $stmt = $this->conn -> prepare("INSERT INTO user (first_name, last_name, email, pass, role) VALUES (:first_name, :last_name, :email, :pass, :role)");
      $stmt->execute($user);
      $user['id'] = $this->conn->lastInsertId();
      return $user;
      #binding params to prevent sql inj
  }

      //Method used to update objects in db

      public function update($user, $id){
        $user['id'] = $id;
        $stmt = $this->conn -> prepare("UPDATE user SET first_name = :first_name, last_name = :last_name, email = :email, pass = :pass, role = :role WHERE id = :id");
        $stmt->execute($user);
        return ($user);
        #binding parameters to prevent sql inj
    }

      //Method used to delete objects from db

      public function delete($id){
        $stmt = $this->conn -> prepare("DELETE FROM user WHERE id = :id");
        $stmt -> bindParam(':id', $id); #prevents SQL injection //can do it this way too
        $stmt->execute();
    }


}

?>