<?php

require '../vendor/autoload.php';
require("services/UserService.php");
require("services/EmployeesService.php");
require("services/MembershipService.php");

Flight::register('user_service', "UserService");
Flight::register('employees_service', "EmployeesService");
Flight::register('membership_service', "MembershipService");

require_once "routes/UserRoutes.php";
require_once "routes/EmployeesRoutes.php";
require_once "routes/MembershipRoutes.php";

Flight::start();

?>