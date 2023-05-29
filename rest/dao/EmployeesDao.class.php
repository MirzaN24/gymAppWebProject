<?php

class EmployeesDao{

    private $conn;



    //constructor used to establish connection to db

    public function __construct(){


        try {
            
            $servername = "localhost";
            $username = "root";
            $password = "mirza123";
            $schema = "web-project-gym-app";

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
        $stmt = $this->conn -> prepare("SELECT * FROM employees");
        $stmt->execute();
        return $result = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

   //Method used to get employeess' id from db

   public function get_by_id($id){
        $stmt = $this->conn -> prepare("SELECT * FROM employees WHERE emp_id=:emp_id");
        $stmt->execute([':emp_id' => $id]); //binding params
        return $result = $stmt -> fetch();
    }

    //Method used to add objects into db

    public function add($employees){
      $stmt = $this->conn -> prepare("INSERT INTO employees (full_name, phone_number, email, position) VALUES (:full_name, :phone_number, :email, :position)");
      $stmt->execute($employees);
      $employees['emp_id'] = $this->conn->lastInsertId();
      return $employees;
      #binding params to prevent sql inj
  }

      //Method used to update objects in db

      public function update($employees, $id){
        $employees['emp_id'] = $id;
        $stmt = $this->conn -> prepare("UPDATE employees SET full_name = :full_name, phone_number = :phone_number, email = :email, position = :position WHERE emp_id = :emp_id");
        $stmt->execute($employees);
        return ($employees);
        #binding parameters to prevent sql inj
    }

      //Method used to delete objects from db

      public function delete($id){
        $stmt = $this->conn -> prepare("DELETE FROM employees WHERE emp_id = :emp_id");
        $stmt -> bindParam(':emp_id', $id); #prevents SQL injection //can do it this way too
        $stmt->execute();
    }


}

?>