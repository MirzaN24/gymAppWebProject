<?php

require_once "BaseDao.class.php";

class MembershipDao extends BaseDao{

  public function __construct(){
    parent::__construct("membership");
  }
  
}

?>