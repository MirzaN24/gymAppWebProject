<?php

require '../vendor/autoload.php';
require("dao/UserDao.class.php");
require("dao/EmployeesDao.class.php");

Flight::register('user_dao', "UserDao");
Flight::register('employees_dao', "EmployeesDao");

require_once "routes/UserRoutes.php";
require_once "routes/EmployeesRoutes.php";

Flight::start();

?>