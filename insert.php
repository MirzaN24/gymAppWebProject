<?php

require_once("rest/dao/UserDao.class.php");

$user_dao = new UserDao();
$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];
$email = $_REQUEST['email'];
$password = $_REQUEST['password'];
$role = $_REQUEST['role'];
$created = $_REQUEST['created'];

$result = $user_dao->add($first_name, $last_name, $email, $password, $role, $created);

print_r($result);

?>