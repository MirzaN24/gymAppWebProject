<?php

require '../vendor/autoload.php';
require("services/UserService.php");
require("services/EmployeesService.php");

Flight::register('user_service', "UserService");
Flight::register('employees_service', "EmployeesService");

require_once "routes/UserRoutes.php";
require_once "routes/EmployeesRoutes.php";

Flight::start();

?>