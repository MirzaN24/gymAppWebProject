<?php

require __DIR__."/../Config.class.php";


class BaseDao{

    private $conn;

    private $table_name;

    public function __construct($table_name){

        try {
            
            $this->table_name = $table_name;

            $servername = Config::DB_HOST();
            $username = Config::DB_USERNAME();
            $password = Config::DB_PASSWORD();
            $schema = Config::DB_SCHEMA();
  
            $this->conn = new PDO("mysql:host=$servername; dbname=$schema", $username, $password);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully"; commenting it for now 
          } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
          }

    }

    //Method used to get all entities from db

    public function get_all(){
     $stmt = $this->conn -> prepare("SELECT * FROM " . $this->table_name);
     $stmt->execute();
     return $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

   //Method used to get entities by id from db

   public function get_by_id($id, $id_column = "id"){
    $stmt = $this->conn -> prepare("SELECT * FROM " . $this->table_name . " WHERE ${id_column}=:id");
    $stmt->execute([':id' => $id]); //binding params
    return $result = $stmt -> fetch(PDO::FETCH_ASSOC);
   }

   //Method used to add objects into db

   public function add($entity){
    $query = "INSERT INTO " . $this->table_name . " (";
    foreach($entity as $column => $value){
        $query.=$column . ', ';
    }
    $query = substr($query, 0, -2);
    $query.=") VALUES (";
    foreach($entity as $column => $value){
        $query.= ":" . $column . ', ';
    }
    $query = substr($query, 0, -2);
    $query.= ")";
    
    $stmt = $this->conn -> prepare($query);
    $stmt->execute($entity);
    $entity['id'] = $this->conn->lastInsertId();
    return $entity;
    #binding params to prevent sql inj
   }

   //Method used to update objects in db 

   public function update($entity, $id, $id_column = "id"){
    $query = "UPDATE " . $this->table_name . " SET ";
    foreach($entity as $column => $value){
        $query.= $column . "=:" . $column . ", ";
    }
    $query = substr($query, 0, -2);
    $query.= " WHERE ${id_column} = :id";

    $stmt = $this->conn -> prepare($query);
    $entity['id'] = $id;

    $stmt->execute($entity);
    return ($entity);
    #binding parameters to prevent sql inj
   }

  //Method used to delete entities from db

  public function delete($id, $id_column = "id"){
   $stmt = $this->conn -> prepare("DELETE FROM " . $this->table_name . " WHERE ${id_column} = :id");
   $stmt -> bindParam(':id', $id); #prevents SQL injection //can do it this way too
   $stmt->execute();
  }

  protected function query_single($query){
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  protected function query($query, $params){
    $stmt = $this->conn->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  protected function query_unique($query, $params){
    $results = $this->query($query, $params);
    return reset($results);
  }

}

?>