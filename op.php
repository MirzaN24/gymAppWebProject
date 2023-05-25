<?php

require_once("rest/dao/UserDao.class.php");
$user_dao = new UserDao();

$type = $_REQUEST['type'];

switch ($type) {
    case 'add':
        $first_name = $_REQUEST['first_name'];
        $last_name = $_REQUEST['last_name'];
        $email = $_REQUEST['email'];
        $pass = $_REQUEST['pass'];
        $role = $_REQUEST['role'];

        $result = $user_dao->add($first_name, $last_name, $email, $pass, $role);
        print_r($result);
        break;

    case 'delete':
        $id = $_REQUEST['id'];
        $user_dao->delete($id);
        break;

    case 'update':
        $first_name = $_REQUEST['first_name'];
        $last_name = $_REQUEST['last_name'];
        $email = $_REQUEST['email'];
        $pass = $_REQUEST['pass'];
        $role = $_REQUEST['role'];
        $id = $_REQUEST['id'];
        $user_dao->update($first_name, $last_name, $email, $pass, $role, $id);
        break;

    case 'get':    
    default:
        $result = $user_dao->get_all();
        print_r($result);
        break;
}

?>