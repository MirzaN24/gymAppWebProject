<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require '../vendor/autoload.php';
require("services/UserService.php");
require("services/EmployeesService.php");
require("services/MembershipService.php");
require("services/UserMembershipService.php");

require("dao/AdminDao.class.php");

Flight::register('user_service', "UserService");
Flight::register('employees_service', "EmployeesService");
Flight::register('membership_service', "MembershipService");
Flight::register('user_membership_service', "UserMembershipService");

Flight::register('adminDao', "AdminDao");

Flight::map('error', function(Exception $ex){
    Flight::json(['message' => $ex->getMessage()], 500);
});


//middleware method for login

Flight::route('/*', function(){
    $path = Flight::request()->url;
    if($path == '/login' || $path == '/docs.json') return TRUE; //exclude /login and /docs.json
    $headers = getallheaders();
    if(@!$headers['Authorization']){
        Flight::json(["message" => "Authorization is missing!"], 403);
        return FALSE;
    } else {
        try {
            $decoded = (array)JWT::decode($headers['Authorization'], new Key(Config::JWT_SECRET(), 'HS256'));
            Flight::set('admin', $decoded);
            return TRUE;
        } catch (\Throwable $th) {
            Flight::json(["message" => "Authorization token is not valid!"], 403);
            return FALSE;
        }
    }
});

/* REST API documentation endpoint */
Flight::route('GET /docs.json', function(){
    $openapi = \OpenApi\scan('routes');
    header('Content-Type: application/json');
    echo $openapi->toJson();
  });

require_once "routes/UserRoutes.php";
require_once "routes/EmployeesRoutes.php";
require_once "routes/MembershipRoutes.php";
require_once "routes/UserMembershipRoutes.php";
require_once "routes/AdminRoutes.php";



Flight::start();

?>