<?php

require_once 'BaseService.php';
require_once __DIR__."/../dao/UserMembershipDao.class.php";


class UserMembershipService extends BaseService{

    public function __construct(){
        parent::__construct(new UserMembershipDao);
    }


public function  get_users_membership_by_user_id($user_id){
    return $this->dao-> get_users_membership_by_user_id($user_id);
  }

  public function  get_user_membership(){
    return $this->dao-> get_user_membership();
}

public function  get_active_users(){
    return $this->dao-> get_active_users();
}

public function  get_earned(){
    return $this->dao->get_earned();
}

}

?>