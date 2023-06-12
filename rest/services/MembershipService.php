<?php

require_once 'BaseService.php';
require_once __DIR__."/../dao/MembershipDao.class.php";


class MembershipService extends BaseService{

    public function __construct(){
        parent::__construct(new MembershipDao);
    }
}

?>