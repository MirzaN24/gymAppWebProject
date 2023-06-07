<?php

require_once 'BaseService.php';
require_once __DIR__."/../dao/EmployeesDao.class.php";

class EmployeesService extends BaseService{

    public function __construct(){
        parent::__construct(new EmployeesDao);
    }
}

?>