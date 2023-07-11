<?php

require_once "BaseDao.class.php";

class UserDao extends BaseDao{

  public function __construct(){
    parent::__construct("user");
  }

  public function get_user_count(){
    return $this->query_single(" SELECT COUNT(user.`id`) as count FROM user");
  }
  
}

?>