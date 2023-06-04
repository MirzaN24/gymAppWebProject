<?php

class UserService{

    private $user_dao;

    public function __construct(){
        $user_dao = new UserDao();
    }

    public function get_all(){
        return $this->user_dao->get_all();
    }

    public function get_by_id($id){
        return $this->user_dao->get_by_id($id);
    }

    public function update($user, $id){
        return $this->user_dao->update($user, $id);
    }

    public function add($user){
        return $this->user_dao->add($user);
    }
    
    public function delete($id){
        return $this->user_dao->delete($id);
    }
}

?>