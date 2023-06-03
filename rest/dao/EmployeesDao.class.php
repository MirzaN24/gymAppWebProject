<?php

require_once "BaseDao.class.php";

class EmployeesDao extends BaseDao{

  public function __construct(){
    parent::__construct("employees");
  }
  
}

?>