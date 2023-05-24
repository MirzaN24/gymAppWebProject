<?php

require_once("rest/dao/UserDao.class.php");
$user_dao = new UserDao();

$type = $_REQUEST['type'];

switch ($type) {
    case 'add':
        $first_name = $_REQUEST['first_name'];
        $last_name = $_REQUEST['last_name'];
        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];
        $role = $_REQUEST['role'];
        $created = $_REQUEST['created'];
        $result = $user_dao->add($first_name, $last_name, $email, $password, $role, $created);
        print_r($result);
        break;

    case 'delete':
        print_r("delete");
        break;

    case 'update':
        print_r("update");
        break;

    case 'get':    
    default:
        $stmt = $this->conn -> prepare("SELECT * FROM users");
        $stmt->execute();
        break;
}

?>