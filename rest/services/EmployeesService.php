<?php

class EmployeesService{

    private $employees_dao;

    public function __construct(){
        $employees_dao = new EmployeesDao();
    }

    public function get_all(){
        return $this->employees_dao->get_all();
    }

    public function get_by_id($id){
        return $this->employees_dao->get_by_id($id);
    }

    public function update($employees, $id){
        return $this->employees_dao->update($employees, $id);
    }

    public function add($employees){
        return $this->employees_dao->add($employees);
    }
    
    public function delete($id){
        return $this->employees_dao->delete($id);
    }
}

?>