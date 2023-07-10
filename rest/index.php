<?php

require '../vendor/autoload.php';
require("services/UserService.php");
require("services/EmployeesService.php");
require("services/MembershipService.php");
require("services/UserMembershipService.php");

Flight::register('user_service', "UserService");
Flight::register('employees_service', "EmployeesService");
Flight::register('membership_service', "MembershipService");
Flight::register('user_membership_service', "UserMembershipService");

require_once "routes/UserRoutes.php";
require_once "routes/EmployeesRoutes.php";
require_once "routes/MembershipRoutes.php";
require_once "routes/UserMembershipRoutes.php";



Flight::start();

?>