<?php

require_once 'BaseService.php';
require_once __DIR__."/../dao/UserMembershipDao.class.php";


class UserMembershipService extends BaseService{

    public function __construct(){
        parent::__construct(new UserMembershipDao);
    }
}

#update

?>